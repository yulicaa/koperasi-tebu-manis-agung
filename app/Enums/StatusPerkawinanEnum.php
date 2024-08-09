<?php

namespace App\Enums;

enum StatusPerkawinanEnum: string
{
    case Menikah = 'Menikah';
    case Lajang = 'Lajang';

    public function R1(): float
    {
        return match ($this) {
            StatusPerkawinanEnum::Menikah => 0.913043478,
            StatusPerkawinanEnum::Lajang => 0.086956522,
        };
    }

    public function R2(): float
    {
        return match ($this) {
            StatusPerkawinanEnum::Menikah => 0.894736842,
            StatusPerkawinanEnum::Lajang => 0.105263158,
        };
    }

    public static function search(string $status): ?self
    {
        return match ($status) {
            'Menikah' => self::Menikah,
            'Lajang' => self::Lajang,
            default => null,
        };
    }
}
