<?php

namespace App\Enums;

enum StatusPinjamanEnum: string
{
    case Baru = 'Baru';
    case PernahPinjam = 'Pernah Pinjam';

    public function R1(): float
    {
        return match ($this) {
            StatusPinjamanEnum::Baru => 0.565217391,
            StatusPinjamanEnum::PernahPinjam => 0.434782609,
        };
    }

    public function R2(): float
    {
        return match ($this) {
            StatusPinjamanEnum::Baru => 0.578947368,
            StatusPinjamanEnum::PernahPinjam => 0.421052632,
        };
    }

    public static function search(string $status): ?self
    {
        return match ($status) {
            'Baru' => self::Baru,
            'Pernah Pinjam' => self::PernahPinjam,
            default => null,
        };
    }
}
