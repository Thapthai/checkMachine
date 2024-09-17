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
                    <a href="{{ route('new.app.resin.line', [$department->id, $app, $frequencyCheck->id]) }}"
                        class="btn btn-sm btn-warning">กลับ</a>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h4><strong>{{ $appName }} <strong> | แผนก :</strong>{{ $department->name }}</strong></h4>

                </div>
            </div>
            <hr>


            <div class="row">
                <div class="col">
                    <h4><strong>{{ $frequencyCheck->name }} | ไลน์ผลิต : {{ $line->name }}</strong></h4>
                </div>
                <div class="col-auto">
                    <h4><strong> เลือกเครื่องจักร</strong></h4>

                </div>
            </div>

            <form action="{{ route('new.app.resin.machine', [$department->id, $app, $frequencyCheck->id, $line->id]) }}"
                method="get" enctype="multipart/form-data">
                @csrf
                <div class="input-group mb-2">
                    <input type="text" name="searchMachine" class="form-control" placeholder="ค้นหาชื่อ...เครื่องจักร..."
                        value="{{ $searchMachine }}">
                    <div class="input-group-append mx-2">
                        <a href="{{ route('new.app.resin.machine', [$department->id, $app, $frequencyCheck->id, $line->id]) }}"
                            class="btn btn-secondary" title="คืนค่า"><i class="fa-solid fa-rotate-right"></i></a>
                    </div>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary" title="ค้นหา"><i
                                class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </div>
            </form>


            @foreach ($line->machines->filter(function ($machine) use ($searchMachine) {
            return stripos($machine->name, $searchMachine) !== false;
        }) as $machine)
                @if (count($machine->schedulePlans) > 0)
                    @php
                        $schedulePlans = $machine->schedulePlans->where('frequency_check_id', $frequencyCheck->id);

                        $schedulePlansRecord = $schedulePlans->filter(function ($schedulePlan) use ($shift) {
                            return $schedulePlan->ScheduleRecords->contains(function ($scheduleRecord) use ($shift) {
                                return $scheduleRecord->shift_date == $shift['date'] &&
                                    $scheduleRecord->on_shift == $shift['shift'] &&
                                    $scheduleRecord->detail != 'notuse';
                            });
                        });

                        $schedulePlansRecordNotUse = $schedulePlans->filter(function ($schedulePlan) use ($shift) {
                            return $schedulePlan->ScheduleRecords->contains(function ($scheduleRecord) use ($shift) {
                                return $scheduleRecord->shift_date == $shift['date'] &&
                                    $scheduleRecord->on_shift == $shift['shift'] &&
                                    $scheduleRecord->detail == 'notuse';
                            });
                        });

                        $checkingRecordCount = count($schedulePlansRecordNotUse) + count($schedulePlansRecord);

                    @endphp

                    @if ($schedulePlans->isNotEmpty())
                        @foreach ($schedulePlans as $schedulePlan)
                            {{ $schedulePlan->machines }}
                        @endforeach
                    @endif

                    <div class="col-sm-6 my-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <span>
                                            ตรวจสอบ : {{ count($schedulePlansRecord) }} /
                                            {{ count($schedulePlans) }}
                                        </span> |
                                        <span>ไม่ใช้งาน : {{ count($schedulePlansRecordNotUse) }} /
                                            {{ count($schedulePlans) }}</span> |
                                        <span>รวม : {{ $checkingRecordCount }} /
                                            {{ count($schedulePlans) }}</span>
                                    </div>
                                    <div class="col-auto">

                                        @if ($checkingRecordCount != count($schedulePlans))
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                                data-bs-target="#closeCheckModal-{{ $line->id }}" title="ไม่ใช้งาน">
                                                ปิดใช้งาน
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="closeCheckModal-{{ $line->id }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    department, app, schedule, line
                                                    <form
                                                        action="{{ route('toggleMachineUsage', [$department->id, $app, $frequencyCheck->id, $line->id, $machine->id]) }}"
                                                        method="post">

                                                        @csrf
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">แจ้ง
                                                                    ไม่ได้ใช้งาน
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                ไม่ได้ใช้งานเครื่องจักร {{ $line->name }}

                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button type="submit"
                                                                    class="btn btn-warning">แจ้งไม่ได้ใช้งาน</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif


                                    </div>


                                </div>
                                <hr>
                                <h5>เครื่องจักร: {{ $machine->name }}</h5>

                                <a class="link-secondary" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseDetail-{{ $machine->id }}" aria-expanded="false"
                                    aria-controls="collapseDetail-{{ $machine->id }}">
                                    ดูรายละเอียดเพิ่มเติม
                                </a>
                                <div class="collapse" id="collapseDetail-{{ $machine->id }}">
                                    <p class="card-title"><strong>รายละเอียดเพิ่มเติม:</strong>
                                        {{ $machine->detail }}</p>


                                    <div id="carouselControls-{{ $machine->id }}" class="carousel slide"
                                        data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            <div class="carousel-item active">
                                                @if ($machine->pic1)
                                                    <img src="{{ url('storage/' . $machine->pic1) }}" alt="img"
                                                        class="d-block w-100"
                                                        style="max-height: 500px; object-fit: contain;">
                                                @else
                                                    <img src="{{ asset('icon/no-image.png') }}" alt="img"
                                                        class="d-block w-100" style="height: 500px; object-fit: contain;">
                                                @endif
                                            </div>

                                            @for ($i = 2; $i <= 3; $i++)
                                                @php
                                                    $picAttribute = 'pic' . $i; // สร้างชื่อ attribute ของรูปภาพ
                                                @endphp
                                                <div class="carousel-item">
                                                    @if ($machine->$picAttribute)
                                                        <img src="{{ url('storage/' . $machine->$picAttribute) }}"
                                                            alt="img" class="d-block w-100"
                                                            style="max-height: 500px ; object-fit: contain;">
                                                    @else
                                                        <img src="{{ asset('icon/no-image.png') }}" alt="img"
                                                            class="d-block w-100"
                                                            style="max-height: 500px; object-fit: contain;">
                                                    @endif
                                                </div>
                                            @endfor
                                        </div>


                                        <button class="carousel-control-prev" type="button"
                                            data-bs-target="#carouselControls-{{ $machine->id }}" data-bs-slide="prev">

                                            <span class="carousel-control-prev-icon rounded-2" aria-hidden="true"
                                                style="background-color: #000000"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button"
                                            data-bs-target="#carouselControls-{{ $machine->id }}" data-bs-slide="next">
                                            <span class="carousel-control-next-icon rounded-2" aria-hidden="true"
                                                style="background-color: #000000"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>

                                    </div>
                                </div>
                                @if ($checkingRecordCount != count($schedulePlans))
                                    <div class="text-end mt-2">
                                        <a href="{{ route('new.app.resin.schedule.resin', [$department->id, $app, $frequencyCheck->id, $line->id, $machine->id]) }}"
                                            class="btn btn-success w-100">ดำเนินการตรวจ</a>
                                    </div>
                                @else
                                    <div class="alert alert-success mt-2">
                                        <p>ดำเนินการตรวจ เรียบร้อย</p>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
