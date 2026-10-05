<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\MultaModel;
use App\Models\PagamentoModel;
use App\Models\UtenteModel;
use App\Models\LogModel;
use App\Models\InfracaoModel;
use App\Models\LocalInfracaoModel;
use App\Libraries\PdfService;

class Admin extends BaseController
{
    protected $adminModel;
    protected $multaModel;
    protected $pagamentoModel;
    protected $utenteModel;
    protected $logModel;
    protected $infracaoModel;
    protected $localInfracaoModel;
    protected $session;

    public function __construct()
    {
        $this->adminModel         = new AdminModel();
        $this->multaModel         = new MultaModel();
        $this->pagamentoModel     = new PagamentoModel();
        $this->utenteModel        = new UtenteModel();
        $this->logModel           = new LogModel();
        $this->infracaoModel      = new InfracaoModel();
        $this->localInfracaoModel = new LocalInfracaoModel();
        $this->session            = session();
    }

    /**
     * Tela de Login de Administrador
     */
    public function login()
    {
        if ($this->session->get('admin_logged_in')) {
            return redirect()->to('/admin/dashboard');
        }

        return view('admin/login', [
            'title' => 'Acesso Administrativo — INATRO',
        ]);
    }

    /**
     * Autenticação de Administrador
     */
    public function autenticar()
    {
        $email = $this->request->getPost('email');
        $senha = $this->request->getPost('senha');

        if (empty($email) || empty($senha)) {
            return redirect()->back()->with('error', 'Preencha o e-mail e a palavra-passe.')->withInput();
        }

        $admin = $this->adminModel->autenticar($email, $senha);

        if (!$admin) {
            return redirect()->back()->with('error', 'Credenciais administrativas inválidas.')->withInput();
        }

        $this->session->set([
            'admin_logged_in' => true,
            'admin_id'        => $admin['id'],
            'admin_nome'      => $admin['nome'],
            'admin_email'     => $admin['email'],
            'admin_cargo'     => $admin['cargo'],
        ]);

        $this->logModel->registrar($admin['nome'], 'Login de Administrador', "Autenticação efectuada a partir do e-mail {$admin['email']}");

        return redirect()->to('/admin/dashboard');
    }

