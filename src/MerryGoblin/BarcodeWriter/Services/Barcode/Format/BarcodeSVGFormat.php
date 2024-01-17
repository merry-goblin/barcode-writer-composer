<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Format;

class BarcodeSVGFormat extends AbstractBarcodeFormat implements BarcodeFormatInterface
{
	protected $resourceRenderingIsAllowed = false;
	protected $stringRenderingIsAllowed = true;
	protected $contentType = 'image/svg+xml';

	/**
	 * @param resource $image
	 * @return void
	 * @throws ResourceRenderingNotAllowedException
	 */
	public function outputResource($image)
	{
		throw new ResourceRenderingNotAllowedException();
	}

	/**
	 * @param string $image
	 * @return void
	 */
	public function outputString($image)
	{
		header($this->getContentType());
		echo $image;
	}
}