<?php

namespace App\Http\Controllers;

use App\Enums\JangkaWaktuEnum;
use App\Enums\JenisPembayaranEnum;
use App\Enums\LuasLahanEnum;
use App\Enums\NilaiPinjamEnum;
use App\Enums\PengahasilanEnum;
use App\Enums\PengahasilanPanenEnum;
use App\Enums\PinjamanSebelumnyaEnum;
use App\Enums\StatusKeanggotaanEnum;
use App\Enums\StatusKelayakanEnum;
use App\Enums\StatusPerkawinanEnum;
use App\Enums\StatusPinjamanEnum;
use App\Enums\UsiaEnum;
use App\Models\Pinjaman;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Exception;

class PinjamanController extends Controller
{
    public function showCreatePinjamanPage()
    {
        return view('pinjaman.create');
    }

    public function getAllPinjaman(Request $request)
    {
        $user = Auth::user();
        $status = $request->input('status');
        $this->autoPotongPinjaman();

        if ($user->role === 'ADMIN') {
            $query = Pinjaman::orderBy('created_at');
        } else {
            $query = Pinjaman::where('user_id', $user->id)
                ->orderBy('created_at', 'desc');
        }

        if ($status) {
            $query->where('status', $status);
        }

        $dataPinjamans = $query->paginate(10);

        return view('pinjaman.index', compact('dataPinjamans'));
    }


    public function createPinjaman(Request $request)
    {
        try {
            DB::beginTransaction();

            $user = Auth::user();
            $cleanPinjaman = preg_replace('/\D/', '', $request->jumlahPinjaman);

            // $totalPinjaman = $cleanPinjaman * $request->tenor * 0.05;
            // $roundedTotalPinjaman = $cleanPinjaman + ceil($totalPinjaman / 1000) * 1000;

            $idPinjaman = Str::uuid();
            $newPinjaman = Pinjaman::create([
                'id' => $idPinjaman,
                'user_id' => Auth::user()->id,
                'nama_pemilik_rekening' => $request->namaPemilikRekening,
                'bank' => $request->bank,
                'no_rek' => $request->noRekening,
                'tenor' => $request->tenor,
                'total_pinjaman' => $cleanPinjaman,
                'tipe_pinjaman' => $request->tipePinjaman,
                'status' => 'PENDING',
                'status_kelayakan' => $this->hitungKelayakan($user, $cleanPinjaman, $request->tenor, $request->tipePinjaman)
            ]);
            $newPinjaman->save();

            DB::commit();

            return redirect()->route('pinjaman.detail', ['pinjamanId' => $idPinjaman])->with('success', 'Success ajukan Pinjaman!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to ajukan Pinjaman: ' . $e->getMessage());
        }
    }


