<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>

<!-- BANNER / HERO PRINCIPAL -->
<section class="hero-banner">
    <div class="container">
        <div class="row align-items-center justify-content-between g-4">
            <div class="col-lg-8">
                <div class="badge bg-success text-white mb-3 px-3 py-2 rounded-pill" style="font-size: 0.85rem;">
                    <i class="fa-solid fa-shield-halved me-1"></i> PORTAL OFICIAL DE SERVIÇOS PÚBLICOS
                </div>
                <h1 class="hero-title mb-3">
                    Gestão e Pagamento Electrónico de <span class="hero-accent">Multas de Trânsito</span>
                </h1>
                <p class="hero-subtitle mb-4">
                    Consulte as suas multas de trânsito e acompanhe o processo de pagamento de forma simples, rápida e segura.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <?php $authUrl = session()->get('utente_logged_in') ? base_url('/utente/dashboard') : base_url('/utente/login'); ?>
                    <a href="<?= $authUrl ?>" class="btn btn-inatro-primary btn-lg shadow-sm px-4">
                        <i class="fa-solid fa-magnifying-glass me-2"></i> Consultar Multas
                    </a>
                    <a href="#servicos" class="btn btn-inatro-outline btn-lg text-white border-white px-4">
                        <i class="fa-solid fa-circle-info me-2"></i> Saiba Mais
                    </a>
                </div>
            </div>
            <div class="col-lg-4 d-none d-lg-block text-end">
                <div class="p-4 rounded-4 bg-dark bg-opacity-50 border border-light border-opacity-25 text-white">
                    <i class="fa-solid fa-car-on display-4 text-success mb-3"></i>
                    <h5 class="fw-bold mb-2">Serviço de Trânsito Institucional</h5>
                    <p class="small text-white-50 mb-0">Consulte infrações associadas à sua Carta de Condução e regularize pendências com total segurança.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECCÇÃO DE SERVIÇOS -->
