<?php

namespace App\Enums;

enum NilaiPinjamEnum: string
{
    case A = '<70';
    case B = '70-150';
    case C = '>150';

    public function R1(): float
    {
        return match ($this) {
            NilaiPinjamEnum::A => 0.826086957,
            NilaiPinjamEnum::B => 0.043478261,
            NilaiPinjamEnum::C => 0.130434783,
        };
    }

    public function R2(): float
    {
        return match ($this) {
            NilaiPinjamEnum::A => 0.210526316,
            NilaiPinjamEnum::B => 0.578947368,
            NilaiPinjamEnum::C => 0.210526316,
        };
    }

    public static function search(float $nilai): ?self
    {
        return match (true) {
            $nilai < 70 => self::A,
            $nilai >= 70 && $nilai <= 150 => self::B,
            $nilai > 150 => self::C,
            default => null,
        };
    }
}
