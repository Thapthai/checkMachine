@extends('layouts.app')

@push('styles')
    <style>
        body {
            /* background-color: #e1f5ff; */
        }

        .btn-circle {
            width: 30px;
            height: 30px;
            padding: 6px 0px;
            border-radius: 15px;
            text-align: center;
            font-size: 12px;
            line-height: 1.42857;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <a href="{{ route('admin.department', [$department->id]) }}" class="btn btn-secondary mb-2">
            กลับ</a>
        <div class="row justify-content-center">
            <div class="col">

                <h3>สรุปผล {{ $department->name }} วันที่ {{ $shift['date'] }} กะ {{ $shift['shift'] }}

                </h3>
            </div>
        </div>
        <hr>

        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            @foreach ($lines as $lineId => $lineName)
                <li class="nav-item" role="presentation">
                    <a href="{{ route('admin.department.dashboard', ['department' => $department->id, 'line_id' => $lineId]) }}"
                        class="nav-link btn mx-2 {{ isset($line) && $line->id == $lineId ? 'btn-primary' : 'btn-secondary' }}"
                        id="pills-home-tab" role="tab"
                        aria-selected="{{ isset($line) && $line->id == $lineId ? 'true' : 'false' }}">
                        {{ $lineName }}
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="tab-content card card-body" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                @if (isset($line))
                    <h5>ข้อมูลของไลน์: {{ $line->name }}</h5>
                    <p class="card-text"><strong>สถานะ:</strong> {{ $line->status }}</p>
                    <p class="card-text"><strong>รายละเอียด:</strong> {{ $line->detail }}</p>
                    @if (count($line->schedulePlans) > 0)
                        @php
                            $schedulePlans = $line->schedulePlans->where('frequency_check_id', 1);

                            $schedulePlansRecord = $schedulePlans->filter(function ($schedulePlan) use ($shift) {
                                return $schedulePlan->ScheduleRecords->contains(function ($scheduleRecord) use (
                                    $shift,
                                ) {
                                    return $scheduleRecord->shift_date == $shift['date'] &&
                                        $scheduleRecord->on_shift == $shift['shift'] &&
                                        $scheduleRecord->detail != 'notuse';
                                });
                            });

                            $schedulePlansRecordNotUse = $schedulePlans->filter(function ($schedulePlan) use ($shift) {
                                return $schedulePlan->ScheduleRecords->contains(function ($scheduleRecord) use (
                                    $shift,
                                ) {
                                    return $scheduleRecord->shift_date == $shift['date'] &&
                                        $scheduleRecord->on_shift == $shift['shift'] &&
                                        $scheduleRecord->detail == 'notuse';
                                });
                            });

                            $checkingRecordCount = count($schedulePlansRecordNotUse) + count($schedulePlansRecord);

                            $schedulePlansRecordResult_clean_pass = $schedulePlans->filter(function (
                                $schedulePlan,
                            ) use ($shift) {
                                return $schedulePlan->ScheduleRecords->contains(function ($scheduleRecord) use (
                                    $shift,
                                ) {
                                    return $scheduleRecord->shift_date == $shift['date'] &&
                                        $scheduleRecord->on_shift == $shift['shift'] &&
                                        $scheduleRecord->clean == 'pass';
                                });
                            });

                            $schedulePlansRecordResult_clean_not = $schedulePlans->filter(function ($schedulePlan) use (
                                $shift,
                            ) {
                                return $schedulePlan->ScheduleRecords->contains(function ($scheduleRecord) use (
                                    $shift,
                                ) {
                                    return $scheduleRecord->shift_date == $shift['date'] &&
                                        $scheduleRecord->on_shift == $shift['shift'] &&
                                        $scheduleRecord->clean == 'NOT';
                                });
                            });

                            $schedulePlansRecordResult_complete_pass = $schedulePlans->filter(function (
                                $schedulePlan,
                            ) use ($shift) {
                                return $schedulePlan->ScheduleRecords->contains(function ($scheduleRecord) use (
                                    $shift,
                                ) {
                                    return $scheduleRecord->shift_date == $shift['date'] &&
                                        $scheduleRecord->on_shift == $shift['shift'] &&
                                        $scheduleRecord->complete == 'pass';
                                });
                            });

                            $schedulePlansRecordResult_complete_not = $schedulePlans->filter(function (
                                $schedulePlan,
                            ) use ($shift) {
                                return $schedulePlan->ScheduleRecords->contains(function ($scheduleRecord) use (
                                    $shift,
                                ) {
                                    return $scheduleRecord->shift_date == $shift['date'] &&
                                        $scheduleRecord->on_shift == $shift['shift'] &&
                                        $scheduleRecord->complete == 'NOT';
                                });
                            });
                        @endphp

                        <div class="d-flex flex-wrap">

                            <div class="card card-body m-2">
                                <h5>การตรวจสอบโดยรวม</h5>
                                <hr>
                                <table class="table" style="text-align: center">
                                    <tr>
                                        <th>ตรวจสอบ</th>
                                        <th>ไม่ใช้งาน</th>
                                        <th>รวมทั้งหมด</th>
                                    </tr>
                                    <tr>
                                        <td>{{ count($schedulePlansRecord) }} / {{ count($schedulePlans) }}</td>
                                        <td>{{ count($schedulePlansRecordNotUse) }} / {{ count($schedulePlans) }}
                                        </td>
                                        <td>{{ $checkingRecordCount }} / {{ count($schedulePlans) }}</td>
                                    </tr>
                                </table>
                                <div style="width: 400px">
                                    <canvas id="appPieChart"></canvas>
                                </div>
                            </div>

                            <div class="card card-body m-2">
                                <h5>ผลตรวจความสะอาด</h5>
                                <hr>
                                <table class="table" style="text-align: center">
                                    <tr>
                                        <th>ผ่าน</th>
                                        <th>ไม่ผ่าน</th>
                                        <th>ผลตรวจทั้งหมด</th>
                                    </tr>
                                    <tr>
                                        <td>{{ count($schedulePlansRecordResult_clean_pass) }}</td>
                                        <td>{{ count($schedulePlansRecordResult_clean_not) }}</td>
                                        <td>{{ count($schedulePlansRecord) }}</td>
                                    </tr>
                                </table>
                                <div style="width: 400px">
                                    <canvas id="cleanPieChart2"></canvas>
                                </div>
                            </div>

                            <div class="card card-body m-2">
                                <h5>ผลตรวจความสมบูรณ์</h5>
                                <hr>
                                <table class="table" style="text-align: center">
                                    <tr>
                                        <th>ผ่าน</th>
                                        <th>ไม่ผ่าน</th>
                                        <th>ผลตรวจทั้งหมด</th>
                                    </tr>
                                    <tr>
                                        <td>{{ count($schedulePlansRecordResult_complete_pass) }}</td>
                                        <td>{{ count($schedulePlansRecordResult_complete_not) }}</td>
                                        <td>{{ count($schedulePlansRecord) }}</td>
                                    </tr>
                                </table>
                                <div style="width: 400px">
                                    <canvas id="completePieChart3"></canvas>
                                </div>
                            </div>
                        </div>

                        @include('admin.department.dashboard.script')
                    @endif
                @else
                    <div class="alert alert-danger">

                        <p>กรุณาเลือกไลน์จากเมนูด้านบน</p>
                    </div>
                @endif
            </div>
        </div>

    </div>


@endsection
