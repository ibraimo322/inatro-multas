<?= $this->extend('layouts/utente') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        
        <div class="d-flex align-items-center justify-content-between mb-4">
            <a href="<?= base_url('/utente/multa/' . $multa['id']) ?>" class="btn btn-outline-secondary btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> Voltar aos Detalhes
            </a>
            <span class="badge bg-success text-white px-3 py-2 fw-semibold"><i class="fa-solid fa-shield-halved me-1"></i> Canal Seguro INATRO</span>
        </div>

        <div class="card card-inatro p-4 p-md-5 shadow-sm border-0">
            <div class="text-center mb-4 pb-3 border-bottom">
                <span class="text-success fw-bold text-uppercase" style="font-size: 0.85rem;">Passo 1 de 2 — Escolha de Pagamento</span>
                <h3 class="fw-bold text-dark mt-1">Pagamento Electrónico de Multa</h3>
                <p class="text-muted small">Seleccione a modalidade de pagamento pretendida para liquidar a infração.</p>
            </div>

            <!-- RESUMO DA MULTA -->
            <div class="bg-light p-3 rounded-3 border mb-4">
                <div class="row g-2">
                    <div class="col-sm-6">
                        <small class="text-muted d-block">Número da Multa</small>
                        <strong class="text-dark fs-6"><?= esc($multa['codigo_multa']) ?></strong>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-block">Nome do Condutor</small>
                        <strong class="text-dark fs-6"><?= esc(session()->get('utente_nome')) ?></strong>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-block">Infração</small>
                        <span class="text-dark fw-medium"><?= esc($multa['tipo_infracao']) ?></span>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted d-block">Valor a Pagar</small>
                        <span class="text-success fw-bold fs-5"><?= number_format($multa['valor'], 2, ',', '.') ?> MT</span>
                    </div>
                </div>
            </div>

            <!-- FORMULÁRIO DE SELECÇÃO DE MÉTODO -->
            <form action="<?= base_url('/utente/confirmar') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="multa_id" value="<?= esc($multa['id']) ?>">

                <h6 class="fw-bold text-dark mb-3">Selecione o Método de Pagamento:</h6>

                <div class="row g-3 mb-4">
                    <!-- Option M-Pesa -->
                    <div class="col-md-6">
                        <label class="card card-inatro p-3 h-100 cursor-pointer border-2" for="metodo_mpesa">
                            <div class="form-check d-flex align-items-center gap-3">
                                <input class="form-check-input flex-shrink-0" type="radio" name="metodo_pagamento" id="metodo_mpesa" value="M-Pesa" checked>
                                <div>
                                    <div class="fw-bold text-dark"><i class="fa-solid fa-mobile-screen-button text-danger me-1"></i> M-Pesa</div>
                                    <small class="text-muted">Pagamento via Carteira Móvel Vodacom</small>
                                </div>
                            </div>
                        </label>
                    </div>

                    <!-- Option e-Mola -->
                    <div class="col-md-6">
                        <label class="card card-inatro p-3 h-100 cursor-pointer border-2" for="metodo_emola">
                            <div class="form-check d-flex align-items-center gap-3">
                                <input class="form-check-input flex-shrink-0" type="radio" name="metodo_pagamento" id="metodo_emola" value="e-Mola">
                                <div>
                                    <div class="fw-bold text-dark"><i class="fa-solid fa-mobile-retro text-warning me-1"></i> e-Mola</div>
                                    <small class="text-muted">Pagamento via Carteira Móvel Movitel</small>
                                </div>
                            </div>
                        </label>
                    </div>

                    <!-- Option Banco -->
                    <div class="col-md-6">
                        <label class="card card-inatro p-3 h-100 cursor-pointer border-2" for="metodo_banco">
                            <div class="form-check d-flex align-items-center gap-3">
                                <input class="form-check-input flex-shrink-0" type="radio" name="metodo_pagamento" id="metodo_banco" value="Banco">
                                <div>
                                    <div class="fw-bold text-dark"><i class="fa-solid fa-building-columns text-primary me-1"></i> Transferência Bancária</div>
                                    <small class="text-muted">Referência de Pagamento Bancário</small>
                                </div>
                            </div>
                        </label>
                    </div>

                    <!-- Option Cartão -->
                    <div class="col-md-6">
                        <label class="card card-inatro p-3 h-100 cursor-pointer border-2" for="metodo_cartao">
                            <div class="form-check d-flex align-items-center gap-3">
                                <input class="form-check-input flex-shrink-0" type="radio" name="metodo_pagamento" id="metodo_cartao" value="Cartão">
                                <div>
                                    <div class="fw-bold text-dark"><i class="fa-solid fa-credit-card text-success me-1"></i> Cartão de Débito / Crédito</div>
                                    <small class="text-muted">Visa / Mastercard / SIMO Network</small>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="detalhes_metodo" class="form-label fw-semibold text-dark">
                        Número de Telefone ou Contacto para a Operação
                    </label>
                    <input type="text" class="form-control form-control-lg" id="detalhes_metodo" name="detalhes_metodo" value="+258 84 123 4567" required>
                    <small class="text-muted">Número utilizado para receber a solicitação de confirmação da transação.</small>
                </div>

                <button type="submit" class="btn btn-inatro-primary btn-lg w-100 fw-bold shadow-sm">
                    Continuar para Pagamento <i class="fa-solid fa-arrow-right ms-2"></i>
                </button>
            </form>

        </div>
    </div>
</div>

<?= $this->endSection() ?>
