<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title ?? 'Histórico Geral de Pagamentos — INATRO') ?></title>
    <style>
        @page {
            size: A4 portrait;
            margin: 10mm 12mm 15mm 12mm;
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
            margin-bottom: 10px;
            padding-bottom: 6px;
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
            margin: 8px 0 12px 0;
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
        
        /* METADADOS DO UTENTE E EMISSÃO */
        .meta-box {
            background-color: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 4px;
            margin-bottom: 14px;
            padding: 8px 12px;
            page-break-inside: avoid;
        }
        .meta-table {
            width: 100%;
            border-collapse: collapse;
        }
        .meta-table td {
            padding: 3px 0;
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

        /* REGISTOS EM FORMATO VERTICAL (BLOCO POR MULTA) */
        .multa-card {
            background-color: #ffffff;
            border: 1px solid #cccccc;
            border-radius: 5px;
            margin-bottom: 12px;
            page-break-inside: avoid;
            overflow: hidden;
        }
        .multa-card-header {
            background-color: #f1f3f5;
            padding: 6px 12px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 9pt;
            font-weight: bold;
            color: #333333;
            display: table;
            width: 100%;
            box-sizing: border-box;
        }
        .multa-card-body {
            padding: 10px 12px;
        }
        .multa-info-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        .multa-info-grid td {
            padding: 3px 0;
            vertical-align: top;
            font-size: 8.5pt;
        }
        
        /* SUB-BLOCO DE PAGAMENTO */
        .pagamento-subblock {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-left: 3px solid #198754;
            border-radius: 4px;
            padding: 8px 10px;
            margin-top: 6px;
        }
        .pagamento-subblock-title {
            font-size: 8pt;
            font-weight: bold;
            color: #198754;
            text-transform: uppercase;
            margin-bottom: 4px;
            border-bottom: 1px solid #eeeeee;
            padding-bottom: 2px;
        }
        
        /* BADGES DE ESTADO */
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
        .badge-nao-pago { background-color: #e2e3e5; color: #41464b; border: 1px solid #d3d6d8; }

        .footer {
            margin-top: 20px;
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

    <!-- CABEÇALHO DO DOCUMENTO -->
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
        <h3>Histórico Geral de Pagamentos</h3>
    </div>

    <!-- METADADOS DO UTENTE E EMISSÃO TEMPO REAL -->
    <div class="meta-box">
        <table class="meta-table">
            <tr>
                <td style="width: 50%;">
                    <span class="label">Nome do Utente</span>
                    <span class="value"><?= esc($utente['nome']) ?></span>
                </td>
                <td style="width: 50%;">
                    <span class="label">Número da Carta de Condução</span>
                    <span class="value-code"><?= esc($utente['numero_carta']) ?></span>
                </td>
            </tr>
            <tr>
                <td style="padding-top: 6px;">
                    <span class="label">Data de Emissão</span>
                    <span class="value"><?= date('d/m/Y') ?></span>
                </td>
                <td style="padding-top: 6px;">
                    <span class="label">Hora de Emissão</span>
                    <span class="value"><?= date('H:i:s') ?></span>
                </td>
            </tr>
        </table>
    </div>

    <!-- REGISTOS EM FORMATO VERTICAL (DE CIMA PARA BAIXO) -->
    <?php if (empty($multas)): ?>
        <div style="text-align: center; padding: 25px; background-color: #f8f9fa; border: 1px solid #eeeeee; color: #666666; border-radius: 4px;">
            Nenhum registo de multa ou pagamento no seu histórico.
        </div>
    <?php else: ?>
        <?php foreach ($multas as $m): ?>
            <?php $p = $pagamentosPorMulta[$m['id']] ?? null; ?>
            <div class="multa-card">
                <!-- CABEÇALHO DO CARD DA MULTA -->
                <table style="width: 100%; border-collapse: collapse; background-color: #f1f3f5; padding: 6px 12px; border-bottom: 1px solid #e0e0e0;">
                    <tr>
                        <td style="font-weight: bold; font-size: 9.5pt; color: #0f5132;">
                            MULTA N.º <span style="font-family: monospace; color: #0d6efd;"><?= esc($m['codigo_multa']) ?></span>
                        </td>
                        <td style="text-align: right;">
                            <?php if ($m['estado'] === 'paga' || ($p && $p['estado'] === 'pago')): ?>
                                <span class="badge badge-paga">Paga</span>
                            <?php elseif ($m['estado'] === 'vencida'): ?>
                                <span class="badge badge-vencida">Vencida</span>
                            <?php else: ?>
                                <span class="badge badge-pendente">Pendente</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>

                <div class="multa-card-body">
                    <!-- DADOS DA MULTA -->
                    <table class="multa-info-grid">
                        <tr>
                            <td style="width: 50%;">
                                <span class="label">Tipo de Infração</span>
                                <span class="value" style="font-size: 8.5pt;"><?= esc($m['tipo_infracao']) ?></span>
                            </td>
                            <td style="width: 50%;">
                                <span class="label">Data e Hora da Infração</span>
                                <span class="value"><?= date('d/m/Y H:i', strtotime($m['data_infracao'])) ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 4px;">
                                <span class="label">Local da Infração</span>
                                <span class="value"><?= esc($m['local_infracao'] ?? 'Não especificado') ?></span>
                            </td>
                            <td style="padding-top: 4px;">
                                <span class="label">Valor da Multa</span>
                                <span class="value" style="color: #198754; font-size: 9.5pt;"><?= number_format($m['valor'] ?? $m['valor_multa'] ?? 0, 2, ',', '.') ?> MT</span>
                            </td>
                        </tr>
                    </table>

                    <!-- SUB-BLOCO DE PAGAMENTO -->
                    <div class="pagamento-subblock" style="<?= ($p && $p['estado'] === 'pago') ? 'border-left-color: #198754;' : 'border-left-color: #6c757d;' ?>">
                        <div class="pagamento-subblock-title" style="<?= ($p && $p['estado'] === 'pago') ? 'color: #198754;' : 'color: #495057;' ?>">PAGAMENTO</div>
                        
                        <?php if ($p && $p['estado'] === 'pago'): ?>
                            <table class="multa-info-grid" style="margin-bottom: 0;">
                                <tr>
                                    <td style="width: 33%;">
                                        <span class="label">Valor Pago</span>
                                        <span class="value" style="color: #198754;"><?= number_format($p['valor_pago'], 2, ',', '.') ?> MT</span>
                                    </td>
                                    <td style="width: 33%;">
                                        <span class="label">Data do Pagamento</span>
                                        <span class="value"><?= date('d/m/Y H:i', strtotime($p['data_pagamento'])) ?></span>
                                    </td>
                                    <td style="width: 34%;">
                                        <span class="label">Método</span>
                                        <span class="value"><?= esc($p['metodo_pagamento']) ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 4px;">
                                        <span class="label">Referência da Transação</span>
                                        <span class="value-code"><?= esc($p['referencia_transacao']) ?></span>
                                    </td>
                                    <td colspan="2" style="padding-top: 4px;">
                                        <span class="label">Estado do Pagamento</span>
                                        <span class="badge badge-paga">Concluído</span>
                                    </td>
                                </tr>
                            </table>
                        <?php elseif ($p): ?>
                            <table class="multa-info-grid" style="margin-bottom: 0;">
                                <tr>
                                    <td style="width: 50%;">
                                        <span class="label">Referência</span>
                                        <span class="value-code"><?= esc($p['referencia_transacao']) ?></span>
                                    </td>
                                    <td style="width: 50%;">
                                        <span class="label">Estado</span>
                                        <span class="badge badge-pendente"><?= strtoupper(esc($p['estado'])) ?></span>
                                    </td>
                                </tr>
                            </table>
                        <?php else: ?>
                            <table class="multa-info-grid" style="margin-bottom: 0;">
                                <tr>
                                    <td>
                                        <span class="label">Estado do Pagamento</span>
                                        <span class="badge badge-nao-pago">Não pago</span>
                                    </td>
                                </tr>
                            </table>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <div class="footer">
        <p style="margin-bottom: 2px;">Este Histórico Geral de Pagamentos foi emitido através do Portal do Condutor do INATRO, IP.</p>
        <p style="margin: 0; font-weight: bold;">Documento Pessoal de Consulta do Utente.</p>
    </div>

</body>
</html>
