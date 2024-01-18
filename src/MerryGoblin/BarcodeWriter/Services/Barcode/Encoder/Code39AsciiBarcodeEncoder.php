<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Encoder;

use MerryGoblin\BarcodeWriter\Services\Barcode\Shape\AbstractBarcodeShape;
use MerryGoblin\BarcodeWriter\Services\Barcode\Type\BarcodeTypeInterface;

class Code39AsciiBarcodeEncoder extends Code93BarcodeEncoder implements BarcodeEncoderInterface
{
	protected $shapeName = BarcodeShapeHelper::SHAPE_LINEAR;

	protected $asciiAlphabet = [
		'&U', '#A', '#B', '#C', '#D', '#E', '#F', '#G',
		'#H', '#I', '#J', '#K', '#L', '#M', '#N', '#O',
		'#P', '#Q', '#R', '#S', '#T', '#U', '#V', '#W',
		'#X', '#Y', '#Z', '&A', '&B', '&C', '&D', '&E',
		' ' , '|A', '|B', '|C', '$' , '%' , '|F', '|G',
		'|H', '|I', '|J', '+' , '|L', '-' , '.' , '/' ,
		'0' , '1' , '2' , '3' , '4' , '5' , '6' , '7' ,
		'8' , '9' , '|Z', '&F', '&G', '&H', '&I', '&J',
		'&V', 'A' , 'B' , 'C' , 'D' , 'E' , 'F' , 'G' ,
		'H' , 'I' , 'J' , 'K' , 'L' , 'M' , 'N' , 'O' ,
		'P' , 'Q' , 'R' , 'S' , 'T' , 'U' , 'V' , 'W' ,
		'X' , 'Y' , 'Z' , '&K', '&L', '&M', '&N', '&O',
		'&W', '=A', '=B', '=C', '=D', '=E', '=F', '=G',
		'=H', '=I', '=J', '=K', '=L', '=M', '=N', '=O',
		'=P', '=Q', '=R', '=S', '=T', '=U', '=V', '=W',
		'=X', '=Y', '=Z', '&P', '&Q', '&R', '&S', '&T',
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
		$modules[] = [0, 1, 1];
		$modules[] = [1, 1, 1];
		$modules[] = [0, 1, 1];
		$modules[] = [1, 4, 1];
		$modules[] = [0, 1, 1];
		/* Data */
		$label = '';
		$values = [];
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
					$modules[] = [1, $b[0], 1];
					$modules[] = [0, $b[1], 1];
					$modules[] = [1, $b[2], 1];
					$modules[] = [0, $b[3], 1];
					$modules[] = [1, $b[4], 1];
					$modules[] = [0, $b[5], 1];
					$values[] = $b[6];
				}
			}
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
		$blocks = [['m' => $modules, 'l' => [$label]]];
		return ['b' => $blocks];
	}
}
