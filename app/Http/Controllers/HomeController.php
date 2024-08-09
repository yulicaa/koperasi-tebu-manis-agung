<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Auth;
use Exception;

class HomeController extends Controller
{
    public function getDashboardData()
    {
        try {
            $user = Auth::user();
            $isAdmin = $user->role === 'ADMIN';

            $statusPinjaman = [
                'pending' => Pinjaman::where('status', 'PENDING')->when(!$isAdmin, function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->count(),
                'onGoing' => Pinjaman::where('status', 'ON GOING')->when(!$isAdmin, function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->count(),
                'paid' => Pinjaman::where('status', 'PAID')->when(!$isAdmin, function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->count(),
                'rejected' => Pinjaman::where('status', 'REJECTED')->when(!$isAdmin, function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->count(),
            ];

            $statusTagihan = [
                'pending' => Tagihan::where('status', 'PENDING')->when(!$isAdmin, function ($query) use ($user) {
                    $query->whereHas('pinjaman', function ($query) use ($user) {
                        $query->where('user_id', $user->id);
                    });
                })->count(),
                'waiting' => Tagihan::where('status', 'WAITING FOR PAYMENT')->when(!$isAdmin, function ($query) use ($user) {
                    $query->whereHas('pinjaman', function ($query) use ($user) {
                        $query->where('user_id', $user->id);
                    });
                })->count(),
                'onProcess' => Tagihan::where('status', 'ON PROCESS')->when(!$isAdmin, function ($query) use ($user) {
                    $query->whereHas('pinjaman', function ($query) use ($user) {
                        $query->where('user_id', $user->id);
                    });
                })->count(),
                'paid' => Tagihan::where('status', 'PAID')->when(!$isAdmin, function ($query) use ($user) {
                    $query->whereHas('pinjaman', function ($query) use ($user) {
                        $query->where('user_id', $user->id);
                    });
                })->count(),
                'rejected' => Tagihan::where('status', 'REJECTED')->when(!$isAdmin, function ($query) use ($user) {
                    $query->whereHas('pinjaman', function ($query) use ($user) {
                        $query->where('user_id', $user->id);
                    });
                })->count(),
            ];

            $data = [
                'statusPinjaman' => $statusPinjaman,
                'statusTagihan' => $statusTagihan,
            ];

            return response()->json(['data' => $data]);
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching dashboard data.'], 500);
        }
    }

    public function notification()
    {
        try {
            $user = Auth::user();

            $pinjamans = null;
            $tagihans = null;

            if ($user->role === 'ADMIN') {
                $pinjamans = Pinjaman::where('status', 'PENDING')->count();
                $tagihans = Tagihan::where('status', 'ON PROCESS')->count();
            } else {

                $tagihans = Tagihan::whereHas('pinjaman', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                    ->where('status', 'WAITING FOR PAYMENT')
                    ->count();
            }

            $data = [
                'pinjamans' => $pinjamans,
                'tagihans' => $tagihans
            ];

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

        return response()->json(['data' => $data]);
    }
}
