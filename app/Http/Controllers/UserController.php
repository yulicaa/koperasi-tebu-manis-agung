<?php

namespace App\Http\Controllers;

use App\Enums\PinjamanSebelumnyaEnum;
use App\Enums\StatusPinjamanEnum;
use App\Models\Pinjaman;
use App\Models\Tagihan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use DateTime;
use Exception;

class UserController extends Controller
{

    public function showCreateUserPage()
    {
        return view('admin.users.create');
    }

    public function getAllUsers()
    {
        $dataUsers = User::where('role', 'USER')
            ->orderBy('name')
            ->paginate(5);

        return view('admin.users.index', compact('dataUsers'));
    }

    public function detailUser($userId)
    {
        $user = User::findOrFail($userId);
        return view('admin.users.detail', compact('user'));
    }

    public function createUser(Request $request)
    {
        try {

            $umur = $this->countUmur($request->tanggalLahir);
            $cleanPenghasilanPerbulan = preg_replace('/\D/', '', $request->penghasilanPerbulan);
            $cleanPenghasilanPanen = preg_replace('/\D/', '', $request->penghasilanPanen);

            $newUser = User::create([
                'id' => Str::uuid(),
                'name' => $request->name,
                'email' => $request->email,
                'status_keanggotaan' => $request->statusKeanggotaan,
                'role' => 'USER',
                'tempat_lahir' => $request->tempatLahir,
                'tanggal_lahir' => $request->tanggalLahir,
                'umur' => $umur,
                'agama' => $request->agama,
                'status_perkawinan' => $request->statusPerkawinan,
                'no_telp' => $request->noTelp,
                'luas_lahan' => $request->luasLahan,
                'penghasilan_perbulan' => $cleanPenghasilanPerbulan,
                'penghasilan_panen' => $cleanPenghasilanPanen,
                'status_pinjaman' => StatusPinjamanEnum::Baru,
                'pinjaman_sebelumnya' => PinjamanSebelumnyaEnum::Lancar,
                'password' => Hash::make($request->noTelp)
            ]);
            $newUser->save();
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed create new User: ' . $e->getMessage());
        }
        return redirect()->route('admin.user.index')->with('success', 'User created!');
    }

    public function updateUser(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        try {
            $user->name = $request->name;
            $user->tempat_lahir = $request->tempatLahir;
            $user->agama = $request->agama;
            $user->status_keanggotaan = $request->statusKeanggotaan;
            $user->status_perkawinan = $request->statusPerkawinan;

            if ($user->tanggal_lahir != $request->tanggalLahir) {
                $user->tanggal_lahir = $request->tanggalLahir;
                $user->umur = $this->countUmur($request->tanggalLahir);
            }

            $user->save();
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed update User detail: ' . $e->getMessage());
        }
        return redirect()->back()->with('success', 'User updated!');
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        try {
            $pinjaman = Pinjaman::where('user_id', $user->id)
                ->where('status', '!=', 'Lunas')
                ->exists();

            if ($pinjaman) {
                throw new \Exception('User masih memiliki pinjaman aktif!');
            }

            $user->delete();
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed delete User: ' . $e->getMessage());
        }
        return redirect()->back()->with('success', 'User deleted!');
    }

    public function countUmur($tanggalLahir)
    {
        $today = new DateTime();
        $diff = $today->diff(new DateTime($tanggalLahir));
        $age = $diff->y;
        return $age;
    }
}
