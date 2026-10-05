<?php

namespace App\Controllers;

use App\Models\UtenteModel;
use App\Models\MultaModel;
use App\Models\PagamentoModel;
use App\Models\LogModel;

class Utente extends BaseController
{
    protected $utenteModel;
    protected $multaModel;
    protected $pagamentoModel;
    protected $logModel;
    protected $session;

    public function __construct()
    {
        $this->utenteModel    = new UtenteModel();
        $this->multaModel     = new MultaModel();
        $this->pagamentoModel = new PagamentoModel();
        $this->logModel       = new LogModel();
        $this->session        = session();
    }

    /**
     * Tela de Identificação de Utente / Condutor
     */
    public function login()
    {
        if ($this->session->get('utente_logged_in')) {
            return redirect()->to('/utente/dashboard');
        }

        return view('utente/login', [
            'title' => 'Identificação do Condutor — INATRO',
        ]);
    }

    /**
     * Processamento de Login / Identificação do Utente
     */
    public function autenticar()
    {
        $numeroCarta    = $this->request->getPost('numero_carta');
        $dataNascimento = $this->request->getPost('data_nascimento');

        if (empty($numeroCarta) || empty($dataNascimento)) {
            return redirect()->back()->with('error', 'Por favor, preencha o número da carta de condução e a data de nascimento.')->withInput();
        }

        $utente = $this->utenteModel->autenticar($numeroCarta, $dataNascimento);

        if (!$utente) {
            return redirect()->back()->with('error', 'Nenhum condutor encontrado com o N.º de Carta e Data de Nascimento indicados. Verifique os dados digitados.')->withInput();
        }

        // Criar Sessão do Utente
        $this->session->set([
            'utente_logged_in' => true,
            'utente_id'        => $utente['id'],
            'utente_nome'      => $utente['nome'],
            'utente_carta'     => $utente['numero_carta'],
            'utente_data_nasc' => $utente['data_nascimento'],
        ]);

        $this->logModel->registrar($utente['nome'], 'Autenticação no Portal', "Identificação efectuada com a carta {$utente['numero_carta']}");

        return redirect()->to('/utente/dashboard');
    }

    /**
     * Dashboard Principal do Condutor
     */
    public function dashboard()
    {
        if (!$this->session->get('utente_logged_in')) {
            return redirect()->to('/utente/login')->with('warning', 'Por favor, identifique-se primeiro.');
        }

        $utenteId = $this->session->get('utente_id');
        $estadoFiltro = $this->request->getGet('estado') ?? 'todas';

        $resumo = $this->multaModel->getResumoUtente($utenteId);
        $multas = $this->multaModel->getMultasUtente($utenteId, $estadoFiltro);

        return view('utente/dashboard', [
            'title'        => 'Painel do Condutor — INATRO',
            'resumo'       => $resumo,
            'multas'       => $multas,
            'estadoFiltro' => $estadoFiltro,
        ]);
    }

    /**
     * Detalhes de uma Multa Específica
     */
    public function multa($id)
    {
        if (!$this->session->get('utente_logged_in')) {
            return redirect()->to('/utente/login');
        }

        $utenteId = $this->session->get('utente_id');
        $multa = $this->multaModel->where('id', $id)->where('utente_id', $utenteId)->first();

        if (!$multa) {
            return redirect()->to('/utente/dashboard')->with('error', 'Multa não encontrada.');
        }

        return view('utente/multa_detalhes', [
            'title' => 'Detalhes da Multa ' . $multa['codigo_multa'],
            'multa' => $multa,
        ]);
    }

    /**
     * Formulário de Selecção de Método de Pagamento (Mock)
     */
    public function pagar($id)
    {
        if (!$this->session->get('utente_logged_in')) {
            return redirect()->to('/utente/login');
        }

        $utenteId = $this->session->get('utente_id');
        $multa = $this->multaModel->where('id', $id)->where('utente_id', $utenteId)->first();

        if (!$multa) {
            return redirect()->to('/utente/dashboard')->with('error', 'Multa não encontrada.');
        }

        if ($multa['estado'] === 'paga') {
            return redirect()->to('/utente/multa/' . $id)->with('info', 'Esta multa já se encontra paga.');
        }

        return view('utente/pagamento', [
            'title' => 'Pagamento de Multa — ' . $multa['codigo_multa'],
            'multa' => $multa,
        ]);
    }

    /**
     * Página de Confirmação dos Dados de Pagamento
     */
    public function confirmar()
    {
        if (!$this->session->get('utente_logged_in')) {
            return redirect()->to('/utente/login');
        }

        $multaId = $this->request->getPost('multa_id');
        $metodo  = $this->request->getPost('metodo_pagamento');
        $contato = $this->request->getPost('detalhes_metodo');

        if (empty($multaId) || empty($metodo)) {
            return redirect()->back()->with('error', 'Selecione um método de pagamento válido.');
        }

        $utenteId = $this->session->get('utente_id');
        $multa = $this->multaModel->where('id', $multaId)->where('utente_id', $utenteId)->first();

        if (!$multa) {
            return redirect()->to('/utente/dashboard');
        }

        return view('utente/confirmacao', [
            'title'   => 'Confirmação do Pagamento — INATRO',
            'multa'   => $multa,
            'metodo'  => $metodo,
            'contato' => $contato,
        ]);
    }

