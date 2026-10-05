<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'INATRO — Gestão de Multas') ?></title>
    
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

    <!-- Cabeçalho Principal -->
    <header class="inatro-header sticky-top">
        <nav class="navbar navbar-expand-lg navbar-light bg-white py-2">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="<?= base_url('/') ?>">
                    <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo INATRO" class="navbar-brand-logo">
                </a>
                
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Navegação">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarMain">
                    <?php $isUtenteLogged = session()->get('utente_logged_in'); ?>
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-lg-1">
                        <li class="nav-item">
                            <a class="nav-link nav-link-inatro <?= url_is('/') ? 'active' : '' ?>" href="<?= base_url('/') ?>">
                                <i class="fa-solid fa-house me-1"></i> Início
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-inatro" href="<?= base_url('/#servicos') ?>">
                                <i class="fa-solid fa-list-check me-1"></i> Serviços
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-inatro" href="<?= $isUtenteLogged ? base_url('/utente/dashboard') : base_url('/utente/login') ?>">
                                <i class="fa-solid fa-magnifying-glass me-1"></i> Consulta de Multas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-inatro" href="<?= base_url('/#como-funciona') ?>">
                                <i class="fa-solid fa-circle-info me-1"></i> Como Funciona
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-inatro" href="<?= base_url('/#faq') ?>">
                                <i class="fa-solid fa-circle-question me-1"></i> FAQ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-inatro" href="<?= base_url('/#contactos') ?>">
                                <i class="fa-solid fa-headset me-1"></i> Contactos
                            </a>
                        </li>
                    </ul>

                    <div class="d-flex align-items-center gap-2">
                        <?php if ($isUtenteLogged): ?>
                            <a href="<?= base_url('/utente/dashboard') ?>" class="btn btn-inatro-primary">
                                <i class="fa-solid fa-user-check me-1"></i> Área do Utente
                            </a>
                        <?php else: ?>
                            <a href="<?= base_url('/utente/login') ?>" class="btn btn-inatro-primary">
                                <i class="fa-solid fa-user me-1"></i> Área do Utente
                            </a>
                        <?php endif; ?>
                        
                        <?php if (session()->get('admin_logged_in')): ?>
                            <a href="<?= base_url('/admin/dashboard') ?>" class="btn btn-inatro-secondary btn-sm" title="Painel do Administrador">
                                <i class="fa-solid fa-shield-halved me-1"></i> Admin
                            </a>
                        <?php else: ?>
                            <a href="<?= base_url('/admin/login') ?>" class="btn btn-inatro-secondary btn-sm" title="Acesso Reservado ao Administrador">
                                <i class="fa-solid fa-lock me-1"></i> Admin
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Conteúdo Principal -->
    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Rodapé Institucional -->
    <footer class="inatro-footer">
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-lg-4 col-md-6">
                    <img src="<?= base_url('assets/images/logo.png') ?>" alt="INATRO Logo" class="bg-white p-2 rounded mb-3" style="max-height: 55px;">
                    <p class="text-white-50">
                        Instituto Nacional dos Transportes Rodoviários — República de Moçambique.
                        Plataforma de gestão e simplificação electrónica de multas de trânsito.
                    </p>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <h5>Navegação</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?= base_url('/') ?>"><i class="fa-solid fa-angle-right me-1 text-success"></i> Início</a></li>
                        <li class="mb-2"><a href="<?= base_url('/#servicos') ?>"><i class="fa-solid fa-angle-right me-1 text-success"></i> Serviços</a></li>
                        <li class="mb-2"><a href="<?= $isUtenteLogged ? base_url('/utente/dashboard') : base_url('/utente/login') ?>"><i class="fa-solid fa-angle-right me-1 text-success"></i> Consultar Multas</a></li>
                        <li class="mb-2"><a href="<?= base_url('/#faq') ?>"><i class="fa-solid fa-angle-right me-1 text-success"></i> FAQ</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5>Serviços Online</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?= $isUtenteLogged ? base_url('/utente/dashboard') : base_url('/utente/login') ?>"><i class="fa-solid fa-shield-halved me-1 text-success"></i> Consulta por N.º de Carta</a></li>
                        <li class="mb-2"><a href="<?= $isUtenteLogged ? base_url('/utente/dashboard') : base_url('/utente/login') ?>"><i class="fa-solid fa-credit-card me-1 text-success"></i> Pagamento Electrónico</a></li>
                        <li class="mb-2"><a href="<?= $isUtenteLogged ? base_url('/utente/dashboard') : base_url('/utente/login') ?>"><i class="fa-solid fa-file-invoice me-1 text-success"></i> Emissão de Comprovativo</a></li>
                        <li class="mb-2"><a href="<?= $isUtenteLogged ? base_url('/utente/historico') : base_url('/utente/login') ?>"><i class="fa-solid fa-clock-rotate-left me-1 text-success"></i> Histórico do Condutor</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5>Contactos Institucionais</h5>
                    <p class="mb-1 text-white-50"><i class="fa-solid fa-location-dot me-2 text-success"></i> Av. das Indústrias, Maputo — Moçambique</p>
                    <p class="mb-1 text-white-50"><i class="fa-solid fa-phone me-2 text-success"></i> (+258) 21 000 000 / 800 123 456</p>
                    <p class="mb-1 text-white-50"><i class="fa-solid fa-envelope me-2 text-success"></i> apoio@inatro.gov.mz</p>
                </div>
            </div>
        </div>

        <div class="prototype-notice-bar text-center">
            <div class="container">
                <p class="mb-0">
                    © <?= date('Y') ?> INATRO — Instituto Nacional dos Transportes Rodoviários. Todos os direitos reservados.
                </p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
