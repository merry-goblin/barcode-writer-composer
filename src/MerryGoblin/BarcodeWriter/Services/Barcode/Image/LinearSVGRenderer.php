<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Image;

use MerryGoblin\BarcodeWriter\Services\Barcode\BarcodeConfig;
use MerryGoblin\BarcodeWriter\Services\Barcode\Format\ResourceRenderingNotAllowedException;
use MerryGoblin\BarcodeWriter\Services\Barcode\Shape\BarcodeDimensions;

class LinearSVGRenderer extends AbstractBarcodeImageRenderer implements BarcodeImageRendererInterface
{
	/**
	 * @param array $encodedData
	 * @param BarcodeDimensions $dimensions
	 * @param BarcodeConfig $barcodeConfig
	 * @return resource
	 * @throws ResourceRenderingNotAllowedException
	 */
	public function renderResource($encodedData, BarcodeDimensions $dimensions, BarcodeConfig $barcodeConfig)
	{
		throw new ResourceRenderingNotAllowedException();
	}

	/**
	 * @param array $encodedData
	 * @param BarcodeDimensions $dimensions
	 * @param BarcodeConfig $barcodeConfig
	 * @return string
	 */
	public function renderString($encodedData, BarcodeDimensions $dimensions, BarcodeConfig $barcodeConfig)
	{
		$width = 0;
		$w = $dimensions->barcodeWidth;
		$h = $dimensions->barcodeHeight;
		$x = $dimensions->barcodeLeftPosition;
		$y = $dimensions->barcodeTopPosition;

		$colors = $this->initColors($barcodeConfig);
		$svg  = '<?xml version=\'1.0\'?>';
		$svg .= '<svg xmlns=\'http://www.w3.org/2000/svg\' version=\'1.1\'';
		$svg .= ' width=\''.$dimensions->imageWidth.'\' height=\''.$dimensions->imageHeight.'\'';
		$svg .= ' viewBox=\'0 0 '.$dimensions->imageWidth.' '.$dimensions->imageHeight.'\'><g>';
		if ($barcodeConfig->bc) {
			$svg .= '<rect x=\'0\' y=\'0\'';
			$svg .= ' width=\''.$dimensions->imageWidth.'\' height=\''.$dimensions->imageHeight.'\'';
			$svg .= ' fill=\''.htmlspecialchars($barcodeConfig->bc).'\'/>';
		}
		foreach ($encodedData['b'] as $block) {
			foreach ($block['m'] as $module) {
				$width += $module[1] * $dimensions->widths[$module[2]];
			}
		}
		if ($width) {
			$scale = $w / $width;
			if ($scale > 1) {
				$scale = floor($scale);
				$x = floor($x + ($w - $width * $scale) / 2);
			}
		} else {
			$scale = 1;
			$x = floor($x + $w / 2);
		}
		$tx = 'translate(' . $x . ' ' . $y . ')';
		if ($scale != 1) $tx .= ' scale(' . $scale . ' 1)';
		$svg .= '<g transform=\'' . htmlspecialchars($tx) . '\'>';
		$x = 0;
		foreach ($encodedData['b'] as $block) {
			if (isset($block['l'])) {
				$label = $block['l'][0];
				$ly = (isset($block['l'][1]) ? (float)$block['l'][1] : 1);
				$lx = (isset($block['l'][2]) ? (float)$block['l'][2] : 0.5);
				$mh = min($h, $h + ($ly - 1) * $barcodeConfig->th);
				$ly = $h + $ly * $barcodeConfig->th;
			} else {
				$label = null;
				$mh = $h;
			}
			$svg .= '<g>';
			$mx = $x;
			foreach ($block['m'] as $module) {
				$mc = htmlspecialchars($colors[$module[0]]);
				$mw = $module[1] * $dimensions->widths[$module[2]];
				if ($mc) {
					$svg .= '<rect';
					$svg .= ' x=\'' . $mx . '\' y=\'0\'';
					$svg .= ' width=\'' . $mw . '\'';
					$svg .= ' height=\'' . $mh . '\'';
					$svg .= ' fill=\'' . $mc . '\'/>';
				}
				$mx += $mw;
			}
			if (!is_null($label) && $barcodeConfig->displayLabel) {
				$lx = ($x + ($mx - $x) * $lx);
				$svg .= '<text';
				$svg .= ' x=\'' . $lx . '\' y=\'' . $ly . '\'';
				$svg .= ' text-anchor=\'middle\'';
				$svg .= ' font-family=\''.htmlspecialchars($barcodeConfig->tf).'\'';
				$svg .= ' font-size=\''.htmlspecialchars($barcodeConfig->ts).'\'';
				$svg .= ' fill=\''.htmlspecialchars($barcodeConfig->tc).'\'>';
				$svg .= htmlspecialchars($label);
				$svg .= '</text>';
			}
			$svg .= '</g>';
			$x = $mx;
		}
		$svg .= '</g>';
		$svg .= '</g></svg>';
		return $svg;
	}
}

