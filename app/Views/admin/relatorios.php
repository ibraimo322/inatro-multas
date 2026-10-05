<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<!-- CABEÇALHO DA PÁGINA -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-chart-pie text-success me-2"></i> Relatórios Gerenciais
        </h4>
        <p class="text-muted small mb-0">Indicadores demonstrativos de desempenho da arrecadação e cobrança de multas.</p>
    </div>
    <a href="<?= base_url('/admin/gerar-pdf-historico') ?>" class="btn btn-success btn-sm shadow-sm px-3" target="_blank">
        <i class="fa-solid fa-file-pdf me-1"></i> Relatório Geral em PDF
    </a>
</div>

<div class="row g-4">
    <!-- ARRECADAÇÃO POR CANAL -->
    <div class="col-md-6">
        <div class="card card-inatro p-4 shadow-sm h-100">
            <h6 class="fw-bold text-dark mb-3 border-bottom pb-2">
                <i class="fa-solid fa-credit-card text-success me-2"></i>Arrecadação por Canal de Pagamento
            </h6>
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fw-semibold text-dark">M-Pesa (Vodacom)</span>
                    <span class="badge bg-danger px-2 py-1">55%</span>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 55%"></div>
                </div>
            </div>
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fw-semibold text-dark">e-Mola (Movitel)</span>
                    <span class="badge bg-warning text-dark px-2 py-1">25%</span>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 25%"></div>
                </div>
            </div>
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="fw-semibold text-dark">Transferência Bancária / Cartão</span>
                    <span class="badge bg-primary px-2 py-1">20%</span>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 20%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- INFRAÇÕES MAIS FREQUENTES -->
    <div class="col-md-6">
        <div class="card card-inatro p-4 shadow-sm h-100">
            <h6 class="fw-bold text-dark mb-3 border-bottom pb-2">
                <i class="fa-solid fa-ranking-star text-warning me-2"></i>Infrações Mais Frequentes
            </h6>
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                    <div>
                        <strong class="text-dark">Excesso de Velocidade</strong>
                        <div class="small text-muted">Art. 27.º — Código da Estrada de Moçambique</div>
                    </div>
                    <span class="badge bg-danger rounded-pill px-3 py-2">42%</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                    <div>
                        <strong class="text-dark">Estacionamento Proibido</strong>
                        <div class="small text-muted">Art. 48.º — Código da Estrada de Moçambique</div>
                    </div>
                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2">28%</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                    <div>
                        <strong class="text-dark">Uso de Telemóvel ao Volante</strong>
                        <div class="small text-muted">Art. 84.º — Código da Estrada de Moçambique</div>
                    </div>
                    <span class="badge bg-info rounded-pill px-3 py-2">18%</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center px-0 border-0">
                    <div>
                        <strong class="text-dark">Falta de Cinto de Segurança</strong>
                        <div class="small text-muted">Art. 82.º — Código da Estrada de Moçambique</div>
                    </div>
                    <span class="badge bg-secondary rounded-pill px-3 py-2">12%</span>
                </li>
            </ul>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
