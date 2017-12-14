<?php
namespace App;

class DeCreeptor extends CreepImage
{
    /**
     * @var /App/ByteFunctions   ByteFunctions object
     */
    private $byteFunctions;

    public function __construct(ByteFunctions $bf)
    {
        $this->byteFunctions = $bf;
    }

    /**
	 * Run DeCreepter
	 *
	 * @return string|boolean
	 */
	public function run()
	{
		$dataSize = $this->readDecimal(self::PIXELS_FOR_SIZE);

		if (!$dataSize) {
			return false;
		}

		$decimals = [];
		for ($i = 0; $i < $dataSize; ++$i) {
			$decimals[] = $this->readDecimal();
		}

		$str = $this->byteFunctions->decimalToString($decimals);

		return $str;
	}

	/**
	 * Read decimal value from pixels
	 *
	 * @param integer $pixelCount   Number of pixels
	 *
	 * @return integer
	 */
	private function readDecimal($pixelCount = 3)
	{
		$binary = $this->readBinary($pixelCount);

		$dec = $this->byteFunctions->binaryToDecimal($binary);

		return $dec;
	}

	/**
	 * Read binary from pixels
	 *
	 * @param integer $pixelCount   Number of pixels
	 *
	 * @return array
	 */
	private function readBinary($pixelCount)
	{
		$binary = [];

		$controlLevel = null;
		for ($i = 0; $i < $pixelCount; ++$i) {
			$colors = $this->getActualPixel();

			foreach ($colors as $key => $color) {
				if ($controlLevel === null) {
					$controlLevel = $color;
					continue;
				}

				$diff = abs($controlLevel - $color);

				$binary[] = (int)($diff === self::PIXELDIFF);
			}

			$this->stepPixel();
		}

		return $binary;
	}
}
