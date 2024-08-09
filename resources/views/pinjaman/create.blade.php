@extends('components.layout')
@section('heading')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Ajukan Pinjaman</h1>
</div>
@endsection
@section('content')
<div class="row px-2">
    <div class="card shadow col-xl-12 col-md-12 mb-4">
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Ajukan Pinjaman</h6>
            {{-- <h6 class="m-0 font-weight-bold text-danger">Limit Tersedia: {{Auth::user()->limit}}</h6> --}}
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('pinjaman.create') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" value="{{ Auth::user()->name }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="jumlahPinjaman" class="form-label">Total Pinjaman</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp.</span>
                                <input type="text" class="form-control nominal-format" name="jumlahPinjaman" id="jumlahPinjaman" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="namaPemilikRekening" class="form-label">Nama Pemilik Rekening</label>
                            <input type="text" class="form-control alphabet-format" name="namaPemilikRekening" id="namaPemilikRekening" required>
                        </div>
                        <div class="mb-3">
                            <label for="tipePinjaman" class="form-label">Tipe Pinjaman</label>
                            <select class="form-control" name="tipePinjaman" id="tipePinjaman" required>
                                <option value="">--Tipe Pinjaman--</option>
                                <option value="Angsuran">Angsuran</option>
                                <option value="Potongan">Potongan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="Email" class="form-label">Email</label>
                            <input type="email" id="email" class="form-control" value="{{ Auth::user()->email }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="bank" class="form-label">Bank</label>
                            <select class="form-control" name="bank" id="bank">
                                <option value="">--Bank--</option>
                                <option value="BCA">BCA</option>
                                <option value="BRI">BRI</option>
                                <option value="BNI">BNI</option>
                                <option value="Mandiri">Mandiri</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="noRekening" class="form-label">No. Rekening</label>
                            <input type="text" class="form-control number-format" name="noRekening" id="noRekening" required>
                        </div>
                        <div class="mb-3">
                            <label for="tenor" class="form-label">Tenor (Bulan)</label>
                            <input type="number" class="form-control" name="tenor" id="tenor" max="12" required>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-5">
                    <button type="submit" class="btn btn-success w-100">Ajukan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
            .then(response => response.json())
            .then(data => {
                let tempatLahir = document.getElementById('tempatLahir');
                data.forEach(tempat => {
                    let option = document.createElement('option');
                    option.value = tempat.name;
                    option.textContent = tempat.name;
                    tempatLahir.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching provinces:', error));

    });

    function formatNumber(number) {
        return number.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
</script>