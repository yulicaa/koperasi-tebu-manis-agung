<div class="card shadow col-xl-12 col-md-12 mb-4">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Cara Pembayaran</h6>
        <div class="col-6 text-left">
            <h6 class="m-0 font-weight-bold text-primary">Bukti Transfer</h6>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-2">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">1. Transfer ke Bank BCA</li>
                        <li class="list-group-item">2. Masukkan rekening tujuan: <b>0830435685</b> A/N <b>PT
                                Tebu Manis Agung</b></li>
                        <li class="list-group-item">3. Masukkan nominal transfer:
                            <b>{{ $tagihan->total_tagihan }}</b>
                        </li>
                        <li class="list-group-item">4. Screenshot bukti transaksi</li>
                        <li class="list-group-item">5. Upload bukti transaksi</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                @if ($upload && $upload->count() > 0)
                <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                    <div class="image-card-mycars">
                        <img class="border" style="width: 200px; height: 150px; object-fit: cover; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" src="{{ asset('storage/uploads/' . $upload->file_name . '.' . $upload->file_type) }}" alt="{{ $upload->file_name . '.' . $upload->file_type }}">
                        @if ($tagihan->status === 'ON PROCESS')
                        <button type="button" class="delete-button-mycars" style="position:absolute;top:0;right:0;background-color:rgba(255,0,0,0.7);color:#fff;border:none;border-radius:50%;cursor:pointer;width:25px;height:25px;display:flex;align-items:center;justify-content:center;" onclick="deleteImage('{{ $upload->id }}')">X</button>
                        @endif
                    </div>
                </div>
                @else
                <form method="POST" action="{{ route('upload.bukti') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="tagihanId" id="tagihanId" value="{{ $tagihan->id }}" hidden>
                    <div class="input-group mb-3">
                        <div class="custom-file">
                            <input type="file" name="fileInput" class="custom-file-input" id="fileInput">
                            <label id="fileName" class="custom-file-label" for="fileInput" aria-describedby="inputGroupFileAddon02" required>Choose file</label>
                        </div>
                    </div>
                    <div id="file-error" class="invalid-feedback mb-3"></div>
                    <div class="input-group">
                        <button class="btn btn-success w-100">Upload</button>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>