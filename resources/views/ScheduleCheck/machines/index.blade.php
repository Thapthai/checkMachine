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

        </div>
        <hr>
        <h5><strong>{{ $frequencyCheck->name }}</strong></h5>



        <h1>
            {{ strtoupper(date('', strtotime($shiftDate))) }}
        </h1>

        @php
            $groupedPlans = $frequencyCheck->schedulePlans->where('line_id', $line->id)->groupBy(function ($item) {
                return $item->resin->machine->id; // ใช้ id ของ machine เป็น key
            });

            // จัดกลุ่มตาม define และดึงค่าจากกลุ่มแรก
            $definedPlans = $frequencyCheck->schedulePlans->where('line_id', $line->id)->groupBy('define');

            $define = $definedPlans->keys()->first(); // ดึง key ของกลุ่มแรก

        @endphp


        @if (strtoupper(date('D', strtotime($shiftDate))) == $define ||
                strtoupper(date('d', strtotime($shiftDate))) == $define ||
                $define == 'D')
            <div class="row">
                @foreach ($groupedPlans as $machineId => $schedulePlans)
                    @php
                        $machine = $schedulePlans->first()->resin->machine;
                    @endphp
                    <div class="col-sm-6 my-2">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="row">

                                    <div class="col">

                                        <h5 class="card-title"><strong>{{ $machine->sequence }}. เครื่องจักร:</strong>
                                            {{ $machine->name }}</h5>
                                    </div>
                                    <div class="col col-auto">
                                        <button class="btn" type="button" data-toggle="collapse"
                                            data-target="#collapseMachine-{{ $machine->id }}" aria-expanded="false"><i
                                                class='bx bx-chevron-down'></i>
                                        </button>
                                    </div>

                                </div>
                                @if ($machine->detail)
                                    <p class="card-text"><strong>รายละเอียด:</strong> {{ $machine->detail }}</p>
                                @else
                                    <p class="card-text"><strong>รายละเอียด:</strong> ไม่มี</p>
                                @endif
                                <div class="collapse" id="collapseMachine-{{ $machine->id }}">
                                    <div class="card card-body">

                                        @if (!is_null($machine->pic1))
                                            <div class="show-image">
                                                <img src="{{ url('storage/' . $machine->pic1) }}" class="m-1"
                                                    style="height: 520px">
                                            </div>
                                        @else
                                            <h5>ไม่มีรูปภาพ</h5>
                                        @endif
                                    </div>
                                </div>

                                <div style="text-align: right" class="mt-2">

                                    {{ $machine->id }}
                                    @if ($frequencyCheck->name == 'Daily')
                                        <a href="{{ route('machines_schedule_check_resin', [$department->id, $onshift, $selected, $line->id, $frequencyCheck->id, $machine->id, 'beforeCheck', $shiftDate]) }}"
                                            class="btn btn-outline-primary">ตรวจสอบ ก่อน</a>

                                        <a href="{{ route('machines_schedule_check_resin', [$department->id, $onshift, $selected, $line->id, $frequencyCheck->id, $machine->id, 'afterCheck', $shiftDate]) }}"
                                            class="btn btn-outline-primary">ตรวจสอบ ก่อน</a>
                                    @else
                                        <a href="{{ route('machines_schedule_check_resin', [$department->id, $onshift, $selected, $line->id, $frequencyCheck->id, $machine->id, 'check', $shiftDate]) }}"
                                            class="btn btn-outline-primary">ตรวจสอบ</a>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-warning">
                <p>ไม่มีกำหนดการ</p>
            </div>
        @endif
    </div>
@endsection
