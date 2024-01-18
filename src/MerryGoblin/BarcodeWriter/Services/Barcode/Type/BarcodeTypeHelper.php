<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Type;

class BarcodeTypeHelper
{
	const TYPE_UPC_A = 'UPCA';
	const TYPE_UPC_E = 'UPCE';
	const TYPE_EAN_2 = 'EAN2'; // Not handled
	const TYPE_EAN_5 = 'EAN5'; // Not handled
	const TYPE_EAN_8 = 'EAN8';
	const TYPE_EAN_13 = 'EAN13';
	const TYPE_EAN_13_NO_PAD = 'EAN13NOPAD';
	const TYPE_EAN_13_PAD = 'EAN13PAD';
	const TYPE_EAN_128 = 'EAN128';
	const TYPE_EAN_128_A = 'EAN128A';
	const TYPE_EAN_128_B = 'EAN128B';
	const TYPE_EAN_128_C = 'EAN128C';
	const TYPE_EAN_128_AC = 'EAN128AC';
	const TYPE_EAN_128_BC = 'EAN128BC';
	const TYPE_CODE_11 = 'CODE11'; // Not handled
	const TYPE_CODE_39 = 'C39';
	const TYPE_CODE_39_ASCII = 'C39ASCII';
	const TYPE_CODE_39_CHECKSUM = 'C39+'; // Not handled
	const TYPE_CODE_39E = 'C39E'; // Not handled
	const TYPE_CODE_39E_CHECKSUM = 'C39E+'; // Not handled
	const TYPE_CODE_93 = 'C93';
	const TYPE_CODE_93_ASCII = 'C93ASCII';
	const TYPE_CODE_128 = 'C128';
	const TYPE_CODE_128_A = 'C128A';
	const TYPE_CODE_128_B = 'C128B';
	const TYPE_CODE_128_C = 'C128C';
	const TYPE_CODE_128_AC = 'C128AC';
	const TYPE_CODE_128_BC = 'C128BC';
	const TYPE_STANDARD_2_5 = 'S25'; // Not handled
	const TYPE_STANDARD_2_5_CHECKSUM = 'S25+'; // Not handled
	const TYPE_INTERLEAVED_2_5 = 'I25'; // Not handled
	const TYPE_INTERLEAVED_2_5_CHECKSUM = 'I25+'; // Not handled
	const TYPE_MSI = 'MSI'; // Not handled
	const TYPE_MSI_CHECKSUM = 'MSI+'; // Not handled
	const TYPE_POSTNET = 'POSTNET'; // Not handled
	const TYPE_PLANET = 'PLANET'; // Not handled
	const TYPE_RMS4CC = 'RMS4CC'; // Not handled
	const TYPE_KIX = 'KIX'; // Not handled
	const TYPE_IMB = 'IMB'; // Not handled
	const TYPE_CODABAR = 'CODABAR'; // Not handled
	const TYPE_PHARMA_CODE = 'PHARMA'; // Not handled
	const TYPE_PHARMA_CODE_TWO_TRACKS = 'PHARMA2T'; // Not handled

	/**
	 * @param string $type
	 * @return BarcodeTypeInterface
	 * @throws BarcodeTypeNotHandledException
	 */
	public static function getBarcodeType($type)
	{
		$barcodeType = null;
		$type = strtolower(preg_replace('/[^A-Za-z0-9]/', '', $type));
		switch ($type) {
			case 'upca':
				$barcodeType = new UPCAType();
				break;
			case 'upce':
				$barcodeType = new UPCEType();
				break;
			case 'ean8':
				$barcodeType = new EAN8Type();
				break;
			case 'ean13':
				$barcodeType = new EAN13Type();
				break;
			case 'ean13nopad':
				$barcodeType = new EAN13NoPadType();
				break;
			case 'ean13pad':
				$barcodeType = new EAN13PadType();
				break;
			case 'c39':
			case 'code39':
				$barcodeType = new Code39Type();
				break;
			case 'c39ascii':
			case 'code39ascii':
				$barcodeType = new Code39AsciiType();
				break;
			case 'c93':
			case 'code93':
				$barcodeType = new Code93Type();
				break;
			case 'c93ascii':
			case 'code93ascii':
				$barcodeType = new Code93AsciiType();
				break;
			case 'c128':
			case 'code128':
				$barcodeType = new Code128Type();
				break;
			case 'c128a':
			case 'code128a':
				$barcodeType = new Code128AType();
				break;
			case 'c128b':
			case 'code128b':
				$barcodeType = new Code128BType();
				break;
			case 'c128c':
			case 'code128c':
				$barcodeType = new Code128CType();
				break;
			case 'c128ac':
			case 'code128ac':
				$barcodeType = new Code128ACType();
				break;
			case 'c128bc':
			case 'code128bc':
				$barcodeType = new Code128BCType();
				break;
			case 'ean128':
				$barcodeType = new EAN128Type();
				break;
			case 'ean128a':
				$barcodeType = new EAN128AType();
				break;
			case 'ean128b':
				$barcodeType = new EAN128BType();
				break;
			case 'ean128c':
				$barcodeType = new EAN128CType();
				break;
			case 'ean128ac':
				$barcodeType = new EAN128ACType();
				break;
			case 'ean128bc':
				$barcodeType = new EAN128BCType();
				break;
		}

		if (is_null($barcodeType)) {
			throw new BarcodeTypeNotHandledException();
		}

		return $barcodeType;
	}
}