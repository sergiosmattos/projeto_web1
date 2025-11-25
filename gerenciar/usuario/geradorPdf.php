<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
require_once DIR_PROJETOWEB . 'vendor/autoload.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();

ob_start();
require "pdf.php";
$html = ob_get_clean();

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

$filename = 'Relatorio-produtos-' . date('d-m-Y') . '.pdf';
$dompdf->stream($filename, ['Attachment' => 2]);