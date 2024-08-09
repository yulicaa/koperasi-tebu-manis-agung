@extends('components.layout')
@section('heading')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Pinjaman</h1>
</div>
@endsection
@section('content')
<div class="row px-2">
    <div class="card shadow col-xl-12 col-md-12 mb-4">
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Detail Pinjaman</h6>
            <h6 class="m-0 font-weight-bold text-info">{{ $dataPinjaman->status }}</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" class="form-control" id="idUser" value="{{ $dataPinjaman->user->id }}" hidden>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" value="{{ $dataPinjaman->user->name }}" @if (Auth::user()->role === 'ADMIN') onclick="detailUser()" style="cursor: pointer"
                        @else
                        disabled @endif
                        readonly>
                    </div>
                    <div class="mb-3">
                        <label for="jumlahPinjaman" class="form-label">Total Pinjaman</label>
                        <input type="text" class="form-control" name="jumlahPinjaman" id="jumlahPinjaman" value="{{ $dataPinjaman->total_pinjaman }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="bank" class="form-label">Bank</label>
                        <input type="text" class="form-control" name="bank" id="bank" value="{{ $dataPinjaman->bank }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="tipePinjaman" class="form-label">Tipe Pinjaman</label>
                        <input type="text" class="form-control" name="tipePinjaman" id="tipePinjaman" value="{{ $dataPinjaman->tipe_pinjaman }}" disabled>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" name="email" id="email" value="{{ Auth::user()->email }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="namaPemilikRekening" class="form-label">Nama Pemilik Rekening</label>
                        <input type="text" class="form-control" name="namaPemilikRekening" id="namaPemilikRekening" value="{{ $dataPinjaman->nama_pemilik_rekening }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="noRekening" class="form-label">No. Rekening</label>
                        <input type="text" class="form-control" name="noRekening" id="noRekening" value="{{ $dataPinjaman->no_rek }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="tenor" class="form-label">Tenor</label>
                        <input type="text" class="form-control" name="tenor" id="tenor" value="{{ $dataPinjaman->tenor }} Bulan" disabled>
                    </div>

                </div>
                @if (Auth::user()->role === 'ADMIN')
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status Pinjaman</label>
                        <input type="text" class="form-control" name="status" id="status" value="{{ $dataPinjaman->status }}" disabled>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="statusKelayakan" class="form-label">Status Kelayakan</label>
                        <input type="text" class="form-control" name="statusKelayakan" id="statusKelayakan" value="{{ $dataPinjaman->status_kelayakan }}" disabled>
                    </div>
                </div>
                @else
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status Pinjaman</label>
                        <input type="text" class="form-control" name="status" id="status" value="{{ $dataPinjaman->status }}" disabled>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @if (Auth::user()->role === 'ADMIN' && $dataPinjaman->status === 'PENDING')
        <form method="POST" action="{{ route('pinjaman.update', ['pinjamanId' => $dataPinjaman->id]) }}">
            @csrf
            @method('PATCH')
            <input type="hidden" name="pinjamanId" value="{{ $dataPinjaman->id }}">
            <div class="col-md-12 d-flex justify-content-center mt-2 mb-5">
                <button type="submit" name="action" value="APPROVED" class="btn btn-success w-100 mx-2">Approve</button>
                <button type="submit" name="action" value="REJECTED" class="btn btn-danger w-100 mx-2">Reject</button>
            </div>
        </form>
        @endif
    </div>
</div>
@if (!in_array($dataPinjaman->status, ['PENDING', 'REJECTED']) && $dataPinjaman->tipe_pinjaman != 'Potongan')
<div class="row px-2">
    <div class="card shadow col-xl-12 col-md-12 mb-4">
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Tagihan</h6>
            {{-- <a href="{{ route('tagihan.create.page') }}" class="btn btn-primary btn-sm">Ajukan tagihan</a> --}}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Tagihan</th>
                            <th>Jumlah Tagihan</th>
                            <th>Tenor</th>
                            <th>Jatuh Tempo</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($dataTagihans->isNotEmpty())
                        @foreach ($dataTagihans as $tagihan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="align-middle">{{ $tagihan->id }}</td>
                            <td class="align-middle">{{ $tagihan->total_tagihan }}</td>
                            <td class="align-middle">{{ $tagihan->angsuran }} Dari
                                {{ $tagihan->pinjaman->tenor }}
                            </td>
                            <td class="align-middle">
                                {{ $tagihan->jatuh_tempo ? \Carbon\Carbon::parse($tagihan->jatuh_tempo)->format('d-m-Y') : '-' }}
                            </td>
                            <td class="align-middle">{{ $tagihan->status }}</td>
                            <td class="text-center">
                                <a href="{{ route('tagihan.detail', ['tagihanId' => $tagihan->id]) }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                {{-- <a href="#" class="delete-tagihan-btn" data-toggle="modal" data-target="#deleteUserModal" data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-nik="{{ $user->nik }}" data-no-telp="{{ $user->no_telp }}">
                                <i class="fas fa-trash"></i>
                                </a> --}}
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="6" class="text-center">No data available</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $dataTagihans->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

<script>
    function detailUser() {
        const userId = document.getElementById('idUser').value;
        const url = "{ route('admin.user.detail', ['userId' => ': userId']) }}".replace(':userId', userId);
        window.location.href = url;
    }
</script>