<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Encoder;

use MerryGoblin\BarcodeWriter\Services\Barcode\Shape\AbstractBarcodeShape;
use MerryGoblin\BarcodeWriter\Services\Barcode\Type\BarcodeTypeInterface;

class UPCABarcodeEncoder extends AbstractBarcodeEncoder implements BarcodeEncoderInterface
{
	protected $shapeName = BarcodeShapeHelper::SHAPE_LINEAR;

	protected $alphabet = [
		'0' => [3, 2, 1, 1],
		'1' => [2, 2, 2, 1],
		'2' => [2, 1, 2, 2],
		'3' => [1, 4, 1, 1],
		'4' => [1, 1, 3, 2],
		'5' => [1, 2, 3, 1],
		'6' => [1, 1, 1, 4],
		'7' => [1, 3, 1, 2],
		'8' => [1, 2, 1, 3],
		'9' => [3, 1, 1, 2],
	];

	/**
	 * @param string $data
	 * @param BarcodeTypeInterface $barcodeType
	 * @return array
	 */
	public function encode($data, BarcodeTypeInterface $barcodeType)
	{
		$data = $this->normalize($data);
		$blocks = [];
		/* Quiet zone, start, first digit. */
		$digit = substr($data, 0, 1);
		$blocks[] = [
			'm' => [[0, 9, 0]],
			'l' => [$digit, 0, 1/3]
		];
		$blocks[] = [
			'm' => [
				[1, 1, 1],
				[0, 1, 1],
				[1, 1, 1],
			]
		];
		$blocks[] = [
			'm' => [
				[0, $this->alphabet[$digit][0], 1],
				[1, $this->alphabet[$digit][1], 1],
				[0, $this->alphabet[$digit][2], 1],
				[1, $this->alphabet[$digit][3], 1],
			]
		];
		/* Left zone. */
		for ($i = 1; $i < 6; $i++) {
			$digit = substr($data, $i, 1);
			$blocks[] = [
				'm' => [
					[0, $this->alphabet[$digit][0], 1],
					[1, $this->alphabet[$digit][1], 1],
					[0, $this->alphabet[$digit][2], 1],
					[1, $this->alphabet[$digit][3], 1],
				],
				'l' => [$digit, 0.5, (6 - $i) / 6]
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
		for ($i = 6; $i < 11; $i++) {
			$digit = substr($data, $i, 1);
			$blocks[] = [
				'm' => [
					[1, $this->alphabet[$digit][0], 1],
					[0, $this->alphabet[$digit][1], 1],
					[1, $this->alphabet[$digit][2], 1],
					[0, $this->alphabet[$digit][3], 1],
				],
				'l' => [$digit, 0.5, (11 - $i) / 6]
			];
		}
		/* Last digit, end, quiet zone. */
		$digit = substr($data, 11, 1);
		$blocks[] = [
			'm' => [
				[1, $this->alphabet[$digit][0], 1],
				[0, $this->alphabet[$digit][1], 1],
				[1, $this->alphabet[$digit][2], 1],
				[0, $this->alphabet[$digit][3], 1],
			]
		];
		$blocks[] = [
			'm' => [
				[1, 1, 1],
				[0, 1, 1],
				[1, 1, 1],
			]
		];
		$blocks[] = [
			'm' => [[0, 9, 0]],
			'l' => [$digit, 0, 2/3]
		];
		/* Return code. */
		return ['b' => $blocks];
	}

	/**
	 * @param string $data
	 * @return string
	 */
	protected function normalizeUPCA($data)
	{
		$data = preg_replace('/[^0-9*]/', '', $data);
		/* Set length to 12 digits. */
		if (strlen($data) < 5) {
			$data = str_repeat('0', 12);
		} else if (strlen($data) < 12) {
			$system = substr($data, 0, 1);
			$edata = substr($data, 1, -2);
			$epattern = (int)substr($data, -2, 1);
			$check = substr($data, -1);
			if ($epattern < 3) {
				$left = $system . substr($edata, 0, 2) . $epattern;
				$right = substr($edata, 2) . $check;
			} else if ($epattern < strlen($edata)) {
				$left = $system . substr($edata, 0, $epattern);
				$right = substr($edata, $epattern) . $check;
			} else {
				$left = $system . $edata;
				$right = $epattern . $check;
			}
			$center = str_repeat('0', 12 - strlen($left . $right));
			$data = $left . $center . $right;
		} else if (strlen($data) > 12) {
			$left = substr($data, 0, 6);
			$right = substr($data, -6);
			$data = $left . $right;
		}
		/* Replace * with missing or check digit. */
		while (($o = strrpos($data, '*')) !== false) {
			$checksum = 0;
			for ($i = 0; $i < 12; $i++) {
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
