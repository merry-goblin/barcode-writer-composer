<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Image;

use MerryGoblin\BarcodeWriter\Services\Barcode\BarcodeConfig;
use MerryGoblin\BarcodeWriter\Services\Barcode\Shape\BarcodeDimensions;

abstract class AbstractBarcodeImageRenderer
{
	/**
	 * @param BarcodeConfig $barcodeConfig
	 * @param BarcodeDimensions $dimensions
	 * @return array
	 */
	protected function initImage(BarcodeDimensions $dimensions, BarcodeConfig $barcodeConfig)
	{
		$image = imagecreatetruecolor($dimensions->imageWidth, $dimensions->imageHeight);
		imagesavealpha($image, true);

		$bgColor = $this->allocateColor($image, $barcodeConfig->bc);
		imagefill($image, 0, 0, $bgColor);
		$colors = $this->initColors($barcodeConfig);
		foreach ($colors as $i => $color) {
			$colors[$i] = $this->allocateColor($image, $color);
		}
		$textColor = $this->allocateColor($image, $barcodeConfig->tc);

		return [$image, $colors, $textColor];
	}

	/**
	 * @param BarcodeConfig $barcodeConfig
	 * @param BarcodeDimensions $dimensions
	 * @return array
	 */
	protected function initColors(BarcodeConfig $barcodeConfig)
	{
		$colors = [
			$barcodeConfig->cs,
			$barcodeConfig->cm,
			$barcodeConfig->c2,
			$barcodeConfig->c3,
			$barcodeConfig->c4,
			$barcodeConfig->c5,
			$barcodeConfig->c6,
			$barcodeConfig->c7,
			$barcodeConfig->c8,
			$barcodeConfig->c9,
		];
		return $colors;
	}

	/**
	 * @param resource $image
	 * @param string $color
	 * @return false|int
	 */
	protected function allocateColor($image, $color)
	{
		$color = preg_replace('/[^0-9A-Fa-f]/', '', $color);
		switch (strlen($color)) {
			case 1:
				$v = hexdec($color) * 17;
				return imagecolorallocate($image, $v, $v, $v);
			case 2:
				$v = hexdec($color);
				return imagecolorallocate($image, $v, $v, $v);
			case 3:
				$r = hexdec(substr($color, 0, 1)) * 17;
				$g = hexdec(substr($color, 1, 1)) * 17;
				$b = hexdec(substr($color, 2, 1)) * 17;
				return imagecolorallocate($image, $r, $g, $b);
			case 4:
				$a = hexdec(substr($color, 0, 1)) * 17;
				$r = hexdec(substr($color, 1, 1)) * 17;
				$g = hexdec(substr($color, 2, 1)) * 17;
				$b = hexdec(substr($color, 3, 1)) * 17;
				$a = round((255 - $a) * 127 / 255);
				return imagecolorallocatealpha($image, $r, $g, $b, $a);
			case 6:
				$r = hexdec(substr($color, 0, 2));
				$g = hexdec(substr($color, 2, 2));
				$b = hexdec(substr($color, 4, 2));
				return imagecolorallocate($image, $r, $g, $b);
			case 8:
				$a = hexdec(substr($color, 0, 2));
				$r = hexdec(substr($color, 2, 2));
				$g = hexdec(substr($color, 4, 2));
				$b = hexdec(substr($color, 6, 2));
				$a = round((255 - $a) * 127 / 255);
				return imagecolorallocatealpha($image, $r, $g, $b, $a);
			default:
				return imagecolorallocatealpha($image, 0, 0, 0, 127);
		}
	}


}