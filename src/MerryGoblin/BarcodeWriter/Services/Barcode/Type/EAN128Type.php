<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Type;

class EAN128Type extends Code128Type implements BarcodeTypeInterface
{
	public $dstate = 0;
	public $fnc1 = true;
}
