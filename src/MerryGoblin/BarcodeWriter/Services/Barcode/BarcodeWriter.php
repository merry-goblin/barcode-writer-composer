<?php

/**
 * @link https://github.com/merry-goblin/barcode-writer-composer
 */

namespace MerryGoblin\BarcodeWriter\Services\Barcode;

use MerryGoblin\BarcodeWriter\Services\Barcode\Format\BarcodeFormatHelper;
use MerryGoblin\BarcodeWriter\Services\Barcode\Format\BarcodeFormatInterface;
use MerryGoblin\BarcodeWriter\Services\Barcode\Type\BarcodeTypeHelper;
use MerryGoblin\BarcodeWriter\Services\Barcode\Type\BarcodeTypeInterface;
use MerryGoblin\BarcodeWriter\Services\Barcode\Encoder\BarcodeEncoderHelper;
use MerryGoblin\BarcodeWriter\Services\Barcode\Encoder\BarcodeEncoderInterface;

use MerryGoblin\BarcodeWriter\Services\Barcode\Format\BarcodeFormatNotHandledException;
use MerryGoblin\BarcodeWriter\Services\Barcode\Format\ResourceRenderingNotAllowedException;
use MerryGoblin\BarcodeWriter\Services\Barcode\Format\StringRenderingNotAllowedException;
use MerryGoblin\BarcodeWriter\Services\Barcode\Type\BarcodeTypeNotHandledException;
use MerryGoblin\BarcodeWriter\Services\Barcode\Encoder\BarcodeEncoderNotHandledException;

class BarcodeWriter
{
	public function __construct()
	{

	}

	/**
	 * @param string $format
	 * @param string $type
	 * @param string $data
	 * @return resource
	 * @throws BarcodeFormatNotHandledException
	 * @throws ResourceRenderingNotAllowedException
	 */
	public function renderImage($format, $type, $data)
	{
		//	Barcode format
		$barcodeFormat = $this->getBarcodeFormat($format);
		if (!$barcodeFormat->canRenderAResource()) {
			throw new ResourceRenderingNotAllowedException();
		}

		//	Type
		$barcodeType = $this->getBarcodeType($type);

		//	Encoder
		$barcodeEncoder = $this->getBarcodeEncoder($barcodeType->getEncoderName());

		var_dump($barcodeEncoder->getShapeName());
		exit();

		$image = imagecreatetruecolor(1, 1);
		return $image;
	}

	/**
	 * @param string $format
	 * @param string $type
	 * @param string $data
	 * @return string
	 * @throws BarcodeFormatNotHandledException
	 * @throws StringRenderingNotAllowedException
	 */
	public function renderString($format, $type, $data)
	{
		//	Barcode format
		$barcodeFormat = $this->getBarcodeFormat($format);
		if (!$barcodeFormat->canRenderAString()) {
			throw new StringRenderingNotAllowedException();
		}

		return '';
	}

	/**
	 * @param string $format
	 * @param string $type
	 * @param string $data
	 * @return void
	 * @throws BarcodeFormatNotHandledException
	 */
	public function output($format, $type, $data)
	{
		//	Barcode format
		$barcodeFormat = $this->getBarcodeFormat($format);
		// TODO
	}

	/**
	 * @param string $format
	 * @return BarcodeFormatInterface
	 * @throws BarcodeFormatNotHandledException
	 */
	private function getBarcodeFormat($format)
	{
		return BarcodeFormatHelper::getBarcodeFormat($format);
	}

	/**
	 * @param string $type
	 * @return BarcodeTypeInterface
	 * @throws BarcodeTypeNotHandledException
	 */
	private function getBarcodeType($type)
	{
		return BarcodeTypeHelper::getBarcodeType($type);
	}

	/**
	 * @param string $encoder
	 * @return BarcodeEncoderInterface
	 * @throws BarcodeEncoderNotHandledException
	 */
	private function getBarcodeEncoder($encoder)
	{
		return BarcodeEncoderHelper::getBarcodeEncoder($encoder);
	}
}