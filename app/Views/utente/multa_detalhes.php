<?= $this->extend('layouts/utente') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-9">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <a href="<?= base_url('/utente/dashboard') ?>" class="btn btn-outline-secondary btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> Voltar ao Painel
            </a>
            <span class="text-muted small">Visualização de Infração</span>
        </div>

        <div class="card card-inatro p-4 p-md-5 mb-4 shadow-sm border-0">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center border-bottom pb-4 mb-4 gap-3">
                <div>
                    <span class="text-success fw-bold text-uppercase" style="font-size: 0.85rem;">Infração de Trânsito</span>
                    <h3 class="fw-bold text-dark mb-0"><?= esc($multa['codigo_multa']) ?></h3>
                </div>
                <div>
                    <?php if ($multa['estado'] === 'pendente'): ?>
                        <span class="badge-status badge-pendente fs-6 py-2 px-3">
                            <i class="fa-solid fa-clock me-1"></i> Multa Pendente
                        </span>
                    <?php elseif ($multa['estado'] === 'paga'): ?>
                        <span class="badge-status badge-paga fs-6 py-2 px-3">
                            <i class="fa-solid fa-circle-check me-1"></i> Multa Liquidadas / Paga
                        </span>
                    <?php elseif ($multa['estado'] === 'em_processamento'): ?>
                        <span class="badge-status badge-em_processamento fs-6 py-2 px-3">
                            <i class="fa-solid fa-arrows-rotate fa-spin me-1"></i> Em Processamento
                        </span>
                    <?php elseif ($multa['estado'] === 'vencida'): ?>
                        <span class="badge-status badge-vencida fs-6 py-2 px-3">
                            <i class="fa-solid fa-triangle-exclamation me-1"></i> Multa Vencida
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3 border">
                        <small class="text-muted d-block fw-semibold mb-1">TIPO DE INFRAÇÃO</small>
                        <div class="fw-bold text-dark fs-5"><?= esc($multa['tipo_infracao']) ?></div>
                        <small class="text-success fw-medium"><?= esc($multa['artigo_lei'] ?? 'Artigo do Código da Estrada') ?></small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3 border">
                        <small class="text-muted d-block fw-semibold mb-1">VALOR DA MULTA</small>
                        <div class="fw-bold text-success fs-3"><?= number_format($multa['valor'], 2, ',', '.') ?> MT</div>
                        <small class="text-muted">Moeda Nacional (Meticais)</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <small class="text-muted d-block fw-semibold mb-1"><i class="fa-solid fa-calendar-day me-1"></i> DATA E HORA DA INFRAÇÃO</small>
                    <div class="fw-semibold text-dark"><?= date('d/m/Y \à\s H:i', strtotime($multa['data_infracao'])) ?></div>
                </div>

                <div class="col-md-6">
                    <small class="text-muted d-block fw-semibold mb-1"><i class="fa-solid fa-calendar-xmark me-1"></i> DATA DE VENCIMENTO</small>
                    <div class="fw-semibold text-dark"><?= date('d/m/Y', strtotime($multa['data_vencimento'])) ?></div>
                </div>

                <div class="col-md-12">
                    <small class="text-muted d-block fw-semibold mb-1"><i class="fa-solid fa-map-location-dot me-1"></i> LOCAL DA INFRAÇÃO</small>
                    <div class="fw-semibold text-dark"><?= esc($multa['local_infracao']) ?></div>
                </div>

                <div class="col-md-12">
                    <small class="text-muted d-block fw-semibold mb-1"><i class="fa-solid fa-align-left me-1"></i> DESCRIÇÃO DETALHADA</small>
                    <p class="text-muted mb-0 bg-light p-3 rounded-3 border">
                        <?= esc($multa['descricao'] ?? 'Sem observações adicionais registadas pelo agente fiscalizador.') ?>
                    </p>
                </div>
            </div>

            <!-- ACÇÕES CONTEXTUAIS BASEADAS NO ESTADO -->
            <div class="pt-4 border-top text-end">
                <?php if ($multa['estado'] === 'pendente'): ?>
                    <a href="<?= base_url('/utente/pagar/' . $multa['id']) ?>" class="btn btn-inatro-primary btn-lg shadow-sm">
                        <i class="fa-solid fa-credit-card me-2"></i> Pagar Multa Agora
                    </a>
                <?php elseif ($multa['estado'] === 'paga'): ?>
                    <a href="<?= base_url('/utente/comprovativo/' . $multa['codigo_multa']) ?>" class="btn btn-success btn-lg shadow-sm">
                        <i class="fa-solid fa-file-invoice me-2"></i> Ver Comprovativo de Pagamento
                    </a>
                <?php elseif ($multa['estado'] === 'em_processamento'): ?>
                    <a href="<?= base_url('/utente/historico') ?>" class="btn btn-info text-white btn-lg shadow-sm">
                        <i class="fa-solid fa-arrows-rotate me-2"></i> Ver Estado do Pagamento
                    </a>
                <?php elseif ($multa['estado'] === 'vencida'): ?>
                    <a href="<?= base_url('/utente/pagar/' . $multa['id']) ?>" class="btn btn-warning text-dark btn-lg shadow-sm">
                        <i class="fa-solid fa-hand-holding-dollar me-2"></i> Consultar Opções de Regularização
                    </a>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
