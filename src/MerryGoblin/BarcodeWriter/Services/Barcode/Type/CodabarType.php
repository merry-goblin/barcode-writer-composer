<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Type;

class CodabarType extends AbstractBarcodeType implements BarcodeTypeInterface
{
	protected $encoderName = 'codabar';
}
