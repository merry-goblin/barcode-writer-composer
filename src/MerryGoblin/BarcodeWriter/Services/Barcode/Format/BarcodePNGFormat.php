<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Format;

class BarcodePNGFormat extends AbstractBarcodeFormat implements BarcodeFormatInterface
{
	protected $resourceRenderingIsAllowed = true;
	protected $stringRenderingIsAllowed = true;
	protected $contentType = 'image/png';

	/**
	 * @param resource $image
	 * @return void
	 */
	public function outputResource($image, $applyContentTypeInHeader = true)
	{
		if ($applyContentTypeInHeader) {
			header($this->getContentType());
		}
		imagepng($image);
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