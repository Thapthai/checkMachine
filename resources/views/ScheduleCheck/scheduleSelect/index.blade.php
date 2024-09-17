@extends('layouts.app')

@push('styles')
    <style>
        div[id^="business"]:not(:target) {
            display: none;
        }

        .show-image {
            width: 570px;
            height: 520px;
            overflow: hidden;

        }

        .show-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        @media screen and (max-width: 900px) {

            .show-image {
                width: 275px;
                height: 415px;
                overflow: hidden;
            }

            .show-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                object-position: center;
            }

        }
    </style>
@endpush


@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <h5><strong>กะ : {{ $onshift }} | วันที่ {{ $shiftDate }} </strong></h5>
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-warning">
                    <p>{{ $message }}</p>
                </div>
            @endif


        </div>

        <div class="row">
            <div class="col">
                <a href="{{ route('lines', [$department->id, $onshift, $selected, $shiftDate]) }}"
                    class="btn btn-warning">กลับ</a>
                <a href="{{ url('/') }}" class="btn btn-primary">หน้าแรก</a>

            </div>

            <div class="col-auto">
                @if (Auth::user()->is_admin == '1')
                    <div class="pull-right mb-2">
                        <button type="button" class="btn btn-success my-2 mt-2" style="width: 300px" data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">
                            เพิ่มเครื่องจักรที่จะตรวจสอบ
                        </button>
                    </div>
                @endif

            </div>
        </div>
        <hr>
        <div class="row">
            @foreach ($frequencyChecks as $frequencyCheck)
                <div class="col">
                    <a href="{{ route('machines_schedule', [$department->id, $onshift, $selected, $line->id, $frequencyCheck->id, $shiftDate]) }}"
                        class="btn btn-outline-primary w-100">{{ $frequencyCheck->name }}</a>
                </div>
            @endforeach
        </div>

    </div>
@endsection
