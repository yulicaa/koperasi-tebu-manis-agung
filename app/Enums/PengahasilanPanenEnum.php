<?php

namespace App\Enums;

enum PengahasilanPanenEnum: string
{
    case A = '<50';
    case B = '50-180';
    case C = '>180';

    public function R1(): float
    {
        return match ($this) {
            PengahasilanPanenEnum::A => 0.217391304,
            PengahasilanPanenEnum::B => 0.434782609,
            PengahasilanPanenEnum::C => 0.347826087,
        };
    }

    public function R2(): float
    {
        return match ($this) {
            PengahasilanPanenEnum::A => 0.210526316,
            PengahasilanPanenEnum::B => 0.631578947,
            PengahasilanPanenEnum::C => 0.157894737,
        };
    }

    public static function search(float $panen): ?self
    {
        return match (true) {
            $panen < 50 => self::A,
            $panen >= 50 && $panen <= 180 => self::B,
            $panen > 180 => self::C,
            default => null,
        };
    }
}
