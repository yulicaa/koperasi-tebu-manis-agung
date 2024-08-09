@extends('components.layout')
@section('heading')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Profile</h1>
    </div>
@endsection
@php
    $user = Auth::user();
@endphp
@section('content')
    <div class="row px-2">
        @if ($user->role === 'USER')
            <div class="card shadow col-xl-12 col-md-12 mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profile</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control alphabet-format" name="name" id="name"
                                    value="{{ $user->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="noTelp" class="form-label">No. Telp</label>
                                <input type="text" class="form-control number-format" name="noTelp" id="noTelp"
                                    value="{{ $user->no_telp }}" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="tempatLahir" class="form-label">Tempat Lahir</label>
                                <select class="form-control" name="tempatLahir" id="tempatLahir" required>
                                    <option value="">--Tempat Lahir--</option>
                                    @foreach (json_decode(file_get_contents('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')) as $tempat)
                                        <option value="{{ $tempat->name }}"
                                            @if ($tempat->name == $user->tempat_lahir) selected @endif>
                                            {{ $tempat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="agama" class="form-label">Agama</label>
                                <select class="form-control" name="agama" id="agama" required>
                                    <option value="">--Agama--</option>
                                    <option value="Islam" @if ($user->agama == 'Islam') selected @endif>Islam</option>
                                    <option value="Kristen Protestan" @if ($user->agama == 'Kristen Protestan') selected @endif>
                                        Kristen
                                        Protestan</option>
                                    <option value="Kristen Katolik" @if ($user->agama == 'Kristen Katolik') selected @endif>
                                        Kristen
                                        Katolik</option>
                                    <option value="Hindu" @if ($user->agama == 'Hindu') selected @endif>Hindu</option>
                                    <option value="Buddha" @if ($user->agama == 'Buddha') selected @endif>Buddha</option>
                                    <option value="Konghucu" @if ($user->agama == 'Konghucu') selected @endif>Konghucu
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="statusKeanggotaan" class="form-label">Status Keanggotaan</label>
                                <input type="text" class="form-control" name="statusKeanggotaan" id="statusKeanggotaan"
                                    value="{{ $user->status_keanggotaan }}" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="penghasilanPerbulan" class="form-label">Penghasilan Perbulan</label>
                                <input type="text" class="form-control" name="penghasilanPerbulan"
                                    id="penghasilanPerbulan" value="{{ $user->penghasilan_perbulan }}" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="statusPinjaman" class="form-label">Status Pinjaman</label>
                                <input type="text" class="form-control" name="statusPinjaman" id="statusPinjaman"
                                    value="{{ $user->status_pinjaman }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ $user->email }}"
                                    disabled>
                            </div>
                            <div class="mb-3">
                                <label for="umur" class="form-label">Umur</label>
                                <input type="text" class="form-control" name="umur" id="umur"
                                    value="{{ $user->umur }}" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="tanggalLahir" class="form-label">Tanggal Lahir</label>
                                <input id="tanggalLahir" name="tanggalLahir" class="form-control" type="date"
                                    value="{{ $user->tanggal_lahir }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="statusPerkawinan" class="form-label">Status Perkawinan</label>
                                <select class="form-control" name="statusPerkawinan" id="statusPerkawinan" required>
                                    <option value="">--Status Perkawinan--</option>
                                    <option value="Menikah" @if ($user->status_perkawinan == 'Menikah') selected @endif>Menikah
                                    </option>
                                    <option value="Lajang" @if ($user->status_perkawinan == 'Lajang') selected @endif>Lajang
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="luasLahan" class="form-label">Luas Lahan (ha)</label>
                                <input type="text" class="form-control" name="luasLahan" id="luasLahan"
                                    value="{{ $user->luas_lahan }}" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="penghasilanPanen" class="form-label">Penghasilan Panen</label>
                                <input type="text" class="form-control" name="penghasilanPanen" id="penghasilanPanen"
                                    value="{{ $user->penghasilan_panen }}" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="pinjamanSebelumnya" class="form-label">Pinjaman Sebelumnya</label>
                                <input type="text" class="form-control" name="pinjamanSebelumnya"
                                    id="pinjamanSebelumnya" value="{{ $user->pinjaman_sebelumnya }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="card shadow col-xl-12 col-md-12 mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 font-weight-bold text-primary">Change Password</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('change.password', ['userId' => $user->id]) }}">
                    @csrf
                    {{-- <input type="hidden" name="_method" value="PATCH" /> --}}
                    <input type="hidden" name="userId" id="userId" value="{{ $user->id }}">
                    @method('PATCH')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" class="form-control" name="password" id="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" name="confirmPassword" id="confirmPassword"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        <button type="submit" class="btn btn-success w-100">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
