<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Encoder;

class BarcodeEncoderHelper
{
	/**
	 * @param string $encoder
	 * @return BarcodeEncoderInterface
	 * @throws BarcodeEncoderNotHandledException
	 */
	public static function getBarcodeEncoder($encoder)
	{
		$barcodeEncoder = null;
		switch ($encoder) {
			case 'code128':
				$barcodeEncoder = new Code128BarcodeEncoder();
				break;
		}

		if (is_null($barcodeEncoder)) {
			throw new BarcodeEncoderNotHandledException();
		}

		return $barcodeEncoder;
	}
}