<?php
namespace App;

class ByteFunctions
{
	/**
	 * Convert decimal value to binary
	 *
	 * @param integer $number   Decimal value
	 * @param integer $length   Binary string lenght
	 *
	 * @return array
	 */
	public static function decimalToBinary($number, $length = 8)
	{
		$binary = sprintf('%0' . $length . 'd', decbin($number));
		$binary = str_split($binary);

		return $binary;
	}

	/**
	 * Convert binary to decimal value
	 *
	 * @param array $binary   Binary array
	 *
	 * @return number
	 */
	public static function binaryToDecimal(array $binary)
	{
		$binary = implode('', $binary);

		return bindec($binary);
	}

	/**
	 * Convert string to decimal values
	 *
	 * @param string $str   Convertable string
	 *
	 * @return array
	 */
	public static function stringToDecimal($str)
	{
		$output = [];

		$str = str_split($str);
		foreach ($str as $char) {
			$output[] = ord($char);
		}

		return $output;
	}

	/**
	 * Convert decimal values to string
	 *
	 * @param array $decArray   Decimal values array
	 *
	 * @return string
	 */
	public static function decimalToString(array $decArray)
	{
		$output = [];

		foreach ($decArray as $dec) {
			$output[] = chr($dec);
		}

		$output = implode('', $output);

		return $output;
	}
}
