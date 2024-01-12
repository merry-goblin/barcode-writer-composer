<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Image;

use MerryGoblin\BarcodeWriter\Services\Barcode\Format\BarcodeFormatNotHandledException;
use MerryGoblin\BarcodeWriter\Services\Barcode\Shape\BarcodeShapeNotHandledException;

class BarcodeImageRendererHelper
{
	/**
	 * @param string $shape
	 * @param string $format
	 * @return BarcodeImageRendererInterface
	 * @throws BarcodeFormatNotHandledException
	 * @throws BarcodeShapeNotHandledException
	 */
	public static function getBarcodeImageRenderer($shape, $format)
	{
		$barcodeImageRenderer = null;
		$format = strtolower($format);
		$shape = strtolower($shape);
		if ($shape === 'linear') {
			switch ($format) {
				case 'png':
				case 'jpeg':
				case 'jpg':
				case 'gif':
					$barcodeImageRenderer = new LinearImageRenderer();
					break;
				case 'svg':
					$barcodeImageRenderer = new LinearSVGRenderer();
					break;
			}
		} elseif ($shape === 'matrix') {
			switch ($format) {
				case 'png':
				case 'jpeg':
				case 'jpg':
				case 'gif':
					$barcodeImageRenderer = new MatrixImageRenderer();
					break;
				case 'svg':
					$barcodeImageRenderer = new MatrixSVGRenderer();
					break;
			}
		} else {
			throw new BarcodeShapeNotHandledException();
		}

		if (is_null($barcodeImageRenderer)) {
			throw new BarcodeFormatNotHandledException();
		}

		return $barcodeImageRenderer;
	}
}