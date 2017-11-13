<?php
namespace App;

class CreepImage
{
	/**
	 * @var integer
	 */
	const PIXELDIFF = 5;

	/**
	 * @var integer
	 */
	const PIXELS_FOR_SIZE = 7;

	/**
	 * @var BaseImage   BaseImage object
	 */
	protected $image;

	/**
	 * @var integer   X-coordinate pointer
	 */
	protected $posX = 0;

	/**
	 * @var integer   Y-coordinate pointer
	 */
	protected $posY = 0;

	/**
	 * Load BaseImage object
	 *
	 * @param BaseImage $image   BaseImage object
	 *
	 * @return void
	 */
	public function loadImage(BaseImage &$image)
	{
		$this->image = $image;

		return;
	}

	/**
	 * Change color of pixel at actual coordinates
	 *
	 * @param array $rgb   RGB array
	 *
	 * @return boolean
	 */
	protected function setActualPixel(array $rgb)
	{
		return $this->image->setPixelColor($this->posX, $this->posY, $rgb);
	}

	/**
	 * Get color of pixel at actual coordinates
	 *
	 * @return array   RGB array
	 */
	protected function getActualPixel()
	{
		return $this->image->colorAt($this->posX, $this->posY);
	}

	/**
	 * Step coordinate-pointers to the next pixel
	 *
	 * @return void
	 */
	protected function stepPixel()
	{
		++$this->posX;
		if ($this->posX >= $this->image->width) {
			$this->posX = 0;
			++$this->posY;
		}

		return;
	}

	/**
	 * Reset coordinate-pointers
	 *
	 * @return void
	 */
	protected function resetPosition()
	{
		$this->posX = 0;
		$this->posY = 0;

		return;
	}

	/**
	 * Calculate the maximum size allowed by the set parameters
	 *
	 * @return integer
	 */
	public static function getSystemMaxSize()
	{
		return pow(2, self::PIXELS_FOR_SIZE * 3 - 1) - 1;
	}
}
