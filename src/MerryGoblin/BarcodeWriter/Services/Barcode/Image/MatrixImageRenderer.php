<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Image;

use MerryGoblin\BarcodeWriter\Services\Barcode\BarcodeConfig;
use MerryGoblin\BarcodeWriter\Services\Barcode\Format\StringRenderingNotAllowedException;
use MerryGoblin\BarcodeWriter\Services\Barcode\Shape\BarcodeDimensions;

class MatrixImageRenderer extends AbstractBarcodeImageRenderer implements BarcodeImageRendererInterface
{
	public function renderResource($encodedData, BarcodeDimensions $dimensions, BarcodeConfig $barcodeConfig)
	{
		list($image, $colors, $textColor) = $this->initImage($dimensions, $barcodeConfig);

		$shape = $barcodeConfig->ms;
		$density = $barcodeConfig->md;

		$w = $dimensions->barcodeUnscaledWidth;
		$h = $dimensions->barcodeUnscaledHeight;
		$x = $dimensions->barcodeLeftPosition;
		$y = $dimensions->barcodeTopPosition;

		if ($w && $h) {
			$scale = min($dimensions->imageWidth / $w, $dimensions->imageHeight, $h);
			$scale = (($scale > 1) ? floor($scale) : 1);
			$x = floor($x + ($dimensions->imageWidth - $w * $scale) / 2);
			$y = floor($y + ($dimensions->imageHeight - $h * $scale) / 2);
		} else {
			$scale = 1;
			$x = floor($x + $w / 2);
			$y = floor($y + $h / 2);
		}
		$x += $encodedData['q'][3] * $dimensions->widths[0] * $scale;
		$y += $encodedData['q'][0] * $dimensions->widths[0] * $scale;
		$wh = $dimensions->widths[1] * $scale;
		foreach ($encodedData['b'] as $by => $row) {
			$y1 = $y + $by * $wh;
			foreach ($row as $bx => $color) {
				$x1 = $x + $bx * $wh;
				$mc = $colors[$color];
				$this->matrix_dot_image(
					$image, $x1, $y1, $wh, $wh, $mc, $shape, $density
				);
			}
		}
		return $image;
	}

	function matrix_dot_image($image, $x, $y, $w, $h, $mc, $ms, $md) {
		switch ($ms) {
			default:
				$x = floor($x + (1 - $md) * $w / 2);
				$y = floor($y + (1 - $md) * $h / 2);
				$w = ceil($w * $md);
				$h = ceil($h * $md);
				imagefilledrectangle($image, $x, $y, $x+$w-1, $y+$h-1, $mc);
				break;
			case 'r':
				$cx = floor($x + $w / 2);
				$cy = floor($y + $h / 2);
				$dx = ceil($w * $md);
				$dy = ceil($h * $md);
				imagefilledellipse($image, $cx, $cy, $dx, $dy, $mc);
				break;
			case 'x':
				$x = floor($x + (1 - $md) * $w / 2);
				$y = floor($y + (1 - $md) * $h / 2);
				$w = ceil($w * $md);
				$h = ceil($h * $md);
				imageline($image, $x, $y, $x+$w-1, $y+$h-1, $mc);
				imageline($image, $x, $y+$h-1, $x+$w-1, $y, $mc);
				break;
		}
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
		throw new StringRenderingNotAllowedException();
	}
}

