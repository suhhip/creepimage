<?php
namespace App;

class EnCreeptor extends CreepImage {
	/**
	 * @var integer   Max byte length
	 */
	protected $maxSize;

	/**
	 * @var array   Deciaml values of the loadded data
	 */
	private $dataBytes;

	/**
	 * @var integer   Loaded data size
	 */
	private $dataSize;

	/**
	 * {@inheritDoc}
	 * @see \App\CreepImage::loadImage()
	 */
	public function loadImage(BaseImage &$image)
	{
		$response = parent::loadImage($image);

		$this->maxSize = $this->calculateMaxSize();

		return $response;
	}

	/**
	 * Load data
	 *
	 * @param string $data   Creeptable data
	 *
	 * @return boolean
	 */
	public function loadData($data)
	{
		$bytes   = ByteFunctions::stringToDecimal($data);
		$size    = count($bytes);

		if ($size > $this->maxSize) {
			return false;
		}

		$this->dataSize    = $size;
		$this->dataBytes   = $bytes;

		return true;
	}

	/**
	 * Run EnCreepter
	 *
	 * @return void
	 */
	public function run()
	{
		$this->normalizeBytePixels(self::PIXELDIFF);

		// Draw size pixels
		$binary = self::splitToPixels($this->dataSize, self::PIXELS_FOR_SIZE);
		$this->drawBinaryGroup($binary);

		// Draw data
		foreach ($this->dataBytes as $bK => $byte) {
			$binary = self::splitToPixels($byte);
			$this->drawBinaryGroup($binary);
		}

		return;
	}

	/**
	 * Draw binaries to image
	 *
	 * @param array $binaries   Binary array
	 */
	private function drawBinaryGroup($binaries)
	{
		$controlLevel = null;

		foreach ($binaries as $pixelIndex => $values) {
			if ($pixelIndex === 0) {
				$colors = $this->getActualPixel();

				$controlLevel = $colors[0];
			}

			if (!in_array(1, $values)) {
				$this->stepPixel();
				continue;
			}

			if ($pixelIndex !== 0) {
				$colors = $this->getActualPixel();
			}

			$origColors = $colors;

			foreach ($values as $colorIndex => $value) {
				if (!$value) {
					continue;
				}

				self::setColorAsBit($controlLevel, $colors[$colorIndex]);
			}

			$this->setActualPixel($colors);
			$this->stepPixel();
		}
	}

	/**
	 * Split decimal value to pixels
	 *
	 * @param integer $integer   Decimal value
	 * @param integer $pixels    Number of pixels
	 *
	 * @return array[]
	 */
	private static function splitToPixels($integer, $pixels = 3)
	{
		$binary = ByteFunctions::decimalToBinary($integer, $pixels * 3 - 1);

		$pixelIndex = 0;
		$colorIndex = 1;

		$pixels = [
			[]
		];

		foreach ($binary as $key => $value) {
			if ($key % 3 === 2) {
				++$pixelIndex;
				$colorIndex = 0;

				$pixels[$pixelIndex] = [];
			}

			$pixels[$pixelIndex][$colorIndex] = $value;

			++$colorIndex;
		}

		return $pixels;
	}

	/**
	 * Set color as bit
	 *
	 * @param integer $controlLevel   Bit control level
	 * @param integer $color          Actual color
	 */
	private static function setColorAsBit($controlLevel, &$color)
	{
		$color = $controlLevel + self::PIXELDIFF;
		if ($color > 255) {
			$color -= (2 * self::PIXELDIFF);
		}

		return;
	}


	/**
	 * ...
	 *
	 * @return void
	 */
	private function normalizeBytePixels()
	{
		$first = true;

		// TODO <suhi>: this
		$iTo = $this->dataSize + self::PIXELS_FOR_SIZE;

		for ($i = 0; $i < $iTo; ++$i) {
			$pixels = [];

			$to = ($first ? self::PIXELS_FOR_SIZE : 3);
			$first = false;

			for ($j = 0; $j < $to; ++$j) {
				$pixels[] = [$this->posX, $this->posY];
				$this->stepPixel();
			}

			$this->normalizeBytePixelGroup($pixels);
		}

		$this->resetPosition();

		return;
	}

	/**
	 * ...
	 *
	 * @param array $pixels   Pixels array
	 *
	 * @return void
	 */
	private function normalizeBytePixelGroup($pixels)
	{
		$level = self::PIXELDIFF;

		$pixelColors = [];
		foreach ($pixels as $pixel) {
			$pixelColors[] = $this->image->colorAt($pixel[0], $pixel[1]);
		}

		$controlLevel = $pixelColors[0][0];

		$colorIndex = 1;
		foreach ($pixelColors as $pixelIndex => $pixelColor) {
			$modified = false;

			for ($colorIndex; $colorIndex < 3; ++$colorIndex) {
				$diff = $pixelColor[$colorIndex] - $controlLevel;

				if (abs($diff) !== self::PIXELDIFF) {
					continue;
				}

				$modified = true;

				if ($diff < 0 || $pixelColor[$colorIndex] === 255) {
					--$pixelColor[$colorIndex];
				}
				else {
					++$pixelColor[$colorIndex];
				}
			}
			$colorIndex = 0;

			if ($modified) {
				$pixel = $pixels[$pixelIndex];

				$this->image->setPixelColor($pixel[0], $pixel[1], $pixelColor);
			}
		}

		return;
	}

	/**
	 *
	 * @return integer
	 */
	private function calculateMaxSize()
	{
		$maxSize = self::getSystemMaxSize();

		$imageMaxSize = floor(($this->image->width * $this->image->height - self::PIXELS_FOR_SIZE) / 3);
		if ($imageMaxSize < $this->maxSize) {
			$maxSize = $imageMaxSize;
		}

		return $maxSize;
	}
}
