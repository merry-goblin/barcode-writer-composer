<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Shape;

class BarcodeShapeHelper
{
	const SHAPE_LINEAR = 'linear';
	const SHAPE_MATRIX = 'matrix';

	/**
	 * @param string $shape
	 * @return BarcodeShapeInterface
	 * @throws BarcodeShapeNotHandledException
	 */
	public static function getBarcodeShape($shape)
	{
		$barcodeShape = null;
		$shape = strtolower($shape);
		switch ($shape) {
			case 'linear':
				$barcodeShape = new BarcodeLinearShape();
				break;
			case 'matrix':
				$barcodeShape = new BarcodeMatrixShape();
				break;
		}

		if (is_null($barcodeShape)) {
			throw new BarcodeShapeNotHandledException();
		}

		return $barcodeShape;
	}
}