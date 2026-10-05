<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<!-- 1. CABEÇALHO DA PÁGINA -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-credit-card text-success me-2"></i> Gestão de Pagamentos
        </h4>
        <p class="text-muted small mb-0">Acompanhamento e controlo de pagamentos efectuados pelos utentes no portal.</p>
    </div>
    <div class="d-flex flex-wrap align-items-center gap-2">
        <!-- SELETOR RÁPIDO DE EXTRATO DE UTENTE -->
        <form action="" method="get" id="formExtratoUtente" class="d-inline-block" onsubmit="event.preventDefault(); var id=document.getElementById('selectUtenteExtrato').value; if(id) window.open('<?= base_url('/admin/gerar-pdf-utente') ?>/' + id, '_blank'); else alert('Por favor, seleccione um utente.');">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-white text-success border-success fw-bold"><i class="fa-solid fa-user me-1"></i> Extrato:</span>
                <select id="selectUtenteExtrato" class="form-select border-success" style="max-width: 220px;" required>
                    <option value="">-- Seleccionar Utente --</option>
                    <?php if (!empty($utentesLista)): ?>
                        <?php foreach ($utentesLista as $u): ?>
                            <option value="<?= $u['id'] ?>"><?= esc($u['nome']) ?> (<?= esc($u['numero_carta']) ?>)</option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <button type="submit" class="btn btn-outline-success"><i class="fa-solid fa-file-pdf me-1"></i> Gerar Extrato</button>
            </div>
        </form>
        <a href="<?= base_url('/admin/gerar-pdf-historico') ?>" class="btn btn-success btn-sm shadow-sm px-3" target="_blank">
            <i class="fa-solid fa-file-pdf me-1"></i> Relatório Geral
        </a>
        <a href="<?= base_url('/admin/transacoes') ?>" class="btn btn-outline-secondary btn-sm px-3">
            <i class="fa-solid fa-receipt me-1"></i> Ver Transacções
        </a>
    </div>
</div>

<!-- 2. BARRA DE PESQUISA E FILTROS -->
<div class="card card-inatro p-3 mb-4 border-0 shadow-sm">
    <form action="<?= base_url('/admin/pagamentos') ?>" method="get" class="row g-2 align-items-center">
        <div class="col-md-5">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-search text-muted"></i></span>
                <input type="text" class="form-control border-start-0" name="busca" placeholder="Pesquisar por Utente, Carta, Ref. Transacção ou Multa..." value="<?= esc($busca ?? '') ?>">
            </div>
        </div>
        <div class="col-md-3">
            <select name="estado" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="todos" <?= ($estadoFiltro ?? 'todos') === 'todos' ? 'selected' : '' ?>>Todos os Estados</option>
                <option value="pago" <?= ($estadoFiltro ?? '') === 'pago' ? 'selected' : '' ?>>Pago / Concluído</option>
                <option value="pendente" <?= ($estadoFiltro ?? '') === 'pendente' ? 'selected' : '' ?>>Pendente / Em Processamento</option>
                <option value="rejeitado" <?= ($estadoFiltro ?? '') === 'rejeitado' ? 'selected' : '' ?>>Rejeitado / Falhado</option>
            </select>
        </div>
        <div class="col-md-2">
            <input type="date" class="form-control form-control-sm" name="data" value="<?= esc($dataFiltro ?? '') ?>" onchange="this.form.submit()">
        </div>
        <div class="col-md-2 d-flex gap-1">
            <button type="submit" class="btn btn-inatro-primary btn-sm w-100">Filtrar</button>
            <a href="<?= base_url('/admin/pagamentos') ?>" class="btn btn-outline-secondary btn-sm" title="Limpar Filtros"><i class="fa-solid fa-rotate-left"></i></a>
        </div>
    </form>
</div>