    /**
     * Dashboard Geral do Administrador
     */
    public function dashboard()
    {
        if (!$this->session->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $allMultas    = $this->multaModel->findAll();
        $allPagamentos= $this->pagamentoModel->findAll();
        $allUtentes   = $this->utenteModel->findAll();
        $recentLogs   = $this->logModel->orderBy('created_at', 'DESC')->findAll(10);

        $totalMultas    = count($allMultas);
        $totalPendentes = 0;
        $totalPagas     = 0;
        $totalProc      = 0;
        $totalValorRec  = 0.00;

        foreach ($allMultas as $m) {
            if ($m['estado'] === 'pendente') $totalPendentes++;
            if ($m['estado'] === 'paga') $totalPagas++;
            if ($m['estado'] === 'em_processamento') $totalProc++;
        }

        foreach ($allPagamentos as $p) {
            if ($p['estado'] === 'pago') {
                $totalValorRec += floatval($p['valor_pago']);
            }
        }

        return view('admin/dashboard', [
            'title'          => 'Painel de Administração — INATRO',
            'totalMultas'    => $totalMultas,
            'totalPendentes' => $totalPendentes,
            'totalPagas'     => $totalPagas,
            'totalProc'      => $totalProc,
            'totalValorRec'  => $totalValorRec,
            'totalUtentes'   => count($allUtentes),
            'totalTrans'     => count($allPagamentos),
            'recentLogs'     => $recentLogs,
        ]);
    }

    /**
     * Gestão de Utentes
     */
    public function utentes()
    {
        if (!$this->session->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $utentes = $this->utenteModel->orderBy('created_at', 'DESC')->findAll();

        return view('admin/utentes', [
            'title'   => 'Gestão de Utentes — Admin INATRO',
            'utentes' => $utentes,
        ]);
    }

    /**
     * Formulário para Registar Novo Utente
     */
    public function novoUtente()
    {
        if (!$this->session->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $numeroCartaGerado = $this->gerarNumeroCarta();

        return view('admin/utente_novo', [
            'title'             => 'Registar Novo Utente — Admin INATRO',
            'numeroCartaGerado' => $numeroCartaGerado,
        ]);
    }

    /**
     * Processar o Registo de Novo Utente
     */
    public function salvarUtente()
    {
        if (!$this->session->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $nome           = trim($this->request->getPost('nome'));
        $dataNascimento = trim($this->request->getPost('data_nascimento'));
        $biNumero       = trim($this->request->getPost('bi_numero'));
        $telefone       = trim($this->request->getPost('telefone'));
        $email          = trim($this->request->getPost('email'));

        if (empty($nome) || empty($dataNascimento) || empty($biNumero)) {
            return redirect()->back()->with('error', 'Por favor, preencha todos os campos obrigatórios.')->withInput();
        }

        // Verificar duplicado de BI
        $biExistente = $this->utenteModel->where('bi_numero', $biNumero)->first();
        if ($biExistente) {
            return redirect()->back()->with('error', "Já existe um utente registado com o N.º de BI {$biNumero}.")->withInput();
        }

        // Verificar duplicado de E-mail se fornecido
        if (!empty($email)) {
            $emailExistente = $this->utenteModel->where('email', $email)->first();
            if ($emailExistente) {
                return redirect()->back()->with('error', "Já existe um utente registado com o e-mail {$email}.")->withInput();
            }
        }

        // Gerar e validar número de carta único
        $numeroCarta = $this->gerarNumeroCarta();

        $this->utenteModel->insert([
            'nome'            => $nome,
            'numero_carta'    => $numeroCarta,
            'data_nascimento' => $dataNascimento,
            'bi_numero'       => $biNumero,
            'telefone'        => $telefone,
            'email'           => $email,
        ]);

        $this->logModel->registrar(
            $this->session->get('admin_nome'),
            'Registo de Novo Utente',
            "Utente {$nome} registado com sucesso com a Carta N.º {$numeroCarta}"
        );

        return redirect()->to('/admin/utentes')->with('success', 'Utente registado com sucesso.');
    }

    /**
     * Gestão de Multas
     */
    public function multas()
    {
        if (!$this->session->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $estadoFiltro = $this->request->getGet('estado') ?? 'todas';
        $multas = $this->multaModel->getMultasComUtente($estadoFiltro);

        return view('admin/multas', [
            'title'        => 'Gestão de Multas — Painel Admin INATRO',
            'multas'       => $multas,
            'estadoFiltro' => $estadoFiltro,
        ]);
    }

    /**
     * Formulário para Atribuir Nova Multa
     */
    public function atribuirMulta()
    {
        if (!$this->session->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $utentes    = $this->utenteModel->orderBy('nome', 'ASC')->findAll();
        $infracoes  = $this->infracaoModel->getInfracoesActivas();
        $provincias = $this->localInfracaoModel->getProvincias();

        return view('admin/multa_atribuir', [
            'title'      => 'Atribuir Multa — Admin INATRO',
            'utentes'    => $utentes,
            'infracoes'  => $infracoes,
            'provincias' => $provincias,
        ]);
    }

    /**
     * Processar Atribuição de Nova Multa
     */
    public function salvarMulta()
    {
        if (!$this->session->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $utenteId      = $this->request->getPost('utente_id');
        $tipoInfracao  = $this->request->getPost('tipo_infracao');
        $artigoLei     = $this->request->getPost('artigo_lei');
        $descricao     = $this->request->getPost('descricao');
        $localInfracao = $this->request->getPost('local_infracao');
        $dataInfracao  = $this->request->getPost('data_infracao');
        $valor         = floatval($this->request->getPost('valor'));
        $estado        = $this->request->getPost('estado') ?? 'pendente';

        if (empty($utenteId) || empty($tipoInfracao) || empty($localInfracao) || empty($dataInfracao) || $valor <= 0) {
            return redirect()->back()->with('error', 'Preencha todos os campos obrigatórios da multa.')->withInput();
        }

        // Gerar código de multa único
        $codigoMulta = 'MT-2026-' . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);

        // Data de vencimento padrão: 30 dias após infração
        $dataVencimento = date('Y-m-d', strtotime($dataInfracao . ' + 30 days'));

        $this->multaModel->insert([
            'codigo_multa'    => $codigoMulta,
            'utente_id'       => $utenteId,
            'tipo_infracao'   => $tipoInfracao,
            'artigo_lei'      => $artigoLei,
            'descricao'       => $descricao,
            'local_infracao'  => $localInfracao,
            'data_infracao'   => date('Y-m-d H:i:s', strtotime($dataInfracao)),
            'data_vencimento' => $dataVencimento,
            'valor'           => $valor,
            'estado'          => $estado,
        ]);

        $utente = $this->utenteModel->find($utenteId);

        $this->logModel->registrar(
            $this->session->get('admin_nome'),
            'Atribuição de Multa',
            "Multa {$codigoMulta} no valor de " . number_format($valor, 2, ',', '.') . " MT atribuída ao utente {$utente['nome']} ({$utente['numero_carta']})"
        );

        return redirect()->to('/admin/multas')->with('success', "Multa {$codigoMulta} atribuída com sucesso ao condutor {$utente['nome']}.");
    }

    /**
     * AJAX endpoint para obter locais pré-cadastrados por província
     */
    public function getLocaisPorProvincia()
    {
        $provincia = $this->request->getGet('provincia');
        if (empty($provincia)) {
            return $this->response->setJSON([]);
        }

        $locais = $this->localInfracaoModel->getLocaisPorProvincia($provincia);
        return $this->response->setJSON($locais);
    }

    /**
     * Alterar Estado da Multa
     */
    public function alterarEstadoMulta()
    {
        if (!$this->session->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $multaId    = $this->request->getPost('multa_id');
        $novoEstado = $this->request->getPost('novo_estado');

        if (!empty($multaId) && !empty($novoEstado)) {
            $multa = $this->multaModel->find($multaId);
            if ($multa) {
                $this->multaModel->update($multaId, ['estado' => $novoEstado]);

                // Sincronizar transação e pagamento correspondente se houver
                $pagamento = $this->pagamentoModel->where('multa_id', $multaId)->first();
                if ($pagamento) {
                    $estadoPagamento = ($novoEstado === 'paga') ? 'pago' : (($novoEstado === 'em_processamento') ? 'em_processamento' : 'pendente');
                    $this->pagamentoModel->update($pagamento['id'], ['estado' => $estadoPagamento]);
                }

                $this->logModel->registrar(
                    $this->session->get('admin_nome'),
                    'Alteração de Estado de Multa',
                    "Multa {$multa['codigo_multa']} alterada de {$multa['estado']} para {$novoEstado}"
                );
                return redirect()->back()->with('success', "Estado da multa {$multa['codigo_multa']} actualizado para " . strtoupper($novoEstado) . ".");
            }
        }

        return redirect()->back()->with('error', 'Não foi possível alterar o estado da multa.');
    }

    /**
     * Gestão de Pagamentos
     */
    public function pagamentos()
    {
        if (!$this->session->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $busca  = $this->request->getGet('busca');
        $estado = $this->request->getGet('estado') ?? 'todos';
        $data   = $this->request->getGet('data');

        $pagamentos   = $this->pagamentoModel->getPagamentosAdmin($estado, $busca, $data);
        $resumo       = $this->getResumoPagamentos();
        $utentesLista = $this->utenteModel->orderBy('nome', 'ASC')->findAll();

        return view('admin/pagamentos', [
            'title'        => 'Gestão de Pagamentos — Admin INATRO',
            'pagamentos'   => $pagamentos,
            'resumo'       => $resumo,
            'utentesLista' => $utentesLista,
            'estadoFiltro' => $estado,
            'busca'        => $busca,
            'dataFiltro'   => $data,
        ]);
    }

    /**
     * Gestão de Transações
     */
    public function transacoes()
    {
        if (!$this->session->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $busca  = $this->request->getGet('busca');
        $estado = $this->request->getGet('estado') ?? 'todos';
        $data   = $this->request->getGet('data');

        $transacoes = $this->pagamentoModel->getPagamentosAdmin($estado, $busca, $data);
        $resumo     = $this->getResumoPagamentos();

        return view('admin/transacoes', [
            'title'        => 'Monitorização de Transacções — Admin INATRO',
            'transacoes'   => $transacoes,
            'resumo'       => $resumo,
            'estadoFiltro' => $estado,
            'busca'        => $busca,
            'dataFiltro'   => $data,
        ]);
    }

    /**
     * Calcular Métricas Globais de Pagamentos/Transacções
     */
    private function getResumoPagamentos()
    {
        $todos = $this->pagamentoModel->findAll();
        $resumo = [
            'total'            => count($todos),
            'valor_total'      => 0.00,
            'pagos'            => 0,
            'valor_pago'       => 0.00,
            'pendentes'        => 0,
            'valor_pendente'   => 0.00,
            'rejeitados'       => 0,
            'valor_rejeitado'  => 0.00,
        ];
        foreach ($todos as $p) {
            $val = floatval($p['valor_pago']);
            $resumo['valor_total'] += $val;
            if ($p['estado'] === 'pago') {
                $resumo['pagos']++;
                $resumo['valor_pago'] += $val;
            } elseif ($p['estado'] === 'em_processamento' || $p['estado'] === 'pendente') {
                $resumo['pendentes']++;
                $resumo['valor_pendente'] += $val;
            } else {
                $resumo['rejeitados']++;
                $resumo['valor_rejeitado'] += $val;
            }
        }
        return $resumo;
    }

    /**
     * Histórico Geral de Pagamentos do Admin
     */
    public function historico()
    {
        if (!$this->session->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $pagamentos = $this->pagamentoModel->getPagamentosAdmin('todos');

        return view('admin/historico', [
            'title'      => 'Histórico Geral de Pagamentos — Admin INATRO',
            'pagamentos' => $pagamentos,
        ]);
    }

    /**
     * Gerar e Descarregar Histórico Geral em PDF (Admin)
     */
    public function gerarPdfHistorico()
    {
        if (!$this->session->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $pagamentos = $this->pagamentoModel->getPagamentosAdmin('todos');
        $resumo     = $this->getResumoPagamentos();

        $html = view('pdf/historico_pagamentos', [
            'title'      => 'Relatório Geral de Pagamentos — INATRO',
            'utente'     => null,
            'pagamentos' => $pagamentos,
            'resumo'     => $resumo,
        ]);

        return PdfService::gerarPdf($html, 'relatorio_geral_pagamentos_inatro.pdf', true);
    }

    /**
     * Gerar e Descarregar PDF Individual de um Pagamento (Admin)
     */
    public function gerarPdfPagamento($refOuId)
    {
        if (!$this->session->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $comprovativo = $this->pagamentoModel->getComprovativo($refOuId);

        if (!$comprovativo) {
            return redirect()->to('/admin/pagamentos')->with('error', 'Comprovativo de pagamento não encontrado.');
        }

        $html = view('pdf/comprovativo_pagamento', [
            'title' => 'Comprovativo de Pagamento — ' . $comprovativo['referencia_transacao'],
            'comp'  => $comprovativo,
        ]);

        $filename = 'comprovativo_' . $comprovativo['referencia_transacao'] . '.pdf';
        return PdfService::gerarPdf($html, $filename, true);
    }

    /**
     * Gerar e Descarregar Extrato Individual por Utente (Admin)
     */
    public function gerarPdfUtente($utenteId)
    {
        if (!$this->session->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $utente = $this->utenteModel->find($utenteId);

        if (!$utente) {
            return redirect()->to('/admin/utentes')->with('error', 'Utente não encontrado.');
        }

        $multas     = $this->multaModel->where('utente_id', $utenteId)->orderBy('data_infracao', 'DESC')->findAll();
        $pagamentos = $this->pagamentoModel->where('utente_id', $utenteId)->findAll();
        
        $pagamentosPorMulta = [];
        foreach ($pagamentos as $p) {
            $pagamentosPorMulta[$p['multa_id']] = $p;
        }

        $valorPagoTotal = 0.00;
        $valorPendenteTotal = 0.00;
        $qtdPagas = 0;
        $qtdPendentes = 0;
        $qtdVencidas = 0;

        foreach ($multas as $m) {
            $val = floatval($m['valor'] ?? $m['valor_multa'] ?? 0);
            $pag = $pagamentosPorMulta[$m['id']] ?? null;

            if ($m['estado'] === 'paga' || ($pag && $pag['estado'] === 'pago')) {
                $qtdPagas++;
                $valorPagoTotal += $val;
            } elseif ($m['estado'] === 'vencida') {
                $qtdVencidas++;
                $valorPendenteTotal += $val;
            } else {
                $qtdPendentes++;
                $valorPendenteTotal += $val;
            }
        }

        $resumo = [
            'total_multas'         => count($multas),
            'qtd_pagas'            => $qtdPagas,
            'qtd_pendentes'        => $qtdPendentes,
            'qtd_vencidas'         => $qtdVencidas,
            'valor_pago_total'     => $valorPagoTotal,
            'valor_pendente_total' => $valorPendenteTotal,
            'valor_total_global'   => $valorPagoTotal + $valorPendenteTotal,
        ];

        $html = view('pdf/relatorio_utente', [
            'title'              => 'Extrato de Utente — ' . $utente['nome'],
            'utente'             => $utente,
            'multas'             => $multas,
            'pagamentosPorMulta' => $pagamentosPorMulta,
            'resumo'             => $resumo,
        ]);

        $filename = 'extrato_utente_' . preg_replace('/[^a-zA-Z0-9]/', '_', strtolower($utente['nome'])) . '.pdf';
        return PdfService::gerarPdf($html, $filename, true);
    }

    /**
     * Relatórios
     */
    public function relatorios()
    {
        if (!$this->session->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        return view('admin/relatorios', [
            'title' => 'Relatórios Gerenciais — Admin INATRO',
        ]);
    }

    /**
     * Logs do Sistema
     */
    public function logs()
    {
        if (!$this->session->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $logs = $this->logModel->orderBy('created_at', 'DESC')->findAll(100);

        return view('admin/logs', [
            'title' => 'Logs de Atividade — Admin INATRO',
            'logs'  => $logs,
        ]);
    }

    /**
     * Configurações
     */
    public function configuracoes()
    {
        if (!$this->session->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        return view('admin/configuracoes', [
            'title' => 'Configurações do Sistema — Admin INATRO',
        ]);
    }

    /**
     * Logout Admin
     */
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/admin/login')->with('info', 'Sessão administrativa encerrada.');
    }

    /**
     * Helper privado para gerar número de carta no formato XXXXXXXX/MZ
     */
    private function gerarNumeroCarta()
    {
        do {
            $num = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . '/MZ';
            $exists = $this->utenteModel->where('numero_carta', $num)->countAllResults();
        } while ($exists > 0);

        return $num;
    }
}
