<?php

namespace MerryGoblin\BarcodeWriter\Services\Barcode;

class BarcodeConfig
{
	public $w = null;
	public $h = null;
	public $sf = null;
	public $sx = null;
	public $sy = null;
	public $p = null;
	public $pv = null;
	public $ph = null;
	public $pt = null;
	public $pl = null;
	public $pr = null;
	public $pb = null;

	public $wq = null;
	public $wm = null;
	public $ww = null;
	public $wn = null;
	public $w4 = null;
	public $w5 = null;
	public $w6 = null;
	public $w7 = null;
	public $w8 = null;
	public $w9 = null;

	public $ms = null;
	public $md = null;

	public $displayLabel = false; // Allow label to be displayed
	public $th = null;
	public $tf = null;
	public $ts = null;

	public $bc = null;
	public $cs = null;
	public $cm = null;
	public $c2 = null;
	public $c3 = null;
	public $c4 = null;
	public $c5 = null;
	public $c6 = null;
	public $c7 = null;
	public $c8 = null;
	public $c9 = null;

	public $tc = null;

	/**
	 * Can be initialized from the very start
	 * @return void
	 */
	public function init()
	{
		$this->wq = (!is_null($this->wq)) ? (int)$this->wq : 1;
		$this->wm = (!is_null($this->wm)) ? (int)$this->wm : 1;
		$this->ww = (!is_null($this->ww)) ? (int)$this->ww : 3;
		$this->wn = (!is_null($this->wn)) ? (int)$this->wn : 1;
		$this->w4 = (!is_null($this->w4)) ? (int)$this->w4 : 1;
		$this->w5 = (!is_null($this->w5)) ? (int)$this->w5 : 1;
		$this->w6 = (!is_null($this->w6)) ? (int)$this->w6 : 1;
		$this->w7 = (!is_null($this->w7)) ? (int)$this->w7 : 1;
		$this->w8 = (!is_null($this->w8)) ? (int)$this->w8 : 1;
		$this->w9 = (!is_null($this->w9)) ? (int)$this->w9 : 1;
	}

	/**
	 * Can be initialized once format is known
	 * @param $format
	 * @return void
	 */
	public function initFormat($format)
	{
		$format = strtolower($format);
		switch ($format) {
			case 'png':
			case 'jpeg':
			case 'jpg':
			case 'gif':
				$this->initImage();
				break;
			case 'svg':
				$this->initXML();
				break;
		}
	}

	/**
	 * @return void
	 */
	public function initImage()
	{
		$this->bc = (!is_null($this->bc)) ? $this->bc : 'FFF';
		$this->cs = (!is_null($this->cs)) ? $this->cs : '';
		$this->cm = (!is_null($this->cm)) ? $this->cm : '000';
		$this->c2 = (!is_null($this->c2)) ? $this->c2 : 'F00';
		$this->c3 = (!is_null($this->c3)) ? $this->c3 : 'FF0';
		$this->c4 = (!is_null($this->c4)) ? $this->c4 : '0F0';
		$this->c5 = (!is_null($this->c5)) ? $this->c5 : '0FF';
		$this->c6 = (!is_null($this->c6)) ? $this->c6 : '00F';
		$this->c7 = (!is_null($this->c7)) ? $this->c7 : 'F0F';
		$this->c8 = (!is_null($this->c8)) ? $this->c8 : 'FFF';
		$this->c9 = (!is_null($this->c9)) ? $this->c9 : '000';
	}

	/**
	 * @return void
	 */
	public function initXML()
	{
		$this->bc = (!is_null($this->bc)) ? $this->bc : 'white';
		$this->cs = (!is_null($this->cs)) ? $this->cs : '';
		$this->cm = (!is_null($this->cm)) ? $this->cm : 'black';
		$this->c2 = (!is_null($this->c2)) ? $this->c2 : '#FF0000';
		$this->c3 = (!is_null($this->c3)) ? $this->c3 : '#FFFF00';
		$this->c4 = (!is_null($this->c4)) ? $this->c4 : '#00FF00';
		$this->c5 = (!is_null($this->c5)) ? $this->c5 : '#00FFFF';
		$this->c6 = (!is_null($this->c6)) ? $this->c6 : '#0000FF';
		$this->c7 = (!is_null($this->c7)) ? $this->c7 : '#FF00FF';
		$this->c8 = (!is_null($this->c8)) ? $this->c8 : 'white';
		$this->c9 = (!is_null($this->c9)) ? $this->c9 : 'black';
	}

	/**
	 * Can be initialized once shape & format are known
	 * @param string $shape
	 * @param string $format
	 * @return void
	 */
	public function initShapeAndFormat($shape, $format)
	{
		$shape = strtolower($shape);
		$format = strtolower($format);
		if ($shape === 'linear') {
			switch ($format) {
				case 'png':
				case 'jpeg':
				case 'jpg':
				case 'gif':
					$this->initLinearImage();
					break;
				case 'svg':
					$this->initLinearXML();
					break;
			}
		} elseif ($shape === 'matrix') {
			switch ($format) {
				case 'png':
				case 'jpeg':
				case 'jpg':
				case 'gif':
					$this->initMatrixImage();
					break;
				case 'svg':
					$this->initMatrixXML();
					break;
			}
		}
	}

	/**
	 * @return void
	 */
	public function initLinearImage()
	{
		$this->th = (!is_null($this->th)) ? $this->th : 10;
		$this->ts = (!is_null($this->ts)) ? $this->ts : 1;
		$this->tc = (!is_null($this->tc)) ? $this->tc : '000';
	}

	/**
	 * @return void
	 */
	public function initLinearXML()
	{
		$this->th = (!is_null($this->th)) ? $this->th : 10;
		$this->tf = (!is_null($this->tf)) ? $this->tf : 'monospace';
		$this->ts = (!is_null($this->ts)) ? $this->ts : 10;
		$this->tc = (!is_null($this->tc)) ? $this->tc : 'black';
	}

	/**
	 * @return void
	 */
	public function initMatrixImage()
	{
		$this->ms = (!is_null($this->ms)) ? strtolower($this->ms) : '';
		$this->md = (!is_null($this->md)) ? (float)$this->md : 1.0;
	}

	/**
	 * @return void
	 */
	public function initMatrixXML()
	{
		$this->ms = (!is_null($this->ms)) ? strtolower($this->ms) : '';
		$this->md = (!is_null($this->md)) ? (float)$this->md : 1.0;
	}
}