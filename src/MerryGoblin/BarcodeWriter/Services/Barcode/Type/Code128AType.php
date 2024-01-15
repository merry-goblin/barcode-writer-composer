<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Type;

class Code128AType extends Code128Type implements BarcodeTypeInterface
{
	public $dstate = 1;
	public $fnc1 = false;
}
