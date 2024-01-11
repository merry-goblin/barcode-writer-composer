<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Encoder;

interface BarcodeEncoderInterface
{
	function encode($data, $params = null);

	function getShapeName();
}
