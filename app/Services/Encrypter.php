<?php
/**
 * Created by PhpStorm.
 * User: mitchelwijt
 * Date: 09/06/2019
 * Time: 08:18
 */

namespace App\Services;


class Encrypter {
    public static function encrypt_decrypt($action, $input){
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = 'This is my secret key';
        $secret_iv = 'This is my secret iv';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if( $action == 'encrypt' ) {
            $output = openssl_encrypt($input, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        }
        else if( $action == 'decrypt' ){
            $output = openssl_decrypt(base64_decode($input), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }
}