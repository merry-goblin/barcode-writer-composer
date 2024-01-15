<?php

exit();

use MerryGoblin\BarcodeWriter\Services\Barcode\BarcodeWriter;
use MerryGoblin\BarcodeWriter\Services\Barcode\BarcodeConfig;

require_once(__DIR__.'/vendor/autoload.php');

$format = 'png';
$type = 'code128';
$data = '1235467890123456';

$barcodeWriter = new BarcodeWriter();
$barcodeConfig = new BarcodeConfig();
$barcodeConfig->w = 600;
$barcodeConfig->h = 80;
$barcodeConfig->ts = 10;
$barcodeConfig->th = 10;
$image = $barcodeWriter->renderResource($format, $type, $data, $barcodeConfig);

header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);
