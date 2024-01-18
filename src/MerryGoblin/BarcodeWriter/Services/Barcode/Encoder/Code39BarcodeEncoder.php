<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Encoder;

use MerryGoblin\BarcodeWriter\Services\Barcode\Shape\AbstractBarcodeShape;
use MerryGoblin\BarcodeWriter\Services\Barcode\Type\BarcodeTypeInterface;

class Code39BarcodeEncoder extends AbstractBarcodeEncoder implements BarcodeEncoderInterface
{
	protected $shapeName = BarcodeShapeHelper::SHAPE_LINEAR;

	protected $alphabet = [
		'1' => [2, 1, 1, 2, 1, 1, 1, 1, 2],
		'2' => [1, 1, 2, 2, 1, 1, 1, 1, 2],
		'3' => [2, 1, 2, 2, 1, 1, 1, 1, 1],
		'4' => [1, 1, 1, 2, 2, 1, 1, 1, 2],
		'5' => [2, 1, 1, 2, 2, 1, 1, 1, 1],
		'6' => [1, 1, 2, 2, 2, 1, 1, 1, 1],
		'7' => [1, 1, 1, 2, 1, 1, 2, 1, 2],
		'8' => [2, 1, 1, 2, 1, 1, 2, 1, 1],
		'9' => [1, 1, 2, 2, 1, 1, 2, 1, 1],
		'0' => [1, 1, 1, 2, 2, 1, 2, 1, 1],
		'A' => [2, 1, 1, 1, 1, 2, 1, 1, 2],
		'B' => [1, 1, 2, 1, 1, 2, 1, 1, 2],
		'C' => [2, 1, 2, 1, 1, 2, 1, 1, 1],
		'D' => [1, 1, 1, 1, 2, 2, 1, 1, 2],
		'E' => [2, 1, 1, 1, 2, 2, 1, 1, 1],
		'F' => [1, 1, 2, 1, 2, 2, 1, 1, 1],
		'G' => [1, 1, 1, 1, 1, 2, 2, 1, 2],
		'H' => [2, 1, 1, 1, 1, 2, 2, 1, 1],
		'I' => [1, 1, 2, 1, 1, 2, 2, 1, 1],
		'J' => [1, 1, 1, 1, 2, 2, 2, 1, 1],
		'K' => [2, 1, 1, 1, 1, 1, 1, 2, 2],
		'L' => [1, 1, 2, 1, 1, 1, 1, 2, 2],
		'M' => [2, 1, 2, 1, 1, 1, 1, 2, 1],
		'N' => [1, 1, 1, 1, 2, 1, 1, 2, 2],
		'O' => [2, 1, 1, 1, 2, 1, 1, 2, 1],
		'P' => [1, 1, 2, 1, 2, 1, 1, 2, 1],
		'Q' => [1, 1, 1, 1, 1, 1, 2, 2, 2],
		'R' => [2, 1, 1, 1, 1, 1, 2, 2, 1],
		'S' => [1, 1, 2, 1, 1, 1, 2, 2, 1],
		'T' => [1, 1, 1, 1, 2, 1, 2, 2, 1],
		'U' => [2, 2, 1, 1, 1, 1, 1, 1, 2],
		'V' => [1, 2, 2, 1, 1, 1, 1, 1, 2],
		'W' => [2, 2, 2, 1, 1, 1, 1, 1, 1],
		'X' => [1, 2, 1, 1, 2, 1, 1, 1, 2],
		'Y' => [2, 2, 1, 1, 2, 1, 1, 1, 1],
		'Z' => [1, 2, 2, 1, 2, 1, 1, 1, 1],
		'-' => [1, 2, 1, 1, 1, 1, 2, 1, 2],
		'.' => [2, 2, 1, 1, 1, 1, 2, 1, 1],
		' ' => [1, 2, 2, 1, 1, 1, 2, 1, 1],
		'*' => [1, 2, 1, 1, 2, 1, 2, 1, 1],
		'+' => [1, 2, 1, 1, 1, 2, 1, 2, 1],
		'/' => [1, 2, 1, 2, 1, 1, 1, 2, 1],
		'$' => [1, 2, 1, 2, 1, 2, 1, 1, 1],
		'%' => [1, 1, 1, 2, 1, 2, 1, 2, 1],
	];

	/**
	 * @param string $data
	 * @param BarcodeTypeInterface $barcodeType
	 * @return array
	 */
	public function encode($data, BarcodeTypeInterface $barcodeType)
	{
		$data = strtoupper(preg_replace('/[^0-9A-Za-z%$\/+ .-]/', '', $data));
		$blocks = [];
		/* Start */
		$blocks[] = [
			'm' => [
				[1, 1, 1], [0, 1, 2], [1, 1, 1],
				[0, 1, 1], [1, 1, 2], [0, 1, 1],
				[1, 1, 2], [0, 1, 1], [1, 1, 1],
			],
			'l' => ['*']
		];
		/* Data */
		for ($i = 0, $n = strlen($data); $i < $n; $i++) {
			$blocks[] = [
				'm' => [[0, 1, 3]]
			];
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
					[0, 1, $block[7]],
					[1, 1, $block[8]],
				],
				'l' => [$char]
			];
		}
		$blocks[] = [
			'm' => [[0, 1, 3]]
		];
		/* End */
		$blocks[] = [
			'm' => [
				[1, 1, 1], [0, 1, 2], [1, 1, 1],
				[0, 1, 1], [1, 1, 2], [0, 1, 1],
				[1, 1, 2], [0, 1, 1], [1, 1, 1],
			],
			'l' => ['*']
		];
		/* Return */
		return ['b' => $blocks];
	}
}
