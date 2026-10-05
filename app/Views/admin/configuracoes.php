<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<!-- CABEÇALHO DA PÁGINA -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-gears text-success me-2"></i> Configurações do Sistema
        </h4>
        <p class="text-muted small mb-0">Parâmetros institucionais e informações técnicas do portal INATRO.</p>
    </div>
</div>

<div class="row g-4">
    <!-- PARÂMETROS GERAIS -->
    <div class="col-lg-8">
        <div class="card card-inatro p-4 shadow-sm">
            <h6 class="fw-bold text-dark mb-3 border-bottom pb-2">
                <i class="fa-solid fa-sliders text-success me-2"></i>Parâmetros Gerais do Sistema
            </h6>
            <div class="mb-3">
                <label class="form-label fw-semibold text-dark">Nome da Instituição</label>
                <input type="text" class="form-control bg-light text-dark" value="INATRO — Instituto Nacional dos Transportes Terrestres (INATRO, IP)" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-dark">Modo de Operação</label>
                <input type="text" class="form-control bg-light text-success fw-bold" value="Sistema Operacional — Modo Institucional" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-dark">Moeda Padrão do Sistema</label>
                <input type="text" class="form-control bg-light" value="MT — Metical Moçambicano (MZN)" readonly>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold text-dark">Canais de Pagamento Activos</label>
                <div class="d-flex flex-wrap gap-2 mt-1">
                    <span class="badge bg-danger px-3 py-2"><i class="fa-solid fa-mobile-screen me-1"></i>M-Pesa</span>
                    <span class="badge bg-warning text-dark px-3 py-2"><i class="fa-solid fa-mobile-screen me-1"></i>e-Mola</span>
                    <span class="badge bg-primary px-3 py-2"><i class="fa-solid fa-building-columns me-1"></i>Transferência Bancária</span>
                    <span class="badge bg-success px-3 py-2"><i class="fa-solid fa-credit-card me-1"></i>Cartão Déb./Créd.</span>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-dark">Formato do N.º de Carta de Condução</label>
                <input type="text" class="form-control bg-light font-monospace" value="XXXXXXXX/MZ  (8 dígitos + /MZ — gerado automaticamente)" readonly>
                <small class="text-muted">O número é gerado automaticamente e único no sistema.</small>
            </div>
        </div>
    </div>

    <!-- INFORMAÇÕES TÉCNICAS -->
    <div class="col-lg-4">
        <div class="card card-inatro p-4 shadow-sm mb-3">
            <h6 class="fw-bold text-dark mb-3 border-bottom pb-2">
                <i class="fa-solid fa-server text-success me-2"></i>Informações Técnicas
            </h6>
            <ul class="list-unstyled small mb-0">
                <li class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted">Framework</span>
                    <strong class="text-dark">CodeIgniter 4</strong>
                </li>
                <li class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted">Linguagem</span>
                    <strong class="text-dark">PHP 8.2+</strong>
                </li>
                <li class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted">Base de Dados</span>
                    <strong class="text-dark">MySQL</strong>
                </li>
                <li class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted">Arquitectura</span>
                    <strong class="text-dark">MVC</strong>
                </li>
                <li class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted">PDF (relatórios)</span>
                    <strong class="text-dark">Dompdf 3.x</strong>
                </li>
                <li class="d-flex justify-content-between py-2">
                    <span class="text-muted">Estado</span>
                    <span class="badge bg-success px-2"><i class="fa-solid fa-circle-check me-1"></i>Operacional</span>
                </li>
            </ul>
        </div>

        <div class="card card-inatro p-4 shadow-sm">
            <h6 class="fw-bold text-dark mb-3 border-bottom pb-2">
                <i class="fa-solid fa-database text-success me-2"></i>Tabelas do Sistema
            </h6>
            <ul class="list-unstyled small mb-0">
                <?php
                $tabelas = ['utentes', 'multas', 'pagamentos', 'utilizadores_admin', 'logs', 'infracoes', 'locais_infracao'];
                foreach ($tabelas as $t): ?>
                    <li class="d-flex justify-content-between py-1 border-bottom">
                        <code class="text-muted"><?= $t ?></code>
                        <span class="badge bg-success-subtle text-success border border-success px-2">activa</span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
