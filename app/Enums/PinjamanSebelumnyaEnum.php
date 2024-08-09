<?php

namespace App\Enums;

enum PinjamanSebelumnyaEnum: string
{
    case Lancar = 'Lancar';
    case Macet = 'Macet';

    public function R1(): float
    {
        return match ($this) {
            PinjamanSebelumnyaEnum::Lancar => 0.782608696,
            PinjamanSebelumnyaEnum::Macet => 0.217391304,
        };
    }

    public function R2(): float
    {
        return match ($this) {
            PinjamanSebelumnyaEnum::Lancar => 0.631578947,
            PinjamanSebelumnyaEnum::Macet => 0.368421053,
        };
    }

    public static function search(string $status): ?self
    {
        return match ($status) {
            'Lancar' => self::Lancar,
            'Macet' => self::Macet,
            default => null,
        };
    }
}
