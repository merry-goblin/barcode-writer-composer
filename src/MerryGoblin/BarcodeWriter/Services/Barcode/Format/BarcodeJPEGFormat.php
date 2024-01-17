<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Format;

class BarcodeJPEGFormat extends AbstractBarcodeFormat implements BarcodeFormatInterface
{
	protected $resourceRenderingIsAllowed = true;
	protected $stringRenderingIsAllowed = true;
	protected $contentType = 'image/jpeg';

	/**
	 * @param resource $image
	 * @return void
	 */
	public function outputResource($image)
	{
		header($this->getContentType());
		imagejpeg($image);
		imagedestroy($image);
	}

	/**
	 * @param string $image
	 * @return void
	 * @throws StringRenderingNotAllowedException
	 */
	function outputString($image)
	{
		throw new StringRenderingNotAllowedException();
	}
}