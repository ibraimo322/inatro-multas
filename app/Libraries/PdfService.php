<?php

namespace App\Libraries;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfService
{
    /**
     * Gera e envia o ficheiro PDF para o navegador
     *
     * @param string $html Conteúdo HTML do relatório
     * @param string $filename Nome do ficheiro a ser descarregado
     * @param bool $stream Se true, envia o download directamente ao utilizador
     * @return string|null Conteúdo binário se $stream for false
     */
    public static function gerarPdf(string $html, string $filename = 'relatorio_inatro.pdf', bool $stream = true)
    {
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('defaultFont', 'Helvetica');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        if ($stream) {
            $dompdf->stream($filename, ['Attachment' => true]);
            exit;
        }

        return $dompdf->output();
    }
}
