<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Encoder;

use MerryGoblin\BarcodeWriter\Services\Barcode\Shape\BarcodeShapeHelper;
use MerryGoblin\BarcodeWriter\Services\Barcode\Type\BarcodeTypeInterface;

class EAN13BarcodeEncoder extends UPCEBarcodeEncoder implements BarcodeEncoderInterface
{
	protected $shapeName = BarcodeShapeHelper::SHAPE_LINEAR;

	/**
	 * @param string $data
	 * @param BarcodeTypeInterface $barcodeType
	 * @return array
	 */
	public function encode($data, BarcodeTypeInterface $barcodeType)
	{
		list($pad) = $this->getParametersForEncodeMethod($barcodeType->getParameters());

		$data = $this->normalizeEAN13($data);
		$blocks = [];
		/* Quiet zone, start, first digit (as parity). */
		$system = substr($data, 0, 1);
		$pbits = (
		(int)$system ?
			$this->parityAlphabet[$system] :
			[1, 1, 1, 1, 1, 1]
		);
		$blocks[] = [
			'm' => [[0, 9, 0]],
			'l' => [$system, 0.5, 1/3]
		];
		$blocks[] = [
			'm' => [
				[1, 1, 1],
				[0, 1, 1],
				[1, 1, 1],
			]
		];
		/* Left zone. */
		for ($i = 1; $i < 7; $i++) {
			$digit = substr($data, $i, 1);
			$pbit = $pbits[$i - 1];
			$blocks[] = [
				'm' => [
					[0, $this->alphabet[$digit][$pbit ? 0 : 3], 1],
					[1, $this->alphabet[$digit][$pbit ? 1 : 2], 1],
					[0, $this->alphabet[$digit][$pbit ? 2 : 1], 1],
					[1, $this->alphabet[$digit][$pbit ? 3 : 0], 1],
				],
				'l' => [$digit, 0.5, (7 - $i) / 7]
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
		for ($i = 7; $i < 13; $i++) {
			$digit = substr($data, $i, 1);
			$blocks[] = [
				'm' => [
					[1, $this->alphabet[$digit][0], 1],
					[0, $this->alphabet[$digit][1], 1],
					[1, $this->alphabet[$digit][2], 1],
					[0, $this->alphabet[$digit][3], 1],
				],
				'l' => [$digit, 0.5, (13 - $i) / 7]
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
			'l' => [$pad, 0.5, 2/3]
		];
		/* Return code. */
		return ['b' => $blocks];
	}

	/**
	 * @param array|null $params
	 * @return array
	 */
	private function getParametersForEncodeMethod($params = null)
	{
		$pad = (isset($params['pad'])) ? $params['pad'] : ' ';
		return [$pad];
	}

	/**
	 * @param string $data
	 * @return string
	 */
	protected function normalizeEAN13($data)
	{
		$data = preg_replace('/[^0-9*]/', '', $data);
		/* Set length to 13 digits. */
		if (strlen($data) < 13) {
			return '0' . $this->normalizeUPCA($data);
		} else if (strlen($data) > 13) {
			$left = substr($data, 0, 7);
			$right = substr($data, -6);
			$data = $left . $right;
		}
		/* Replace * with missing or check digit. */
		while (($o = strrpos($data, '*')) !== false) {
			$checksum = 0;
			for ($i = 0; $i < 13; $i++) {
				$digit = substr($data, $i, 1);
				$checksum += (($i % 2) ? 3 : 1) * $digit;
			}
			$checksum *= (($o % 2) ? 3 : 9);
			$left = substr($data, 0, $o);
			$center = substr($checksum, -1);
			$right = substr($data, $o + 1);
			$data = $left . $center . $right;
		}
		return $data;
	}
}
