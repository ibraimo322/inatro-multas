<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title ?? 'Relatório Geral de Pagamentos — INATRO') ?></title>
    <style>
        @page {
            size: A4 landscape;
            margin: 10mm 12mm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 8.5pt;
            color: #222222;
            line-height: 1.3;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 2px solid #198754;
        }
        .logo-img {
            max-width: 140px;
            height: auto;
            display: inline-block;
            margin-bottom: 3px;
        }
        .header h2 {
            margin: 2px 0 1px 0;
            font-size: 12pt;
            color: #0f5132;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .header h4 {
            margin: 0;
            font-size: 9pt;
            font-weight: normal;
            color: #444444;
        }
        .doc-title {
            text-align: center;
            margin: 8px 0 10px 0;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-left: 4px solid #198754;
            padding: 6px;
            border-radius: 4px;
        }
        .doc-title h3 {
            margin: 0;
            color: #198754;
            font-size: 11pt;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .doc-title p {
            margin: 1px 0 0 0;
            font-size: 8pt;
            color: #666666;
        }

        /* GRID DE INDICADORES DE RESUMO */
        .summary-grid {
            width: 100%;
            border-collapse: separate;
            border-spacing: 6px;
            margin-bottom: 10px;
            page-break-inside: avoid;
        }
        .summary-card {
            background-color: #ffffff;
            border: 1px solid #cccccc;
            border-radius: 4px;
            padding: 6px;
            text-align: center;
        }
        .card-title {
            font-size: 7pt;
            font-weight: bold;
            text-transform: uppercase;
            color: #555555;
        }
        .card-value {
            font-size: 11.5pt;
            font-weight: bold;
            margin: 1px 0;
        }

        /* TABELA DE DADOS */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            font-size: 8pt;
        }
        .data-table thead {
            display: table-header-group;
        }
        .data-table tr {
            page-break-inside: avoid;
        }
        .data-table th {
            background-color: #198754;
            color: #ffffff;
            font-weight: bold;
            text-align: left;
            padding: 5px 6px;
            border: 1px solid #146c43;
            font-size: 7.5pt;
            text-transform: uppercase;
        }
        .data-table td {
            padding: 5px 6px;
            border: 1px solid #dee2e6;
            vertical-align: middle;
        }
        .data-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .badge {
            display: inline-block;
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 7pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-pago { background-color: #d1e7dd; color: #0f5132; border: 1px solid #badbcc; }
        .badge-pendente { background-color: #fff3cd; color: #664d03; border: 1px solid #ffecb5; }
        .badge-rejeitado { background-color: #f8d7da; color: #842029; border: 1px solid #f5c2c7; }

        .footer {
            margin-top: 12px;
            padding-top: 6px;
            border-top: 1px dashed #cccccc;
            font-size: 7.5pt;
            color: #666666;
            text-align: center;
            page-break-inside: avoid;
        }
        .text-end { text-align: right; }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo-container">
            <?php 
                $logoPath = FCPATH . 'assets/images/logo.png';
                if (file_exists($logoPath)) {
                    $type = pathinfo($logoPath, PATHINFO_EXTENSION);
                    $data = file_get_contents($logoPath);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    echo '<img src="' . $base64 . '" class="logo-img" alt="INATRO Logo">';
                } else {
                    echo '<h3 style="color: #198754; margin:0;">INATRO, IP</h3>';
                }
            ?>
        </div>
        <h2>REPÚBLICA DE MOÇAMBIQUE</h2>
        <h4>INSTITUTO NACIONAL DOS TRANSPORTES TERRESTRES (INATRO, IP)</h4>
    </div>

    <div class="doc-title">
        <h3><?= esc($utente ? 'Histórico Geral de Pagamentos do Utente' : 'Relatório Geral de Pagamentos do Sistema') ?></h3>
        <p>Documento Consolidado da Administração — Emissão em <?= date('d/m/Y H:i:s') ?></p>
    </div>

    <?php if (isset($resumo)): ?>
        <!-- CARTÕES DE INDICADORES GERAIS -->
        <table class="summary-grid">
            <tr>
                <td style="width: 25%;">
                    <div class="summary-card" style="border-left: 4px solid #0d6efd;">
                        <div class="card-title">Total Registos</div>
                        <div class="card-value" style="color: #0d6efd;"><?= $resumo['total'] ?? 0 ?></div>
                        <div style="font-size: 6.5pt; color: #666;"><?= number_format($resumo['valor_total'] ?? 0, 2, ',', '.') ?> MT Total</div>
                    </div>
                </td>
                <td style="width: 25%;">
                    <div class="summary-card" style="border-left: 4px solid #198754;">
                        <div class="card-title">Total Liquidado (Pago)</div>
                        <div class="card-value" style="color: #198754;"><?= $resumo['pagos'] ?? 0 ?></div>
                        <div style="font-size: 6.5pt; color: #198754; font-weight: bold;"><?= number_format($resumo['valor_pago'] ?? 0, 2, ',', '.') ?> MT Liquidado</div>
                    </div>
                </td>
                <td style="width: 25%;">
                    <div class="summary-card" style="border-left: 4px solid #ffc107;">
                        <div class="card-title">Pendentes / Análise</div>
                        <div class="card-value" style="color: #856404;"><?= $resumo['pendentes'] ?? 0 ?></div>
                        <div style="font-size: 6.5pt; color: #856404;"><?= number_format($resumo['valor_pendente'] ?? 0, 2, ',', '.') ?> MT Pendente</div>
                    </div>
                </td>
                <td style="width: 25%;">
                    <div class="summary-card" style="border-left: 4px solid #dc3545;">
                        <div class="card-title">Rejeitadas / Falhadas</div>
                        <div class="card-value" style="color: #dc3545;"><?= $resumo['rejeitados'] ?? 0 ?></div>
                        <div style="font-size: 6.5pt; color: #dc3545;"><?= number_format($resumo['valor_rejeitado'] ?? 0, 2, ',', '.') ?> MT Rejeitado</div>
                    </div>
                </td>
            </tr>
        </table>
    <?php endif; ?>

    <?php if (empty($pagamentos)): ?>
        <div style="text-align: center; padding: 20px; background-color: #f8f9fa; border: 1px solid #eeeeee; color: #666666;">
            Nenhum registo de pagamento encontrado na base de dados.
        </div>
    <?php else: ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 14%;">Ref. Transação</th>
                    <?php if (empty($utente)): ?>
                        <th style="width: 20%;">Utente / Condutor</th>
                        <th style="width: 12%;">Carta N.º</th>
                    <?php endif; ?>
                    <th style="width: 10%;">Multa N.º</th>
                    <th style="width: 18%;">Infração</th>
                    <th style="width: 10%;">Método</th>
                    <th style="width: 12%;">Data Pagamento</th>
                    <th style="width: 10%;" class="text-end">Valor Pago</th>
                    <th style="width: 8%;">Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $totalPago = 0.00;
                    foreach ($pagamentos as $p): 
                        if ($p['estado'] === 'pago') {
                            $totalPago += floatval($p['valor_pago']);
                        }
                ?>
                    <tr>
                        <td>
                            <strong style="font-family: monospace; color: #0d6efd;"><?= esc($p['referencia_transacao']) ?></strong>
                        </td>
                        <?php if (empty($utente)): ?>
                            <td><strong><?= esc($p['utente_nome'] ?? 'N/A') ?></strong></td>
                            <td><code style="font-family: monospace; font-weight: bold;"><?= esc($p['numero_carta'] ?? 'N/A') ?></code></td>
                        <?php endif; ?>
                        <td><strong style="color: #444;"><?= esc($p['codigo_multa']) ?></strong></td>
                        <td><?= esc($p['tipo_infracao']) ?></td>
                        <td><?= esc($p['metodo_pagamento']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($p['data_pagamento'])) ?></td>
                        <td class="text-end"><strong style="color: #198754;"><?= number_format($p['valor_pago'], 2, ',', '.') ?> MT</strong></td>
                        <td>
                            <?php if ($p['estado'] === 'pago'): ?>
                                <span class="badge badge-pago">Pago</span>
                            <?php elseif ($p['estado'] === 'em_processamento' || $p['estado'] === 'pendente'): ?>
                                <span class="badge badge-pendente">Pendente</span>
                            <?php else: ?>
                                <span class="badge badge-rejeitado">Rejeitado</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <table style="width: 100%; border-collapse: collapse; margin-top: 10px; page-break-inside: avoid;">
            <tr>
                <td style="text-align: right; font-size: 10pt;">
                    <strong>TOTAL GERAL LIQUIDADO NO RELATÓRIO: </strong>
                    <span style="color: #198754; font-size: 12pt; font-weight: bold; margin-left: 8px;">
                        <?= number_format($totalPago, 2, ',', '.') ?> MT
                    </span>
                </td>
            </tr>
        </table>
    <?php endif; ?>

    <div class="footer">
        <p style="margin-bottom: 2px;">Relatório Oficial emitido pelo Sistema Central do Instituto Nacional dos Transportes Terrestres (INATRO, IP).</p>
        <p style="margin: 0;">© <?= date('Y') ?> INATRO, IP — República de Moçambique. Todos os direitos reservados.</p>
    </div>

</body>
</html>
