<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf {

    public function createPDF($html, $filename = 'document', $stream = true)
    {
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // PENTING: bersihkan buffer
        if (ob_get_length()) {
            ob_end_clean();
        }

        $dompdf->stream($filename . '.pdf', [
            "Attachment" => 1 // ⬅️ DOWNLOAD, BUKAN OPEN
        ]);
        exit;
    }
}
