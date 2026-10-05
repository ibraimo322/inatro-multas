<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<!-- 1. CABEÇALHO DA PÁGINA -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-receipt text-success me-2"></i> Monitorização de Transacções
        </h4>
        <p class="text-muted small mb-0">Acompanhamento detalhado do processamento financeiro e estado das transações no sistema.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= base_url('/admin/gerar-pdf-historico') ?>" class="btn btn-success btn-sm shadow-sm px-3" target="_blank">
            <i class="fa-solid fa-file-pdf me-1"></i> Baixar Relatório PDF
        </a>
        <a href="<?= base_url('/admin/pagamentos') ?>" class="btn btn-outline-secondary btn-sm px-3">
            <i class="fa-solid fa-credit-card me-1"></i> Ir para Pagamentos
        </a>
    </div>
</div>

<!-- 2. BARRA DE PESQUISA E FILTROS -->
<div class="card card-inatro p-3 mb-4 border-0 shadow-sm">
    <form action="<?= base_url('/admin/transacoes') ?>" method="get" class="row g-2 align-items-center">
        <div class="col-md-5">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-search text-muted"></i></span>
                <input type="text" class="form-control border-start-0" name="busca" placeholder="Pesquisar por ID, Ref Transacção, Utente ou N.º da Carta..." value="<?= esc($busca ?? '') ?>">
            </div>
        </div>
        <div class="col-md-3">
            <select name="estado" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="todos" <?= ($estadoFiltro ?? 'todos') === 'todos' ? 'selected' : '' ?>>Todos os Estados</option>
                <option value="pago" <?= ($estadoFiltro ?? '') === 'pago' ? 'selected' : '' ?>>Concluída (Pago)</option>
                <option value="pendente" <?= ($estadoFiltro ?? '') === 'pendente' ? 'selected' : '' ?>>Pendente / Em Análise</option>
                <option value="rejeitado" <?= ($estadoFiltro ?? '') === 'rejeitado' ? 'selected' : '' ?>>Falhada / Rejeitada</option>
            </select>
        </div>
        <div class="col-md-2">
            <input type="date" class="form-control form-control-sm" name="data" value="<?= esc($dataFiltro ?? '') ?>" onchange="this.form.submit()">
        </div>
        <div class="col-md-2 d-flex gap-1">
            <button type="submit" class="btn btn-inatro-primary btn-sm w-100">Filtrar</button>
            <a href="<?= base_url('/admin/transacoes') ?>" class="btn btn-outline-secondary btn-sm" title="Limpar Filtros"><i class="fa-solid fa-rotate-left"></i></a>
        </div>
    </form>
</div>

<!-- 3. INDICADORES / RESUMO ESTATÍSTICO -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card card-inatro p-3 border-0 shadow-sm border-start border-4 border-primary">
            <div class="text-muted small fw-bold text-uppercase">Total Transações</div>
            <div class="fs-4 fw-bold text-dark my-1"><?= $resumo['total'] ?? 0 ?></div>
            <div class="small text-muted"><?= number_format($resumo['valor_total'] ?? 0, 2, ',', '.') ?> MT</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card card-inatro p-3 border-0 shadow-sm border-start border-4 border-success">
            <div class="text-success small fw-bold text-uppercase">Concluídas (Sucesso)</div>
            <div class="fs-4 fw-bold text-success my-1"><?= $resumo['pagos'] ?? 0 ?></div>
            <div class="small text-muted"><?= number_format($resumo['valor_pago'] ?? 0, 2, ',', '.') ?> MT</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card card-inatro p-3 border-0 shadow-sm border-start border-4 border-warning">
            <div class="text-warning-emphasis small fw-bold text-uppercase">Pendentes / Em Análise</div>
            <div class="fs-4 fw-bold text-warning-emphasis my-1"><?= $resumo['pendentes'] ?? 0 ?></div>
            <div class="small text-muted"><?= number_format($resumo['valor_pendente'] ?? 0, 2, ',', '.') ?> MT</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card card-inatro p-3 border-0 shadow-sm border-start border-4 border-danger">
            <div class="text-danger small fw-bold text-uppercase">Falhadas / Rejeitadas</div>
            <div class="fs-4 fw-bold text-danger my-1"><?= $resumo['rejeitados'] ?? 0 ?></div>
            <div class="small text-muted"><?= number_format($resumo['valor_rejeitado'] ?? 0, 2, ',', '.') ?> MT</div>
        </div>
    </div>
