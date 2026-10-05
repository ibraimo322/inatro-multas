<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-file-circle-plus text-success me-2"></i> Atribuir Nova Multa de Trânsito
        </h4>
        <p class="text-muted small mb-0">Selecione o utente, a infracção pré-cadastrada e o local por província para registar a multa.</p>
    </div>
    <a href="<?= base_url('/admin/multas') ?>" class="btn btn-outline-secondary btn-sm">
        <i class="fa-solid fa-arrow-left me-1"></i> Voltar à Lista
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card card-inatro p-4 border-0 shadow-sm">
            <form action="<?= base_url('/admin/salvar-multa') ?>" method="post">
                <?= csrf_field() ?>

                <div class="row g-3">
                    <!-- Seleção do Utente -->
                    <div class="col-md-6">
                        <label for="utente_id" class="form-label fw-bold text-dark">Utente / Condutor <span class="text-danger">*</span></label>
                        <select class="form-select" id="utente_id" name="utente_id" required>
                            <option value="" selected disabled>-- Seleccione o Condutor --</option>
                            <?php foreach ($utentes as $u): ?>
                                <option value="<?= esc($u['id']) ?>" <?= old('utente_id') == $u['id'] ? 'selected' : '' ?>>
                                    <?= esc($u['nome']) ?> (Carta: <?= esc($u['numero_carta']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Seleção da Infracção Pré-cadastrada -->
                    <div class="col-md-6">
                        <label for="infracao_id" class="form-label fw-bold text-dark">Tipo de Infracção (Pré-cadastrada) <span class="text-danger">*</span></label>
                        <select class="form-select" id="infracao_id" name="infracao_id" required onchange="actualizarInfracao(this)">
                            <option value="" selected disabled>-- Seleccione a Infracção --</option>
                            <?php foreach ($infracoes as $inf): ?>
                                <option value="<?= esc($inf['id']) ?>" 
                                        data-valor="<?= esc($inf['valor']) ?>" 
                                        data-artigo="<?= esc($inf['artigo_lei']) ?>" 
                                        data-descricao="<?= esc($inf['descricao']) ?>"
                                        data-tipo="<?= esc($inf['tipo']) ?>">
                                    <?= esc($inf['tipo']) ?> — <?= number_format($inf['valor'], 2, ',', '.') ?> MT
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <input type="hidden" id="tipo_infracao" name="tipo_infracao" value="">
                        <input type="hidden" id="artigo_lei" name="artigo_lei" value="">
                        <input type="hidden" id="descricao" name="descricao" value="">
                    </div>

                    <!-- Valor da Multa (Automático / Readonly) -->
                    <div class="col-md-6">
                        <label for="valor_exibicao" class="form-label fw-bold text-dark">Valor da Multa (Automático)</label>
                        <div class="input-group">
                            <input type="text" class="form-control bg-light fw-bold text-success fs-5" id="valor_exibicao" readonly value="0,00 MT">
                            <input type="hidden" id="valor" name="valor" value="0.00">
                        </div>
                        <small class="text-muted" style="font-size: 0.78rem;">O valor é definido automaticamente conforme a infracção seleccionada.</small>
                    </div>

                    <!-- Enquadramento Legal (Artigo) -->
                    <div class="col-md-6">
                        <label for="artigo_exibicao" class="form-label fw-bold text-dark">Artigo de Lei</label>
                        <input type="text" class="form-control bg-light text-muted" id="artigo_exibicao" readonly value="Selecione uma infracção">
                    </div>

                    <!-- Seleção da Província -->
                    <div class="col-md-6">
                        <label for="provincia" class="form-label fw-bold text-dark">Província da Ocorrência <span class="text-danger">*</span></label>
                        <select class="form-select" id="provincia" name="provincia" required onchange="carregarLocaisPorProvincia(this.value)">
                            <option value="" selected disabled>-- Seleccione a Província --</option>
                            <?php foreach ($provincias as $p): ?>
                                <option value="<?= esc($p['provincia']) ?>"><?= esc($p['provincia']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Seleção do Local da Infracção (Pré-cadastrado por Província) -->
                    <div class="col-md-6">
                        <label for="local_infracao" class="form-label fw-bold text-dark">Local da Infracção (Pré-cadastrado) <span class="text-danger">*</span></label>
                        <select class="form-select" id="local_infracao" name="local_infracao" required disabled>
                            <option value="" selected disabled>-- Seleccione primeiro a Província --</option>
                        </select>
                        <small class="text-muted" style="font-size: 0.78rem;">Locais oficiais associados à província seleccionada.</small>
                    </div>

                    <!-- Data e Hora da Infracção -->
                    <div class="col-md-6">
                        <label for="data_infracao" class="form-label fw-bold text-dark">Data e Hora da Infracção <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control" id="data_infracao" name="data_infracao" required value="<?= date('Y-m-d\TH:i') ?>">
                    </div>

                    <!-- Estado Inicial da Multa -->
                    <div class="col-md-6">
                        <label for="estado" class="form-label fw-bold text-dark">Estado Inicial <span class="text-danger">*</span></label>
                        <select class="form-select" id="estado" name="estado" required>
                            <option value="pendente" selected>Pendente</option>
                            <option value="paga">Paga</option>
                            <option value="em_processamento">Em Processamento</option>
                            <option value="vencida">Vencida</option>
                        </select>
                    </div>

                    <div class="col-12 mt-4 text-end">
                        <a href="<?= base_url('/admin/multas') ?>" class="btn btn-light me-2">Cancelar</a>
                        <button type="submit" class="btn btn-inatro-primary px-4">
                            <i class="fa-solid fa-check-circle me-1"></i> Atribuir Multa
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function actualizarInfracao(selectElem) {
        const option = selectElem.options[selectElem.selectedIndex];
        if (!option || !option.value) return;

        const valor = parseFloat(option.getAttribute('data-valor') || 0);
        const artigo = option.getAttribute('data-artigo') || '';
        const descricao = option.getAttribute('data-descricao') || '';
        const tipo = option.getAttribute('data-tipo') || '';

        document.getElementById('valor').value = valor.toFixed(2);
        document.getElementById('valor_exibicao').value = valor.toLocaleString('pt-MZ', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' MT';
        document.getElementById('artigo_exibicao').value = artigo;

        document.getElementById('tipo_infracao').value = tipo;
        document.getElementById('artigo_lei').value = artigo;
        document.getElementById('descricao').value = descricao;
    }

    function carregarLocaisPorProvincia(provincia) {
        const localSelect = document.getElementById('local_infracao');
        localSelect.innerHTML = '<option value="" selected disabled>A carregar locais...</option>';
        localSelect.disabled = true;

        fetch('<?= base_url('/admin/get-locais-por-provincia') ?>?provincia=' + encodeURIComponent(provincia))
            .then(response => response.json())
            .then(data => {
                localSelect.innerHTML = '<option value="" selected disabled>-- Seleccione o Local --</option>';
                if (data && data.length > 0) {
                    data.forEach(item => {
                        const opt = document.createElement('option');
                        opt.value = item.local_nome;
                        opt.textContent = item.local_nome;
                        localSelect.appendChild(opt);
                    });
                    localSelect.disabled = false;
                } else {
                    localSelect.innerHTML = '<option value="" selected disabled>Nenhum local encontrado para esta província</option>';
                }
            })
            .catch(err => {
                console.error(err);
                localSelect.innerHTML = '<option value="" selected disabled>Erro ao carregar locais</option>';
            });
    }
</script>

<?= $this->endSection() ?>
