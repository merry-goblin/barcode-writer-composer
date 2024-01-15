<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Type;

class EAN128BType extends Code128Type implements BarcodeTypeInterface
{
	public $dstate = 2;
	public $fnc1 = true;
}
