@extends('components.layout')
@section('heading')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create User</h1>
    </div>
@endsection
@section('content')
    <div class="row px-2">
        <div class="card shadow col-xl-12 col-md-12 mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 font-weight-bold text-primary">Create User</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.user.create') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control alphabet-format" name="name" id="name"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="noTelp" class="form-label">No. Telp</label>
                                <input type="number" class="form-control" name="noTelp" id="noTelp" required>
                            </div>
                            <div class="mb-3">
                                <label for="tempatLahir" class="form-label">Tempat Lahir</label>
                                <select class="form-control" name="tempatLahir" id="tempatLahir" required>
                                    <option value="">--Tempat Lahir--</option>
                                    @foreach (json_decode(file_get_contents('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')) as $tempat)
                                        <option value="{{ $tempat->name }}">{{ $tempat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="agama" class="form-label">Agama</label>
                                <select class="form-control" name="agama" id="agama" required>
                                    <option value="">--Agama--</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen Protestan">Kristen Protestan</option>
                                    <option value="Kristen Katolik">Kristen Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Konghucu">Konghucu</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="statusKeanggotaan" class="form-label">Status Keanggotaan</label>
                                <select class="form-control" name="statusKeanggotaan" id="statusKeanggotaan" required>
                                    <option value="">--Status Keanggotaan--</option>
                                    <option value="Pengurus">Pengurus</option>
                                    <option value="Pengawas">Pengawas</option>
                                    <option value="Anggota">Anggota</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="penghasilanPerbulan" class="form-label">Penghasilan Perbulan</label>
                                <input type="text" class="form-control nominal-format" name="penghasilanPerbulan"
                                    id="penghasilanPerbulan" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" required>
                            </div>
                            <div class="mb-3">
                                <label for="umur" class="form-label">Umur</label>
                                <input type="text" class="form-control" name="umur" id="umur" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="tanggalLahir" class="form-label">Tanggal Lahir</label>
                                <input id="tanggalLahir" name="tanggalLahir" class="form-control" type="date" required>
                            </div>
                            <div class="mb-3">
                                <label for="statusPerkawinan" class="form-label">Status Perkawinan</label>
                                <select class="form-control" name="statusPerkawinan" id="statusPerkawinan" required>
                                    <option value="">--Status Perkawinan--</option>
                                    <option value="Menikah">Menikah</option>
                                    <option value="Lajang">Lajang</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="luasLahan" class="form-label">Luas Lahan (ha)</label>
                                <input type="text" class="form-control number-format" name="luasLahan" id="luasLahan"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="penghasilanPanen" class="form-label">Penghasilan Panen</label>
                                <input type="text" class="form-control nominal-format" name="penghasilanPanen"
                                    id="penghasilanPanen" required>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-5">
                        <button type="submit" class="btn btn-success w-100">Save</button>
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

        document.getElementById('tanggalLahir').addEventListener('change', function() {
            let birthdate = this.value;
            if (birthdate) {
                let today = new Date();
                let birthdateDate = new Date(birthdate);
                let age = today.getFullYear() - birthdateDate.getFullYear();
                let m = today.getMonth() - birthdateDate.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < birthdateDate.getDate())) {
                    age--;
                }
                document.getElementById('umur').value = age;
            }
        });
    });
</script>
