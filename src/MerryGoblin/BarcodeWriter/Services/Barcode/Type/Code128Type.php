<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Type;

class Code128Type extends AbstractBarcodeType implements BarcodeTypeInterface
{
	public $dstate = 0;
	public $fnc1 = false;
	protected $encoderName = 'code128';
}
