<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Encoder;

use MerryGoblin\BarcodeWriter\Services\Barcode\Shape\AbstractBarcodeShape;
use MerryGoblin\BarcodeWriter\Services\Barcode\Type\BarcodeTypeInterface;

class EAN8BarcodeEncoder extends UPCABarcodeEncoder implements BarcodeEncoderInterface
{
	protected $shapeName = BarcodeShapeHelper::SHAPE_LINEAR;

	/**
	 * @param string $data
	 * @param BarcodeTypeInterface $barcodeType
	 * @return array
	 */
	public function encode($data, BarcodeTypeInterface $barcodeType)
	{
		$data = $this->normalizeEAN8($data);
		$blocks = [];
		/* Quiet zone, start. */
		$blocks[] = [
			'm' => [[0, 9, 0]],
			'l' => ['<', 0.5, 1/3]
		];
		$blocks[] = [
			'm' => [
				[1, 1, 1],
				[0, 1, 1],
				[1, 1, 1],
			]
		];
		/* Left zone. */
		for ($i = 0; $i < 4; $i++) {
			$digit = substr($data, $i, 1);
			$blocks[] = [
				'm' => [
					[0, $this->alphabet[$digit][0], 1],
					[1, $this->alphabet[$digit][1], 1],
					[0, $this->alphabet[$digit][2], 1],
					[1, $this->alphabet[$digit][3], 1],
				],
				'l' => [$digit, 0.5, (4 - $i) / 5]
			];
		}
		/* Middle. */
		$blocks[] = [
			'm' => [
				[0, 1, 1],
				[1, 1, 1],
				[0, 1, 1],
				[1, 1, 1],
				[0, 1, 1],
			]
		];
		/* Right zone. */
		for ($i = 4; $i < 8; $i++) {
			$digit = substr($data, $i, 1);
			$blocks[] = [
				'm' => [
					[1, $this->alphabet[$digit][0], 1],
					[0, $this->alphabet[$digit][1], 1],
					[1, $this->alphabet[$digit][2], 1],
					[0, $this->alphabet[$digit][3], 1],
				],
				'l' => [$digit, 0.5, (8 - $i) / 5]
			];
		}
		/* End, quiet zone. */
		$blocks[] = [
			'm' => [
				[1, 1, 1],
				[0, 1, 1],
				[1, 1, 1],
			]
		];
		$blocks[] = [
			'm' => [[0, 9, 0]],
			'l' => ['>', 0.5, 2/3]
		];
		/* Return code. */
		return ['g' => 'l', 'b' => $blocks];
	}

	/**
	 * @param string $data
	 * @return string
	 */
	protected function normalizeEAN8($data)
	{
		$data = preg_replace('/[^0-9*]/', '', $data);
		/* Set length to 8 digits. */
		if (strlen($data) < 8) {
			$midpoint = floor(strlen($data) / 2);
			$left = substr($data, 0, $midpoint);
			$center = str_repeat('0', 8 - strlen($data));
			$right = substr($data, $midpoint);
			$data = $left . $center . $right;
		} else if (strlen($data) > 8) {
			$left = substr($data, 0, 4);
			$right = substr($data, -4);
			$data = $left . $right;
		}
		/* Replace * with missing or check digit. */
		while (($o = strrpos($data, '*')) !== false) {
			$checksum = 0;
			for ($i = 0; $i < 8; $i++) {
				$digit = substr($data, $i, 1);
				$checksum += (($i % 2) ? 1 : 3) * $digit;
			}
			$checksum *= (($o % 2) ? 9 : 3);
			$left = substr($data, 0, $o);
			$center = substr($checksum, -1);
			$right = substr($data, $o + 1);
			$data = $left . $center . $right;
		}
		return $data;
	}
}
