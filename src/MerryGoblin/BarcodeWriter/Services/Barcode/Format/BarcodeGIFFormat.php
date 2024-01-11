<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Format;

class BarcodeGIFFormat extends AbstractBarcodeFormat implements BarcodeFormatInterface
{
	protected $resourceRenderingIsAllowed = true;
	protected $stringRenderingIsAllowed = true;
	protected $contentType = 'image/gif';

	/**
	 * @param resource $image
	 * @return void
	 */
	public function outputResource($image)
	{
		header($this->getContentType());
		imagegif($image);
		imagedestroy($image);
	}
}