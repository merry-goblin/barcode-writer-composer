<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Type;

interface BarcodeTypeInterface
{
	/**
	 * @return string
	 */
	function getEncoderName();

	/**
	 * @return array
	 */
	function getParameters();
}
