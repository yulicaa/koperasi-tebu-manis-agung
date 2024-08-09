<?php

namespace App\Enums;

enum StatusKeanggotaanEnum: string
{
    case Pengurus = 'Pengurus';
    case Pengawas = 'Pengawas';
    case Anggota = 'Anggota';

    public function R1(): float
    {
        return match ($this) {
            StatusKeanggotaanEnum::Pengurus => 0.130434783,
            StatusKeanggotaanEnum::Pengawas => 0.086956522,
            StatusKeanggotaanEnum::Anggota =>  0.782608696,
        };
    }

    public function R2(): float
    {
        return match ($this) {
            StatusKeanggotaanEnum::Pengurus => 0.105263158,
            StatusKeanggotaanEnum::Pengawas => 0.052631579,
            StatusKeanggotaanEnum::Anggota => 0.842105263,
        };
    }

    public static function search(string $status): ?self
    {
        return match ($status) {
            'Pengurus' => self::Pengurus,
            'Pengawas' => self::Pengawas,
            'Anggota' => self::Anggota,
            default => null,
        };
    }
}
