<?php
namespace App\Interfaces;

interface DataEncryption
{
    /**
     * Set raw data
     *
     * @param string $data   Raw data
     *
     * @return void
     */
    public function setRawData($data);

    /**
     * Set encrypted data
     *
     * @param string $data   Encrypted string
     *
     * @return void
     */
    public function setEncryptedData($data);

    /**
     * Calculate encrypted data length from the raw data
     *
     * @return integer
     */
    public function getLength();

    /**
     * Encrypt method
     *
     * @param string $password   Password
     *
     * @return string   Coded string
     */
    public function encrypt($password);

    /**
     * Decrypt method
     *
     * @param string $password   Password
     *
     * @return boolean|string   Decoded string
     */
    public function decrypt($password);
}
