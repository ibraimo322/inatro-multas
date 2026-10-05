<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<!-- CABEÇALHO DA PÁGINA -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-list-check text-success me-2"></i> Logs de Auditoria e Actividade
        </h4>
        <p class="text-muted small mb-0">Histórico cronológico de acções executadas por utilizadores e administradores.</p>
    </div>
    <span class="badge bg-secondary px-3 py-2" style="font-size: 0.85rem;">
        <i class="fa-solid fa-shield-halved me-1"></i> Somente Leitura
    </span>
</div>

<div class="card card-inatro p-4 shadow-sm border-0">
    <?php if (empty($logs)): ?>
        <div class="text-center py-5">
            <i class="fa-solid fa-list-check text-muted fs-1 mb-3"></i>
            <p class="text-muted fw-medium mb-0">Nenhum registo de log encontrado.</p>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem;">
                <thead class="table-light">
                    <tr>
                        <th scope="col" style="white-space: nowrap;">Data e Hora</th>
                        <th scope="col">Utilizador / Actor</th>
                        <th scope="col">Acção Executada</th>
                        <th scope="col">Detalhes da Operação</th>
                        <th scope="col">Endereço IP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logs as $l): ?>
                        <tr>
                            <td class="small text-muted" style="white-space: nowrap;">
                                <?= date('d/m/Y H:i:s', strtotime($l['created_at'])) ?>
                            </td>
                            <td>
                                <strong class="text-dark"><?= esc($l['utilizador']) ?></strong>
                            </td>
                            <td>
                                <span class="badge bg-success-subtle text-success border border-success px-2 py-1"><?= esc($l['acao']) ?></span>
                            </td>
                            <td class="small text-muted">
                                <?= esc($l['detalhes']) ?>
                            </td>
                            <td>
                                <code class="text-muted"><?= esc($l['ip_address'] ?? '127.0.0.1') ?></code>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
