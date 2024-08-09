<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;

class LaporanController extends Controller
{

    public function getDataLaporan(Request $request)
    {
        $user = Auth::user();

        $month = $request->input('month');
        $year = $request->input('year');

        $query = Tagihan::query();

        if ($month) {
            $query->whereMonth('created_at', $month);
        }

        if ($year) {
            $query->whereYear('created_at', $year);
        }

        if ($user->role === 'USER') {
            $query->whereHas('pinjaman', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        }

        $query->where('status', 'PAID');

        $dataTagihans = $query->orderBy('status', 'DESC')->paginate(10);

        return view('laporan.index', compact('dataTagihans'));
    }

    public function detailLaporan($pinjamanId)
    {
        try {
            $pinjaman = Pinjaman::findOrFail($pinjamanId);
            $dataTagihans = Tagihan::where('pinjaman_id', $pinjaman->id)
                ->orderBy('angsuran')
                ->orderBy('updated_at')
                ->paginate(10);

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
        return view('laporan.detail', compact('pinjaman', 'dataTagihans'));
    }

    public function printLaporan(Request $request)
    {
        try {
            $month = $request->input('month');
            $year = $request->input('year');
            $status = $request->input('status');

            $query = Tagihan::query();

            if ($month) {
                $query->whereMonth('updated_at', $month);
            }

            if ($year) {
                $query->whereYear('updated_at', $year);
            }

            if ($status) {
                $query->where('status', $status);
            }

            $dataTagihans = $query->where('status', 'PAID')
                ->orderBy('updated_at', 'DESC')
                ->get();

            if (!$dataTagihans->isNotEmpty()) {
                throw new Exception('Data not found!');
            }

            $pdf = PDF::loadView('laporan.pdf', ['dataTagihans' => $dataTagihans]);
            return $pdf->stream('document.pdf');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

}
