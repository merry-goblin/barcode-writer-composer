<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode\Format;

interface BarcodeFormatInterface
{
	/**
	 * @return bool
	 */
	function canRenderAResource();

	/**
	 * @return bool
	 */
	function canRenderAString();

	/**
	 * @return string
	 */
	function getContentType();

	/**
	 * @param resource $image
	 * @return void
	 * @throws ResourceRenderingNotAllowedException
	 */
	function outputResource($image);
}
