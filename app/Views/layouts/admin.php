<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Administração — INATRO') ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts (Inter) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- INATRO Custom CSS -->
    <link href="<?= base_url('assets/css/inatro.css') ?>" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="admin-app-container">
        <!-- Topbar Admin Navigation -->
        <header class="navbar navbar-dark bg-dark admin-header-nav sticky-top px-3 shadow-sm">
            <div class="d-flex align-items-center gap-3">
                <button class="navbar-toggler d-lg-none border-0" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand fs-6 fw-bold text-white d-flex align-items-center gap-2 m-0" href="<?= base_url('/admin/dashboard') ?>">
                    <span class="bg-success text-white px-2 py-1 rounded">
                        <i class="fa-solid fa-shield-halved"></i>
                    </span>
                    <span>INATRO Admin</span>
                </a>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div class="text-end text-white-50 small d-none d-md-block">
                    Olá, <strong class="text-white"><?= esc(session()->get('admin_nome') ?? 'Administrador') ?></strong> <span class="badge bg-secondary ms-1"><?= esc(session()->get('admin_cargo') ?? 'Admin') ?></span>
                </div>
                <a class="btn btn-outline-danger btn-sm px-3" href="<?= base_url('/admin/logout') ?>">
                    <i class="fa-solid fa-right-from-bracket me-1"></i> Sair
                </a>
            </div>
        </header>

        <!-- Corpo com Sidebar + Conteúdo em Flexbox -->
        <div class="admin-body-wrapper">
            <!-- Sidebar Lateral Admin -->
            <nav id="sidebarMenu" class="admin-sidebar collapse d-lg-block p-3">
                <div class="position-sticky pt-1">
                    <ul class="nav flex-column">
                        <!-- 1. DASHBOARD -->
                        <li class="nav-item mb-2">
                            <a class="nav-link <?= url_is('admin/dashboard') ? 'active' : '' ?>" href="<?= base_url('/admin/dashboard') ?>">
                                <i class="fa-solid fa-chart-line"></i> Dashboard
                            </a>
                        </li>

                        <!-- 2. UTENTES -->
                        <li class="nav-item mt-2 mb-1">
                            <div class="text-uppercase text-white-50 px-3" style="font-size: 0.70rem; font-weight: 700; letter-spacing: 0.5px;">Gestão de Utentes</div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= url_is('admin/utentes') ? 'active' : '' ?>" href="<?= base_url('/admin/utentes') ?>">
                                <i class="fa-solid fa-users"></i> Listar Utentes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= url_is('admin/novo-utente') ? 'active' : '' ?>" href="<?= base_url('/admin/novo-utente') ?>">
                                <i class="fa-solid fa-user-plus text-success"></i> Registar Utente
                            </a>
                        </li>

                        <!-- 3. MULTAS -->
                        <li class="nav-item mt-3 mb-1">
                            <div class="text-uppercase text-white-50 px-3" style="font-size: 0.70rem; font-weight: 700; letter-spacing: 0.5px;">Gestão de Multas</div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= url_is('admin/multas') ? 'active' : '' ?>" href="<?= base_url('/admin/multas') ?>">
                                <i class="fa-solid fa-file-invoice-dollar"></i> Listar Multas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= url_is('admin/atribuir-multa') ? 'active' : '' ?>" href="<?= base_url('/admin/atribuir-multa') ?>">
                                <i class="fa-solid fa-file-circle-plus text-warning"></i> Atribuir Multa
                            </a>
                        </li>

                        <!-- 4. PAGAMENTOS & TRANSAÇÕES -->
                        <li class="nav-item mt-3 mb-1">
                            <div class="text-uppercase text-white-50 px-3" style="font-size: 0.70rem; font-weight: 700; letter-spacing: 0.5px;">Pagamentos & Transacções</div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= url_is('admin/pagamentos') ? 'active' : '' ?>" href="<?= base_url('/admin/pagamentos') ?>">
                                <i class="fa-solid fa-credit-card"></i> Pagamentos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= url_is('admin/transacoes') ? 'active' : '' ?>" href="<?= base_url('/admin/transacoes') ?>">
                                <i class="fa-solid fa-receipt"></i> Transacções
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= url_is('admin/historico*') ? 'active' : '' ?>" href="<?= base_url('/admin/historico') ?>">
                                <i class="fa-solid fa-clock-rotate-left"></i> Histórico Geral
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-success fw-bold" href="<?= base_url('/admin/gerar-pdf-historico') ?>" target="_blank">
                                <i class="fa-solid fa-file-pdf"></i> Gerar PDF Geral
                            </a>
                        </li>

                        <!-- 5. RELATÓRIOS & SISTEMA -->
                        <li class="nav-item mt-3 mb-1">
                            <div class="text-uppercase text-white-50 px-3" style="font-size: 0.70rem; font-weight: 700; letter-spacing: 0.5px;">Sistema</div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= url_is('admin/relatorios*') ? 'active' : '' ?>" href="<?= base_url('/admin/relatorios') ?>">
                                <i class="fa-solid fa-chart-pie"></i> Relatórios
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= url_is('admin/logs*') ? 'active' : '' ?>" href="<?= base_url('/admin/logs') ?>">
                                <i class="fa-solid fa-list-check"></i> Logs de Actividade
                            </a>
                        </li>
                        
                        <li class="nav-item mt-4 pt-3 border-top border-secondary">
                            <a class="nav-link text-warning" href="<?= base_url('/') ?>" target="_blank">
                                <i class="fa-solid fa-globe"></i> Ver Portal Público
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Área Principal de Conteúdo Admin -->
            <main class="admin-main-content">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                        <i class="fa-solid fa-circle-check me-2"></i> <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                        <i class="fa-solid fa-circle-exclamation me-2"></i> <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
