<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Shape;

use MerryGoblin\BarcodeWriter\Services\Barcode\BarcodeConfig;

abstract class AbstractBarcodeShape
{
	/**
	 * @param array $encodedData
	 * @param BarcodeConfig $config
	 * @return BarcodeDimensions
	 */
	public function build($encodedData, BarcodeConfig $config)
	{
		$barcodeDimensions = new BarcodeDimensions();

		$barcodeDimensions->widths = [
			$config->wq,
			$config->wm,
			$config->ww,
			$config->wn,
			$config->w4,
			$config->w5,
			$config->w6,
			$config->w7,
			$config->w8,
			$config->w9,
		];
		$size = $this->calculateSize($encodedData, $barcodeDimensions->widths);
		$dscale = ($encodedData && isset($encodedData['g']) && $encodedData['g'] == 'm') ? 4 : 1;
		$scale = (isset($config->sf) ? (float)$config->sf : $dscale);
		$scalex = (isset($config->sx) ? (float)$config->sx : $scale);
		$scaley = (isset($config->sy) ? (float)$config->sy : $scale);
		$dpadding = ($encodedData && isset($encodedData['g']) && $encodedData['g'] == 'm') ? 0 : 10;
		$padding = (isset($config->p) ? (int)$config->p : $dpadding);
		$vert = (isset($config->pv) ? (int)$config->pv : $padding);
		$horiz = (isset($config->ph) ? (int)$config->ph : $padding);
		$barcodeDimensions->barcodeTopPosition = (isset($config->pt) ? (int)$config->pt : $vert);
		$barcodeDimensions->barcodeLeftPosition = (isset($config->pl) ? (int)$config->pl : $horiz);
		$right = (isset($config->pr) ? (int)$config->pr : $horiz);
		$bottom = (isset($config->pb) ? (int)$config->pb : $vert);
		$dwidth = ceil($size[0] * $scalex) + $barcodeDimensions->barcodeLeftPosition + $right;
		$dheight = ceil($size[1] * $scaley) + $barcodeDimensions->barcodeTopPosition + $bottom;
		$barcodeDimensions->imageWidth = (isset($config->w) ? (int)$config->w : $dwidth);
		$barcodeDimensions->imageHeight = (isset($config->h) ? (int)$config->h : $dheight);
		$barcodeDimensions->barcodeWidth = $barcodeDimensions->imageWidth - $barcodeDimensions->barcodeLeftPosition - $right;
		$barcodeDimensions->barcodeHeight = $barcodeDimensions->imageHeight - $barcodeDimensions->barcodeTopPosition - $bottom;

		return $barcodeDimensions;
	}

	protected abstract function calculateSize($encodedData, $widths);
}