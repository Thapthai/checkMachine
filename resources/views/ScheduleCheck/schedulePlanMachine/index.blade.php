@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            {{-- <h5><strong>กะ : {{ $onshift }} | วันที่ {{ $shiftDate }} </strong></h5> --}}
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

        {{-- <div class="row">
            <div class="col">
                <a href="{{ route('lines', [$department->id, $onshift, $selected, $shiftDate]) }}"
                    class="btn btn-warning">กลับ</a>
                <a href="{{ url('/') }}" class="btn btn-primary">หน้าแรก</a>

            </div>

        </div> --}}

        <h3>Schedule Plan {{ $machine->name }}</h3>
        <hr>
        <form
            action="{{ route('schedule_plan', [$department->id, $onshift, $selected, $line->id, $machine->id, $shiftDate]) }}"
            method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            @foreach ($frequencyChecks as $frequencyCheck)
                <div class="border border-2 rounded-1 p-2 mb-3">
                    {{-- <div class="alert alert-success mt-2"> --}}
                    <h5><strong>

                            @switch($frequencyCheck->name)
                                @case('Weekly')
                                    ตรวจสอบ ของสัปดาห์
                                @break

                                @case('Monthly')
                                    ตรวจสอบ ของแต่ละเดือน
                                @break

                                @default
                                    ตรวจสอบ ทุกวัน
                            @endswitch
                        </strong></h5>
                    {{-- </div> --}}

                    <div class="card card-body">
                        @foreach ($machine->resins as $resin)
                            <div class="form-check">

                                <input class="form-check-input" type="checkbox"
                                    name="scheduleResins[{{ $frequencyCheck->id }}][{{ $resin->id }}]"
                                    @foreach ($frequencyCheck->schedulePlans as $schedulePlan)
                                @if ($resin->id == $schedulePlan->resin_id) checked @endif @endforeach>
                                <label class="form-check-label mt-2">
                                    {{ $resin->id }} ||
                                    {{ $resin->position }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                </div>
            @endforeach

            <button type="submit" class="btn btn-secondary my-2 w-100">บันทึก</button>
        </form>

    </div>
@endsection