    /**
     * Processamento Simulado do Pagamento (Mock Processing)
     */
    public function processarPagamento()
    {
        if (!$this->session->get('utente_logged_in')) {
            return redirect()->to('/utente/login');
        }

        $multaId = $this->request->getPost('multa_id');
        $metodo  = $this->request->getPost('metodo_pagamento');
        $contato = $this->request->getPost('detalhes_metodo');

        $utenteId = $this->session->get('utente_id');
        $multa    = $this->multaModel->where('id', $multaId)->where('utente_id', $utenteId)->first();

        if (!$multa) {
            return redirect()->to('/utente/dashboard');
        }

        // Gerar Referência Fictícia de Transação
        $refTransacao = 'TX-2026-' . str_pad(rand(100, 999999), 6, '0', STR_PAD_LEFT);

        // Criar Registo de Pagamento
        $this->pagamentoModel->insert([
            'referencia_transacao' => $refTransacao,
            'multa_id'             => $multa['id'],
            'utente_id'            => $utenteId,
            'valor_pago'           => $multa['valor'],
            'metodo_pagamento'     => $metodo,
            'detalhes_metodo'      => $contato,
            'estado'               => 'pago',
            'data_pagamento'       => date('Y-m-d H:i:s'),
        ]);

        // Atualizar Estado da Multa para Paga
        $this->multaModel->update($multa['id'], [
            'estado' => 'paga',
        ]);

        $this->logModel->registrar(
            $this->session->get('utente_nome'),
            'Pagamento Concluído (Demonstração)',
            "Pagamento da multa {$multa['codigo_multa']} no valor de " . number_format($multa['valor'], 2, ',', '.') . " MT via {$metodo} [Ref: {$refTransacao}]"
        );

        return redirect()->to('/utente/comprovativo/' . $refTransacao)->with('success', 'Pagamento efectuado com sucesso.');
    }

    /**
     * Visualização do Comprovativo de Pagamento
     */
    public function comprovativo($refOuId)
    {
        if (!$this->session->get('utente_logged_in')) {
            return redirect()->to('/utente/login');
        }

        $comprovativo = $this->pagamentoModel->getComprovativo($refOuId);

        if (!$comprovativo) {
            return redirect()->to('/utente/dashboard')->with('error', 'Comprovativo não encontrado.');
        }

        return view('utente/comprovativo', [
            'title' => 'Comprovativo de Pagamento — ' . $comprovativo['referencia_transacao'],
            'comp'  => $comprovativo,
        ]);
    }

    /**
     * Histórico de Pagamentos do Utente
     */
    public function historico()
    {
        if (!$this->session->get('utente_logged_in')) {
            return redirect()->to('/utente/login');
        }

        $utenteId   = $this->session->get('utente_id');
        $pagamentos = $this->pagamentoModel->getHistoricoUtente($utenteId);

        return view('utente/historico', [
            'title'      => 'Histórico de Pagamentos — INATRO',
            'pagamentos' => $pagamentos,
        ]);
    }

    /**
     * Gerar e descarregar PDF individual de um pagamento (Utente)
     */
    public function gerarPdfPagamento($refOuId)
    {
        if (!$this->session->get('utente_logged_in')) {
            return redirect()->to('/utente/login');
        }

        $comprovativo = $this->pagamentoModel->getComprovativo($refOuId);

        if (!$comprovativo) {
            return redirect()->to('/utente/historico')->with('error', 'Comprovativo de pagamento não encontrado.');
        }

        // Validação de Segurança: Garantir que o pagamento pertence ao utente autenticado
        $utenteId = $this->session->get('utente_id');
        if ($comprovativo['utente_id'] != $utenteId) {
            return redirect()->to('/utente/historico')->with('error', 'Acesso não autorizado a este comprovativo.');
        }

        $html = view('pdf/comprovativo_pagamento', [
            'title' => 'Comprovativo de Pagamento — ' . $comprovativo['referencia_transacao'],
            'comp'  => $comprovativo,
        ]);

        $filename = 'comprovativo_' . $comprovativo['referencia_transacao'] . '.pdf';
        return \App\Libraries\PdfService::gerarPdf($html, $filename, true);
    }

    /**
     * Gerar e descarregar Histórico Geral de Pagamentos em PDF (Formato Vertical)
     */
    public function gerarPdfHistorico()
    {
        if (!$this->session->get('utente_logged_in')) {
            return redirect()->to('/utente/login');
        }

        $utenteId   = $this->session->get('utente_id');
        $utente     = $this->utenteModel->find($utenteId);

        if (!$utente) {
            return redirect()->to('/utente/login');
        }

        $multas     = $this->multaModel->where('utente_id', $utenteId)->orderBy('data_infracao', 'DESC')->findAll();
        $pagamentos = $this->pagamentoModel->where('utente_id', $utenteId)->findAll();

        $pagamentosPorMulta = [];
        foreach ($pagamentos as $p) {
            $pagamentosPorMulta[$p['multa_id']] = $p;
        }

        $html = view('pdf/historico_utente_vertical', [
            'title'              => 'Histórico Geral de Pagamentos — ' . $utente['nome'],
            'utente'             => $utente,
            'multas'             => $multas,
            'pagamentosPorMulta' => $pagamentosPorMulta,
        ]);

        $filename = 'historico_geral_' . preg_replace('/[^a-zA-Z0-9]/', '_', strtolower($utente['nome'])) . '.pdf';
        return \App\Libraries\PdfService::gerarPdf($html, $filename, true);
    }

    /**
     * Terminar Sessão do Utente
     */
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/utente/login')->with('info', 'Sessão terminada com sucesso.');
    }
}
