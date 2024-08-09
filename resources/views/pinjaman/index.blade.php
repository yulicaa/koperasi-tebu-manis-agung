@extends('components.layout')
@section('heading')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Pinjaman</h1>
    @if (Auth::user()->role === 'USER')
    <a href="{{ route('pinjaman.create.page') }}" class="btn btn-primary btn" style="white-space: nowrap;">Ajukan
        Pinjaman</a>
    @endif
</div>
@endsection
@section('content')
<!-- Content Row -->
<div class="row px-2">
    <div class="card shadow col-xl-12 col-md-12 mb-4">
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Pinjaman</h6>
            <form method="GET" action="{{ route('pinjaman.index') }}" class="d-flex align-items-center">
                <!-- Status Filter -->
                <select name="status" class="form-control mr-2" onchange="this.form.submit()">
                    <option value="">All</option>
                    <option value="PENDING" {{ request('status') == 'PENDING' ? 'selected' : '' }}>Pending</option>
                    <option value="ON GOING" {{ request('status') == 'ON GOING' ? 'selected' : '' }}>On Going</option>
                    <option value="PAID" {{ request('status') == 'PAID' ? 'selected' : '' }}>Paid</option>
                    <option value="REJECTED" {{ request('status') == 'REJECTED' ? 'selected' : '' }}>Rejected</option>
                </select>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No. </th>
                            <th>ID Pinjaman</th>
                            <th>Nama Peminjam</th>
                            <th>Total Pinjaman</th>
                            <th>Tenor</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($dataPinjamans->isNotEmpty())
                        @foreach ($dataPinjamans as $pinjaman)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="align-middle">{{ $pinjaman->id }}</td>
                            <td class="align-middle">{{ $pinjaman->user->name }}</td>
                            <td class="align-middle">{{ $pinjaman->total_pinjaman }}</td>
                            <td class="align-middle">{{ $pinjaman->tenor }} Bulan</td>
                            <td class="align-middle">{{ $pinjaman->status }}</td>
                            <td class="text-center">
                                <a href="{{ route('pinjaman.detail', ['pinjamanId' => $pinjaman->id]) }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                {{-- <a href="#" class="delete-pinjaman-btn" data-toggle="modal" data-target="#deleteUserModal" data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-nik="{{ $user->nik }}" data-no-telp="{{ $user->no_telp }}">
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
                    {{ $dataPinjamans->links('pagination::bootstrap-5') }}
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

{{-- <script>
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
</script> --}}
@endsection