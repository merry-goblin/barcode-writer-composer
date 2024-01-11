<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Type;

class BarcodeTypeHelper
{
	/**
	 * @param string $format
	 * @return BarcodeFormatInterface
	 * @throws BarcodeFormatNotHandledException
	 */
	public static function getBarcodeType($type)
	{
		$barcodeType = null;
		$type = strtolower(preg_replace('/[^A-Za-z0-9]/', '', $type));
		switch ($type) {
			case 'code128':
				$barcodeType = new Code128Type();
				break;
		}

		if (is_null($barcodeType)) {
			throw new BarcodeTypeNotHandledException();
		}

		return $barcodeType;
	}
}