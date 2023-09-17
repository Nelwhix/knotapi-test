<?php

namespace App\Enums;

enum Status: int
{
    case Failed = 0;
    case Finished = 1;
    case InProgress = 2;

    public static function values() {
        return [0, 1, 2];
    }
}
