@extends('components.layout')
@section('heading')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Halo, {{ Auth::user()->name }}</h1>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pinjaman</h6>
                </div>
                <div class="card-body">
                    <h4 class="small font-weight-bold">Pending<span id="pending-pinjaman" class="float-right">0</span></h4>
                    <div class="progress mb-4">
                        <div id="pending-pinjaman-progress" class="progress-bar bg-warning" role="progressbar"
                            style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">On Going<span id="ongoing-pinjaman" class="float-right">0</span></h4>
                    <div class="progress mb-4">
                        <div id="ongoing-pinjaman-progress" class="progress-bar bg-info" role="progressbar"
                            style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">Paid <span id="paid-pinjaman" class="float-right">0</span></h4>
                    <div class="progress mb-4">
                        <div id="paid-pinjaman-progress" class="progress-bar bg-success" role="progressbar"
                            style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">Rejected<span id="rejected-pinjaman" class="float-right">0</span>
                    </h4>
                    <div class="progress mb-4">
                        <div id="rejected-pinjaman-progress" class="progress-bar bg-danger" role="progressbar"
                            style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tagihan</h6>
                </div>
                <div class="card-body">
                    <h4 class="small font-weight-bold">Pending<span id="pending-tagihan" class="float-right">0</span></h4>
                    <div class="progress mb-4">
                        <div id="pending-tagihan-progress" class="progress-bar bg-secondary" role="progressbar"
                            style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">Waiting for Payment<span id="waiting-tagihan"
                            class="float-right">0</span></h4>
                    <div class="progress mb-4">
                        <div id="waiting-tagihan-progress" class="progress-bar bg-warning" role="progressbar"
                            style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">On Process<span id="onprocess-tagihan" class="float-right">0</span>
                    </h4>
                    <div class="progress mb-4">
                        <div id="onprocess-tagihan-progress" class="progress-bar bg-info" role="progressbar"
                            style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">Paid<span id="paid-tagihan" class="float-right">0</span></h4>
                    <div class="progress mb-4">
                        <div id="paid-tagihan-progress" class="progress-bar bg-success" role="progressbar" style="width: 0%"
                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold">Rejected<span id="rejected-tagihan" class="float-right">0</span>
                    </h4>
                    <div class="progress mb-4">
                        <div id="rejected-tagihan-progress" class="progress-bar bg-danger" role="progressbar"
                            style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


<script>
    document.addEventListener('DOMContentLoaded', function() {
        function updateDashboardData() {
            fetch("{{ route('dashboard.data') }}")
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Update data Pinjaman
                    const pinjaman = data.data.statusPinjaman;
                    document.getElementById('pending-pinjaman').textContent = pinjaman.pending;
                    document.getElementById('ongoing-pinjaman').textContent = pinjaman.onGoing;
                    document.getElementById('paid-pinjaman').textContent = pinjaman.paid;
                    document.getElementById('rejected-pinjaman').textContent = pinjaman.rejected;

                    document.getElementById('pending-pinjaman-progress').style.width = pinjaman.pending + '%';
                    document.getElementById('ongoing-pinjaman-progress').style.width = pinjaman.onGoing + '%';
                    document.getElementById('paid-pinjaman-progress').style.width = pinjaman.paid + '%';
                    document.getElementById('rejected-pinjaman-progress').style.width = pinjaman.rejected + '%';

                    // Update data Tagihan
                    const tagihan = data.data.statusTagihan;
                    document.getElementById('pending-tagihan').textContent = tagihan.pending;
                    document.getElementById('waiting-tagihan').textContent = tagihan.waiting;
                    document.getElementById('onprocess-tagihan').textContent = tagihan.onProcess;
                    document.getElementById('paid-tagihan').textContent = tagihan.paid;
                    document.getElementById('rejected-tagihan').textContent = tagihan.rejected;

                    document.getElementById('pending-tagihan-progress').style.width = tagihan.pending + '%';
                    document.getElementById('waiting-tagihan-progress').style.width = tagihan.waiting + '%';
                    document.getElementById('onprocess-tagihan-progress').style.width = tagihan.onProcess + '%';
                    document.getElementById('paid-tagihan-progress').style.width = tagihan.paid + '%';
                    document.getElementById('rejected-tagihan-progress').style.width = tagihan.rejected + '%';
                })
                .catch(error => {
                    console.error('Error fetching dashboard data:', error);
                });
        }
        updateDashboardData();
        setInterval(updateDashboardData, 5000);
    });
</script>
