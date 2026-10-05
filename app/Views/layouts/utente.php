<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Área do Utente — INATRO') ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts (Inter) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- INATRO Custom CSS -->
    <link href="<?= base_url('assets/css/inatro.css') ?>" rel="stylesheet">
</head>
<body>


    <!-- Cabeçalho Utente -->
    <header class="inatro-header bg-white sticky-top">
        <nav class="navbar navbar-expand-lg navbar-light py-2">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="<?= base_url('/utente/dashboard') ?>">
                    <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo INATRO" class="navbar-brand-logo">
                </a>
                
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarUtente">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarUtente">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link nav-link-inatro <?= url_is('utente/dashboard*') ? 'active' : '' ?>" href="<?= base_url('/utente/dashboard') ?>">
                                <i class="fa-solid fa-gauge-high me-1"></i> Painel Geral
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-inatro <?= url_is('utente/historico*') ? 'active' : '' ?>" href="<?= base_url('/utente/historico') ?>">
                                <i class="fa-solid fa-history me-1"></i> Histórico de Pagamentos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-inatro" href="<?= base_url('/#faq') ?>" target="_blank">
                                <i class="fa-solid fa-circle-question me-1"></i> Ajuda / FAQ
                            </a>
                        </li>
                    </ul>

                    <?php if (session()->get('utente_logged_in')): ?>
                        <div class="d-flex align-items-center gap-3">
                            <div class="text-end d-none d-sm-block">
                                <div class="fw-bold text-dark" style="font-size: 0.92rem;"><?= esc(session()->get('utente_nome')) ?></div>
                                <div class="text-muted" style="font-size: 0.8rem;">Carta: <code><?= esc(session()->get('utente_carta')) ?></code></div>
                            </div>
                            <a href="<?= base_url('/utente/logout') ?>" class="btn btn-outline-danger btn-sm">
                                <i class="fa-solid fa-right-from-bracket me-1"></i> Sair
                            </a>
                        </div>
                    <?php else: ?>
                        <a href="<?= base_url('/utente/login') ?>" class="btn btn-inatro-primary btn-sm">
                            <i class="fa-solid fa-user me-1"></i> Identificar-se
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>

    <!-- Conteúdo da Área de Utente -->
    <main class="py-4">
        <div class="container">
            <!-- Alert Flash Messages -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i> <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fa-solid fa-circle-exclamation me-2"></i> <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('info')): ?>
                <div class="alert alert-info alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fa-solid fa-circle-info me-2"></i> <?= session()->getFlashdata('info') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>
        </div>
    </main>

    <footer class="inatro-footer">
        <div class="container text-center">
            <p class="mb-0">INATRO — Sistema Web Integrado de Gestão e Pagamento Electrónico de Multas de Trânsito</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
