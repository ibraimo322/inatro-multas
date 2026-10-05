<?= $this->extend('layouts/utente') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        
        <div class="d-flex align-items-center justify-content-between mb-4">
            <a href="<?= base_url('/utente/pagar/' . $multa['id']) ?>" class="btn btn-outline-secondary btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> Alterar Método
            </a>
            <span class="badge bg-warning text-dark px-3 py-2 fw-semibold">Passo Final de Pagamento</span>
        </div>

        <div class="card card-inatro p-4 p-md-5 shadow-lg border-0 border-top border-success border-4">
            <div class="text-center mb-4 pb-3 border-bottom">
                <div class="service-icon-box mx-auto mb-3 bg-success-subtle text-success">
                    <i class="fa-solid fa-shield-check"></i>
                </div>
                <h3 class="fw-bold text-dark mb-1">Confirme os Dados do Pagamento</h3>
                <p class="text-muted small">Verifique as informações antes de autorizar o débito/liquidação simulada.</p>
            </div>

            <!-- TABELA DE RESUMO DE CONFIRMAÇÃO -->
            <div class="table-responsive mb-4">
                <table class="table table-bordered align-middle">
                    <tbody>
                        <tr>
                            <td class="bg-light fw-bold text-secondary" style="width: 40%;">Número da Multa:</td>
                            <td class="fw-bold text-dark fs-6"><?= esc($multa['codigo_multa']) ?></td>
                        </tr>
                        <tr>
                            <td class="bg-light fw-bold text-secondary">Condutor / Utente:</td>
                            <td class="fw-semibold text-dark"><?= esc(session()->get('utente_nome')) ?></td>
                        </tr>
                        <tr>
                            <td class="bg-light fw-bold text-secondary">Infração:</td>
                            <td><?= esc($multa['tipo_infracao']) ?></td>
                        </tr>
                        <tr>
                            <td class="bg-light fw-bold text-secondary">Método Seleccionado:</td>
                            <td>
                                <span class="badge bg-success-subtle text-success border border-success px-3 py-1 fw-bold fs-6">
                                    <i class="fa-solid fa-credit-card me-1"></i> <?= esc($metodo) ?>
                                </span>
                                <?php if (!empty($contato)): ?>
                                    <div class="small text-muted mt-1">Contacto: <?= esc($contato) ?></div>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="bg-light fw-bold text-secondary fs-5">Valor Total a Pagar:</td>
                            <td class="fw-bold text-success fs-4"><?= number_format($multa['valor'], 2, ',', '.') ?> MT</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="p-3 bg-light rounded-3 border mb-4">
                <div class="d-flex gap-2 text-muted small">
                    <i class="fa-solid fa-shield-halved text-success mt-1 fs-5"></i>
                    <div>
                        <strong>Informação Importante:</strong> Ao clicar em <em>Confirmar Pagamento</em>, o sistema procederá à liquidação oficial da multa e emitirá o respectivo comprovativo com número de referência transacional.
                    </div>
                </div>
            </div>

            <!-- FORMULÁRIO DE CONFIRMAÇÃO DE PROCESSAMENTO -->
            <form action="<?= base_url('/utente/processar-pagamento') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="multa_id" value="<?= esc($multa['id']) ?>">
                <input type="hidden" name="metodo_pagamento" value="<?= esc($metodo) ?>">
                <input type="hidden" name="detalhes_metodo" value="<?= esc($contato) ?>">

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success btn-lg fw-bold shadow-sm">
                        <i class="fa-solid fa-circle-check me-2"></i> Confirmar Pagamento
                    </button>
                    <a href="<?= base_url('/utente/dashboard') ?>" class="btn btn-outline-secondary">
                        Cancelar e Voltar ao Painel
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>

<?= $this->endSection() ?>
