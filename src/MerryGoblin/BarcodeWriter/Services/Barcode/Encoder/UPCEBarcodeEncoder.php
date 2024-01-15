<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Encoder;

use MerryGoblin\BarcodeWriter\Services\Barcode\Shape\AbstractBarcodeShape;
use MerryGoblin\BarcodeWriter\Services\Barcode\Type\BarcodeTypeInterface;

class UPCEBarcodeEncoder extends UPCABarcodeEncoder implements BarcodeEncoderInterface
{
	protected $shapeName = AbstractBarcodeShape::LINEAR_SHAPE;

	protected $parityAlphabet = [
		'0' => [1, 1, 1, 0, 0, 0],
		'1' => [1, 1, 0, 1, 0, 0],
		'2' => [1, 1, 0, 0, 1, 0],
		'3' => [1, 1, 0, 0, 0, 1],
		'4' => [1, 0, 1, 1, 0, 0],
		'5' => [1, 0, 0, 1, 1, 0],
		'6' => [1, 0, 0, 0, 1, 1],
		'7' => [1, 0, 1, 0, 1, 0],
		'8' => [1, 0, 1, 0, 0, 1],
		'9' => [1, 0, 0, 1, 0, 1],
	];

	/**
	 * @param string $data
	 * @param BarcodeTypeInterface $barcodeType
	 * @return array
	 */
	public function encode($data, BarcodeTypeInterface $barcodeType)
	{
		$data = $this->normalizeUPCE($data);
		$blocks = [];
		/* Quiet zone, start. */
		$blocks[] = [
			'm' => [[0, 9, 0]]
		];
		$blocks[] = [
			'm' => [
				[1, 1, 1],
				[0, 1, 1],
				[1, 1, 1],
			]
		];
		/* Digits */
		$system = substr($data, 0, 1) & 1;
		$check = substr($data, 7, 1);
		$pbits = $this->parityAlphabet[$check];
		for ($i = 1; $i < 7; $i++) {
			$digit = substr($data, $i, 1);
			$pbit = $pbits[$i - 1] ^ $system;
			$blocks[] = [
				'm' => [
					[0, $this->alphabet[$digit][$pbit ? 3 : 0], 1],
					[1, $this->alphabet[$digit][$pbit ? 2 : 1], 1],
					[0, $this->alphabet[$digit][$pbit ? 1 : 2], 1],
					[1, $this->alphabet[$digit][$pbit ? 0 : 3], 1],
				],
				'l' => [$digit, 0.5, (7 - $i) / 7]
			];
		}
		/* End, quiet zone. */
		$blocks[] = [
			'm' => [
				[0, 1, 1],
				[1, 1, 1],
				[0, 1, 1],
				[1, 1, 1],
				[0, 1, 1],
				[1, 1, 1],
			]
		];
		$blocks[] = [
			'm' => [[0, 9, 0]]
		];
		/* Return code. */
		return ['b' => $blocks];
	}

	/**
	 * @param string $data
	 * @return string
	 */
	protected function normalizeUPCE($data)
	{
		$data = preg_replace('/[^0-9*]/', '', $data);
		/* If exactly 8 digits, use verbatim even if check digit is wrong. */
		if (preg_match(
			'/^([01])([0-9][0-9][0-9][0-9][0-9][0-9])([0-9])$/',
			$data, $m
		)) {
			return $data;
		}
		/* If unknown check digit, use verbatim but calculate check digit. */
		if (preg_match(
			'/^([01])([0-9][0-9][0-9][0-9][0-9][0-9])([*])$/',
			$data, $m
		)) {
			$data = $this->normalizeUPCA($data);
			return $m[1] . $m[2] . substr($data, -1);
		}
		/* Otherwise normalize to UPC-A and convert back. */
		$data = $this->normalizeUPCA($data);
		if (preg_match(
			'/^([01])([0-9][0-9])([0-2])0000([0-9][0-9][0-9])([0-9])$/',
			$data, $m
		)) {
			return $m[1] . $m[2] . $m[4] . $m[3] . $m[5];
		}
		if (preg_match(
			'/^([01])([0-9][0-9][0-9])00000([0-9][0-9])([0-9])$/',
			$data, $m
		)) {
			return $m[1] . $m[2] . $m[3] . '3' . $m[4];
		}
		if (preg_match(
			'/^([01])([0-9][0-9][0-9][0-9])00000([0-9])([0-9])$/',
			$data, $m
		)) {
			return $m[1] . $m[2] . $m[3] . '4' . $m[4];
		}
		if (preg_match(
			'/^([01])([0-9][0-9][0-9][0-9][0-9])0000([5-9])([0-9])$/',
			$data, $m
		)) {
			return $m[1] . $m[2] . $m[3] . $m[4];
		}
		return str_repeat('0', 8);
	}
}
