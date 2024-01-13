<?php

namespace App\Utilities;

class BashColorizer
{
    public static function printInRed(string $string): string
    {
        return "\e[0;31m$string\e[0m";
    }

    public static function printInGreen(string $string): string
    {
        return "\e[0;32m$string\e[0m";
    }

    public static function printInYellow(string $string): string
    {
        return "\e[0;33m$string\e[0m";
    }

    public static function printInWhiteOnRedBackground(string $string): string
    {
        return "\e[0;37;41m$string\e[0m";
    }

    public static function printInBlackOnRedBackground(string $string): string
    {
        return "\e[0;30;41m$string\e[0m";
    }

    public static function printInBoldBlackOnRedBackground(string $string): string
    {
        return "\e[1;30;41m$string\e[0m";
    }

    public static function printInWhiteOnBlackBackground(string $string): string
    {
        return "\e[0;30;47m$string\e[0m";
    }

    public static function printInBold(string $string): string
    {
        return "\e[1m$string\e[0m";
    }


}
