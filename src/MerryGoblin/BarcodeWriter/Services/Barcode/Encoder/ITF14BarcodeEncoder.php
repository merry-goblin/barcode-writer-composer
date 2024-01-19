<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Encoder;

use MerryGoblin\BarcodeWriter\Services\Barcode\Shape\BarcodeShapeHelper;
use MerryGoblin\BarcodeWriter\Services\Barcode\Type\BarcodeTypeInterface;

class ITF14BarcodeEncoder extends AbstractBarcodeEncoder implements BarcodeEncoderInterface
{
	protected $shapeName = BarcodeShapeHelper::SHAPE_LINEAR;

	protected $alphabet = [
		'0' => [1, 1, 2, 2, 1],
		'1' => [2, 1, 1, 1, 2],
		'2' => [1, 2, 1, 1, 2],
		'3' => [2, 2, 1, 1, 1],
		'4' => [1, 1, 2, 1, 2],
		'5' => [2, 1, 2, 1, 1],
		'6' => [1, 2, 2, 1, 1],
		'7' => [1, 1, 1, 2, 2],
		'8' => [2, 1, 1, 2, 1],
		'9' => [1, 2, 1, 2, 1],
	];

	/**
	 * @param string $data
	 * @param BarcodeTypeInterface $barcodeType
	 * @return array
	 */
	public function encode($data, BarcodeTypeInterface $barcodeType)
	{
		$data = preg_replace('/[^0-9]/', '', $data);
		if (strlen($data) % 2) $data = '0' . $data;
		$blocks = [];
		/* Quiet zone, start. */
		$blocks[] = [
			'm' => [[0, 10, 0]]
		];
		$blocks[] = [
			'm' => [
				[1, 1, 1],
				[0, 1, 1],
				[1, 1, 1],
				[0, 1, 1],
			]
		];
		/* Data. */
		for ($i = 0, $n = strlen($data); $i < $n; $i += 2) {
			$c1 = substr($data, $i, 1);
			$c2 = substr($data, $i+1, 1);
			$b1 = $this->alphabet[$c1];
			$b2 = $this->alphabet[$c2];
			$blocks[] = [
				'm' => [
					[1, 1, $b1[0]],
					[0, 1, $b2[0]],
					[1, 1, $b1[1]],
					[0, 1, $b2[1]],
					[1, 1, $b1[2]],
					[0, 1, $b2[2]],
					[1, 1, $b1[3]],
					[0, 1, $b2[3]],
					[1, 1, $b1[4]],
					[0, 1, $b2[4]],
				],
				'l' => [$c1 . $c2]
			];
		}
		/* End, quiet zone. */
		$blocks[] = [
			'm' => [
				[1, 1, 2],
				[0, 1, 1],
				[1, 1, 1],
			]
		];
		$blocks[] = [
			'm' => [[0, 10, 0]]
		];
		/* Return code. */
		return ['b' => $blocks];
	}
}
