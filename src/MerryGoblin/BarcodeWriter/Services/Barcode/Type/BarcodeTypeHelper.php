<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Type;

class BarcodeTypeHelper
{
	/**
	 * @param string $type
	 * @return BarcodeTypeInterface
	 * @throws BarcodeTypeNotHandledException
	 */
	public static function getBarcodeType($type)
	{
		$barcodeType = null;
		$type = strtolower(preg_replace('/[^A-Za-z0-9]/', '', $type));
		switch ($type) {
			case 'upca':
				$barcodeType = new UPCAType();
				break;
			case 'upce':
				$barcodeType = new UPCEType();
				break;
			case 'ean8':
				$barcodeType = new EAN8Type();
				break;
			case 'ean13':
				$barcodeType = new EAN13Type();
				break;
			case 'ean13nopad':
				$barcodeType = new EAN13NoPadType();
				break;
			case 'ean13pad':
				$barcodeType = new EAN13PadType();
				break;
			case 'code39':
				$barcodeType = new Code39Type();
				break;
			case 'code39ascii':
				$barcodeType = new Code39AsciiType();
				break;
			case 'code128':
				$barcodeType = new Code128Type();
				break;
			case 'code128a':
				$barcodeType = new Code128AType();
				break;
			case 'code128b':
				$barcodeType = new Code128BType();
				break;
			case 'code128c':
				$barcodeType = new Code128CType();
				break;
			case 'code128ac':
				$barcodeType = new Code128ACType();
				break;
			case 'code128bc':
				$barcodeType = new Code128BCType();
				break;
			case 'ean128':
				$barcodeType = new EAN128Type();
				break;
			case 'ean128a':
				$barcodeType = new EAN128AType();
				break;
			case 'ean128b':
				$barcodeType = new EAN128BType();
				break;
			case 'ean128c':
				$barcodeType = new EAN128CType();
				break;
			case 'ean128ac':
				$barcodeType = new EAN128ACType();
				break;
			case 'ean128bc':
				$barcodeType = new EAN128BCType();
				break;
		}

		if (is_null($barcodeType)) {
			throw new BarcodeTypeNotHandledException();
		}

		return $barcodeType;
	}
}