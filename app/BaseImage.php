<?php
namespace App;

class BaseImage implements Interfaces\BaseImage
{
	private $filePath;
	private $image;

	/**
	 * @var integer   Width of image
	 */
	private $width;

	/**
	 * @var integer   Height of image
	 */
	private $height;

    /**
     * {@inheritDoc}
     * @see \App\Interfaces\BaseImage::loadFile()
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
     * {@inheritDoc}
     * @see \App\Interfaces\BaseImage::getImage()
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * {@inheritDoc}
     * @see \App\Interfaces\BaseImage::getWidth()
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * {@inheritDoc}
     * @see \App\Interfaces\BaseImage::getHeight()
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * {@inheritDoc}
     * @see \App\Interfaces\BaseImage::getMimeType()
     */
	public function getMimeType()
	{
		return image_type_to_mime_type(
			exif_imagetype($this->filePath)
		);
	}

    /**
     * {@inheritDoc}
     * @see \App\Interfaces\BaseImage::setPixelColor()
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
     * {@inheritDoc}
     * @see \App\Interfaces\BaseImage::colorAt()
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
