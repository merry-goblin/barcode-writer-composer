<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Image;

use MerryGoblin\BarcodeWriter\Services\Barcode\BarcodeConfig;
use MerryGoblin\BarcodeWriter\Services\Barcode\Format\ResourceRenderingNotAllowedException;
use MerryGoblin\BarcodeWriter\Services\Barcode\Shape\BarcodeDimensions;

class MatrixSVGRenderer extends AbstractBarcodeImageRenderer implements BarcodeImageRendererInterface
{
	public function renderResource($encodedData, BarcodeDimensions $dimensions, BarcodeConfig $barcodeConfig)
	{
		throw new ResourceRenderingNotAllowedException();
	}

	/**
	 * @param array $encodedData
	 * @param BarcodeDimensions $dimensions
	 * @param BarcodeConfig $barcodeConfig
	 * @return string
	 */
	public function renderString($encodedData, BarcodeDimensions $dimensions, BarcodeConfig $barcodeConfig)
	{
		return '';
	}
}

