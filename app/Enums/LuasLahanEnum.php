<?php

namespace App\Enums;

enum LuasLahanEnum: string
{
    case A = '<3';
    case B = '3-5';
    case C = '>5';

    public function R1(): float
    {
        return match ($this) {
            LuasLahanEnum::A => 0.47826087,
            LuasLahanEnum::B => 0.304347826,
            LuasLahanEnum::C =>  0.217391304,
        };
    }

    public function R2(): float
    {
        return match ($this) {
            LuasLahanEnum::A => 0.578947368,
            LuasLahanEnum::B => 0.315789474,
            LuasLahanEnum::C => 0.105263158,
        };
    }

    public static function search(float $luas): ?self
    {
        return match (true) {
            $luas < 3 => self::A,
            $luas >= 3 && $luas <= 5 => self::B,
            $luas > 5 => self::C,
            default => null,
        };
    }
}