<section id="servicos" class="py-5 bg-white">
    <div class="container py-4">
        <div class="text-center max-w-700 mx-auto mb-5">
            <span class="text-success fw-bold text-uppercase" style="font-size: 0.85rem; letter-spacing: 1px;">Serviços Disponíveis</span>
            <h2 class="fw-bold text-dark mt-1">O que pode fazer na plataforma</h2>
            <p class="text-muted">Serviços concebidos para garantir comodidade, transparência e eficiência aos cidadãos e condutores.</p>
        </div>

        <?php $utenteAuthUrl = session()->get('utente_logged_in') ? base_url('/utente/dashboard') : base_url('/utente/login'); ?>
        <?php $historicoAuthUrl = session()->get('utente_logged_in') ? base_url('/utente/historico') : base_url('/utente/login'); ?>

        <div class="row g-4">
            <!-- Serviço 1 -->
            <div class="col-md-6 col-lg-4">
                <div class="card card-inatro p-4">
                    <div class="service-icon-box">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <h5 class="fw-bold mb-2">1. Consulta de Multas</h5>
                    <p class="text-muted small mb-3">Pesquise multas pendentes, pagas ou em processamento associadas à sua carta de condução.</p>
                    <a href="<?= $utenteAuthUrl ?>" class="btn btn-inatro-outline btn-sm mt-auto align-self-start">
                        Consultar Agora <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <!-- Serviço 2 -->
            <div class="col-md-6 col-lg-4">
                <div class="card card-inatro p-4">
                    <div class="service-icon-box">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <h5 class="fw-bold mb-2">2. Pagamento Electrónico</h5>
                    <p class="text-muted small mb-3">Efectue a regularização de infrações através de canais móveis e bancários com toda a segurança.</p>
                    <a href="<?= $utenteAuthUrl ?>" class="btn btn-inatro-outline btn-sm mt-auto align-self-start">
                        Efectuar Pagamento <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <!-- Serviço 3 -->
            <div class="col-md-6 col-lg-4">
                <div class="card card-inatro p-4">
                    <div class="service-icon-box">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <h5 class="fw-bold mb-2">3. Histórico de Pagamentos</h5>
                    <p class="text-muted small mb-3">Consulte o seu histórico completo de transações e situação regularizada de condutor.</p>
                    <a href="<?= $historicoAuthUrl ?>" class="btn btn-inatro-outline btn-sm mt-auto align-self-start">
                        Ver Histórico <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <!-- Serviço 4 -->
            <div class="col-md-6 col-lg-4">
                <div class="card card-inatro p-4">
                    <div class="service-icon-box">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                    </div>
                    <h5 class="fw-bold mb-2">4. Emissão de Comprovativo</h5>
                    <p class="text-muted small mb-3">Obtenha e imprima o seu recibo oficial de pagamento com código de verificação único.</p>
                    <a href="<?= $historicoAuthUrl ?>" class="btn btn-inatro-outline btn-sm mt-auto align-self-start">
                        Emitir Recibo <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <!-- Serviço 5 -->
            <div class="col-md-6 col-lg-4">
                <div class="card card-inatro p-4">
                    <div class="service-icon-box">
                        <i class="fa-solid fa-circle-info"></i>
                    </div>
                    <h5 class="fw-bold mb-2">5. Informações Gerais</h5>
                    <p class="text-muted small mb-3">Esclareça dúvidas sobre os prazos de regularização e os estados operacionais das multas.</p>
                    <a href="#faq" class="btn btn-inatro-outline btn-sm mt-auto align-self-start">
                        Ler Informações <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <!-- Serviço 6 -->
            <div class="col-md-6 col-lg-4">
                <div class="card card-inatro p-4">
                    <div class="service-icon-box">
                        <i class="fa-solid fa-circle-question"></i>
                    </div>
                    <h5 class="fw-bold mb-2">6. Perguntas Frequentes</h5>
                    <p class="text-muted small mb-3">Respostas rápidas às dúvidas mais comuns sobre o funcionamento do portal de multas.</p>
                    <a href="#faq" class="btn btn-inatro-outline btn-sm mt-auto align-self-start">
                        Aceder ao FAQ <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECÇÃO COMO FUNCIONA (4 PASSOS) -->
<section id="como-funciona" class="py-5 bg-light border-top border-bottom">
    <div class="container py-4">
        <div class="text-center max-w-700 mx-auto mb-5">
            <span class="text-success fw-bold text-uppercase" style="font-size: 0.85rem; letter-spacing: 1px;">Simplicidade em 4 Passos</span>
            <h2 class="fw-bold text-dark mt-1">Como Funciona o Processo</h2>
            <p class="text-muted">Acompanhe a forma como o utente pode consultar e liquidar as suas multas em minutos.</p>
        </div>

        <div class="row g-4">
            <!-- Passo 1 -->
            <div class="col-md-6 col-lg-3">
                <div class="card card-inatro p-4 text-center">
                    <div class="step-number mx-auto">1</div>
                    <h6 class="fw-bold mb-2">Identifique-se</h6>
                    <p class="text-muted small mb-0">Insira o número da carta de condução e a sua data de nascimento para validar o acesso.</p>
                </div>
            </div>

            <!-- Passo 2 -->
            <div class="col-md-6 col-lg-3">
                <div class="card card-inatro p-4 text-center">
                    <div class="step-number mx-auto">2</div>
                    <h6 class="fw-bold mb-2">Consulte as Multas</h6>
                    <p class="text-muted small mb-0">Visualize a lista completa de multas associadas e o estado de cada processo.</p>
                </div>
            </div>

            <!-- Passo 3 -->
            <div class="col-md-6 col-lg-3">
                <div class="card card-inatro p-4 text-center">
                    <div class="step-number mx-auto">3</div>
                    <h6 class="fw-bold mb-2">Escolha a Multa</h6>
                    <p class="text-muted small mb-0">Seleccione a multa pendente pretendida para examinar o valor e os detalhes.</p>
                </div>
            </div>

            <!-- Passo 4 -->
            <div class="col-md-6 col-lg-3">
                <div class="card card-inatro p-4 text-center">
                    <div class="step-number mx-auto">4</div>
                    <h6 class="fw-bold mb-2">Efectue o Pagamento</h6>
                    <p class="text-muted small mb-0">Escolha a modalidade electrónica preferida e emita o seu comprovativo oficial.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECÇÃO PERGUNTAS FREQUENTES (FAQ) -->
