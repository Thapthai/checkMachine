@extends('layouts.app')

@push('styles')
    <style>
        body {
            background-color: #dae7da;
        }

        .btn-custom {
            border: 1px solid #dbdbdb;
            background-color: #ffffff;
            width: 100%;
            text-align: start;
            color: black;
            background-position: right bottom;
        }

        .btn-custom:hover {
            background-color: #ffffff;
            border: 1px solid #dbdbdb;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row mb-2">
                <div class="col">
                    <a href="{{ route('new.appSelect', [$department->id, $app]) }}" class="btn btn-sm btn-warning">กลับ</a>
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
                    <h4><strong>{{ $frequencyCheck->name }} </strong></h4>
                </div>
                <div class="col-auto">
                    <h4><strong> เลือกไลน์</strong></h4>

                </div>
            </div>

            @if ($scheduleDefine)
                @if (date('Y-m-d', strtotime($shift['date'])) >= $scheduleDefine['inspectionStartDate'] &&
                        date('Y-m-d', strtotime($shift['date'])) <= $scheduleDefine['inspectionEndDate']
                )
                    <div class="row">
                        @foreach ($lines as $line)
                            @if (count($line->schedulePlans) > 0)
                                @php
                                    $schedulePlans = $line->schedulePlans->where(
                                        'frequency_check_id',
                                        $frequencyCheck->id,
                                    );

                                    $schedulePlansRecord = $schedulePlans->filter(function ($schedulePlan) use (
                                        $shift,
                                    ) {
                                        return $schedulePlan->ScheduleRecords->contains(function ($scheduleRecord) use (
                                            $shift,
                                        ) {
                                            return $scheduleRecord->shift_date == $shift['date'] &&
                                                $scheduleRecord->on_shift == $shift['shift'] &&
                                                $scheduleRecord->detail != 'notuse';
                                        });
                                    });

                                    $schedulePlansRecordNotUse = $schedulePlans->filter(function ($schedulePlan) use (
                                        $shift,
                                    ) {
                                        return $schedulePlan->ScheduleRecords->contains(function ($scheduleRecord) use (
                                            $shift,
                                        ) {
                                            return $scheduleRecord->shift_date == $shift['date'] &&
                                                $scheduleRecord->on_shift == $shift['shift'] &&
                                                $scheduleRecord->detail == 'notuse';
                                        });
                                    });

                                    $checkingRecordCount =
                                        count($schedulePlansRecordNotUse) + count($schedulePlansRecord);

                                @endphp

                                <div class="col-sm-6 mb-2">
                                    <div class="card card-body">
                                        <div class="row">
                                            <div class="col">
                                                <span>ตรวจสอบ : {{ count($schedulePlansRecord) }} /
                                                    {{ count($schedulePlans) }}</span> |
                                                <span>ไม่ใช้งาน : {{ count($schedulePlansRecordNotUse) }} /
                                                    {{ count($schedulePlans) }}</span> |
                                                <span>รวม : {{ $checkingRecordCount }} /
                                                    {{ count($schedulePlans) }}</span>
                                            </div>
                                            <div class="col-auto">


                                                @if ($checkingRecordCount != count($schedulePlans))
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                                        data-bs-target="#closeCheckModal-{{ $line->id }}"
                                                        title="ไม่ใช้งาน">
                                                        ปิดใช้งาน
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="closeCheckModal-{{ $line->id }}"
                                                        tabindex="-1" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            department, app, schedule, line
                                                            <form
                                                                action="{{ route('toggleLineUsage', [$department->id, $app, $frequencyCheck->id, $line->id]) }}"
                                                                method="post">

                                                                @csrf
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">แจ้ง
                                                                            ไม่ได้ใช้งาน
                                                                        </h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        เครื่องจักรภายใน ไลน์ {{ $line->name }}
                                                                        ไม่ได้ใช้งาน

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

                                        <h5 class="card-title"><strong>สายการผลิต:{{ $frequencyCheck->id }}</strong>
                                            {{ $line->name }} </h5>

                                        <p class="card-text"><strong>สถานะ:</strong> {{ $line->status }}</p>
                                        <p class="card-text"><strong>รายละเอียด:</strong> {{ $line->detail }}</p>
                                        <a href="{{ route('new.app.resin.machine', [$department->id, $app, $frequencyCheck->id, $line->id]) }}"
                                            class="btn btn-success">เลือก</a>
                                    </div>

                                </div>
                            @endif
                        @endforeach


                    </div>
                @else
                    <div class="alert alert-warning">
                        <p>ไม่ได้อยู่ ในช่วงตรวจ</p>
                    </div>
                @endif
            @else
                <div class="row">
                    @foreach ($lines as $line)
                        @if (count($line->schedulePlans) > 0)
                            @php
                                $schedulePlans = $line->schedulePlans->where('frequency_check_id', $frequencyCheck->id);
                                $schedulePlansRecord = $schedulePlans->filter(function ($schedulePlan) use ($shift) {
                                    return $schedulePlan->ScheduleRecords->contains(function ($scheduleRecord) use (
                                        $shift,
                                    ) {
                                        return $scheduleRecord->shift_date == $shift['date'] &&
                                            $scheduleRecord->on_shift == $shift['shift'] &&
                                            $scheduleRecord->detail != 'notuse';
                                    });
                                });

                                $schedulePlansRecordNotUse = $schedulePlans->filter(function ($schedulePlan) use (
                                    $shift,
                                ) {
                                    return $schedulePlan->ScheduleRecords->contains(function ($scheduleRecord) use (
                                        $shift,
                                    ) {
                                        return $scheduleRecord->shift_date == $shift['date'] &&
                                            $scheduleRecord->on_shift == $shift['shift'] &&
                                            $scheduleRecord->detail == 'notuse';
                                    });
                                });

                                $checkingRecordCount = count($schedulePlansRecordNotUse) + count($schedulePlansRecord);

                            @endphp

                            <div class="col-sm-6 mb-2">
                                <div class="card card-body">
                                    <div class="row">
                                        <div class="col">
                                            <span>ตรวจสอบ : {{ count($schedulePlansRecord) }} /
                                                {{ count($schedulePlans) }}</span> |
                                            <span>ไม่ใช้งาน : {{ count($schedulePlansRecordNotUse) }} /
                                                {{ count($schedulePlans) }}</span> |
                                            <span>รวม : {{ $checkingRecordCount }} /
                                                {{ count($schedulePlans) }}</span>
                                        </div>
                                        <div class="col-auto">


                                            @if ($checkingRecordCount != count($schedulePlans))
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                                    data-bs-target="#closeCheckModal-{{ $line->id }}"
                                                    title="ไม่ใช้งาน">
                                                    ปิดใช้งาน
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="closeCheckModal-{{ $line->id }}"
                                                    tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        department, app, schedule, line
                                                        <form
                                                            action="{{ route('toggleLineUsage', [$department->id, $app, $frequencyCheck->id, $line->id]) }}"
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
                                                                    เครื่องจักรภายใน ไลน์ {{ $line->name }}
                                                                    ไม่ได้ใช้งาน

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

                                    <h5 class="card-title"><strong>สายการผลิต:{{ $frequencyCheck->id }}</strong>
                                        {{ $line->name }} </h5>

                                    <p class="card-text"><strong>สถานะ:</strong> {{ $line->status }}</p>
                                    <p class="card-text"><strong>รายละเอียด:</strong> {{ $line->detail }}</p>
                                    <a href="{{ route('new.app.resin.machine', [$department->id, $app, $frequencyCheck->id, $line->id]) }}"
                                        class="btn btn-success">เลือก</a>
                                </div>

                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>

    </div>
@endsection
