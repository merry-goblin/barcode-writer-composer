<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Shape;

use MerryGoblin\BarcodeWriter\Services\Barcode\BarcodeConfig;

interface BarcodeShapeInterface
{
	/**
	 * @param array $encodedData
	 * @param BarcodeConfig $config
	 * @return BarcodeDimensions
	 */
	function build($encodedData, BarcodeConfig $config);
}
