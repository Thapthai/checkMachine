@extends('layouts.app')
@push('styles')
    <style>
        body {
            background-color: #dae7da;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row mb-2">
                <div class="col">
                    <a href="{{ url('/') }}" class="btn btn-sm btn-warning">กลับ</a>
                </div>
            </div>



            <div class="row">
                <div class="col">
                    <h4><strong>{{ $appName }} <strong> | แผนก :</strong>{{ $department->name }}</strong></h4>
                </div>
            </div>
            <hr>

            <h4><strong>Schedule Check</strong></h4>
            @foreach ($frequencyChecks as $frequencyCheck)
                <a href="{{ route('new.app.resin.line', [$department->id, $app, $frequencyCheck->id]) }}"
                    class="btn btn-success m-2" style="width: 24rem;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $frequencyCheck->name }}</h5>
                    </div>
                </a>
            @endforeach
        </div>


    </div>
@endsection