<!-- 3. INDICADORES / RESUMO ESTATÍSTICO -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card card-inatro p-3 border-0 shadow-sm border-start border-4 border-primary">
            <div class="text-muted small fw-bold text-uppercase">Total Registos</div>
            <div class="fs-4 fw-bold text-dark my-1"><?= $resumo['total'] ?? 0 ?></div>
            <div class="small text-muted"><?= number_format($resumo['valor_total'] ?? 0, 2, ',', '.') ?> MT</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card card-inatro p-3 border-0 shadow-sm border-start border-4 border-success">
            <div class="text-success small fw-bold text-uppercase">Pagos / Concluídos</div>
            <div class="fs-4 fw-bold text-success my-1"><?= $resumo['pagos'] ?? 0 ?></div>
            <div class="small text-muted"><?= number_format($resumo['valor_pago'] ?? 0, 2, ',', '.') ?> MT</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card card-inatro p-3 border-0 shadow-sm border-start border-4 border-warning">
            <div class="text-warning-emphasis small fw-bold text-uppercase">Pendentes / Processamento</div>
            <div class="fs-4 fw-bold text-warning-emphasis my-1"><?= $resumo['pendentes'] ?? 0 ?></div>
            <div class="small text-muted"><?= number_format($resumo['valor_pendente'] ?? 0, 2, ',', '.') ?> MT</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card card-inatro p-3 border-0 shadow-sm border-start border-4 border-danger">
            <div class="text-danger small fw-bold text-uppercase">Rejeitados / Falhados</div>
            <div class="fs-4 fw-bold text-danger my-1"><?= $resumo['rejeitados'] ?? 0 ?></div>
            <div class="small text-muted"><?= number_format($resumo['valor_rejeitado'] ?? 0, 2, ',', '.') ?> MT</div>
        </div>
    </div>
</div>

<!-- 4. TABELA PRINCIPAL DE PAGAMENTOS -->
<div class="card card-inatro p-3 border-0 shadow-sm">
    <?php if (empty($pagamentos)): ?>
        <div class="text-center py-5">
            <i class="fa-solid fa-receipt text-muted fs-1 mb-3"></i>
            <p class="text-muted fw-medium mb-0">Nenhum pagamento encontrado com os critérios seleccionados.</p>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-sm table-hover align-middle mb-0" style="font-size: 0.88rem;">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Ref. Transação</th>
                        <th scope="col">Utente / Condutor</th>
                        <th scope="col">Carta N.º</th>
                        <th scope="col">Multa ID</th>
                        <th scope="col">Tipo de Infração</th>
                        <th scope="col">Data Multa</th>
                        <th scope="col">Data Pagamento</th>
                        <th scope="col">Método</th>
                        <th scope="col">Valor Pago</th>
                        <th scope="col">Estado</th>
                        <th scope="col" class="text-end">Comprovativo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pagamentos as $p): ?>
                        <tr>
                            <td>
                                <code class="fw-bold text-dark"><?= esc($p['referencia_transacao']) ?></code>
                            </td>
                            <td>
                                <strong class="text-dark"><?= esc($p['utente_nome']) ?></strong>
                            </td>
                            <td>
                                <code class="text-muted"><?= esc($p['numero_carta']) ?></code>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border"><?= esc($p['codigo_multa']) ?></span>
                            </td>
                            <td class="small text-truncate" style="max-width: 170px;">
                                <?= esc($p['tipo_infracao']) ?>
                            </td>
                            <td class="small text-muted">
                                <?= !empty($p['data_infracao']) ? date('d/m/Y H:i', strtotime($p['data_infracao'])) : 'N/A' ?>
                            </td>
                            <td class="small">
                                <?= date('d/m/Y H:i', strtotime($p['data_pagamento'])) ?>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    <i class="fa-solid fa-credit-card text-success me-1"></i> <?= esc($p['metodo_pagamento']) ?>
                                </span>
                            </td>
                            <td>
                                <strong class="text-success"><?= number_format($p['valor_pago'], 2, ',', '.') ?> MT</strong>
                            </td>
                            <td>
                                <?php if ($p['estado'] === 'pago'): ?>
                                    <span class="badge-status badge-paga py-1 px-2">
                                        <i class="fa-solid fa-circle-check"></i> Pago
                                    </span>
                                <?php elseif ($p['estado'] === 'em_processamento' || $p['estado'] === 'pendente'): ?>
                                    <span class="badge-status badge-em_processamento py-1 px-2">
                                        <i class="fa-solid fa-arrows-rotate fa-spin"></i> Pendente
                                    </span>
                                <?php else: ?>
                                    <span class="badge-status badge-vencida py-1 px-2">
                                        <i class="fa-solid fa-circle-xmark"></i> Rejeitado
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end" style="white-space: nowrap;">
                                <a href="<?= base_url('/admin/gerar-pdf-pagamento/' . $p['referencia_transacao']) ?>" class="btn btn-success btn-sm shadow-sm" target="_blank" title="Baixar Comprovativo de Pagamento">
                                    <i class="fa-solid fa-file-pdf me-1"></i> PDF
                                </a>
                                <?php if (!empty($p['utente_id'])): ?>
                                    <a href="<?= base_url('/admin/gerar-pdf-utente/' . $p['utente_id']) ?>" class="btn btn-outline-success btn-sm shadow-sm" target="_blank" title="Gerar Extrato Individual do Utente">
                                        <i class="fa-solid fa-id-card me-1"></i> Extrato Utente
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
