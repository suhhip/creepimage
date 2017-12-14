<?php
namespace App\Interfaces;

interface BaseImage
{
    /**
     * Load image file
     *
     * @param string $filePath   Image file path
     *
     * @return boolean
     */
    public function loadFile($filePath);

    /**
     * Get image
     *
     * @return resource
     */
    public function getImage();

    /**
     * Get image width
     *
     * @return integer
     */
    public function getWidth();

    /**
     * Get image height
     *
     * @return integer
     */
    public function getHeight();

    /**
     * Get image mime type
     *
     * @return string
     */
    public function getMimeType();

    /**
     * Get pixel color
     *
     * @param integer $x   X-coordinate
     * @param integer $y   Y-coordinate
     *
     * @return array   RGB array
     */
    public function colorAt($x, $y);

    /**
     * Change pixel color
     *
     * @param integer $x       X-coordinate
     * @param integer $y       Y-coordinate
     * @param array   $color   RGB array
     *
     * @return boolean
     */
    public function setPixelColor($x, $y, array $color);
}
