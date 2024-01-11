<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Shape;

class LinearShapeBuilder extends AbstractShapeBuilder
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