<?php

namespace App\Http\Controllers;

use App\Enums\PinjamanSebelumnyaEnum;
use App\Enums\StatusPinjamanEnum;
use App\Models\Pinjaman;
use App\Models\Tagihan;
use App\Models\Upload;
use App\Http\Responses\BaseResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Exception;

class TagihanController extends Controller
{

    public function showCreateTagihanPage()
    {
        return view('tagihan.create');
    }

    public function showBayarTagihanPage($tagihanId)
    {
        $tagihan = Tagihan::findOrFail($tagihanId);
        return view('tagihan.bayar', compact('tagihan'));
    }

    public function getAllTagihanUser()
    {
        $user = Auth::user();

        $now = Carbon::now();
        $tanggalJatuhTempo = Carbon::now()->startOfMonth()->addDays(15);

        if ($now->greaterThan($tanggalJatuhTempo)) {
            $this->updateTunggakan();
        }

        if ($user->role === 'ADMIN') {
            $dataTagihans = Tagihan::where('status', 'ON PROCESS')
                ->orderBy('created_at')
                ->paginate(5);
        } else {
            $dataTagihans = Tagihan::whereHas('pinjaman', function ($query) use ($user) {
                $query->where('user_id', $user->id);
                $query->where('status', 'ON GOING');
            })
                ->whereIn('status', ['WAITING FOR PAYMENT', 'REJECTED'])
                ->orderBy('updated_at', 'DESC')
                ->paginate(5);
        }
        return view('tagihan.index', compact('user', 'dataTagihans'));
    }

    public function createTagihan($pinjamanId)
    {
        try {
            DB::beginTransaction();
            $pinjaman = Pinjaman::findOrFail($pinjamanId);
            $user = $pinjaman->user;

            $cleanJumlahPinjaman = preg_replace('/\D/', '', $pinjaman->total_pinjaman);
            // $bunga = ceil($cleanJumlahPinjaman * 0.05 / 1000) * 1000;
            $tagihan_pokok = ceil($cleanJumlahPinjaman / $pinjaman->tenor / 1000) * 1000;

            for ($i = 1; $i <= $pinjaman->tenor; $i++) {
                $jatuhTempo = $i === 1 ? Carbon::now()->addMonths(1)->day(27) : null;
                $status = $i === 1 ? 'WAITING FOR PAYMENT' : 'PENDING';
                $newTagihan = Tagihan::create([
                    'id' => Str::uuid(),
                    'pinjaman_id' => $pinjamanId,
                    'angsuran' => $i,
                    'tagihan_pokok' => $tagihan_pokok,
                    // 'bunga' => $bunga,
                    'tunggakan' => 0,
                    'total_tagihan' => $tagihan_pokok,
                    'jatuh_tempo' => $jatuhTempo,
                    'status' => $status
                ]);
                $newTagihan->save();
            }

            if ($user->status_pinjaman === StatusPinjamanEnum::Baru->value) {
                $user->status_pinjaman = StatusPinjamanEnum::PernahPinjam->value;
                $user->save();
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function updateStatusTagihan(Request $request, $tagihanId)
    {
        try {
            DB::beginTransaction();
            $tagihan = Tagihan::findOrFail($tagihanId);
            $tagihan->status = $request->action;
            $tagihan->save();

            if ($tagihan->status === 'PAID') {
                $nextTagihan = Tagihan::where('pinjaman_id', $tagihan->pinjaman_id)
                    ->where('status', 'PENDING')
                    ->orderBy('angsuran', 'asc')
                    ->first();

                if ($nextTagihan) {
                    $nextTagihan->status = 'WAITING FOR PAYMENT';
                    $nextTagihan->jatuh_tempo = Carbon::now()->addMonths(1)->day(27);
                    $nextTagihan->save();
                } else {
                    $pinjaman = Pinjaman::findOrFail($tagihan->pinjaman_id);

                    if ($pinjaman->tenor === $tagihan->angsuran) {
                        $pinjaman->status = 'PAID';
                        $pinjaman->save();
                    }
                }
            } else {
                $newTagihan = $tagihan->replicate();
                $newTagihan->id = Str::uuid();
                $newTagihan->status = 'WAITING FOR PAYMENT';
                $newTagihan->save();
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed ' . ucfirst(strtolower($request->action)) . ' Tagihan: ' . $e->getMessage());
        }
        return redirect()->back()->with('success', 'Success ' . ucfirst(strtolower($request->action)) . ' Tagihan!');
    }

    public function detailTagihan($tagihanId)
    {
        try {
            $tagihan = Tagihan::findOrFail($tagihanId);
            $upload = Upload::where('parent_id', $tagihan->id)->first();

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
        return view('tagihan.detail', compact('tagihan', 'upload'));
    }

    public function uploadBukti(Request $request)
    {
        try {
            $request->validate([
                'fileInput' => 'required|file|image|max:2048',
            ]);
            DB::beginTransaction();
            $tagihan = Tagihan::findOrFail($request->tagihanId);
            if ($request->hasFile('fileInput')) {
                $uploadController = new UploadController();
                $newPhoto = $uploadController->uploadPhoto($request, $tagihan->id);
                $responseData = json_decode($newPhoto->getContent(), true);

                if ($responseData['responseCode'] != '200') {
                    return redirect()->back()->with('error', 'Failed Upload Bukti Tagihan!');
                }
                $tagihan->status = 'ON PROCESS';
                $tagihan->save();
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed Upload Bukti Tagihan!: ' . $e->getMessage());
        }
        return redirect()->back()->with('success', 'Success Upload Bukti Tagihan!');
    }

    public function deleteBukti(Request $request)
    {
        try {
            $tagihan = Tagihan::findOrFail($request->tagihanId);

            $uploadController = new UploadController();
            $deletePhoto = $uploadController->deleteUploadById($request->uploadId);
            $responseData = json_decode($deletePhoto->getContent(), true);
            if ($responseData['responseCode'] != '200') {
                session()->flash('error', 'Failed Delete Bukti Tagihan!');
                return BaseResponse::errorResponse('Failed Delete Bukti Tagihan!');
            }

            $tagihan->status = 'WAITING FOR PAYMENT';
            $tagihan->save();
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
            return BaseResponse::errorResponse('Failed Delete Bukti Tagihan: ' . $e->getMessage());
        }
        session()->flash('success', 'Success Delete Bukti Tagihan!');
        return BaseResponse::successResponse("Success Delete Bukti Tagihan!");
    }

    public function updateTunggakan()
    {
        try {
            DB::beginTransaction();
            $dataTagihans = Tagihan::where('status', 'WAITING FOR PAYMENT')
                ->where('jatuh_tempo', '<', Carbon::now())
                ->get();

            foreach ($dataTagihans as $tagihan) {
                $totalTagihan = preg_replace('/\D/', '', $tagihan->total_tagihan);
                $tunggakan = preg_replace('/\D/', '', $tagihan->tunggakan);

                $tunggakanBulanIni = ($totalTagihan * 0.0075); //Bunga tunggakan (bunga pokok(9%) / 12bulan) = 0.09 / 12 = 0.0075

                $tagihan->tunggakan = $tunggakan + $tunggakanBulanIni;
                $tagihan->total_tagihan = $totalTagihan + $tunggakanBulanIni;
                $tagihan->jatuh_tempo = Carbon::now()->addMonths(1)->day(27);
                $tagihan->save();

                $user = $tagihan->pinjaman->user;
                $user->pinjaman_sebelumnya = PinjamanSebelumnyaEnum::Macet;
                $user->save();
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('Error update tunggakan   ---   ' . $e->getMessage());
        }
    }    
}
