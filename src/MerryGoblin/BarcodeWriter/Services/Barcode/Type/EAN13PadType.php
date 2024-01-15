<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Type;

class EAN13PadType extends AbstractBarcodeType implements BarcodeTypeInterface
{
	public $pad = '>';
	protected $encoderName = 'ean13';

	/**
	 * @return array
	 */
	function getParameters()
	{
		return [
			'pad' => $this->pad,
		];
	}
}
