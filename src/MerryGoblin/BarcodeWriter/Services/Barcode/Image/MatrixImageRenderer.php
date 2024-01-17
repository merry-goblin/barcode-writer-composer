<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Image;

use MerryGoblin\BarcodeWriter\Services\Barcode\BarcodeConfig;
use MerryGoblin\BarcodeWriter\Services\Barcode\Format\StringRenderingNotAllowedException;
use MerryGoblin\BarcodeWriter\Services\Barcode\Shape\BarcodeDimensions;

class MatrixImageRenderer extends AbstractBarcodeImageRenderer implements BarcodeImageRendererInterface
{
	public function renderResource($encodedData, BarcodeDimensions $dimensions, BarcodeConfig $barcodeConfig)
	{
		return null;
	}

	/**
	 * @param array $encodedData
	 * @param BarcodeDimensions $dimensions
	 * @param BarcodeConfig $barcodeConfig
	 * @return string
	 * @throws StringRenderingNotAllowedException
	 */
	function renderString($encodedData, BarcodeDimensions $dimensions, BarcodeConfig $barcodeConfig)
	{
		throw new StringRenderingNotAllowedException();
	}
}

