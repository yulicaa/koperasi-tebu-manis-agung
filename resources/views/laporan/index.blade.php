@extends('components.layout')
@section('heading')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 hide-print">Laporan</h1>
    <a onclick="printLaporan()" class="btn btn-primary btn hide-print">Print <i class="fas fa-print"></i></a>
</div>
@endsection
@section('content')
<!-- Content Row -->
<div id="main-container" class="row px-2">
    <div class="card shadow col-xl-12 col-md-12 mb-4">
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Laporan</h6>
            <form method="GET" action="{{ route('laporan.index') }}" class="d-flex align-items-center">
                <!-- Month Filter -->
                <select name="month" class="form-control mr-2" onchange="this.form.submit()">
                    <option value="">Month</option>
                    @foreach (range(1, 12) as $month)
                    <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::createFromFormat('m', $month)->format('F') }}
                    </option>
                    @endforeach
                </select>

                <!-- Year Filter -->
                <select name="year" class="form-control mr-2" onchange="this.form.submit()">
                    <option value="">Year</option>
                    @foreach (range(date('Y'), date('Y') - 10) as $year)
                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                    @endforeach
                </select>

                <!-- Status Filter -->
                {{-- <select name="status" class="form-control mr-2">
                        <option value="">Status</option>
                        <option value="PENDING" {{ request('status') == 'PENDING' ? 'selected' : '' }}>Pending</option>
                <option value="ON GOING" {{ request('status') == 'ON GOING' ? 'selected' : '' }}>On Going</option>
                <option value="PAID" {{ request('status') == 'PAID' ? 'selected' : '' }}>Paid</option>
                <option value="REJECTED" {{ request('status') == 'REJECTED' ? 'selected' : '' }}>Rejected</option>
                </select> --}}

                <!-- Submit Button -->
                {{-- <button type="submit" class="btn btn-primary">Filter</button> --}}
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            {{-- <th>ID Tagihan</th> --}}
                            <th>Nama</th>
                            <th>Angsuran</th>
                            <th>Jumlah Tagihan</th>
                            <th>Tanggal Bayar</th>
                            {{-- <th>Status</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($dataTagihans->isNotEmpty())
                        @foreach ($dataTagihans as $tagihan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            {{-- <td class="align-middle">{{ $tagihan->id }}</td> --}}
                            <td class="align-middle">{{ $tagihan->user->name }}</td>
                            <td class="align-middle">{{ $tagihan->angsuran }} dari {{$tagihan->pinjaman->tenor}}</td>
                            <td class="align-middle">{{ $tagihan->total_tagihan }}</td>
                            <td class="align-middle">{{ $tagihan->updated_at->format('d-m-Y H:i:s') }}</td>
                            {{-- <td class="align-middle">{{ $tagihan->status }}</td> --}}
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
    // function printLaporan() {
    //     window.location.href = '{{ route('laporan.print') }}';
    // }

    function printLaporan() {
        const month = document.querySelector('select[name="month"]').value;
        const year = document.querySelector('select[name="year"]').value;
        // const status = document.querySelector('select[name="status"]').value;

        const url = new URL("{{ route('laporan.print') }}", window.location.origin);
        if (month) url.searchParams.append('month', month);
        if (year) url.searchParams.append('year', year);
        // if (status) url.searchParams.append('status', status);

        window.location.href = url.toString();
    }
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
                form.action = "{{ route('admin.user.delete', ['userId' => ':userId']) }}"
                    .replace(':userId', userId);
            });
        });
    });
</script>
@endsection