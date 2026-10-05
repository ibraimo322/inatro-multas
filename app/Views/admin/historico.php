<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<!-- INATRO INSTITUTIONAL HEADER LOGO (CENTERED) -->
<div class="card card-inatro p-4 mb-4 shadow-sm border-0 text-center">
    <div class="d-flex justify-content-center align-items-center mb-3">
        <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logótipo INATRO" class="img-fluid" style="max-height: 80px; width: auto; object-fit: contain;">
    </div>
    <h5 class="fw-bold text-success text-uppercase mb-1" style="letter-spacing: 0.5px;">REPÚBLICA DE MOÇAMBIQUE</h5>
    <h6 class="fw-bold text-dark mb-2">INSTITUTO NACIONAL DOS TRANSPORTES TERRESTRES (INATRO, IP)</h6>
    <div class="border-top pt-3 mt-2 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
        <div class="text-start">
            <h4 class="fw-bold text-dark mb-1">
                <i class="fa-solid fa-clock-rotate-left text-success me-2"></i> Histórico Geral de Pagamentos
            </h4>
            <p class="text-muted small mb-0">Visão consolidada de todas as transações e pagamentos registados no sistema.</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="<?= base_url('/admin/gerar-pdf-historico') ?>" class="btn btn-success btn-sm shadow-sm px-3" target="_blank">
                <i class="fa-solid fa-file-pdf me-1"></i> Baixar Relatório Geral em PDF
            </a>
            <a href="<?= base_url('/admin/dashboard') ?>" class="btn btn-outline-secondary btn-sm px-3">
                <i class="fa-solid fa-arrow-left me-1"></i> Voltar ao Painel
            </a>
        </div>
    </div>
</div>

<div class="card card-inatro p-4 shadow-sm border-0">
    <?php if (empty($pagamentos)): ?>
        <div class="text-center py-5">
            <i class="fa-solid fa-receipt text-muted fs-1 mb-3"></i>
            <p class="text-muted fw-medium mb-0">Nenhum pagamento registado no sistema.</p>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Ref. Transação</th>
                        <th scope="col">Utente / Condutor</th>
                        <th scope="col">N.º Carta</th>
                        <th scope="col">Multa N.º</th>
                        <th scope="col">Método</th>
                        <th scope="col">Data Pagamento</th>
                        <th scope="col">Valor Pago</th>
                        <th scope="col">Estado</th>
                        <th scope="col" class="text-end">Comprovativo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pagamentos as $p): ?>
                        <tr>
                            <td>
                                <code class="fw-bold text-dark"><?= esc($p['referencia_transacao']) ?></code>
                            </td>
                            <td>
                                <strong class="text-dark"><?= esc($p['utente_nome'] ?? 'N/A') ?></strong>
                            </td>
                            <td>
                                <code class="text-muted"><?= esc($p['numero_carta'] ?? 'N/A') ?></code>
                            </td>
                            <td>
                                <strong class="text-dark"><?= esc($p['codigo_multa']) ?></strong>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    <i class="fa-solid fa-credit-card text-success me-1"></i> <?= esc($p['metodo_pagamento']) ?>
                                </span>
                            </td>
                            <td class="small">
                                <?= date('d/m/Y H:i', strtotime($p['data_pagamento'])) ?>
                            </td>
                            <td>
                                <strong class="text-success"><?= number_format($p['valor_pago'], 2, ',', '.') ?> MT</strong>
                            </td>
                            <td>
                                <?php if ($p['estado'] === 'pago'): ?>
                                    <span class="badge-status badge-paga">
                                        <i class="fa-solid fa-circle-check"></i> Pago
                                    </span>
                                <?php elseif ($p['estado'] === 'em_processamento' || $p['estado'] === 'pendente'): ?>
                                    <span class="badge-status badge-em_processamento">
                                        <i class="fa-solid fa-arrows-rotate fa-spin"></i> Pendente
                                    </span>
                                <?php else: ?>
                                    <span class="badge-status badge-vencida">
                                        <i class="fa-solid fa-circle-xmark"></i> Rejeitado
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end" style="white-space: nowrap;">
                                <a href="<?= base_url('/admin/gerar-pdf-pagamento/' . $p['referencia_transacao']) ?>" class="btn btn-success btn-sm shadow-sm" target="_blank" title="Baixar PDF">
                                    <i class="fa-solid fa-file-pdf me-1"></i> PDF
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
