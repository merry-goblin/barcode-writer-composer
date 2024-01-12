<?php

use MerryGoblin\BarcodeWriter\Services\Barcode\BarcodeWriter;

require_once(__DIR__.'/vendor/autoload.php');

$format = 'png';
$type = 'code128';
$data = '1235467890123456';

$barcodeWriter = new BarcodeWriter();
$image = $barcodeWriter->renderResource($format, $type, $data);

header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);
