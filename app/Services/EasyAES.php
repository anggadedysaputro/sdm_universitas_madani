<?php

namespace App\Services;

class EasyAES
{
    private string $iv;
    private string $key;
    private string $mode;

    /**
     * @param string $key Kunci enkripsi
     * @param int $bit 128 atau 256
     * @param string $iv String IV (akan di-hash menjadi 16 byte)
     */
    function __construct(string $key, int $bit = 128, string $iv = "")
    {
        if ($bit === 256) {
            // SHA256 menghasilkan 32 byte (256 bit)
            $this->key = hash('SHA256', $key, true);
            $this->mode = 'AES-256-CBC';
        } else {
            // MD5 menghasilkan 16 byte (128 bit)
            $this->key = hash('MD5', $key, true);
            $this->mode = 'AES-128-CBC';
        }

        // IV untuk AES CBC harus selalu 16 byte
        if (!empty($iv)) {
            $this->iv = hash('MD5', $iv, true);
        } else {
            // Default 16 null bytes (tidak direkomendasikan untuk produksi)
            $this->iv = str_repeat(chr(0), 16);
        }
    }

    /**
     * Enkripsi string ke Base64
     */
    public function encrypt(string $str): string
    {
        // OPENSSL_RAW_DATA secara otomatis menangani PKCS7 padding
        $encrypted = openssl_encrypt($str, $this->mode, $this->key, OPENSSL_RAW_DATA, $this->iv);
        return base64_encode($encrypted);
    }

    /**
     * Dekripsi string dari Base64
     */
    public function decrypt(string $str): string|false
    {
        $decoded = base64_decode($str);
        return openssl_decrypt($decoded, $this->mode, $this->key, OPENSSL_RAW_DATA, $this->iv);
    }

    /**
     * Helper static untuk enkripsi cepat
     */
    static function encryptString(string $content): string
    {
        // Ganti tanda bintang dan pagar dengan key/iv asli Anda
        $aes = new EasyAES('****************', 128, '################');
        return $aes->encrypt($content);
    }

    /**
     * Helper static untuk dekripsi cepat
     */
    static function decryptString(string $content): string|false
    {
        $aes = new EasyAES('****************', 128, '################');
        return $aes->decrypt($content);
    }
}
