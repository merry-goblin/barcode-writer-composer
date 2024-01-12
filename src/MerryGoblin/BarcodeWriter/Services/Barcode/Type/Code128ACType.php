<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Type;

class Code128ACType extends AbstractBarcodeType implements BarcodeTypeInterface
{
	public $dstate = -1;
	public $fnc1 = false;
	protected $encoderName = 'code128';

	/**
	 * @return array
	 */
	function getParameters()
	{
		return [
			'dstate' => $this->dstate,
			'fnc1' => $this->fnc1
		];
	}
}
