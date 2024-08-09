@extends('components.layout')
@section('heading')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Laporan Pinjaman</h1>
</div>
@endsection
@section('content')
<div class="row px-2">
    <div class="card shadow col-xl-12 col-md-12 mb-4">
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Pinjaman</h6>
            <h6 class="m-0 font-weight-bold text-info">{{ $pinjaman->status }}</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" value="{{ Auth::user()->name }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="jumlahPinjaman" class="form-label">Total Pinjaman</label>
                        <input type="text" class="form-control" name="jumlahPinjaman" id="jumlahPinjaman" value="{{ $pinjaman->total_pinjaman }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="bank" class="form-label">Bank</label>
                        <input type="text" class="form-control" name="bank" id="bank" value="{{ $pinjaman->bank }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="tenor" class="form-label">Tenor</label>
                        <input type="text" class="form-control" name="tenor" id="tenor" value="{{ $pinjaman->tenor }} Bulan" disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" name="email" id="email" value="{{ Auth::user()->email }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="namaPemilikRekening" class="form-label">Nama Pemilik Rekening</label>
                        <input type="text" class="form-control" name="namaPemilikRekening" id="namaPemilikRekening" value="{{ $pinjaman->nama_pemilik_rekening }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="noRekening" class="form-label">No. Rekening</label>
                        <input type="text" class="form-control" name="noRekening" id="noRekening" value="{{ $pinjaman->no_rek }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status Pinjaman</label>
                        <input type="text" class="form-control" name="status" id="status" value="{{ $pinjaman->status }}" disabled>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
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
                            <th>No.</th>
                            <th>ID Tagihan</th>
                            <th>Jumlah Tagihan</th>
                            <th>Tenor</th>
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
                            <td class="align-middle">{{ $tagihan->angsuran }} Dari {{$tagihan->pinjaman->tenor}}</td>
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
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('fileInput');
        const fileError = document.getElementById('file-error');

        if (fileInput) {
            fileInput.addEventListener('change', function(event) {
                const files = event.target.files;
                let allFilesValid = true;

                if (files.length > 0) {
                    const uploadedFiles = new FormData();

                    for (const file of files) {
                        const fileType = file.type.toLowerCase();

                        if (fileType === "image/jpeg" || fileType === "image/png") {
                            uploadedFiles.append('files[]', file);
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const fileLabel = document.getElementById('fileName');
                                fileLabel.innerText = file.name;
                                fileError.style.display = 'none';
                            };
                            reader.readAsDataURL(file);
                        } else {
                            allFilesValid = false;
                            break;
                        }
                    }

                    if (!allFilesValid) {
                        fileError.innerText = 'Only JPG and PNG files are allowed.';
                        fileError.style.display = 'block';
                        fileInput.value = '';
                    }
                }
            });
        }
    });

    function deleteImage(imageId) {
        if (confirm('Hapus Bukti Tagihan?')) {
            const formData = new FormData();
            formData.append('_method', 'DELETE'); // This is for Laravel method spoofing
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('uploadId', imageId);
            formData.append('tagihanId', document.getElementById('idTagihan').value);

            fetch(`/tagihan/upload/${imageId}`, {
                    method: 'POST', // Use POST method to support FormData
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: formData
                })
                .then(response => {
                    if (response.ok) {
                        location.reload(); // Reload the page after successful deletion
                    } else {
                        console.error('Failed to delete the image.');
                    }
                })
                .catch(error => console.error('Error deleting image:', error));
        }
    }
</script>