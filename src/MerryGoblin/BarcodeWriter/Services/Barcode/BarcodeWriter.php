<?php

/**
 * @link https://github.com/merry-goblin/barcode-writer-composer
 */

namespace MerryGoblin\BarcodeWriter\Services\Barcode;

use MerryGoblin\BarcodeWriter\Services\Barcode\Encoder\BarcodeEncoderHelper;
use MerryGoblin\BarcodeWriter\Services\Barcode\Encoder\BarcodeEncoderInterface;
use MerryGoblin\BarcodeWriter\Services\Barcode\Format\BarcodeFormatHelper;
use MerryGoblin\BarcodeWriter\Services\Barcode\Format\BarcodeFormatInterface;
use MerryGoblin\BarcodeWriter\Services\Barcode\Shape\BarcodeShapeHelper;
use MerryGoblin\BarcodeWriter\Services\Barcode\Shape\BarcodeShapeInterface;
use MerryGoblin\BarcodeWriter\Services\Barcode\Type\BarcodeTypeHelper;
use MerryGoblin\BarcodeWriter\Services\Barcode\Type\BarcodeTypeInterface;
use MerryGoblin\BarcodeWriter\Services\Barcode\Image\BarcodeImageRendererHelper;
use MerryGoblin\BarcodeWriter\Services\Barcode\Image\BarcodeImageRendererInterface;

use MerryGoblin\BarcodeWriter\Services\Barcode\Encoder\BarcodeEncoderNotHandledException;
use MerryGoblin\BarcodeWriter\Services\Barcode\Format\BarcodeFormatNotHandledException;
use MerryGoblin\BarcodeWriter\Services\Barcode\Format\ResourceRenderingNotAllowedException;
use MerryGoblin\BarcodeWriter\Services\Barcode\Format\StringRenderingNotAllowedException;
use MerryGoblin\BarcodeWriter\Services\Barcode\Shape\BarcodeShapeNotHandledException;
use MerryGoblin\BarcodeWriter\Services\Barcode\Type\BarcodeTypeNotHandledException;

class BarcodeWriter
{
	/**
	 * @var BarcodeFormatInterface
	 */
	private $lastBarcodeFormat;

	public function __construct()
	{

	}

	/**
	 * @param string $format
	 * @param string $type
	 * @param string $data
	 * @param BarcodeConfig|null $barcodeConfig
	 * @return resource
	 * @throws BarcodeEncoderNotHandledException
	 * @throws BarcodeFormatNotHandledException
	 * @throws BarcodeShapeNotHandledException
	 * @throws BarcodeTypeNotHandledException
	 * @throws ResourceRenderingNotAllowedException
	 */
	public function renderResource($format, $type, $data, BarcodeConfig $barcodeConfig = null)
	{
		$barcodeConfig = (!is_null($barcodeConfig)) ? $barcodeConfig : new BarcodeConfig();
		$barcodeConfig->init();

		//	Barcode format
		$barcodeFormat = $this->getBarcodeFormat($format);
		$this->lastBarcodeFormat = $barcodeFormat;
		if (!$barcodeFormat->canRenderAResource()) {
			throw new ResourceRenderingNotAllowedException();
		}
		$barcodeConfig->initFormat($format);

		//	Type
		$barcodeType = $this->getBarcodeType($type);

		//	Encoder
		$barcodeEncoder = $this->getBarcodeEncoder($barcodeType->getEncoderName());
		$encodedData = $barcodeEncoder->encode($data, $barcodeType);

		//	Shape
		$barcodeShape = $this->getBarcodeShape($barcodeEncoder->getShapeName());
		$barcodeConfig->initShapeAndFormat($barcodeEncoder->getShapeName(), $format);
		$dimensions = $barcodeShape->build($encodedData, $barcodeConfig);

		//	Image Renderer
		$barcodeImageRenderer = $this->getBarcodeImageRenderer($barcodeEncoder->getShapeName(), $format);
		return $barcodeImageRenderer->renderResource($encodedData, $dimensions, $barcodeConfig);
	}

