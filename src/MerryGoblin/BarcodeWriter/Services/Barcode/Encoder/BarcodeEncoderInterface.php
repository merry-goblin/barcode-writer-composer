<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Encoder;

use MerryGoblin\BarcodeWriter\Services\Barcode\Type\BarcodeTypeInterface;

interface BarcodeEncoderInterface
{
	/**
	 * @param string $data
	 * @param BarcodeTypeInterface $barcodeType
	 * @return array
	 */
	function encode($data, BarcodeTypeInterface $barcodeType);

	/**
	 * @return string
	 */
	function getShapeName();
}
