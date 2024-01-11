<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Format;

abstract class AbstractBarcodeFormat
{
	protected $resourceRenderingIsAllowed = false;
	protected $stringRenderingIsAllowed = false;
	protected $contentType = '';

	/**
	 * @return bool
	 */
	public function canRenderAResource()
	{
		return $this->resourceRenderingIsAllowed;
	}

	/**
	 * @return bool
	 */
	public function canRenderAString()
	{
		return $this->stringRenderingIsAllowed;
	}

	/**
	 * @return string
	 */
	public function getContentType()
	{
		return 'Content-Type: '.$this->contentType;
	}
}