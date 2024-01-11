<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Shape;

abstract class AbstractShapeBuilder
{
	/**
	 * @param array $encodedData
	 * @param ShapeConfig $config
	 * @return array
	 */
	public function build($encodedData, ShapeConfig $config)
	{
		$widths = [
			(isset($options['wq']) ? (int)$options['wq'] : 1),
			(isset($options['wm']) ? (int)$options['wm'] : 1),
			(isset($options['ww']) ? (int)$options['ww'] : 3),
			(isset($options['wn']) ? (int)$options['wn'] : 1),
			(isset($options['w4']) ? (int)$options['w4'] : 1),
			(isset($options['w5']) ? (int)$options['w5'] : 1),
			(isset($options['w6']) ? (int)$options['w6'] : 1),
			(isset($options['w7']) ? (int)$options['w7'] : 1),
			(isset($options['w8']) ? (int)$options['w8'] : 1),
			(isset($options['w9']) ? (int)$options['w9'] : 1),
		];
		$size = $this->calculateSize($encodedData, $widths);
		$dscale = ($encodedData && isset($encodedData['g']) && $encodedData['g'] == 'm') ? 4 : 1;
		$scale = (isset($options['sf']) ? (float)$options['sf'] : $dscale);
		$scalex = (isset($options['sx']) ? (float)$options['sx'] : $scale);
		$scaley = (isset($options['sy']) ? (float)$options['sy'] : $scale);
		$dpadding = ($encodedData && isset($encodedData['g']) && $encodedData['g'] == 'm') ? 0 : 10;
		$padding = (isset($options['p']) ? (int)$options['p'] : $dpadding);
		$vert = (isset($options['pv']) ? (int)$options['pv'] : $padding);
		$horiz = (isset($options['ph']) ? (int)$options['ph'] : $padding);
		$top = (isset($options['pt']) ? (int)$options['pt'] : $vert);
		$left = (isset($options['pl']) ? (int)$options['pl'] : $horiz);
		$right = (isset($options['pr']) ? (int)$options['pr'] : $horiz);
		$bottom = (isset($options['pb']) ? (int)$options['pb'] : $vert);
		$dwidth = ceil($size[0] * $scalex) + $left + $right;
		$dheight = ceil($size[1] * $scaley) + $top + $bottom;
		$iwidth = (isset($options['w']) ? (int)$options['w'] : $dwidth);
		$iheight = (isset($options['h']) ? (int)$options['h'] : $dheight);
		$swidth = $iwidth - $left - $right;
		$sheight = $iheight - $top - $bottom;
		return [
			$encodedData, $widths, $iwidth, $iheight,
			$left, $top, $swidth, $sheight
		];
	}

	protected abstract function calculateSize($encodedData, $widths);
}