</div>

<!-- 4. TABELA PRINCIPAL DE TRANSAÇÕES -->
<div class="card card-inatro p-3 border-0 shadow-sm">
    <?php if (empty($transacoes)): ?>
        <div class="text-center py-5">
            <i class="fa-solid fa-list-check text-muted fs-1 mb-3"></i>
            <p class="text-muted fw-medium mb-0">Nenhuma transacção encontrada com os critérios seleccionados.</p>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-sm table-hover align-middle mb-0" style="font-size: 0.88rem;">
                <thead class="table-light">
                    <tr>
                        <th scope="col">ID Transação</th>
                        <th scope="col">Ref. Operação</th>
                        <th scope="col">Utente / Condutor</th>
                        <th scope="col">N.º Carta</th>
                        <th scope="col">Multa Associada</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Data / Hora</th>
                        <th scope="col">Método</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Resultado</th>
                        <th scope="col" class="text-end">Comprovativo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transacoes as $t): ?>
                        <tr>
                            <td>
                                <span class="badge bg-secondary">#<?= esc($t['id']) ?></span>
                            </td>
                            <td>
                                <code class="fw-bold text-dark"><?= esc($t['referencia_transacao']) ?></code>
                            </td>
                            <td>
                                <strong class="text-dark"><?= esc($t['utente_nome']) ?></strong>
                            </td>
                            <td>
                                <code class="text-muted"><?= esc($t['numero_carta']) ?></code>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border"><?= esc($t['codigo_multa']) ?></span>
                            </td>
                            <td>
                                <strong class="text-dark"><?= number_format($t['valor_pago'], 2, ',', '.') ?> MT</strong>
                            </td>
                            <td class="small text-muted">
                                <?= date('d/m/Y H:i:s', strtotime($t['data_pagamento'])) ?>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    <i class="fa-solid fa-credit-card text-success me-1"></i> <?= esc($t['metodo_pagamento']) ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($t['estado'] === 'pago'): ?>
                                    <span class="badge bg-success-subtle text-success border border-success px-2 py-1">
                                        <i class="fa-solid fa-check me-1"></i> Concluída
                                    </span>
                                <?php elseif ($t['estado'] === 'em_processamento' || $t['estado'] === 'pendente'): ?>
                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning px-2 py-1">
                                        <i class="fa-solid fa-hourglass-half me-1"></i> Pendente
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-danger-subtle text-danger border border-danger px-2 py-1">
                                        <i class="fa-solid fa-xmark me-1"></i> Falhada
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="small">
                                <?php if ($t['estado'] === 'pago'): ?>
                                    <span class="text-success fw-bold"><i class="fa-solid fa-circle-check me-1"></i> Sucesso</span>
                                <?php elseif ($t['estado'] === 'em_processamento' || $t['estado'] === 'pendente'): ?>
                                    <span class="text-warning fw-bold"><i class="fa-solid fa-spinner fa-spin me-1"></i> Em Análise</span>
                                <?php else: ?>
                                    <span class="text-danger fw-bold"><i class="fa-solid fa-circle-xmark me-1"></i> Rejeitado</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end" style="white-space: nowrap;">
                                <a href="<?= base_url('/admin/gerar-pdf-pagamento/' . $t['referencia_transacao']) ?>" class="btn btn-success btn-sm shadow-sm" target="_blank" title="Baixar PDF">
                                    <i class="fa-solid fa-file-pdf me-1"></i> PDF
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
