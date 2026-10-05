<?= $this->extend('layouts/utente') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        
        <div class="d-flex align-items-center justify-content-between mb-4 no-print">
            <a href="<?= base_url('/utente/historico') ?>" class="btn btn-outline-secondary btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> Voltar ao Histórico
            </a>
            <div class="d-flex gap-2">
                <a href="<?= base_url('/utente/gerar-pdf-pagamento/' . $comp['referencia_transacao']) ?>" class="btn btn-success btn-sm shadow-sm" target="_blank">
                    <i class="fa-solid fa-file-pdf me-1"></i> Baixar PDF
                </a>
                <button onclick="window.print();" class="btn btn-inatro-primary btn-sm shadow-sm">
                    <i class="fa-solid fa-print me-1"></i> Imprimir Comprovativo
                </button>
            </div>
        </div>

        <!-- ESTRUTURA DO COMPROVATIVO PARA IMPRESSÃO E VISUALIZAÇÃO -->
        <div class="receipt-card">
            
            <!-- LOGO E CABEÇALHO INSTITUCIONAL -->
            <div class="text-center mb-4 pb-3 border-bottom border-2">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo INATRO" class="img-fluid" style="max-height: 80px; width: auto; object-fit: contain;">
                </div>
                <div class="text-uppercase fw-bold text-dark" style="font-size: 0.9rem; letter-spacing: 1px;">REPÚBLICA DE MOÇAMBIQUE</div>
                <div class="text-uppercase text-success fw-bold" style="font-size: 0.85rem;">INSTITUTO NACIONAL DOS TRANSPORTES TERRESTRES (INATRO, IP)</div>
                <div class="badge bg-success text-white mt-2 px-3 py-1 text-uppercase" style="letter-spacing: 1px; font-size: 0.75rem;">
                    SISTEMA INTEGRADO DE GESTÃO DE MULTAS
                </div>
            </div>

            <!-- TÍTULO -->
            <div class="text-center mb-4">
                <h4 class="fw-bold text-dark text-uppercase mb-1">Comprovativo de Pagamento</h4>
                <div class="text-muted small">DOCUMENTO COMPROVATIVO OFICIAL DE LIQUIDAÇÃO</div>
            </div>

            <!-- DETALHES EM GRELHA -->
            <div class="row g-3 mb-4">
                <div class="col-sm-6">
                    <div class="p-3 bg-light rounded border">
                        <small class="text-muted d-block fw-semibold" style="font-size: 0.75rem;">REFERÊNCIA DA TRANSAÇÃO</small>
                        <strong class="text-dark fs-6"><code><?= esc($comp['referencia_transacao']) ?></code></strong>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="p-3 bg-light rounded border">
                        <small class="text-muted d-block fw-semibold" style="font-size: 0.75rem;">N.º DO AUTO DE MULTA</small>
                        <strong class="text-dark fs-6"><?= esc($comp['codigo_multa']) ?></strong>
                    </div>
                </div>

                <div class="col-sm-6">
                    <small class="text-muted d-block fw-semibold" style="font-size: 0.75rem;">NOME DO CONDUTOR</small>
                    <div class="fw-bold text-dark"><?= esc($comp['utente_nome']) ?></div>
                </div>

                <div class="col-sm-6">
                    <small class="text-muted d-block fw-semibold" style="font-size: 0.75rem;">CARTA DE CONDUÇÃO N.º</small>
                    <div class="fw-bold text-dark"><code><?= esc($comp['numero_carta']) ?></code></div>
                </div>

                <div class="col-sm-6">
                    <small class="text-muted d-block fw-semibold" style="font-size: 0.75rem;">N.º DO BI</small>
                    <div class="fw-semibold text-dark"><?= esc($comp['bi_numero'] ?? 'Não registado') ?></div>
                </div>

                <div class="col-sm-6">
                    <small class="text-muted d-block fw-semibold" style="font-size: 0.75rem;">DATA DA TRANSAÇÃO</small>
                    <div class="fw-semibold text-dark"><?= date('d/m/Y \à\s H:i:s', strtotime($comp['data_pagamento'])) ?></div>
                </div>

                <div class="col-12 border-top pt-3">
                    <small class="text-muted d-block fw-semibold" style="font-size: 0.75rem;">TIPO DE INFRAÇÃO REGISTADA</small>
                    <div class="fw-semibold text-dark"><?= esc($comp['tipo_infracao']) ?></div>
                    <small class="text-muted"><?= esc($comp['local_infracao']) ?></small>
                </div>

                <div class="col-sm-6 border-top pt-3">
                    <small class="text-muted d-block fw-semibold" style="font-size: 0.75rem;">MÉTODO DE PAGAMENTO</small>
                    <div class="fw-bold text-dark"><i class="fa-solid fa-check text-success me-1"></i> <?= esc($comp['metodo_pagamento']) ?></div>
                </div>

                <div class="col-sm-6 border-top pt-3">
                    <small class="text-muted d-block fw-semibold" style="font-size: 0.75rem;">ESTADO DO PAGAMENTO</small>
                    <span class="badge bg-success text-white px-3 py-1 fw-bold fs-6">
                        <i class="fa-solid fa-circle-check me-1"></i> PAGO
                    </span>
                </div>
            </div>

            <!-- VALOR DESTAQUE -->
            <div class="receipt-amount-box text-center py-3 px-4 mb-4 rounded border border-success">
                <small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 0.8rem;">VALOR TOTAL LIQUIDADO</small>
                <div class="fw-bold text-success display-6 mb-0"><?= number_format($comp['valor_pago'], 2, ',', '.') ?> MT</div>
                <small class="text-muted">Moeda Nacional (Meticais Moçambicanos)</small>
            </div>

            <!-- RODAPÉ DE VALIDAÇÃO INSTITUCIONAL -->
            <div class="border-top pt-3 text-center text-muted" style="font-size: 0.78rem;">
                <p class="mb-1">Este comprovativo foi gerado automaticamente pelo Sistema de Pagamento Electrónico do INATRO.</p>
                <p class="mb-0">Código de Verificação de Autenticidade: <code><?= md5($comp['referencia_transacao'] . $comp['codigo_multa']) ?></code></p>
                <small class="text-muted d-block mt-2">Documento Oficial com Validade Jurídica e Administrativa.</small>
            </div>

        </div>

        <div class="text-center mt-3 no-print">
            <a href="<?= base_url('/utente/gerar-pdf-pagamento/' . $comp['referencia_transacao']) ?>" class="btn btn-success shadow-sm px-4 me-2" target="_blank">
                <i class="fa-solid fa-file-pdf me-1"></i> Baixar PDF
            </a>
            <button onclick="window.print();" class="btn btn-inatro-primary shadow-sm px-4 me-2">
                <i class="fa-solid fa-print me-1"></i> Imprimir Documento
            </button>
            <a href="<?= base_url('/utente/dashboard') ?>" class="btn btn-outline-secondary px-4">
                Voltar ao Painel
            </a>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
