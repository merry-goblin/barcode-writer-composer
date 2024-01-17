<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Image;

use MerryGoblin\BarcodeWriter\Services\Barcode\BarcodeConfig;
use MerryGoblin\BarcodeWriter\Services\Barcode\Shape\BarcodeDimensions;

use MerryGoblin\BarcodeWriter\Services\Barcode\Format\StringRenderingNotAllowedException;

class LinearImageRenderer extends AbstractBarcodeImageRenderer implements BarcodeImageRendererInterface
{
	/**
	 * @param array $encodedData
	 * @param BarcodeDimensions $dimensions
	 * @param BarcodeConfig $barcodeConfig
	 * @return resource
	 */
	public function renderResource($encodedData, BarcodeDimensions $dimensions, BarcodeConfig $barcodeConfig)
	{
		list($image, $colors, $textColor) = $this->initImage($dimensions, $barcodeConfig);

		$w = $dimensions->barcodeWidth;
		$h = $dimensions->barcodeHeight;
		$x = $dimensions->barcodeLeftPosition;
		$y = $dimensions->barcodeTopPosition;

		$width = 0;
		foreach ($encodedData['b'] as $block) {
			foreach ($block['m'] as $module) {
				$width += $module[1] * $dimensions->widths[$module[2]];
			}
		}
		if ($width) {
			$scale = $w / $width;
			$scale = (($scale > 1) ? floor($scale) : 1);
			$x = floor($x + ($w - $width * $scale) / 2);
		} else {
			$scale = 1;
			$x = floor($x + $w / 2);
		}
		foreach ($encodedData['b'] as $block) {
			if (isset($block['l'])) {
				$label = $block['l'][0];
				$ly = (isset($block['l'][1]) ? (float)$block['l'][1] : 1);
				$lx = (isset($block['l'][2]) ? (float)$block['l'][2] : 0.5);
				$my = round($y + min($h, $h + ($ly - 1) * $barcodeConfig->th));
				$ly = ($y + $h + $ly * $barcodeConfig->th);
				$ly = round($ly - imagefontheight($barcodeConfig->ts));
			} else {
				$label = null;
				$my = $y + $h;
			}
			$mx = $x;
			foreach ($block['m'] as $module) {
				$mc = $colors[$module[0]];
				$mw = $mx + $module[1] * $dimensions->widths[$module[2]] * $scale;
				imagefilledrectangle($image, $mx, $y, $mw - 1, $my - 1, $mc);
				$mx = $mw;
			}
			if (!is_null($label) && $barcodeConfig->displayLabel) {
				$lx = ($x + ($mx - $x) * $lx);
				$lw = imagefontwidth($barcodeConfig->ts) * strlen($label);
				$lx = round($lx - $lw / 2);
				imagestring($image, $barcodeConfig->ts, $lx, $ly, $label, $textColor);
			}
			$x = $mx;
		}
		return $image;
	}

	/**
	 * @param array $encodedData
	 * @param BarcodeDimensions $dimensions
	 * @param BarcodeConfig $barcodeConfig
	 * @return string
	 * @throws StringRenderingNotAllowedException
	 */
	function renderString($encodedData, BarcodeDimensions $dimensions, BarcodeConfig $barcodeConfig)
	{
		$image = $this->renderResource($encodedData, $dimensions, $barcodeConfig);

	}
}

