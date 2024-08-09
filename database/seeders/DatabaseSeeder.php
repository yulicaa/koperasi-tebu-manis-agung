<?php

namespace Database\Seeders;

use App\Http\Controllers\PinjamanController;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $pinjamanController = new PinjamanController();
        $admin = [
            'id' => Str::uuid(),
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123'),
            // 'password' => '$2y$10$s3XtgG4VWEJpWRQvyEEXUul8XQ5bIPIioXqNIj1qCJF13UBmQeT4C',
            'role' => 'ADMIN',
            'tanggal_lahir' => '2024-06-26',
            'tempat_lahir' => 'ADMIN',
            'umur' => 1,
            'agama' => 'Lainnya',
            'no_telp' => 0123,
            'luas_lahan' => 0123,
            'status_perkawinan' => 'Menikah',
            'status_keanggotaan' => 'Pengurus',
            'penghasilan_perbulan' => 2000000,
            'penghasilan_panen' => 50000000,
            'status_pinjaman' => 'Baru',
            'pinjaman_sebelumnya' => 'Lancar',
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ];
        DB::table('users')->insert($admin);

        $user = [
            'id' => Str::uuid(),
            'name' => 'Fahmy Malik',
            'email' => 'fahmy.malikk@gmail.com',
            'password' => Hash::make('123'),
            'role' => 'USER',
            'tanggal_lahir' => '2024-06-26',
            'tempat_lahir' => 'ACEH',
            'umur' => 1,
            'agama' => 'Islam',
            'no_telp' => 0123,
            'luas_lahan' => 0123,
            'status_perkawinan' => 'Menikah',
            'status_keanggotaan' => 'Pengurus',
            'penghasilan_perbulan' => 2000000,
            'penghasilan_panen' => 50000000,
            'status_pinjaman' => 'Baru',
            'pinjaman_sebelumnya' => 'Lancar',
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ];
        DB::table('users')->insert($user);

        // User test 1
        $userTestId1 = Str::uuid();
        $userTest1 = [
            'id' => $userTestId1,
            'name' => 'Suwanto',
            'email' => 'wanto@gmail.com',
            'password' => Hash::make('123'),
            'role' => 'USER',
            'tanggal_lahir' => '2024-06-26',
            'tempat_lahir' => 'ACEH',
            'umur' => 54,
            'agama' => 'Islam',
            'no_telp' => 081234567123,
            'luas_lahan' => 4,
            'status_perkawinan' => 'Menikah',
            'status_keanggotaan' => 'Pengurus',
            'penghasilan_perbulan' => '5000000',
            'penghasilan_panen' => '160000000',
            'status_pinjaman' => 'Baru',
            'pinjaman_sebelumnya' => 'Macet',
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ];
        DB::table('users')->insert($userTest1);
        $userTest1 = User::findOrFail($userTestId1);

        $statusKelayakan1 = $pinjamanController->hitungKelayakan($userTest1, 61000000, 4, 'Potongan');
        $pinjamanTest1 = [
            'id' => Str::uuid(),
            'user_id' => $userTestId1,
            'nama_pemilik_rekening' => 'test Suwanto',
            'bank' => 'MANDIRI',
            'no_rek' => '123',
            'tenor' => '2',
            'total_pinjaman' => '61000000',
            'tipe_pinjaman' => 'Potongan',
            'status' => 'PENDING',
            'status_kelayakan' => $statusKelayakan1
        ];
        DB::table('pinjaman')->insert($pinjamanTest1);

        //User Test 2
        $userTestId2 = Str::uuid();
        $userTest2 = [
            'id' => $userTestId2,
            'name' => 'Anita',
            'email' => 'anita@gmail.com',
            'password' => Hash::make('123'),
            'role' => 'USER',
            'tanggal_lahir' => '2024-06-26',
            'tempat_lahir' => 'ACEH',
            'umur' => 30,
            'agama' => 'Islam',
            'no_telp' => 0123,
            'luas_lahan' => 3,
            'status_perkawinan' => 'Lajang',
            'status_keanggotaan' => 'Anggota',
            'penghasilan_perbulan' => 3000000,
            'penghasilan_panen' => 120000000,
            'status_pinjaman' => 'Baru',
            'pinjaman_sebelumnya' => 'Macet',
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ];
        DB::table('users')->insert($userTest2);
        $userTest2 = User::findOrFail($userTestId2);

        $statusKelayakan2 = $pinjamanController->hitungKelayakan($userTest2, 75000000, 6, 'Potongan');
        $pinjamanTest2 = [
            'id' => Str::uuid(),
            'user_id' => $userTestId2,
            'nama_pemilik_rekening' => 'test Anita',
            'bank' => 'MANDIRI',
            'no_rek' => '123',
            'tenor' => '6',
            'total_pinjaman' => '75000000',
            'tipe_pinjaman' => 'Potongan',
            'status' => 'PENDING',
            'status_kelayakan' => $statusKelayakan2
        ];
        DB::table('pinjaman')->insert($pinjamanTest2);
    }
}
