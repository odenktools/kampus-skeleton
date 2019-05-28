<?php

namespace App\Libraries;

/**
 * StringHelpers dipergunakan untuk keperluan manipulasi string.
 *
 * @author     Odenktools
 * @license    MIT
 * @package     \App\Http\Libraries
 * @copyright  (c) 2019, Odenktools Technology
 */
class StringHelpers
{
    /**
     * Generate a more truly "random" alpha-numeric string.
     *
     * @param int $length how long char will generate
     * @return string
     * @throws \Exception;
     */
    public static function random($length = 32)
    {
        $string = '';
        while (($len = strlen($string)) < $length) {
            $size = $length - $len;
            $bytes = random_bytes($size);
            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return $string;
    }
}