<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Type;

class EAN128AType extends Code128Type implements BarcodeTypeInterface
{
	public $dstate = 1;
	public $fnc1 = true;
}
