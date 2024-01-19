<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Encoder;

use MerryGoblin\BarcodeWriter\Services\Barcode\Shape\BarcodeShapeHelper;
use MerryGoblin\BarcodeWriter\Services\Barcode\Type\BarcodeTypeInterface;

class CodabarBarcodeEncoder extends AbstractBarcodeEncoder implements BarcodeEncoderInterface
{
	protected $shapeName = BarcodeShapeHelper::SHAPE_LINEAR;

	protected $alphabet = [
		'0' => [1, 1, 1, 1, 1, 2, 2],
		'1' => [1, 1, 1, 1, 2, 2, 1],
		'4' => [1, 1, 2, 1, 1, 2, 1],
		'5' => [2, 1, 1, 1, 1, 2, 1],
		'2' => [1, 1, 1, 2, 1, 1, 2],
		'-' => [1, 1, 1, 2, 2, 1, 1],
		'$' => [1, 1, 2, 2, 1, 1, 1],
		'9' => [2, 1, 1, 2, 1, 1, 1],
		'6' => [1, 2, 1, 1, 1, 1, 2],
		'7' => [1, 2, 1, 1, 2, 1, 1],
		'8' => [1, 2, 2, 1, 1, 1, 1],
		'3' => [2, 2, 1, 1, 1, 1, 1],
		'C' => [1, 1, 1, 2, 1, 2, 2],
		'D' => [1, 1, 1, 2, 2, 2, 1],
		'A' => [1, 1, 2, 2, 1, 2, 1],
		'B' => [1, 2, 1, 2, 1, 1, 2],
		'*' => [1, 1, 1, 2, 1, 2, 2],
		'E' => [1, 1, 1, 2, 2, 2, 1],
		'T' => [1, 1, 2, 2, 1, 2, 1],
		'N' => [1, 2, 1, 2, 1, 1, 2],
		'.' => [2, 1, 2, 1, 2, 1, 1],
		'/' => [2, 1, 2, 1, 1, 1, 2],
		':' => [2, 1, 1, 1, 2, 1, 2],
		'+' => [1, 1, 2, 1, 2, 1, 2],
	];

	/**
	 * @param string $data
	 * @param BarcodeTypeInterface $barcodeType
	 * @return array
	 */
	public function encode($data, BarcodeTypeInterface $barcodeType)
	{
		$data = strtoupper(preg_replace(
			'/[^0-9ABCDENTabcdent*.\/:+$-]/', '', $data
		));
		$blocks = array();
		for ($i = 0, $n = strlen($data); $i < $n; $i++) {
			if ($blocks) {
				$blocks[] = [
					'm' => [[0, 1, 3]]
				];
			}
			$char = substr($data, $i, 1);
			$block = $this->alphabet[$char];
			$blocks[] = [
				'm' => [
					[1, 1, $block[0]],
					[0, 1, $block[1]],
					[1, 1, $block[2]],
					[0, 1, $block[3]],
					[1, 1, $block[4]],
					[0, 1, $block[5]],
					[1, 1, $block[6]],
				],
				'l' => [$char]
			];
		}
		return ['b' => $blocks];
	}
}
