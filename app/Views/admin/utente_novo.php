<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-user-plus text-success me-2"></i> Registar Novo Utente / Condutor
        </h4>
        <p class="text-muted small mb-0">Preencha os dados do condutor. O Número da Carta de Condução é gerado automaticamente pelo sistema.</p>
    </div>
    <a href="<?= base_url('/admin/utentes') ?>" class="btn btn-outline-secondary btn-sm">
        <i class="fa-solid fa-arrow-left me-1"></i> Voltar à Lista
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-inatro p-4 border-0 shadow-sm">
            <form action="<?= base_url('/admin/salvar-utente') ?>" method="post">
                <?= csrf_field() ?>

                <div class="row g-3">
                    <!-- Número da Carta (Gerado Automático) -->
                    <div class="col-md-6">
                        <label for="numero_carta" class="form-label fw-bold text-dark">N.º Carta de Condução (Automático)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-success fw-bold"><i class="fa-solid fa-id-card"></i></span>
                            <input type="text" class="form-label form-control bg-light fw-bold text-dark fs-6 mb-0" id="numero_carta" name="numero_carta" value="<?= esc($numeroCartaGerado) ?>" readonly required>
                        </div>
                        <small class="text-muted" style="font-size: 0.78rem;">Formato oficial: 8 algarismos + /MZ (Gerado automaticamente pelo sistema).</small>
                    </div>

                    <!-- Nome Completo -->
                    <div class="col-md-6">
                        <label for="nome" class="form-label fw-bold text-dark">Nome Completo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Ex: Carlos Alberto Mondlane" required value="<?= old('nome') ?>">
                    </div>

                    <!-- Data de Nascimento -->
                    <div class="col-md-6">
                        <label for="data_nascimento" class="form-label fw-bold text-dark">Data de Nascimento <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required value="<?= old('data_nascimento') ?>">
                    </div>

                    <!-- N.º de BI -->
                    <div class="col-md-6">
                        <label for="bi_numero" class="form-label fw-bold text-dark">N.º do Bilhete de Identidade (BI) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="bi_numero" name="bi_numero" placeholder="Ex: 110293847591B" required value="<?= old('bi_numero') ?>">
                    </div>

                    <!-- Telefone -->
                    <div class="col-md-6">
                        <label for="telefone" class="form-label fw-bold text-dark">Telefone de Contacto</label>
                        <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Ex: +258 84 123 4567" value="<?= old('telefone') ?>">
                    </div>

                    <!-- E-mail -->
                    <div class="col-md-6">
                        <label for="email" class="form-label fw-bold text-dark">Endereço de E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Ex: carlos.mondlane@exemplo.co.mz" value="<?= old('email') ?>">
                    </div>

                    <div class="col-12 mt-4 text-end">
                        <a href="<?= base_url('/admin/utentes') ?>" class="btn btn-light me-2">Cancelar</a>
                        <button type="submit" class="btn btn-inatro-primary px-4">
                            <i class="fa-solid fa-check-circle me-1"></i> Registar Utente
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
