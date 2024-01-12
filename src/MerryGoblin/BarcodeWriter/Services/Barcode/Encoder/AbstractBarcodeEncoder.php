<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Encoder;

abstract class AbstractBarcodeEncoder
{
	protected $shapeName = null;

	/**
	 * @return string
	 * @throws BarcodeEncoderWithoutShapeException
	 */
	public function getShapeName()
	{
		if (is_null($this->shapeName)) {
			throw new BarcodeEncoderWithoutShapeException();
		}
		return $this->shapeName;
	}
}
