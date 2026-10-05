<?= $this->extend('layouts/utente') ?>

<?= $this->section('content') ?>

<!-- GREETING BANNER -->
<div class="card card-inatro p-4 mb-4 border-0 bg-white shadow-sm">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <div class="badge bg-success-subtle text-success border border-success mb-2 px-3 py-1 fw-bold">
                <i class="fa-solid fa-circle-check me-1"></i> SESSÃO INICIADA
            </div>
            <h3 class="fw-bold text-dark mb-1">Olá, <?= esc(session()->get('utente_nome')) ?></h3>
            <p class="text-muted mb-0">
                N.º da Carta de Condução: <code class="fw-bold fs-6 text-dark"><?= esc(session()->get('utente_carta')) ?></code>
            </p>
        </div>
        <div>
            <a href="<?= base_url('/utente/historico') ?>" class="btn btn-inatro-outline btn-sm">
                <i class="fa-solid fa-clock-rotate-left me-1"></i> Histórico de Pagamentos
            </a>
        </div>
    </div>
</div>

<!-- CARTOES DE RESUMO / METRICAS -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card stat-card-border-warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-value text-warning"><?= esc($resumo['pendentes']) ?></div>
                    <div class="stat-label">Multas Pendentes</div>
                </div>
                <div class="fs-1 text-warning opacity-25">
                    <i class="fa-solid fa-hourglass-half"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="stat-card stat-card-border-success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-value text-success"><?= esc($resumo['pagas']) ?></div>
                    <div class="stat-label">Multas Pagas</div>
                </div>
                <div class="fs-1 text-success opacity-25">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="stat-card stat-card-border-info">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-value text-info"><?= esc($resumo['em_processamento']) ?></div>
                    <div class="stat-label">Em Processamento</div>
                </div>
                <div class="fs-1 text-info opacity-25">
                    <i class="fa-solid fa-spinner"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="stat-card stat-card-border-primary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-value text-dark" style="font-size: 1.5rem;">
                        <?= number_format($resumo['valor_total'], 2, ',', '.') ?> MT
                    </div>
                    <div class="stat-label">Valor Total das Multas</div>
                </div>
                <div class="fs-1 text-success opacity-25">
                    <i class="fa-solid fa-money-bill-wave"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTROS E TABELA DE MULTAS -->
<div class="card card-inatro p-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 pb-3 border-bottom">
        <div>
            <h5 class="fw-bold text-dark mb-0">Minhas Multas de Trânsito</h5>
            <small class="text-muted">Lista de infrações registadas e respectivo estado financeiro.</small>
        </div>

        <!-- FILTROS VISUAIS -->
        <div class="btn-group flex-wrap" role="group" aria-label="Filtro de Estado">
            <a href="<?= base_url('/utente/dashboard?estado=todas') ?>" class="btn btn-sm <?= $estadoFiltro === 'todas' ? 'btn-success fw-bold' : 'btn-outline-secondary' ?>">
                Todas (<?= esc($resumo['total']) ?>)
            </a>
            <a href="<?= base_url('/utente/dashboard?estado=pendente') ?>" class="btn btn-sm <?= $estadoFiltro === 'pendente' ? 'btn-warning text-dark fw-bold' : 'btn-outline-secondary' ?>">
                Pendentes (<?= esc($resumo['pendentes']) ?>)
            </a>
            <a href="<?= base_url('/utente/dashboard?estado=paga') ?>" class="btn btn-sm <?= $estadoFiltro === 'paga' ? 'btn-success fw-bold' : 'btn-outline-secondary' ?>">
                Pagas (<?= esc($resumo['pagas']) ?>)
            </a>
            <a href="<?= base_url('/utente/dashboard?estado=em_processamento') ?>" class="btn btn-sm <?= $estadoFiltro === 'em_processamento' ? 'btn-info text-white fw-bold' : 'btn-outline-secondary' ?>">
                Em Processamento (<?= esc($resumo['em_processamento']) ?>)
            </a>
            <a href="<?= base_url('/utente/dashboard?estado=vencida') ?>" class="btn btn-sm <?= $estadoFiltro === 'vencida' ? 'btn-danger fw-bold' : 'btn-outline-secondary' ?>">
                Vencidas (<?= esc($resumo['vencidas']) ?>)
            </a>
        </div>
    </div>

    <!-- TABELA RESPONSIVA -->
    <?php if (empty($multas)): ?>
        <div class="text-center py-5">
            <i class="fa-solid fa-folder-open text-muted fs-1 mb-3"></i>
            <p class="text-muted fw-medium mb-0">Nenhuma multa encontrada com o filtro seleccionado.</p>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Número</th>
                        <th scope="col">Infracção</th>
                        <th scope="col">Data da Infracção</th>
                        <th scope="col">Local</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Estado</th>
                        <th scope="col" class="text-end">Acção</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($multas as $m): ?>
                        <tr>
                            <td>
                                <strong class="text-dark"><?= esc($m['codigo_multa']) ?></strong>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark"><?= esc($m['tipo_infracao']) ?></div>
                                <small class="text-muted"><?= esc($m['artigo_lei'] ?? 'Código da Estrada') ?></small>
                            </td>
                            <td>
                                <?= date('d/m/Y H:i', strtotime($m['data_infracao'])) ?>
                            </td>
                            <td class="small text-muted">
                                <?= esc($m['local_infracao']) ?>
                            </td>
                            <td>
                                <strong class="text-dark"><?= number_format($m['valor'], 2, ',', '.') ?> MT</strong>
                            </td>
                            <td>
                                <?php if ($m['estado'] === 'pendente'): ?>
                                    <span class="badge-status badge-pendente">
                                        <i class="fa-solid fa-clock"></i> Pendente
                                    </span>
                                <?php elseif ($m['estado'] === 'paga'): ?>
                                    <span class="badge-status badge-paga">
                                        <i class="fa-solid fa-circle-check"></i> Paga
                                    </span>
                                <?php elseif ($m['estado'] === 'em_processamento'): ?>
                                    <span class="badge-status badge-em_processamento">
                                        <i class="fa-solid fa-arrows-rotate fa-spin"></i> Em Processamento
                                    </span>
                                <?php elseif ($m['estado'] === 'vencida'): ?>
                                    <span class="badge-status badge-vencida">
                                        <i class="fa-solid fa-triangle-exclamation"></i> Vencida
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <a href="<?= base_url('/utente/multa/' . $m['id']) ?>" class="btn btn-inatro-primary btn-sm">
                                    <i class="fa-solid fa-eye me-1"></i> Ver
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
