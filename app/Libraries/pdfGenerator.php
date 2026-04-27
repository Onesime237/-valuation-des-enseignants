<?php

namespace App\Libraries;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfGenerator
{
    public function generate(string $html, string $filename): string
    {
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Save to writable/pdfs/
        $outputPath = WRITEPATH . 'pdfs/' . $filename;
        
        // Ensure directory exists
        if (!is_dir(WRITEPATH . 'pdfs/')) {
            mkdir(WRITEPATH . 'pdfs/', 0755, true);
        }

        file_put_contents($outputPath, $dompdf->output());

        return $outputPath;
    }
}
