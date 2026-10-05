<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<!-- CABEÇALHO DA PÁGINA -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-chart-line text-success me-2"></i> Painel de Gestão Administrativa
        </h4>
        <p class="text-muted small mb-0">Visão panorâmica de multas, arrecadação e actividade no sistema INATRO.</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="<?= base_url('/admin/atribuir-multa') ?>" class="btn btn-inatro-primary btn-sm shadow-sm px-3">
            <i class="fa-solid fa-file-circle-plus me-1"></i> Atribuir Multa
        </a>
        <a href="<?= base_url('/admin/novo-utente') ?>" class="btn btn-outline-secondary btn-sm px-3">
            <i class="fa-solid fa-user-plus me-1"></i> Registar Utente
        </a>
    </div>
</div>

<!-- CARTÕES DE MÉTRICAS PRINCIPAIS -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card card-inatro p-3 border-start border-primary border-4 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase mb-1">Total de Multas</div>
                    <div class="fs-3 fw-bold text-dark"><?= esc($totalMultas) ?></div>
                    <div class="small text-muted">registadas no sistema</div>
                </div>
                <div class="fs-1 text-primary opacity-25">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card card-inatro p-3 border-start border-warning border-4 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase mb-1">Multas Pendentes</div>
                    <div class="fs-3 fw-bold text-warning"><?= esc($totalPendentes) ?></div>
                    <div class="small text-muted">aguardam pagamento</div>
                </div>
                <div class="fs-1 text-warning opacity-25">
                    <i class="fa-solid fa-hourglass-half"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card card-inatro p-3 border-start border-success border-4 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase mb-1">Multas Liquidadas</div>
                    <div class="fs-3 fw-bold text-success"><?= esc($totalPagas) ?></div>
                    <div class="small text-muted">pagas com sucesso</div>
                </div>
                <div class="fs-1 text-success opacity-25">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card card-inatro p-3 border-start border-info border-4 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase mb-1">Total Arrecadado</div>
                    <div class="fs-4 fw-bold text-dark" style="line-height: 1.2;"><?= number_format($totalValorRec, 2, ',', '.') ?> <small class="fs-6 text-muted fw-normal">MT</small></div>
                    <div class="small text-muted">valor confirmado</div>
                </div>
                <div class="fs-1 text-info opacity-25">
                    <i class="fa-solid fa-vault"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- LINHA SECUNDÁRIA: UTENTES + TRANSACÇÕES -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card card-inatro p-3 border-start border-secondary border-4 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase mb-1">Utentes Registados</div>
                    <div class="fs-3 fw-bold text-dark"><?= esc($totalUtentes) ?></div>
                    <div class="small text-muted">condutores activos</div>
                </div>
                <div class="fs-1 text-secondary opacity-25">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card card-inatro p-3 border-start border-dark border-4 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase mb-1">Transacções</div>
                    <div class="fs-3 fw-bold text-dark"><?= esc($totalTrans) ?></div>
                    <div class="small text-muted">operações processadas</div>
                </div>
                <div class="fs-1 text-dark opacity-15">
                    <i class="fa-solid fa-receipt"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- ATALHOS RÁPIDOS -->
    <div class="col-lg-4">
        <div class="card card-inatro p-4 shadow-sm h-100">
            <h6 class="fw-bold text-dark mb-3 border-bottom pb-2">
                <i class="fa-solid fa-bolt text-warning me-2"></i>Atalhos Rápidos
            </h6>
            <div class="d-grid gap-2">
                <a href="<?= base_url('/admin/atribuir-multa') ?>" class="btn btn-outline-success text-start py-2">
                    <i class="fa-solid fa-file-circle-plus me-2"></i> Atribuir Nova Multa
                </a>
                <a href="<?= base_url('/admin/novo-utente') ?>" class="btn btn-outline-secondary text-start py-2">
                    <i class="fa-solid fa-user-plus me-2"></i> Registar Novo Utente
                </a>
                <a href="<?= base_url('/admin/pagamentos') ?>" class="btn btn-outline-primary text-start py-2">
                    <i class="fa-solid fa-credit-card me-2"></i> Monitor de Pagamentos
                </a>
                <a href="<?= base_url('/admin/gerar-pdf-historico') ?>" class="btn btn-outline-dark text-start py-2" target="_blank">
                    <i class="fa-solid fa-file-pdf me-2 text-danger"></i> Gerar Relatório PDF Geral
                </a>
            </div>
        </div>
    </div>

    <!-- LOGS RECENTES -->
    <div class="col-lg-8">
        <div class="card card-inatro p-4 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                <h6 class="fw-bold text-dark mb-0">
                    <i class="fa-solid fa-list-check text-success me-2"></i>Actividade Recente no Sistema
                </h6>
                <a href="<?= base_url('/admin/logs') ?>" class="small text-success text-decoration-none fw-semibold">Ver Todos <i class="fa-solid fa-arrow-right ms-1"></i></a>
            </div>

            <?php if (empty($recentLogs)): ?>
                <p class="text-muted small mb-0 text-center py-4">Sem registos de actividade recente.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle mb-0" style="font-size: 0.85rem;">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" style="white-space: nowrap;">Data/Hora</th>
                                <th scope="col">Utilizador</th>
                                <th scope="col">Acção</th>
                                <th scope="col">Detalhes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentLogs as $log): ?>
                                <tr>
                                    <td class="text-muted" style="white-space: nowrap;">
                                        <?= date('d/m H:i', strtotime($log['created_at'])) ?>
                                    </td>
                                    <td>
                                        <strong class="text-dark"><?= esc($log['utilizador']) ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success border border-success px-2"><?= esc($log['acao']) ?></span>
                                    </td>
                                    <td class="text-muted small text-truncate" style="max-width: 280px;">
                                        <?= esc($log['detalhes']) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
