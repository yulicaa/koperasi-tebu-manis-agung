@extends('components.layout')
@section('heading')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tagihan</h1>
</div>
@endsection
@section('content')
<!-- Content Row -->
<div class="row px-2">
    <div class="card shadow col-xl-12 col-md-12 mb-4">
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Tagihan</h6>
            {{-- Search Form --}}
            {{-- <form method="GET" action="{{ route('tagihan.index') }}" class="form-inline">
            <input type="text" name="search" class="form-control mr-2" placeholder="Search...">
            <button type="submit" class="btn btn-primary">Search</button>
            </form> --}}
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
                            <td class="align-middle">{{ $tagihan->angsuran }} Dari {{$tagihan->pinjaman->tenor}}</td>
                            <td class="align-middle">{{ \Carbon\Carbon::parse($tagihan->jatuh_tempo)->format('d-m-Y') }}</td>
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
                            <td colspan="7" class="text-center">No data available</td>
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

<!-- Delete User Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel">Delete User?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteUserForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" disabled>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" disabled>
                    </div>
                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" disabled>
                    </div>
                    <div class="form-group">
                        <label for="no_telp">No. Telp</label>
                        <input type="text" class="form-control" id="noTelp" name="noTelp" disabled>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-user-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Get user data from data attributes
                const name = this.getAttribute('data-name');
                const email = this.getAttribute('data-email');
                const nik = this.getAttribute('data-nik');
                const noTelp = this.getAttribute('data-no-telp');

                // Populate modal form fields
                document.getElementById('name').value = name;
                document.getElementById('email').value = email;
                document.getElementById('nik').value = nik;
                document.getElementById('noTelp').value = noTelp;

                // Set the form action dynamically based on user ID
                const userId = this.dataset.userId; // Ensure you have this dataset in your HTML
                const form = document.getElementById('deleteUserForm');
                form.action = "{{ route('admin.user.delete', ['userId' => ':userId']) }}".replace(':userId', userId);
            });
        });
    });
</script>
@endsection