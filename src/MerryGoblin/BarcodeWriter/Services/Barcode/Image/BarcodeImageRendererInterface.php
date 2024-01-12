<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Image;

use MerryGoblin\BarcodeWriter\Services\Barcode\BarcodeConfig;
use MerryGoblin\BarcodeWriter\Services\Barcode\Shape\BarcodeDimensions;

interface BarcodeImageRendererInterface
{
	function renderResource($encodedData, BarcodeDimensions $dimensions, BarcodeConfig $barcodeConfig);
}