<section id="faq" class="py-5 bg-white">
    <div class="container py-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <span class="text-success fw-bold text-uppercase" style="font-size: 0.85rem; letter-spacing: 1px;">Esclareça as Suas Dúvidas</span>
                <h2 class="fw-bold text-dark mt-1 mb-3">Perguntas Frequentes</h2>
                <p class="text-muted mb-4">
                    Estas respostas explicam o funcionamento técnico e prático da plataforma de gestão electrónica de multas de trânsito.
                </p>
            </div>

            <div class="col-lg-7">
                <div class="accordion accordion-flush shadow-sm border rounded-3 overflow-hidden" id="faqAccordion">
                    <!-- Q1 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                Como posso consultar as minhas multas de trânsito?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted small">
                                Para consultar as suas multas, aceda à área do utente e introduza o número da sua Carta de Condução e a sua Data de Nascimento. O sistema irá listar automaticamente todos os registos associados ao seu perfil.
                            </div>
                        </div>
                    </div>

                    <!-- Q2 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                Quais são os métodos de pagamento suportados no sistema?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted small">
                                O sistema permite pagamentos por M-Pesa, e-Mola, Referência Bancária e Cartão de Débito/Crédito com integração directa aos canais financeiros.
                            </div>
                        </div>
                    </div>

                    <!-- Q3 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Como obtenho o comprovativo de pagamento?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted small">
                                Logo após concluir o pagamento, o portal disponibiliza a vista oficial do comprovativo contendo o número da transação, detalhes do condutor e o valor pago, com a opção de impressão imediata.
                            </div>
                        </div>
                    </div>

                    <!-- Q4 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                É necessário criar uma conta com palavra-passe?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted small">
                                Não. Seguindo o modelo simplificado de serviços públicos, a identificação é realizada directamente mediante a validação do número da carta de condução combinado com a data de nascimento do titular.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECÇÃO DE CONTACTOS -->
<section id="contactos" class="py-5 bg-light border-top">
    <div class="container py-4">
        <div class="text-center max-w-700 mx-auto mb-5">
            <span class="text-success fw-bold text-uppercase" style="font-size: 0.85rem; letter-spacing: 1px;">Atendimento Institucional</span>
            <h2 class="fw-bold text-dark mt-1">Contactos & Suporte</h2>
            <p class="text-muted">Entre em contacto com o apoio ao utilizador do portal INATRO.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card card-inatro p-4 text-center">
                    <div class="service-icon-box mx-auto mb-3">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <h6 class="fw-bold">Sede Principal</h6>
                    <p class="text-muted small mb-0">Av. das Indústrias, Parcela 1234, Cidade da Matola / Maputo</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-inatro p-4 text-center">
                    <div class="service-icon-box mx-auto mb-3">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <h6 class="fw-bold">Linha Verde / Telefone</h6>
                    <p class="text-muted small mb-0">(+258) 21 000 000 | 800 123 456<br><small>(Segunda a Sexta: 07h30 - 15h30)</small></p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-inatro p-4 text-center">
                    <div class="service-icon-box mx-auto mb-3">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <h6 class="fw-bold">Correio Electrónico</h6>
                    <p class="text-muted small mb-0">apoio.multas@inatro.gov.mz<br><small>Resposta em até 24 horas úteis</small></p>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
