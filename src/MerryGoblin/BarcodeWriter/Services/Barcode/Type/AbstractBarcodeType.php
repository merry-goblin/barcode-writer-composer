<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Type;

abstract class AbstractBarcodeType
{
	protected $encoderName = null;

	/**
	 * @return string|null
	 */
	public function getEncoderName()
	{
		return $this->encoderName;
	}

	/**
	 * @return array
	 */
	public function getParameters()
	{
		return [];
	}
}
