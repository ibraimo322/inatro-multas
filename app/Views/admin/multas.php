<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<!-- CABEÇALHO DA PÁGINA -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-file-invoice-dollar text-success me-2"></i> Gestão de Multas de Trânsito
        </h4>
        <p class="text-muted small mb-0">Consultar, pesquisar e actualizar o estado de autos de infracção.</p>
    </div>
    <div class="d-flex gap-2 flex-wrap align-items-center">
        <!-- FILTROS DE ESTADO -->
        <div class="btn-group" role="group" aria-label="Filtro de Estado">
            <a href="<?= base_url('/admin/multas?estado=todas') ?>" class="btn btn-sm <?= $estadoFiltro === 'todas' ? 'btn-dark' : 'btn-outline-secondary' ?>">Todas</a>
            <a href="<?= base_url('/admin/multas?estado=pendente') ?>" class="btn btn-sm <?= $estadoFiltro === 'pendente' ? 'btn-warning text-dark fw-bold' : 'btn-outline-secondary' ?>">Pendentes</a>
            <a href="<?= base_url('/admin/multas?estado=paga') ?>" class="btn btn-sm <?= $estadoFiltro === 'paga' ? 'btn-success fw-bold' : 'btn-outline-secondary' ?>">Pagas</a>
            <a href="<?= base_url('/admin/multas?estado=em_processamento') ?>" class="btn btn-sm <?= $estadoFiltro === 'em_processamento' ? 'btn-info text-white fw-bold' : 'btn-outline-secondary' ?>">Em Proc.</a>
            <a href="<?= base_url('/admin/multas?estado=vencida') ?>" class="btn btn-sm <?= $estadoFiltro === 'vencida' ? 'btn-danger fw-bold' : 'btn-outline-secondary' ?>">Vencidas</a>
        </div>
        <a href="<?= base_url('/admin/atribuir-multa') ?>" class="btn btn-inatro-primary btn-sm shadow-sm px-3">
            <i class="fa-solid fa-file-circle-plus me-1"></i> Atribuir Multa
        </a>
    </div>
</div>

<div class="card card-inatro p-4 shadow-sm border-0">
    <?php if (empty($multas)): ?>
        <div class="text-center py-5">
            <i class="fa-solid fa-folder-open text-muted fs-1 mb-3"></i>
            <p class="text-muted fw-medium mb-0">Nenhuma multa encontrada para o filtro seleccionado.</p>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Auto N.º</th>
                        <th scope="col">Condutor / Utente</th>
                        <th scope="col">Carta N.º</th>
                        <th scope="col">Infracção / Local</th>
                        <th scope="col" style="white-space: nowrap;">Data</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Estado</th>
                        <th scope="col" class="text-end">Alterar Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($multas as $m): ?>
                        <tr>
                            <td>
                                <strong class="text-dark"><?= esc($m['codigo_multa']) ?></strong>
                            </td>
                            <td>
                                <strong class="text-dark"><?= esc($m['utente_nome']) ?></strong>
                            </td>
                            <td>
                                <code class="text-muted"><?= esc($m['numero_carta']) ?></code>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark" style="max-width: 200px;"><?= esc($m['tipo_infracao']) ?></div>
                                <small class="text-muted"><?= esc($m['local_infracao']) ?></small>
                            </td>
                            <td class="small text-muted" style="white-space: nowrap;">
                                <?= date('d/m/Y H:i', strtotime($m['data_infracao'])) ?>
                            </td>
                            <td>
                                <strong class="text-dark"><?= number_format($m['valor'], 2, ',', '.') ?> MT</strong>
                            </td>
                            <td>
                                <?php if ($m['estado'] === 'pendente'): ?>
                                    <span class="badge-status badge-pendente"><i class="fa-solid fa-clock me-1"></i>Pendente</span>
                                <?php elseif ($m['estado'] === 'paga'): ?>
                                    <span class="badge-status badge-paga"><i class="fa-solid fa-circle-check me-1"></i>Paga</span>
                                <?php elseif ($m['estado'] === 'em_processamento'): ?>
                                    <span class="badge-status badge-em_processamento"><i class="fa-solid fa-arrows-rotate fa-spin me-1"></i>Em Proc.</span>
                                <?php elseif ($m['estado'] === 'vencida'): ?>
                                    <span class="badge-status badge-vencida"><i class="fa-solid fa-triangle-exclamation me-1"></i>Vencida</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <form action="<?= base_url('/admin/alterar-estado-multa') ?>" method="post" class="d-inline-flex gap-1 justify-content-end">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="multa_id" value="<?= esc($m['id']) ?>">
                                    <select name="novo_estado" class="form-select form-select-sm" style="min-width: 140px;" onchange="this.form.submit()">
                                        <option value="" disabled selected>Alterar para...</option>
                                        <option value="pendente" <?= $m['estado'] === 'pendente' ? 'disabled' : '' ?>>Pendente</option>
                                        <option value="paga" <?= $m['estado'] === 'paga' ? 'disabled' : '' ?>>Paga</option>
                                        <option value="em_processamento" <?= $m['estado'] === 'em_processamento' ? 'disabled' : '' ?>>Em Processamento</option>
                                        <option value="vencida" <?= $m['estado'] === 'vencida' ? 'disabled' : '' ?>>Vencida</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
