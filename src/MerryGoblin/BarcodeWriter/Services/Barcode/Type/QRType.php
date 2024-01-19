<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Type;

class QRType extends AbstractBarcodeType implements BarcodeTypeInterface
{
	public $ecl = 0;
	protected $encoderName = 'qr';

	/**
	 * @return array
	 */
	function getParameters()
	{
		return [
			'ecl' => $this->ecl,
		];
	}
}
