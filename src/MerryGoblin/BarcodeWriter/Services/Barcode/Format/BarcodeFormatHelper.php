<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Format;

class BarcodeFormatHelper
{
	/**
	 * @param string $format
	 * @return BarcodeFormatInterface
	 * @throws BarcodeFormatNotHandledException
	 */
	public static function getBarcodeFormat($format)
	{
		$barcodeFormat = null;
		$format = strtolower($format);
		switch ($format) {
			case 'png':
				$barcodeFormat = new BarcodePNGFormat();
				break;
			case 'jpeg':
			case 'jpg':
				$barcodeFormat = new BarcodeJPEGFormat();
				break;
			case 'gif':
				$barcodeFormat = new BarcodeGIFFormat();
				break;
			case 'svg':
				$barcodeFormat = new BarcodeSVGFormat();
				break;
		}

		if (is_null($barcodeFormat)) {
			throw new BarcodeFormatNotHandledException();
		}

		return $barcodeFormat;
	}
}