    public function updateStatusPinjaman(Request $request, $pinjamanId)
    {
        try {
            $pinjaman = Pinjaman::findOrFail($pinjamanId);
            $pinjaman->status = $request->action;
            $pinjaman->save();

            if ($pinjaman->status === 'APPROVED') {
                $pinjaman->status = 'ON GOING';
                $pinjaman->save();

                $user = $pinjaman->user;
                $user->save();
                if ($pinjaman->tipe_pinjaman === 'Angsuran') {
                    $tagihanController = new TagihanController();
                    $tagihanController->createTagihan($pinjamanId);
                    // $this->createTagihan($pinjamanId);
                }
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to ' . ucfirst(strtolower($request->action)) . ' Pinjaman: ' . $e->getMessage());
        }
        return redirect()->route('pinjaman.detail', ['pinjamanId' => $pinjamanId])->with('success', 'Success ' . ucfirst(strtolower($request->action)) . ' Pinjaman!');
    }

    public function detailPinjaman($pinjamanId)
    {
        try {
            $dataPinjaman = Pinjaman::findOrFail($pinjamanId);
            $dataTagihans = Tagihan::where('pinjaman_id', $dataPinjaman->id)
                ->orderBy('angsuran', 'ASC')
                ->orderBy('updated_at', 'DESC')
                ->paginate(5);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
        return view('pinjaman.detail', compact('dataPinjaman', 'dataTagihans'));
    }

    public function autoPotongPinjaman()
    {
        try {
            DB::beginTransaction();
            $dataPinjamans = Pinjaman::where('tipe_pinjaman', 'Potongan')
                ->where('status', 'ON GOING')
                ->get();

            foreach ($dataPinjamans as $pinjaman) {
                $updatedAt = Carbon::parse($pinjaman->updated_at);
                $paidDate = $updatedAt->addMonths($pinjaman->tenor);

                if (Carbon::now()->greaterThanOrEqualTo($paidDate)) {
                    $pinjaman->status = 'PAID';
                    $pinjaman->save();
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    public function hitungKelayakan($user, $nilaiPinjam, $jangkaWaktu, $jenisPinjaman)
    {
        try {
            Log::info('============ Hitung Kelayakan User ' . $user->name . ' ============');
            $cleanPenghasilanPerbulan = preg_replace('/\D/', '', $user->penghasilan_perbulan);
            $cleanPenghasilanPanen = preg_replace('/\D/', '', $user->penghasilan_panen);

            $usiaEnum = UsiaEnum::search($user->umur);
            $statusPerkawinanEnum = StatusPerkawinanEnum::search($user->status_perkawinan);
            $statusKeanggotaanEnum = StatusKeanggotaanEnum::search($user->status_keanggotaan);
            $luasLahanEnum = LuasLahanEnum::search($user->luas_lahan);
            $penghasilanEnum = PengahasilanEnum::search($cleanPenghasilanPerbulan / 1000000);
            $penghasilanPanen = PengahasilanPanenEnum::search($cleanPenghasilanPanen / 1000000);
            $nilaiPinjamEnum = NilaiPinjamEnum::search($nilaiPinjam / 1000000);
            $jangkaWaktuEnum = JangkaWaktuEnum::search($jangkaWaktu);
            $statusPinjamanEnum = StatusPinjamanEnum::search($user->status_pinjaman);
            $jenisPinjamanEnum = JenisPembayaranEnum::search($jenisPinjaman);
            $pinjamanSebelumnyaEnum = PinjamanSebelumnyaEnum::search($user->pinjaman_sebelumnya);

            // Log::info('Usia R1: ' . $usiaEnum->R1());
            // Log::info('Status Perkawinan R1: ' . $statusPerkawinanEnum->R1());
            // Log::info('Status Keanggotaan R1: ' . $statusKeanggotaanEnum->R1());
            // Log::info('Luas Lahan R1: ' . $luasLahanEnum->R1());
            // Log::info('Penghasilan Perbulan R1: ' . $penghasilanEnum->R1());
            // Log::info('Penghasilan Panen R1: ' . $penghasilanPanen->R1());
            // Log::info('Nilai Pinjam R1: ' . $nilaiPinjamEnum->R1());
            // Log::info('Jangka Waktu R1: ' . $jangkaWaktuEnum->R1());
            // Log::info('Status Pinjaman R1: ' . $statusPinjamanEnum->R1());
            // Log::info('Jenis Pinjaman R1: ' . $jenisPinjamanEnum->R1());
            // Log::info('Pinjaman Sebelumnya R1: ' . $pinjamanSebelumnyaEnum->R1());

            $r1Likehood = $usiaEnum->R1() * $statusPerkawinanEnum->R1() * $statusKeanggotaanEnum->R1() * $luasLahanEnum->R1() * $penghasilanEnum->R1() * $penghasilanPanen->R1() * $nilaiPinjamEnum->R1() * $jangkaWaktuEnum->R1() * $statusPinjamanEnum->R1() * $jenisPinjamanEnum->R1() * $pinjamanSebelumnyaEnum->R1() * StatusKelayakanEnum::R1();
            $r2Likehood = $usiaEnum->R2() * $statusPerkawinanEnum->R2() * $statusKeanggotaanEnum->R2() * $luasLahanEnum->R2() * $penghasilanEnum->R2() * $penghasilanPanen->R2() * $nilaiPinjamEnum->R2() * $jangkaWaktuEnum->R2() * $statusPinjamanEnum->R2() * $jenisPinjamanEnum->R2() * $pinjamanSebelumnyaEnum->R2() * StatusKelayakanEnum::R2();
            // Log::info('R1 Likehood: ' . $r1Likehood);
            // Log::info('R2 Likehood: ' . $r2Likehood);

            $nilaiProbabilitasR1 = $r1Likehood / ($r1Likehood + $r2Likehood);
            $nilaiProbabilitasR2 = $r2Likehood / ($r1Likehood + $r2Likehood);
            Log::info('Nilai Probabilitas R1 : ' . $nilaiProbabilitasR1);
            Log::info('Nilai Probabilitas R2 : ' . $nilaiProbabilitasR2);

            $hasil = $nilaiProbabilitasR1 > $nilaiProbabilitasR2 ? 'Layak' : 'Tidak Layak';
            Log::info('Hasil User ' . $user->name . ': ' . $hasil);

            return $hasil;
        } catch (Exception $e) {
            Log::info('Error hitung   ---   ' . $e->getMessage());
        }
    }
}
