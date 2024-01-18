<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Encoder;

use MerryGoblin\BarcodeWriter\Services\Barcode\Shape\BarcodeShapeHelper;
use MerryGoblin\BarcodeWriter\Services\Barcode\Type\BarcodeTypeInterface;

class Code93AsciiBarcodeEncoder extends Code93BarcodeEncoder implements BarcodeEncoderInterface
{
	protected $shapeName = BarcodeShapeHelper::SHAPE_LINEAR;

	protected $asciiAlphabet = [
		'%U', '$A', '$B', '$C', '$D', '$E', '$F', '$G',
		'$H', '$I', '$J', '$K', '$L', '$M', '$N', '$O',
		'$P', '$Q', '$R', '$S', '$T', '$U', '$V', '$W',
		'$X', '$Y', '$Z', '%A', '%B', '%C', '%D', '%E',
		' ' , '/A', '/B', '/C', '/D', '/E', '/F', '/G',
		'/H', '/I', '/J', '/K', '/L', '-' , '.' , '/O',
		'0' , '1' , '2' , '3' , '4' , '5' , '6' , '7' ,
		'8' , '9' , '/Z', '%F', '%G', '%H', '%I', '%J',
		'%V', 'A' , 'B' , 'C' , 'D' , 'E' , 'F' , 'G' ,
		'H' , 'I' , 'J' , 'K' , 'L' , 'M' , 'N' , 'O' ,
		'P' , 'Q' , 'R' , 'S' , 'T' , 'U' , 'V' , 'W' ,
		'X' , 'Y' , 'Z' , '%K', '%L', '%M', '%N', '%O',
		'%W', '+A', '+B', '+C', '+D', '+E', '+F', '+G',
		'+H', '+I', '+J', '+K', '+L', '+M', '+N', '+O',
		'+P', '+Q', '+R', '+S', '+T', '+U', '+V', '+W',
		'+X', '+Y', '+Z', '%P', '%Q', '%R', '%S', '%T',
	];

	/**
	 * @param string $data
	 * @param BarcodeTypeInterface $barcodeType
	 * @return array
	 */
	public function encode($data, BarcodeTypeInterface $barcodeType)
	{
		$modules = [];
		/* Start */
		$modules[] = [1, 1, 1];
		$modules[] = [0, 1, 2];
		$modules[] = [1, 1, 1];
		$modules[] = [0, 1, 1];
		$modules[] = [1, 1, 2];
		$modules[] = [0, 1, 1];
		$modules[] = [1, 1, 2];
		$modules[] = [0, 1, 1];
		$modules[] = [1, 1, 1];
		/* Data */
		$label = '';
		for ($i = 0, $n = strlen($data); $i < $n; $i++) {
			$char = substr($data, $i, 1);
			$ch = ord($char);
			if ($ch < 128) {
				if ($ch < 32 || $ch >= 127) {
					$label .= ' ';
				} else {
					$label .= $char;
				}
				$ch = $this->asciiAlphabet[$ch];
				for ($j = 0, $m = strlen($ch); $j < $m; $j++) {
					$c = substr($ch, $j, 1);
					$b = $this->alphabet[$c];
					$modules[] = [0, 1, 3];
					$modules[] = [1, 1, $b[0]];
					$modules[] = [0, 1, $b[1]];
					$modules[] = [1, 1, $b[2]];
					$modules[] = [0, 1, $b[3]];
					$modules[] = [1, 1, $b[4]];
					$modules[] = [0, 1, $b[5]];
					$modules[] = [1, 1, $b[6]];
					$modules[] = [0, 1, $b[7]];
					$modules[] = [1, 1, $b[8]];
				}
			}
		}
		$modules[] = [0, 1, 3];
		/* End */
		$modules[] = [1, 1, 1];
		$modules[] = [0, 1, 2];
		$modules[] = [1, 1, 1];
		$modules[] = [0, 1, 1];
		$modules[] = [1, 1, 2];
		$modules[] = [0, 1, 1];
		$modules[] = [1, 1, 2];
		$modules[] = [0, 1, 1];
		$modules[] = [1, 1, 1];

		$blocks = [['m' => $modules, 'l' => [$label]]];
		return ['b' => $blocks];
	}
}
