<?php

namespace App\Enums;

enum JangkaWaktuEnum: string
{
    case A = '<5';
    case B = '5-8';
    case C = '>8';

    public function R1(): float
    {
        return match ($this) {
            JangkaWaktuEnum::A => 0.260869565,
            JangkaWaktuEnum::B => 0.608695652,
            JangkaWaktuEnum::C => 0.130434783,
        };
    }

    public function R2(): float
    {
        return match ($this) {
            JangkaWaktuEnum::A => 0.578947368,
            JangkaWaktuEnum::B => 0.263157895,
            JangkaWaktuEnum::C => 0.157894737,
        };
    }

    public static function search(float $waktu): ?self
    {
        return match (true) {
            $waktu < 5 => self::A,
            $waktu >= 5 && $waktu <= 8 => self::B,
            $waktu > 8 => self::C,
            default => null,
        };
    }
}
