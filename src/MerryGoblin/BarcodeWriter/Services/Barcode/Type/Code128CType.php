<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Type;

class Code128CType extends AbstractBarcodeType implements BarcodeTypeInterface
{
	public $dstate = 3;
	public $fnc1 = false;
	protected $encoderName = 'code128';
}
