<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Type;

class EAN128CType extends Code128Type implements BarcodeTypeInterface
{
	public $dstate = 3;
	public $fnc1 = true;
}
