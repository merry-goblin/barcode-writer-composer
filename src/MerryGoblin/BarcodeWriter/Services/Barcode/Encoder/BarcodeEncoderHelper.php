<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Encoder;

class BarcodeEncoderHelper
{
	const ENCODER_UPCA = 'UPCA';
	const ENCODER_UPCE = 'UPCE';
	const ENCODER_EAN8 = 'EAN8';
	const ENCODER_EAN13 = 'EAN13';
	const ENCODER_C39 = 'C39';
	const ENCODER_C39_ASCII = 'C39ASCII';
	const ENCODER_C93 = 'C93';
	const ENCODER_C93_ASCII = 'C93ASCII';
	const ENCODER_C128 = 'C128';

	/**
	 * @param string $encoder
	 * @return BarcodeEncoderInterface
	 * @throws BarcodeEncoderNotHandledException
	 */
	public static function getBarcodeEncoder($encoder)
	{
		$barcodeEncoder = null;
		switch ($encoder) {
			case 'upca':
				$barcodeEncoder = new UPCABarcodeEncoder();
				break;
			case 'upce':
				$barcodeEncoder = new UPCEBarcodeEncoder();
				break;
			case 'ean8':
				$barcodeEncoder = new EAN8BarcodeEncoder();
				break;
			case 'ean13':
				$barcodeEncoder = new EAN13BarcodeEncoder();
				break;
			case 'code39':
				$barcodeEncoder = new Code39BarcodeEncoder();
				break;
			case 'code39ascii':
				$barcodeEncoder = new Code39AsciiBarcodeEncoder();
				break;
			case 'code93':
				$barcodeEncoder = new Code93BarcodeEncoder();
				break;
			case 'code93ascii':
				$barcodeEncoder = new Code93AsciiBarcodeEncoder();
				break;
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