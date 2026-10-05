<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title ?? 'Extrato do Utente — INATRO') ?></title>
    <style>
        @page {
            size: A4 portrait;
            margin: 10mm 12mm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 9pt;
            color: #222222;
            line-height: 1.35;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 2px solid #198754;
        }
        .logo-img {
            max-width: 140px;
            height: auto;
            display: inline-block;
            margin-bottom: 4px;
        }
        .header h2 {
            margin: 2px 0 1px 0;
            font-size: 13pt;
            color: #0f5132;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .header h4 {
            margin: 0;
            font-size: 9.5pt;
            font-weight: normal;
            color: #444444;
        }
        .doc-title {
            text-align: center;
            margin: 10px 0 14px 0;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-left: 4px solid #198754;
            padding: 8px;
            border-radius: 4px;
        }
        .doc-title h3 {
            margin: 0;
            color: #198754;
            font-size: 12pt;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .doc-title p {
            margin: 2px 0 0 0;
            font-size: 8.5pt;
            color: #666666;
        }
        .section-box {
            background-color: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 4px;
            margin-bottom: 12px;
            padding: 10px 12px;
            page-break-inside: avoid;
        }
        .section-title {
            font-size: 9pt;
            font-weight: bold;
            color: #198754;
            text-transform: uppercase;
            border-bottom: 1px solid #eeeeee;
            padding-bottom: 3px;
            margin-bottom: 8px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 4px 2px;
            vertical-align: top;
            font-size: 9pt;
        }
        .label {
            color: #666666;
            font-size: 7.5pt;
            text-transform: uppercase;
            font-weight: bold;
            display: block;
        }
        .value {
            color: #111111;
            font-weight: bold;
        }
        .value-code {
            font-family: 'Courier New', Courier, monospace;
            font-weight: bold;
            color: #0d6efd;
        }
        
        /* BOXES DE RESUMO FINANCEIRO */
        .summary-grid {
            width: 100%;
            border-collapse: separate;
            border-spacing: 6px;
            margin-bottom: 12px;
            page-break-inside: avoid;
        }
        .summary-card {
            background-color: #f8f9fa;
            border: 1px solid #cccccc;
            border-radius: 4px;
            padding: 8px;
            text-align: center;
        }
        .card-title {
            font-size: 7.5pt;
            font-weight: bold;
            text-transform: uppercase;
            color: #555555;
        }
        .card-value {
            font-size: 13pt;
            font-weight: bold;
            margin: 2px 0;
        }

        /* TABELA DE MULTAS E PAGAMENTOS */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            font-size: 8.5pt;
        }
        .data-table th {
            background-color: #f1f3f5;
            color: #333333;
            font-weight: bold;
            text-align: left;
            padding: 6px 5px;
            border: 1px solid #dee2e6;
            font-size: 8pt;
            text-transform: uppercase;
        }
        .data-table td {
            padding: 6px 5px;
            border: 1px solid #dee2e6;
            vertical-align: middle;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 7.5pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-paga { background-color: #d1e7dd; color: #0f5132; border: 1px solid #badbcc; }
        .badge-pendente { background-color: #fff3cd; color: #664d03; border: 1px solid #ffecb5; }
        .badge-vencida { background-color: #f8d7da; color: #842029; border: 1px solid #f5c2c7; }

        .footer {
            margin-top: 15px;
            padding-top: 8px;
            border-top: 1px dashed #cccccc;
            font-size: 7.5pt;
            color: #666666;
            text-align: center;
            page-break-inside: avoid;
        }
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
        <h3>Extrato Individual do Utente / Condutor</h3>
        <p>Relatório Consolidado de Situação Administrativa e Financeira — Emissão em <?= date('d/m/Y H:i:s') ?></p>
    </div>

    <!-- DADOS DO UTENTE -->
    <div class="section-box">
        <div class="section-title">Informações do Utente</div>
        <table class="info-table">
            <tr>
                <td style="width: 35%;">
                    <span class="label">Nome Completo</span>
                    <span class="value"><?= esc($utente['nome']) ?></span>
                </td>
                <td style="width: 30%;">
                    <span class="label">Carta de Condução N.º</span>
                    <span class="value-code"><?= esc($utente['numero_carta']) ?></span>
                </td>
                <td style="width: 35%;">
                    <span class="label">N.º de BI</span>
                    <span class="value"><?= esc($utente['bi_numero'] ?? 'Não registado') ?></span>
                </td>
            </tr>
            <tr>
                <td style="padding-top: 5px;">
                    <span class="label">Data de Nascimento</span>
                    <span class="value"><?= !empty($utente['data_nascimento']) ? date('d/m/Y', strtotime($utente['data_nascimento'])) : 'N/D' ?></span>
                </td>
                <td style="padding-top: 5px;">
                    <span class="label">Telefone / Contacto</span>
                    <span class="value"><?= esc($utente['telefone'] ?? 'N/D') ?></span>
                </td>
                <td style="padding-top: 5px;">
                    <span class="label">Endereço de E-mail</span>
                    <span class="value"><?= esc($utente['email'] ?? 'N/D') ?></span>
                </td>
            </tr>
        </table>
    </div>

    <!-- CARTÕES DE RESUMO FINANCEIRO -->
    <table class="summary-grid">
        <tr>
            <td style="width: 25%;">
                <div class="summary-card" style="border-left: 4px solid #0d6efd;">
                    <div class="card-title">Total Multas</div>
                    <div class="card-value" style="color: #0d6efd;"><?= $resumo['total_multas'] ?? 0 ?></div>
                    <div style="font-size: 7pt; color: #666;"><?= number_format($resumo['valor_total_global'] ?? 0, 2, ',', '.') ?> MT</div>
                </div>
            </td>
            <td style="width: 25%;">
                <div class="summary-card" style="border-left: 4px solid #198754;">
                    <div class="card-title">Multas Liquidadas</div>
                    <div class="card-value" style="color: #198754;"><?= $resumo['qtd_pagas'] ?? 0 ?></div>
                    <div style="font-size: 7pt; color: #198754; font-weight: bold;"><?= number_format($resumo['valor_pago_total'] ?? 0, 2, ',', '.') ?> MT Pago</div>
                </div>
            </td>
            <td style="width: 25%;">
                <div class="summary-card" style="border-left: 4px solid #ffc107;">
                    <div class="card-title">Multas Pendentes</div>
                    <div class="card-value" style="color: #856404;"><?= $resumo['qtd_pendentes'] ?? 0 ?></div>
                    <div style="font-size: 7pt; color: #856404;">A aguardar pagamento</div>
                </div>
            </td>
            <td style="width: 25%;">
                <div class="summary-card" style="border-left: 4px solid #dc3545;">
                    <div class="card-title">Saldo por Pagar</div>
                    <div class="card-value" style="color: #dc3545;"><?= number_format($resumo['valor_pendente_total'] ?? 0, 2, ',', '.') ?></div>
                    <div style="font-size: 7pt; color: #dc3545; font-weight: bold;">MT em Aberto</div>
                </div>
            </td>
        </tr>
    </table>

    <!-- HISTÓRICO DE MULTAS E PROCESSAMENTO -->
    <div style="margin-top: 10px;">
        <div class="section-title" style="margin-bottom: 4px;">Histórico Geral de Infrações e Pagamentos do Utente</div>

        <?php if (empty($multas)): ?>
            <div style="text-align: center; padding: 20px; background-color: #f8f9fa; border: 1px solid #eeeeee; color: #666666;">
                Nenhuma infração registada para este utente.
            </div>
        <?php else: ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 12%;">Código</th>
                        <th style="width: 28%;">Infração / Local</th>
                        <th style="width: 14%;">Data Infração</th>
                        <th style="width: 12%;">Valor Multa</th>
                        <th style="width: 12%;">Estado</th>
                        <th style="width: 22%;">Ref. Pagamento / Data</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($multas as $m): ?>
                        <?php $p = $pagamentosPorMulta[$m['id']] ?? null; ?>
                        <tr>
                            <td>
                                <strong style="font-family: monospace; color: #0d6efd;"><?= esc($m['codigo_multa']) ?></strong>
                            </td>
                            <td>
                                <strong><?= esc($m['tipo_infracao']) ?></strong>
                                <?php if (!empty($m['local_infracao'])): ?>
                                    <div style="font-size: 7.5pt; color: #666;"><?= esc($m['local_infracao']) ?></div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= date('d/m/Y H:i', strtotime($m['data_infracao'])) ?>
                            </td>
                            <td>
                                <strong><?= number_format($m['valor'] ?? $m['valor_multa'] ?? 0, 2, ',', '.') ?> MT</strong>
                            </td>
                            <td>
                                <?php if ($m['estado'] === 'paga' || ($p && $p['estado'] === 'pago')): ?>
                                    <span class="badge badge-paga">LIQUIDADA</span>
                                <?php elseif ($m['estado'] === 'vencida'): ?>
                                    <span class="badge badge-vencida">VENCIDA</span>
                                <?php else: ?>
                                    <span class="badge badge-pendente">PENDENTE</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($p && $p['estado'] === 'pago'): ?>
                                    <div style="font-family: monospace; font-size: 7.5pt; color: #198754; font-weight: bold;"><?= esc($p['referencia_transacao']) ?></div>
                                    <div style="font-size: 7pt; color: #666;"><?= date('d/m/Y H:i', strtotime($p['data_pagamento'])) ?> (<?= esc($p['metodo_pagamento']) ?>)</div>
                                <?php elseif ($p): ?>
                                    <div style="font-size: 7.5pt; color: #856404; font-weight: bold;"><?= strtoupper(esc($p['estado'])) ?></div>
                                    <div style="font-size: 7pt; color: #666;"><?= esc($p['referencia_transacao']) ?></div>
                                <?php else: ?>
                                    <span style="color: #999; font-size: 7.5pt; italic">Sem pagamento</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <div class="footer">
        <p style="margin-bottom: 2px;">Este extrato individual foi emitido pelo Administrador através do Portal Institucional do INATRO, IP.</p>
        <p style="margin: 0; font-weight: bold;">Documento Administrativo Oficial de Controlo de Condutor.</p>
    </div>

</body>
</html>
