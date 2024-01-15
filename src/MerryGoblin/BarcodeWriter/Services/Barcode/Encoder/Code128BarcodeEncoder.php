<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Encoder;

use MerryGoblin\BarcodeWriter\Services\Barcode\Shape\AbstractBarcodeShape;
use MerryGoblin\BarcodeWriter\Services\Barcode\Type\BarcodeTypeInterface;

class Code128BarcodeEncoder extends AbstractBarcodeEncoder implements BarcodeEncoderInterface
{
	protected $shapeName = AbstractBarcodeShape::LINEAR_SHAPE;

	protected $alphabet = [
		[2, 1, 2, 2, 2, 2], [2, 2, 2, 1, 2, 2],
		[2, 2, 2, 2, 2, 1], [1, 2, 1, 2, 2, 3],
		[1, 2, 1, 3, 2, 2], [1, 3, 1, 2, 2, 2],
		[1, 2, 2, 2, 1, 3], [1, 2, 2, 3, 1, 2],
		[1, 3, 2, 2, 1, 2], [2, 2, 1, 2, 1, 3],
		[2, 2, 1, 3, 1, 2], [2, 3, 1, 2, 1, 2],
		[1, 1, 2, 2, 3, 2], [1, 2, 2, 1, 3, 2],
		[1, 2, 2, 2, 3, 1], [1, 1, 3, 2, 2, 2],
		[1, 2, 3, 1, 2, 2], [1, 2, 3, 2, 2, 1],
		[2, 2, 3, 2, 1, 1], [2, 2, 1, 1, 3, 2],
		[2, 2, 1, 2, 3, 1], [2, 1, 3, 2, 1, 2],
		[2, 2, 3, 1, 1, 2], [3, 1, 2, 1, 3, 1],
		[3, 1, 1, 2, 2, 2], [3, 2, 1, 1, 2, 2],
		[3, 2, 1, 2, 2, 1], [3, 1, 2, 2, 1, 2],
		[3, 2, 2, 1, 1, 2], [3, 2, 2, 2, 1, 1],
		[2, 1, 2, 1, 2, 3], [2, 1, 2, 3, 2, 1],
		[2, 3, 2, 1, 2, 1], [1, 1, 1, 3, 2, 3],
		[1, 3, 1, 1, 2, 3], [1, 3, 1, 3, 2, 1],
		[1, 1, 2, 3, 1, 3], [1, 3, 2, 1, 1, 3],
		[1, 3, 2, 3, 1, 1], [2, 1, 1, 3, 1, 3],
		[2, 3, 1, 1, 1, 3], [2, 3, 1, 3, 1, 1],
		[1, 1, 2, 1, 3, 3], [1, 1, 2, 3, 3, 1],
		[1, 3, 2, 1, 3, 1], [1, 1, 3, 1, 2, 3],
		[1, 1, 3, 3, 2, 1], [1, 3, 3, 1, 2, 1],
		[3, 1, 3, 1, 2, 1], [2, 1, 1, 3, 3, 1],
		[2, 3, 1, 1, 3, 1], [2, 1, 3, 1, 1, 3],
		[2, 1, 3, 3, 1, 1], [2, 1, 3, 1, 3, 1],
		[3, 1, 1, 1, 2, 3], [3, 1, 1, 3, 2, 1],
		[3, 3, 1, 1, 2, 1], [3, 1, 2, 1, 1, 3],
		[3, 1, 2, 3, 1, 1], [3, 3, 2, 1, 1, 1],
		[3, 1, 4, 1, 1, 1], [2, 2, 1, 4, 1, 1],
		[4, 3, 1, 1, 1, 1], [1, 1, 1, 2, 2, 4],
		[1, 1, 1, 4, 2, 2], [1, 2, 1, 1, 2, 4],
		[1, 2, 1, 4, 2, 1], [1, 4, 1, 1, 2, 2],
		[1, 4, 1, 2, 2, 1], [1, 1, 2, 2, 1, 4],
		[1, 1, 2, 4, 1, 2], [1, 2, 2, 1, 1, 4],
		[1, 2, 2, 4, 1, 1], [1, 4, 2, 1, 1, 2],
		[1, 4, 2, 2, 1, 1], [2, 4, 1, 2, 1, 1],
		[2, 2, 1, 1, 1, 4], [4, 1, 3, 1, 1, 1],
		[2, 4, 1, 1, 1, 2], [1, 3, 4, 1, 1, 1],
		[1, 1, 1, 2, 4, 2], [1, 2, 1, 1, 4, 2],
		[1, 2, 1, 2, 4, 1], [1, 1, 4, 2, 1, 2],
		[1, 2, 4, 1, 1, 2], [1, 2, 4, 2, 1, 1],
		[4, 1, 1, 2, 1, 2], [4, 2, 1, 1, 1, 2],
		[4, 2, 1, 2, 1, 1], [2, 1, 2, 1, 4, 1],
		[2, 1, 4, 1, 2, 1], [4, 1, 2, 1, 2, 1],
		[1, 1, 1, 1, 4, 3], [1, 1, 1, 3, 4, 1],
		[1, 3, 1, 1, 4, 1], [1, 1, 4, 1, 1, 3],
		[1, 1, 4, 3, 1, 1], [4, 1, 1, 1, 1, 3],
		[4, 1, 1, 3, 1, 1], [1, 1, 3, 1, 4, 1],
		[1, 1, 4, 1, 3, 1], [3, 1, 1, 1, 4, 1],
		[4, 1, 1, 1, 3, 1], [2, 1, 1, 4, 1, 2],
		[2, 1, 1, 2, 1, 4], [2, 1, 1, 2, 3, 2],
		[2, 3, 3, 1, 1, 1, 2]
	];

