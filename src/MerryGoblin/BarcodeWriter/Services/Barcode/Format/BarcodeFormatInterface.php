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
	 * @return string
	 */
	function getRawContentType();

	/**
	 * @param resource $image
	 * @return void
	 * @throws ResourceRenderingNotAllowedException
	 */
	function outputResource($image);

	/**
	 * @param string $image
	 * @return void
	 * @throws StringRenderingNotAllowedException
	 */
	function outputString($image);

	/**
	 * @param resource $image
	 * @return false|string
	 */
	function getResourceContent($image);
}
