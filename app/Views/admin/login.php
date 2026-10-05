<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso Administrativo — INATRO</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts (Inter) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- INATRO Custom CSS -->
    <link href="<?= base_url('assets/css/inatro.css') ?>" rel="stylesheet">

    <style>
        .login-page-container {
            min-height: 100vh;
        }
        .login-left-col {
            background-color: #FFFFFF;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 3.5rem 4rem;
        }
        .login-right-col-admin {
            background: linear-gradient(rgba(15, 23, 42, 0.5), rgba(15, 23, 42, 0.6)), url('<?= base_url('assets/images/administrador.png') ?>') center/cover no-repeat;
            position: relative;
            min-height: 100vh;
        }
        .btn-login-green {
            background-color: #388e3c;
            border-color: #388e3c;
            color: #ffffff;
            font-weight: 600;
            font-size: 1rem;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            transition: all 0.2s ease-in-out;
        }
        .btn-login-green:hover {
            background-color: #2e7d32;
            border-color: #2e7d32;
            color: #ffffff;
        }
        .btn-floating-back {
            position: absolute;
            top: 2rem;
            right: 2rem;
            width: 42px;
            height: 42px;
            background-color: #388e3c;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            z-index: 10;
        }
        .btn-floating-back:hover {
            background-color: #2e7d32;
            color: #ffffff;
            transform: translateY(-2px);
        }
        .form-control-inatro {
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            padding: 0.7rem 1rem;
            font-size: 0.95rem;
            transition: border-color 0.2s;
        }
        .form-control-inatro:focus {
            border-color: #388e3c;
            box-shadow: 0 0 0 3px rgba(56, 142, 60, 0.15);
        }
        @media (max-width: 991.98px) {
            .login-left-col {
                padding: 2.5rem 1.5rem;
                min-height: 100vh;
            }
        }
    </style>
</head>
<body class="bg-light">

    <div class="container-fluid p-0 login-page-container">
        <div class="row g-0 min-vh-100">
            <!-- Coluna da Esquerda: Formulário -->
            <div class="col-lg-5 col-xl-4 login-left-col">
                <div>
                    <div class="mb-4">
                        <a href="<?= base_url('/') ?>" class="text-decoration-none">
                            <img src="<?= base_url('assets/images/logo.png') ?>" alt="INATRO Logo" style="max-height: 52px;" class="mb-3">
                        </a>
                        <h3 class="fw-bold text-dark mb-0" style="font-size: 1.6rem; letter-spacing: -0.3px;">Portal do Administrador</h3>
                    </div>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
                            <i class="fa-solid fa-circle-exclamation me-2"></i> <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('info')): ?>
                        <div class="alert alert-info alert-dismissible fade show shadow-sm mb-4" role="alert">
                            <i class="fa-solid fa-circle-info me-2"></i> <?= session()->getFlashdata('info') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('/admin/autenticar') ?>" method="post" class="mt-4">
                        <?= csrf_field() ?>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold text-secondary small mb-1">
                                Correio Electrónico <span class="text-danger">*</span>
                            </label>
                            <input type="email" 
                                   class="form-control form-control-inatro" 
                                   id="email" 
                                   name="email" 
                                   placeholder="nome@inatro.gov.mz" 
                                   value="<?= old('email') ?>" 
                                   required>
                        </div>

                        <div class="mb-4">
                            <label for="senha" class="form-label fw-semibold text-secondary small mb-1">
                                Palavra-passe <span class="text-danger">*</span>
                            </label>
                            <input type="password" 
                                   class="form-control form-control-inatro" 
                                   id="senha" 
                                   name="senha" 
                                   placeholder="••••••••"
                                   value="" 
                                   required>
                        </div>

                        <button type="submit" class="btn btn-login-green w-100 shadow-sm mt-2">
                            Entrar
                        </button>
                    </form>
                </div>

                <div class="mt-5 pt-3">
                    <p class="text-muted small mb-0" style="font-size: 0.8rem;">
                        © <?= date('Y') ?> INATRO. Todos os direitos reservados.
                    </p>
                </div>
            </div>

            <!-- Coluna da Direita: Imagem de Fundo e Mensagem Institucional -->
            <div class="col-lg-7 col-xl-8 login-right-col-admin d-none d-lg-block">
                <!-- Botão Flutuante de Voltar -->
                <a href="<?= base_url('/') ?>" class="btn-floating-back" title="Voltar ao Portal Público">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>

                <!-- Texto Central sobreposição -->
                <div class="position-absolute top-50 start-50 translate-middle text-center text-white px-4" style="max-width: 700px; width: 90%;">
                    <h1 class="fw-bold mb-3 display-5" style="letter-spacing: -0.5px; line-height: 1.2;">
                        Gestão e Fiscalização de Trânsito
                    </h1>
                    <p class="fs-5 text-white-50 fw-normal">
                        Garantindo a segurança rodoviária e a transparência na gestão de infrações em todo o território nacional.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
