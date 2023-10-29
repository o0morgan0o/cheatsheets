<?php

namespace App\Utilities;

class FilePathUtilities
{
    public static function endsWith($haystack, $needle)
    {
        return (strpos(strrev($haystack), strrev($needle)) === 0);
    }
}