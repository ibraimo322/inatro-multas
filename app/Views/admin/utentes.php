<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<!-- CABEÇALHO DA PÁGINA -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-users text-success me-2"></i> Gestão de Utentes / Condutores
        </h4>
        <p class="text-muted small mb-0">Lista de condutores cadastrados na base de dados do sistema.</p>
    </div>
    <a href="<?= base_url('/admin/novo-utente') ?>" class="btn btn-inatro-primary btn-sm shadow-sm px-3">
        <i class="fa-solid fa-user-plus me-1"></i> Registar Novo Utente
    </a>
</div>

<div class="card card-inatro p-4 shadow-sm border-0">
    <?php if (empty($utentes)): ?>
        <div class="text-center py-5">
            <i class="fa-solid fa-users text-muted fs-1 mb-3"></i>
            <p class="text-muted fw-medium mb-0">Nenhum utente/condutor cadastrado no sistema.</p>
            <a href="<?= base_url('/admin/novo-utente') ?>" class="btn btn-inatro-primary btn-sm mt-3">
                <i class="fa-solid fa-user-plus me-1"></i> Registar o Primeiro Utente
            </a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem;">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Nome Completo</th>
                        <th scope="col">Carta de Condução N.º</th>
                        <th scope="col">BI N.º</th>
                        <th scope="col">Data Nascimento</th>
                        <th scope="col">Telefone</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Data de Registo</th>
                        <th scope="col" class="text-end">Acções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($utentes as $u): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-success rounded-circle d-flex align-items-center justify-content-center text-white fw-bold flex-shrink-0" style="width: 34px; height: 34px; font-size: 0.85rem;">
                                        <?= strtoupper(substr($u['nome'], 0, 1)) ?>
                                    </div>
                                    <strong class="text-dark"><?= esc($u['nome']) ?></strong>
                                </div>
                            </td>
                            <td>
                                <code class="fw-bold text-dark"><?= esc($u['numero_carta']) ?></code>
                            </td>
                            <td class="text-muted">
                                <?= esc($u['bi_numero'] ?? 'N/D') ?>
                            </td>
                            <td class="small text-muted">
                                <?= date('d/m/Y', strtotime($u['data_nascimento'])) ?>
                            </td>
                            <td class="small text-muted">
                                <?= esc($u['telefone'] ?? 'N/D') ?>
                            </td>
                            <td class="small text-muted">
                                <?= esc($u['email'] ?? 'N/D') ?>
                            </td>
                            <td class="small text-muted" style="white-space: nowrap;">
                                <?= date('d/m/Y H:i', strtotime($u['created_at'])) ?>
                            </td>
                            <td class="text-end" style="white-space: nowrap;">
                                <a href="<?= base_url('/admin/gerar-pdf-utente/' . $u['id']) ?>" class="btn btn-outline-success btn-sm shadow-sm" target="_blank" title="Baixar PDF do Utente">
                                    <i class="fa-solid fa-file-pdf me-1"></i> PDF do Utente
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