	/**
	 * @param string $format
	 * @param string $type
	 * @param string $data
	 * @param BarcodeConfig|null $barcodeConfig
	 * @return string
	 * @throws BarcodeEncoderNotHandledException
	 * @throws BarcodeFormatNotHandledException
	 * @throws BarcodeShapeNotHandledException
	 * @throws StringRenderingNotAllowedException
	 */
	public function renderString($format, $type, $data, BarcodeConfig $barcodeConfig = null)
	{
		//	Barcode format
		$barcodeFormat = $this->getBarcodeFormat($format);
		if ($barcodeFormat->canRenderAResource()) {
			//	Shortcut: use renderResource method then get the output of this resource in a buffer
			$resource = $this->renderResource($format, $type, $data, $barcodeConfig);
			$imageContent = $barcodeFormat->getResourceContent($resource);
		} else {
			if (!$barcodeFormat->canRenderAString()) {
				throw new StringRenderingNotAllowedException();
			}
			$this->lastBarcodeFormat = $barcodeFormat;

			$barcodeConfig = (!is_null($barcodeConfig)) ? $barcodeConfig : new BarcodeConfig();
			$barcodeConfig->init();

			$barcodeConfig->initFormat($format);

			//	Type
			$barcodeType = $this->getBarcodeType($type);

			//	Encoder
			$barcodeEncoder = $this->getBarcodeEncoder($barcodeType->getEncoderName());
			$encodedData = $barcodeEncoder->encode($data, $barcodeType);

			//	Shape
			$barcodeShape = $this->getBarcodeShape($barcodeEncoder->getShapeName());
			$barcodeConfig->initShapeAndFormat($barcodeEncoder->getShapeName(), $format);
			$dimensions = $barcodeShape->build($encodedData, $barcodeConfig);

			//	Image Renderer
			$barcodeImageRenderer = $this->getBarcodeImageRenderer($barcodeEncoder->getShapeName(), $format);
			$imageContent = $barcodeImageRenderer->renderString($encodedData, $dimensions, $barcodeConfig);
		}
		return $imageContent;
	}

	/**
	 * @param string $format
	 * @param string $type
	 * @param string $data
	 * @param BarcodeConfig|null $barcodeConfig
	 * @return string
	 * @throws BarcodeEncoderNotHandledException
	 * @throws BarcodeFormatNotHandledException
	 * @throws BarcodeShapeNotHandledException
	 * @throws StringRenderingNotAllowedException
	 */
	public function renderImageSource($format, $type, $data, BarcodeConfig $barcodeConfig = null)
	{
		$imageContent = $this->renderString($format, $type, $data, $barcodeConfig);
		return 'data:'.$this->lastBarcodeFormat->getRawContentType().';base64,'.base64_encode($imageContent);
	}

	/**
	 * @param string $format
	 * @param string $type
	 * @param string $data
	 * @param BarcodeConfig|null $barcodeConfig
	 * @return void
	 * @throws BarcodeEncoderNotHandledException
	 * @throws BarcodeFormatNotHandledException
	 * @throws BarcodeShapeNotHandledException
	 * @throws ResourceRenderingNotAllowedException
	 */
	public function output($format, $type, $data, BarcodeConfig $barcodeConfig = null)
	{
		try {
			$resource = $this->renderResource($format, $type, $data, $barcodeConfig);
			if (!is_null($this->lastBarcodeFormat)) {
				$this->lastBarcodeFormat->outputResource($resource);
			}
		} catch (ResourceRenderingNotAllowedException $e) {
			try {
				$imageAsString = $this->renderString($format, $type, $data, $barcodeConfig);
				if (!is_null($this->lastBarcodeFormat)) {
					$this->lastBarcodeFormat->outputString($imageAsString);
				}
			} catch (StringRenderingNotAllowedException $e) {

			}
		}
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

	/**
	 * @param string $shape
	 * @return BarcodeShapeInterface
	 * @throws BarcodeShapeNotHandledException
	 */
	private function getBarcodeShape($shape)
	{
		return BarcodeShapeHelper::getBarcodeShape($shape);
	}

	/**
	 * @param string $shape
	 * @param string $format
	 * @return BarcodeImageRendererInterface
	 * @throws BarcodeFormatNotHandledException
	 * @throws BarcodeShapeNotHandledException
	 */
	private function getBarcodeImageRenderer($shape, $format)
	{
		return BarcodeImageRendererHelper::getBarcodeImageRenderer($shape, $format);
	}

}