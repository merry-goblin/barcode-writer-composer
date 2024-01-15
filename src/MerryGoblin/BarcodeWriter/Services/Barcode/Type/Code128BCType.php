<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Type;

class Code128BCType extends Code128Type implements BarcodeTypeInterface
{
	public $dstate = -2;
	public $fnc1 = false;
}
