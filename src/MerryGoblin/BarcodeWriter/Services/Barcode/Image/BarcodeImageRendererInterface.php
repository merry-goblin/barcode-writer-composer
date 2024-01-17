<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Image;

use MerryGoblin\BarcodeWriter\Services\Barcode\BarcodeConfig;
use MerryGoblin\BarcodeWriter\Services\Barcode\Shape\BarcodeDimensions;

use MerryGoblin\BarcodeWriter\Services\Barcode\Format\ResourceRenderingNotAllowedException;

interface BarcodeImageRendererInterface
{
	/**
	 * @param array $encodedData
	 * @param BarcodeDimensions $dimensions
	 * @param BarcodeConfig $barcodeConfig
	 * @return resource
	 * @throws ResourceRenderingNotAllowedException
	 */
	function renderResource($encodedData, BarcodeDimensions $dimensions, BarcodeConfig $barcodeConfig);

	/**
	 * @param array $encodedData
	 * @param BarcodeDimensions $dimensions
	 * @param BarcodeConfig $barcodeConfig
	 * @return string
	 */
	function renderString($encodedData, BarcodeDimensions $dimensions, BarcodeConfig $barcodeConfig);
}
