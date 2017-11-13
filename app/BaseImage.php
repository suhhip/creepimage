<?php
namespace App;

class BaseImage
{
	private $filePath;
	private $image;

	/**
	 * @var integer   Width of image
	 */
	public $width;

	/**
	 * @var integer   Height of image
	 */
	public $height;

	/**
	 * Load image file
	 *
	 * @param string $filePath   Image file path
	 *
	 * @return boolean
	 */
	public function loadFile($filePath)
	{
		$this->filePath = $filePath;

		switch ($this->getMimeType()) {
			case 'image/png':
				$this->image = imagecreatefrompng($filePath);
				break;

			case 'image/jpg':
			case 'image/jpeg':
				$this->image = imagecreatefromjpeg($filePath);
				break;

			default:
				return false;
		}

		$this->width    = imagesx($this->image);
		$this->height   = imagesy($this->image);

		return ($this->width && $this->height);
	}

	/**
	 * Get image
	 *
	 * @return resource
	 */
	public function getImage()
	{
		return $this->image;
	}

	/**
	 * Get image mime type
	 *
	 * @return string
	 */
	public function getMimeType()
	{
		return image_type_to_mime_type(
			exif_imagetype($this->filePath)
		);
	}

	/**
	 * Change pixel color
	 *
	 * @param integer $x       X-coordinate
	 * @param integer $y       Y-coordinate
	 * @param array   $color   RGB array
	 *
	 * @return boolean
	 */
	public function setPixelColor($x, $y, array $color)
	{
		if (!$this->validateCoordinates($x, $y)) {
			return false;
		}

		$newColor = imagecolorallocate($this->image, $color[0], $color[1], $color[2]);

		imagesetpixel($this->image, $x, $y, $newColor);

		return true;
	}

	/**
	 * Get pixel color
	 *
	 * @param integer $x   X-coordinate
	 * @param integer $y   Y-coordinate
	 *
	 * @return array   RGB array
	 */
	public function colorAt($x, $y)
	{
		if (!self::validateCoordinates($x, $y)) {
			return [0, 0, 0];
		}

		$rgb = imagecolorat($this->image, $x, $y);
		$rgb = self::colorToRGB($rgb);

		return $rgb;
	}

	/**
	 * Validate XY coordinates
	 *
	 * @param integer $x   X-coordinate
	 * @param integer $y   Y-coordinate
	 *
	 * @return boolean
	 */
	private function validateCoordinates($x, $y)
	{
		return (
			$x >= 0 && $y >= 0
			&& $x < $this->width && $y < $this->height
		);
	}

	/**
	 * Convert color index to RGB array
	 *
	 * @param integer $color   The index of a color
	 *
	 * @return array
	 */
	private static function colorToRGB($color)
	{
		return [
			($color >> 16) & 0xFF,
			($color >> 8) & 0xFF,
			$color & 0xFF,
		];
	}
}
