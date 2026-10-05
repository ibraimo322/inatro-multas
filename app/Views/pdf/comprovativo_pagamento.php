<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title ?? 'Comprovativo de Pagamento — INATRO') ?></title>
    <style>
        @page {
            size: A4 portrait;
            margin: 8mm 12mm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 9.5pt;
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
        .logo-container {
            text-align: center;
            margin-bottom: 4px;
        }
        .logo-img {
            max-width: 130px;
            height: auto;
            display: inline-block;
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
            margin: 8px 0 12px 0;
            background-color: #e8f5e9;
            border: 1px solid #c8e6c9;
            padding: 6px;
            border-radius: 4px;
        }
        .doc-title h3 {
            margin: 0;
            color: #1b5e20;
            font-size: 11pt;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .doc-title p {
            margin: 1px 0 0 0;
            font-size: 8pt;
            color: #555555;
            text-transform: uppercase;
        }
        .section-box {
            background-color: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 4px;
            margin-bottom: 8px;
            padding: 8px 12px;
            page-break-inside: avoid;
        }
        .section-title {
            font-size: 8.5pt;
            font-weight: bold;
            color: #198754;
            text-transform: uppercase;
            border-bottom: 1px solid #eeeeee;
            padding-bottom: 2px;
            margin-bottom: 6px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 3px 2px;
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
        .amount-card {
            background-color: #f8f9fa;
            border: 2px solid #198754;
            border-radius: 6px;
            text-align: center;
            padding: 8px;
            margin: 10px 0;
            page-break-inside: avoid;
        }
        .amount-card .lbl {
            font-size: 8pt;
            color: #555555;
            text-transform: uppercase;
            font-weight: bold;
        }
        .amount-card .val {
            font-size: 16pt;
            color: #198754;
            font-weight: bold;
            margin: 2px 0;
        }
        .amount-card .sub {
            font-size: 7.5pt;
            color: #777777;
        }
        .badge-pago {
            display: inline-block;
            background-color: #d1e7dd;
            color: #0f5132;
            padding: 2px 8px;
            border-radius: 10px;
            font-weight: bold;
            font-size: 8.5pt;
            border: 1px solid #badbcc;
        }
        .footer {
            margin-top: 12px;
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
        <h3>Comprovativo de Pagamento</h3>
        <p>Documento Comprovativo Oficial de Liquidação de Multa de Trânsito</p>
    </div>

    <!-- DADOS DO UTENTE -->
    <div class="section-box">
        <div class="section-title">Dados do Condutor / Utente</div>
        <table class="info-table">
            <tr>
                <td style="width: 50%;">
                    <span class="label">Nome Completo do Condutor</span>
                    <span class="value"><?= esc($comp['utente_nome'] ?? 'N/A') ?></span>
                </td>
                <td style="width: 50%;">
                    <span class="label">N.º da Carta de Condução</span>
                    <span class="value-code"><?= esc($comp['numero_carta'] ?? 'N/A') ?></span>
                </td>
            </tr>
            <tr>
                <td style="padding-top: 4px;">
                    <span class="label">N.º de BI / Identificação</span>
                    <span class="value"><?= esc($comp['bi_numero'] ?? 'Não registado') ?></span>
                </td>
                <td style="padding-top: 4px;">
                    <span class="label">Data de Emissão do Comprovativo</span>
                    <span class="value"><?= date('d/m/Y H:i:s') ?></span>
                </td>
            </tr>
        </table>
    </div>

    <!-- DADOS DA MULTA E INFRAÇÃO -->
    <div class="section-box">
        <div class="section-title">Dados do Auto de Multa</div>
        <table class="info-table">
            <tr>
                <td style="width: 50%;">
                    <span class="label">ID / Código da Multa</span>
                    <span class="value-code"><?= esc($comp['codigo_multa'] ?? 'N/A') ?></span>
                </td>
                <td style="width: 50%;">
                    <span class="label">Data e Hora da Infração</span>
                    <span class="value"><?= !empty($comp['data_infracao']) ? date('d/m/Y H:i', strtotime($comp['data_infracao'])) : 'N/A' ?></span>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding-top: 4px;">
                    <span class="label">Tipo de Infração</span>
                    <span class="value"><?= esc($comp['tipo_infracao'] ?? 'N/A') ?></span>
                    <?php if (!empty($comp['local_infracao'])): ?>
                        <span style="font-size: 8pt; color: #555555;"> (Local: <?= esc($comp['local_infracao']) ?>)</span>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>

    <!-- DETALHES DO PAGAMENTO E TRANSAÇÃO -->
    <div class="section-box">
        <div class="section-title">Dados Financeiros e Transacção</div>
        <table class="info-table">
            <tr>
                <td style="width: 50%;">
                    <span class="label">Referência da Transacção</span>
                    <span class="value-code"><?= esc($comp['referencia_transacao'] ?? 'N/A') ?></span>
                </td>
                <td style="width: 50%;">
                    <span class="label">N.º / ID Interno da Transacção</span>
                    <span class="value">#<?= esc($comp['id'] ?? 'N/A') ?></span>
                </td>
            </tr>
            <tr>
                <td style="padding-top: 4px;">
                    <span class="label">Data e Hora do Pagamento</span>
                    <span class="value"><?= !empty($comp['data_pagamento']) ? date('d/m/Y H:i:s', strtotime($comp['data_pagamento'])) : 'N/A' ?></span>
                </td>
                <td style="padding-top: 4px;">
                    <span class="label">Método de Pagamento</span>
                    <span class="value"><?= esc($comp['metodo_pagamento'] ?? 'N/A') ?></span>
                </td>
            </tr>
            <tr>
                <td style="padding-top: 4px;">
                    <span class="label">Estado do Pagamento</span>
                    <span class="badge-pago">PAGO / CONCLUÍDO</span>
                </td>
                <td style="padding-top: 4px;">
                    <span class="label">Valor Pago</span>
                    <span class="value" style="color: #198754; font-size: 10.5pt;"><?= number_format($comp['valor_pago'] ?? 0, 2, ',', '.') ?> MT</span>
                </td>
            </tr>
        </table>
    </div>

    <!-- CARTÃO DESTACADO DE VALOR TOTAL -->
    <div class="amount-card">
        <div class="lbl">VALOR TOTAL LIQUIDADO</div>
        <div class="val"><?= number_format($comp['valor_pago'] ?? 0, 2, ',', '.') ?> MT</div>
        <div class="sub">Moeda Nacional (Meticais Moçambicanos)</div>
    </div>

    <div class="footer">
        <p style="margin-bottom: 2px;">Este comprovativo foi gerado automaticamente pelo Sistema de Pagamento Electrónico do INATRO, IP.</p>
        <p style="margin-bottom: 2px;">Código de Autenticidade: <code><?= md5(($comp['referencia_transacao'] ?? '') . ($comp['codigo_multa'] ?? '')) ?></code></p>
        <p style="margin: 0; font-weight: bold;">Documento Oficial com Validade Administrativa.</p>
    </div>

</body>
</html>
