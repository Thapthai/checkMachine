@extends('layouts.app')

@push('styles')
    <style>

    </style>
@endpush


@section('content')
    <div class="container ">
        <div class="row justify-content-center">

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

        <h5><strong>Plan Check {{ $line->name }} {{ $line->department->name }}</strong></h5>
        <hr>


        @foreach ($frequencyChecks as $frequencyCheck)
            <div class="border border-2 rounded-1 p-2 mt-2">
                <div class="alert alert-success mt-2">
                    <h5><strong>
                            @php
                                $schedulePlan = $frequencyCheck->schedulePlans->where('line_id', $line->id)->first();

                                $define = null;
                                if ($schedulePlan) {
                                    $define = $schedulePlan->define;
                                }

                            @endphp
                            @switch($frequencyCheck->name)
                                @case('Weekly')
                                    ตรวจสอบ {{ $define }} ของสัปดาห์
                                @break

                                @case('Monthly')
                                    ตรวจสอบ {{ $define }} ของแต่ละเดือน
                                @break

                                @default
                                    ตรวจสอบ ทุกวัน
                            @endswitch
                        </strong></h5>

                </div>
                <!-- Button to Open the Daily Modal -->
                <button type="button" class="btn btn-secondary my-2" data-bs-toggle="modal"
                    data-bs-target="#manage-{{ $frequencyCheck->id }}-Modal" title="แผนการตรวจสอบรายวัน ">
                    จัดการ {{ $frequencyCheck->name }}
                </button>


                <button type="button" class="btn btn-secondary my-2">Export</button>



                <!-- Modal -->
                <div class="modal fade" id="manage-{{ $frequencyCheck->id }}-Modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"> จัดการ {{ $frequencyCheck->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('plan_check_plan', [$line->id, $frequencyCheck->id]) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">

                                    @switch($frequencyCheck->name)
                                        @case('Weekly')
                                            <select name="define" class="form-select form-control-sm">
                                                <option value="SUN" @if ($define == 'SUN') selected @endif>วันอาทิตย์
                                                </option>
                                                <option value="MON" @if ($define == 'MON') selected @endif>วันจันทร์
                                                </option>
                                                <option value="TUE" @if ($define == 'TUE') selected @endif>วันอังคาร
                                                </option>
                                                <option value="WED" @if ($define == 'WED') selected @endif>วันพุธ
                                                </option>
                                                <option value="THU" @if ($define == 'THU') selected @endif>วันพฤหัสบดี
                                                </option>
                                                <option value="FRI" @if ($define == 'FRI') selected @endif>วันศุกร์
                                                </option>
                                                <option value="SAT" @if ($define == 'SAT') selected @endif>วันเสาร์
                                                </option>

                                            </select>
                                        @break

                                        @case('Monthly')
                                            <select name="define" class="form-select form-control-sm">
                                                @for ($day = 1; $day <= 31; $day++)
                                                    <option value="{{ $day }}"
                                                        @if ($define == $day) selected @endif>วันที่
                                                        {{ $day }}</option>
                                                @endfor
                                            </select>
                                        @break

                                        @default
                                            <input type="text" name="define" hidden value="D">
                                    @endswitch

                                    @foreach ($machines as $machine)
                                        <button class="btn btn-primary mt-2 w-100" type="button" data-toggle="collapse"
                                            data-target="#collapseMachine-{{ $frequencyCheck->id }}-{{ $machine->id }}"
                                            aria-expanded="false" aria-controls="collapseExample">
                                            เครื่องจักร {{ $machine->name }}
                                        </button>

                                        <br>
                                        <div class="collapse"
                                            id="collapseMachine-{{ $frequencyCheck->id }}-{{ $machine->id }}">

                                            <div class="card card-body">
                                                @foreach ($machine->resins as $resin)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="resins[{{ $resin->id }}]"
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
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                    <button type="submit" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <br>
                @php
                    $groupedPlans = $frequencyCheck->schedulePlans
                        ->where('line_id', $line->id)
                        ->groupBy('resin.machine.name');
                @endphp


                <table class="table ">
                    @foreach ($groupedPlans as $machineName => $schedulePlans)
                        <h5 class="mt-2">เครื่องจักร: {{ $machineName }}</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ตำแหน่งของ Resin</th>
                                    <th style="width: 400px">รายละเอียด</th>
                                    <th style="width: 200px">วัสดุ</th>
                                    <th style="width: 100px">จำนวน</th>
                                    <th style="width: 100px">สี</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schedulePlans as $schedulePlan)
                                    <tr>
                                        <td>{{ $schedulePlan->resin->position }}</td>
                                        <td>{{ $schedulePlan->resin->detail ?? '-' }}</td>
                                        <td>{{ $schedulePlan->resin->material ?? '-' }}</td>
                                        <td>{{ $schedulePlan->resin->total_resin ?? '-' }}</td>

                                        <td>{{ $schedulePlan->resin->color ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endforeach
                </table>
            </div>
        @endforeach
    </div>
@endsection
