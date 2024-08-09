@extends('components.layout')

@section('heading')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Haloo, {{ Auth::user()->name }}</h1>
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
                @foreach($statusPinjaman as $status => $count)
                <h4 class="small font-weight-bold">{{ ucfirst($status) }} <span class="float-right">{{ $count }}</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar @switch($status)
                                @case('pending') bg-warning @break
                                @case('onGoing') bg-info @break
                                @case('paid') bg-success @break
                                @case('rejected') bg-danger @break
                                @endswitch" role="progressbar" style="width: {{ ($count / array_sum($statusPinjaman)) * 100 }}%" aria-valuenow="{{ ($count / array_sum($statusPinjaman)) * 100 }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tagihan</h6>
            </div>
            <div class="card-body">
                @foreach($statusTagihan as $status => $count)
                <h4 class="small font-weight-bold">{{ ucfirst($status) }} <span class="float-right">{{ $count }}</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar @switch($status)
                                @case('waiting') bg-secondary @break
                                @case('onProcess') bg-info @break
                                @case('paid') bg-success @break
                                @case('rejected') bg-danger @break
                                @endswitch" role="progressbar" style="width: {{ ($count / array_sum($statusTagihan)) * 100 }}%" aria-valuenow="{{ ($count / array_sum($statusTagihan)) * 100 }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection