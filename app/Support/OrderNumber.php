<?php

namespace App\Support;

use Illuminate\Support\Str;

class OrderNumber
{
    public static function generate(): string
    {
        return 'VLX-'.now()->format('Ymd').'-'.strtoupper(Str::random(8));
    }
}
