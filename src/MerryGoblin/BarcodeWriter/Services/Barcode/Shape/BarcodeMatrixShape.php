<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Shape;

class BarcodeMatrixShape extends AbstractBarcodeShape implements BarcodeShapeInterface
{
	/**
	 * @param array $encodedData
	 * @param int[] $widths
	 * @return int[]
	 */
	protected function calculateSize($encodedData, $widths) {
		$width = (
			$encodedData['q'][3] * $widths[0] +
			$encodedData['s'][0] * $widths[1] +
			$encodedData['q'][1] * $widths[0]
		);
		$height = (
			$encodedData['q'][0] * $widths[0] +
			$encodedData['s'][1] * $widths[1] +
			$encodedData['q'][2] * $widths[0]
		);
		return [$width, $height];
	}

}