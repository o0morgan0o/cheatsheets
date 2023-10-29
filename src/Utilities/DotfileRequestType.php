<?php
namespace App\Utilities;

enum DotfileRequestType
{
    case ROOT;
    case FOLDER;
    case FILE;
}