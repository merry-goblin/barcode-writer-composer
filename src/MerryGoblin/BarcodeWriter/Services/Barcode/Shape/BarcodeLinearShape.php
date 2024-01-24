<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Shape;

use MerryGoblin\BarcodeWriter\Services\Barcode\BarcodeConfig;

class BarcodeLinearShape extends AbstractBarcodeShape implements BarcodeShapeInterface
{
	/**
	 * @param array $encodedData
	 * @param int[] $widths
	 * @return int[]
	 */
	protected function calculateSize($encodedData, $widths) {
		$width = 0;
		foreach ($encodedData['b'] as $block) {
			foreach ($block['m'] as $module) {
				$width += $module[1] * $widths[$module[2]];
			}
		}
		return [$width, 80];
	}
}