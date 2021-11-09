<?php

namespace App\Models;

class PasswordEncryption
{
    protected $AES_IV="PGKEYENCDECIVSPC";
    protected $AES_METHOD="AES-256-CBC";
    /* AES IV 256 Bit  Encryption/Decryption Methods */
    public function encryptAES($str,$key) {
        $str = $this->pkcs5_pad($str);
        $encrypted = openssl_encrypt($str, $this->AES_METHOD, $key, OPENSSL_ZERO_PADDING, $this->AES_IV);
        $encrypted = base64_decode($encrypted);
        $encrypted = unpack('C*', ($encrypted));
        $encrypted = $this->byteArray2Hex($encrypted);
        $encrypted = urlencode($encrypted);
        return $encrypted;
    }

    public function decryptAES($code,$key) {
        $code = $this->hex2ByteArray(trim($code));
        $code = $this->byteArray2String($code);
        $code = base64_encode($code);
        $decrypted = openssl_decrypt($code, $this->AES_METHOD, $key, OPENSSL_ZERO_PADDING, $this->AES_IV);
        return $this->pkcs5_unpad($decrypted);
    }

    public function pkcs5_pad ($text) {
        $blocksize = openssl_cipher_iv_length($this->AES_METHOD);
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    public function pkcs5_unpad($text) {
        $pad = ord($text{strlen($text)-1});
        if ($pad > strlen($text)) {
            return false;
        }
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
            return false;
        }
        return substr($text, 0, -1 * $pad);
    }

    public function byteArray2Hex($byteArray) {
        $chars = array_map("chr", $byteArray);
        $bin = join($chars);
        return bin2hex($bin);
    }

    public function hex2ByteArray($hexString) {
        $string = hex2bin($hexString);
        return unpack('C*', $string);
    }

    public function byteArray2String($byteArray) {
        $chars = array_map("chr", $byteArray);
        return join($chars);
    }


}