	/**
	 * @param string $data
	 * @param BarcodeTypeInterface $barcodeType
	 * @return array
	 */
	public function encode($data, BarcodeTypeInterface $barcodeType)
	{
		list($dstate, $fnc1) = $this->getParametersForEncodeMethod($barcodeType->getParameters());

		$data = preg_replace('/[\x80-\xFF]/', '', $data);
		$label = preg_replace('/[\x00-\x1F\x7F]/', ' ', $data);
		$chars = $this->normalize($data, $dstate, $fnc1);
		$checksum = $chars[0] % 103;
		for ($i = 1, $n = count($chars); $i < $n; $i++) {
			$checksum += $i * $chars[$i];
			$checksum %= 103;
		}
		$chars[] = $checksum;
		$chars[] = 106;
		$modules = [];
		$modules[] = [0, 10, 0];
		foreach ($chars as $char) {
			$block = $this->alphabet[$char];
			foreach ($block as $i => $module) {
				$modules[] = [($i & 1) ^ 1, $module, 1];
			}
		}
		$modules[] = [0, 10, 0];
		$blocks = [['m' => $modules, 'l' => [$label]]];
		return ['b' => $blocks];
	}

	/**
	 * @param array|null $params
	 * @return array
	 */
	private function getParametersForEncodeMethod($params = null)
	{
		$dstate = (isset($params['dstate'])) ? $params['dstate'] : 0;
		$fnc1 = (isset($params['fnc1'])) ? $params['fnc1'] : false;
		return [$dstate, $fnc1];
	}

	/**
	 * @param string $data
	 * @param int $dstate
	 * @param bool $fnc1
	 * @return int[]
	 */
	private function normalize($data, $dstate, $fnc1)
	{
		$detectcba = '/(^[0-9]{4,}|^[0-9]{2}$)|([\x60-\x7F])|([\x00-\x1F])/';
		$detectc = '/(^[0-9]{6,}|^[0-9]{4,}$)/';
		$detectba = '/([\x60-\x7F])|([\x00-\x1F])/';
		$consumec = '/(^[0-9]{2})/';
		$state = (($dstate > 0 && $dstate < 4) ? $dstate : 0);
		$abstate = ((abs($dstate) == 2) ? 2 : 1);
		$chars = [102 + ($state ? $state : $abstate)];
		if ($fnc1) {
			$chars[] = 102;
		}
		while (strlen($data)) {
			switch ($state) {
				case 0:
					if (preg_match($detectcba, $data, $m)) {
						if ($m[1]) {
							$state = 3;
						} else if ($m[2]) {
							$state = 2;
						} else {
							$state = 1;
						}
					} else {
						$state = $abstate;
					}
					$chars = [102 + $state];
					if ($fnc1) {
						$chars[] = 102;
					}
					break;
				case 1:
					if ($dstate <= 0 && preg_match($detectc, $data, $m)) {
						if (strlen($m[0]) % 2) {
							$data = substr($data, 1);
							$chars[] = 16 + substr($m[0], 0, 1);
						}
						$state = 3;
						$chars[] = 99;
					} else {
						$ch = ord(substr($data, 0, 1));
						$data = substr($data, 1);
						if ($ch < 32) {
							$chars[] = $ch + 64;
						} else if ($ch < 96) {
							$chars[] = $ch - 32;
						} else {
							if (preg_match($detectba, $data, $m)) {
								if ($m[1]) {
									$state = 2;
									$chars[] = 100;
								} else {
									$chars[] = 98;
								}
							} else {
								$chars[] = 98;
							}
							$chars[] = $ch - 32;
						}
					}
					break;
				case 2:
					if ($dstate <= 0 && preg_match($detectc, $data, $m)) {
						if (strlen($m[0]) % 2) {
							$data = substr($data, 1);
							$chars[] = 16 + substr($m[0], 0, 1);
						}
						$state = 3;
						$chars[] = 99;
					} else {
						$ch = ord(substr($data, 0, 1));
						$data = substr($data, 1);
						if ($ch >= 32) {
							$chars[] = $ch - 32;
						} else {
							if (preg_match($detectba, $data, $m)) {
								if ($m[2]) {
									$state = 1;
									$chars[] = 101;
								} else {
									$chars[] = 98;
								}
							} else {
								$chars[] = 98;
							}
							$chars[] = $ch + 64;
						}
					}
					break;
				case 3:
					if (preg_match($consumec, $data, $m)) {
						$data = substr($data, 2);
						$chars[] = (int)$m[0];
					} else {
						if (preg_match($detectba, $data, $m)) {
							if ($m[1]) {
								$state = 2;
							} else {
								$state = 1;
							}
						} else {
							$state = $abstate;
						}
						$chars[] = 102 - $state;
					}
					break;
			}
		}
		return $chars;
	}
}
