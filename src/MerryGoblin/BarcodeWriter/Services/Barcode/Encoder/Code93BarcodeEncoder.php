<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Encoder;

use MerryGoblin\BarcodeWriter\Services\Barcode\Shape\AbstractBarcodeShape;
use MerryGoblin\BarcodeWriter\Services\Barcode\Type\BarcodeTypeInterface;

class Code93BarcodeEncoder extends AbstractBarcodeEncoder implements BarcodeEncoderInterface
{
	protected $shapeName = BarcodeShapeHelper::SHAPE_LINEAR;

	protected $alphabet = [
		'0' => [1, 3, 1, 1, 1, 2,  0],
		'1' => [1, 1, 1, 2, 1, 3,  1],
		'2' => [1, 1, 1, 3, 1, 2,  2],
		'3' => [1, 1, 1, 4, 1, 1,  3],
		'4' => [1, 2, 1, 1, 1, 3,  4],
		'5' => [1, 2, 1, 2, 1, 2,  5],
		'6' => [1, 2, 1, 3, 1, 1,  6],
		'7' => [1, 1, 1, 1, 1, 4,  7],
		'8' => [1, 3, 1, 2, 1, 1,  8],
		'9' => [1, 4, 1, 1, 1, 1,  9],
		'A' => [2, 1, 1, 1, 1, 3, 10],
		'B' => [2, 1, 1, 2, 1, 2, 11],
		'C' => [2, 1, 1, 3, 1, 1, 12],
		'D' => [2, 2, 1, 1, 1, 2, 13],
		'E' => [2, 2, 1, 2, 1, 1, 14],
		'F' => [2, 3, 1, 1, 1, 1, 15],
		'G' => [1, 1, 2, 1, 1, 3, 16],
		'H' => [1, 1, 2, 2, 1, 2, 17],
		'I' => [1, 1, 2, 3, 1, 1, 18],
		'J' => [1, 2, 2, 1, 1, 2, 19],
		'K' => [1, 3, 2, 1, 1, 1, 20],
		'L' => [1, 1, 1, 1, 2, 3, 21],
		'M' => [1, 1, 1, 2, 2, 2, 22],
		'N' => [1, 1, 1, 3, 2, 1, 23],
		'O' => [1, 2, 1, 1, 2, 2, 24],
		'P' => [1, 3, 1, 1, 2, 1, 25],
		'Q' => [2, 1, 2, 1, 1, 2, 26],
		'R' => [2, 1, 2, 2, 1, 1, 27],
		'S' => [2, 1, 1, 1, 2, 2, 28],
		'T' => [2, 1, 1, 2, 2, 1, 29],
		'U' => [2, 2, 1, 1, 2, 1, 30],
		'V' => [2, 2, 2, 1, 1, 1, 31],
		'W' => [1, 1, 2, 1, 2, 2, 32],
		'X' => [1, 1, 2, 2, 2, 1, 33],
		'Y' => [1, 2, 2, 1, 2, 1, 34],
		'Z' => [1, 2, 3, 1, 1, 1, 35],
		'-' => [1, 2, 1, 1, 3, 1, 36],
		'.' => [3, 1, 1, 1, 1, 2, 37],
		' ' => [3, 1, 1, 2, 1, 1, 38],
		'$' => [3, 2, 1, 1, 1, 1, 39],
		'/' => [1, 1, 2, 1, 3, 1, 40],
		'+' => [1, 1, 3, 1, 2, 1, 41],
		'%' => [2, 1, 1, 1, 3, 1, 42],
		'#' => [1, 2, 1, 2, 2, 1, 43], /* ($) */
		'&' => [3, 1, 2, 1, 1, 1, 44], /* (%) */
		'|' => [3, 1, 1, 1, 2, 1, 45], /* (/) */
		'=' => [1, 2, 2, 2, 1, 1, 46], /* (+) */
		'*' => [1, 1, 1, 1, 4, 1,  0],
	];

	/**
	 * @param string $data
	 * @param BarcodeTypeInterface $barcodeType
	 * @return array
	 */
	public function encode($data, BarcodeTypeInterface $barcodeType)
	{
		$data = strtoupper(preg_replace('/[^0-9A-Za-z%+\/$ .-]/', '', $data));
		$modules = [];
		/* Start */
		$modules[] = [1, 1, 1];
		$modules[] = [0, 1, 1];
		$modules[] = [1, 1, 1];
		$modules[] = [0, 1, 1];
		$modules[] = [1, 4, 1];
		$modules[] = [0, 1, 1];
		/* Data */
		$values = [];
		for ($i = 0, $n = strlen($data); $i < $n; $i++) {
			$char = substr($data, $i, 1);
			$block = $this->alphabet[$char];
			$modules[] = [1, $block[0], 1];
			$modules[] = [0, $block[1], 1];
			$modules[] = [1, $block[2], 1];
			$modules[] = [0, $block[3], 1];
			$modules[] = [1, $block[4], 1];
			$modules[] = [0, $block[5], 1];
			$values[] = $block[6];
		}
		/* Check Digits */
		for ($i = 0; $i < 2; $i++) {
			$index = count($values);
			$weight = 0;
			$checksum = 0;
			while ($index) {
				$index--;
				$weight++;
				$checksum += $weight * $values[$index];
				$checksum %= 47;
				$weight %= ($i ? 15 : 20);
			}
			$values[] = $checksum;
		}
		$alphabet = array_values($this->alphabet);
		for ($i = count($values) - 2, $n = count($values); $i < $n; $i++) {
			$block = $alphabet[$values[$i]];
			$modules[] = [1, $block[0], 1];
			$modules[] = [0, $block[1], 1];
			$modules[] = [1, $block[2], 1];
			$modules[] = [0, $block[3], 1];
			$modules[] = [1, $block[4], 1];
			$modules[] = [0, $block[5], 1];
		}
		/* End */
		$modules[] = [1, 1, 1];
		$modules[] = [0, 1, 1];
		$modules[] = [1, 1, 1];
		$modules[] = [0, 1, 1];
		$modules[] = [1, 4, 1];
		$modules[] = [0, 1, 1];
		$modules[] = [1, 1, 1];
		/* Return */
		$blocks = [['m' => $modules, 'l' => [$data]]];
		return ['b' => $blocks];
	}
}
