<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Type;

class Code39Type extends AbstractBarcodeType implements BarcodeTypeInterface
{
	protected $encoderName = 'code39';
}
