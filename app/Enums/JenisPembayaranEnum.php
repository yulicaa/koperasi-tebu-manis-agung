<?php

namespace App\Enums;

enum JenisPembayaranEnum: string
{
    case Angsuran = 'Angsuran';
    case Potongan = 'Potongan';

    public function R1(): float
    {
        return match ($this) {
            JenisPembayaranEnum::Angsuran => 0.608695652,
            JenisPembayaranEnum::Potongan => 0.391304348,
        };
    }

    public function R2(): float
    {
        return match ($this) {
            JenisPembayaranEnum::Angsuran => 0.315789474,
            JenisPembayaranEnum::Potongan => 0.684210526,
        };
    }

    public static function search(string $status): ?self
    {
        return match ($status) {
            'Angsuran' => self::Angsuran,
            'Potongan' => self::Potongan,
            default => null,
        };
    }
}
