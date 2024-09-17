@extends('layouts.app')
@push('styles')
    <style>
        body {
            background-color: #dae7da;
        }
    </style>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="row mb-2">
                <div class="col">

                    <a href="{{ route('new.app.resin.machine', [$department->id, $app, $frequencyCheck->id, $line->id]) }}"
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
                    <h4><strong>{{ $frequencyCheck->name }} </strong></h4>
                </div>
                <div class="col-auto">
                    <h4><strong> เลือกตรวจเรซิ่น</strong></h4>

                </div>
            </div>

            <form
                action="{{ route('new.app.resin.schedule.resin', [$department->id, $app, $frequencyCheck->id, $line->id, $machine->id]) }}"
                method="get" enctype="multipart/form-data">
                @csrf
                <div class="input-group mb-2">
                    <input type="text" name="searchResin" class="form-control" placeholder="ค้นหาตำแหน่ง...เรซิ่น..."
                        value="{{ $searchResin }}">
                    <div class="input-group-append mx-2">
                        <a href="{{ route('new.app.resin.schedule.resin', [$department->id, $app, $frequencyCheck->id, $line->id, $machine->id]) }}"
                            class="btn btn-secondary" title="คืนค่า"><i class="fa-solid fa-rotate-right"></i></a>
                    </div>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary" title="ค้นหา"><i
                                class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </div>
            </form>



            <h4>เครื่องจักร: {{ $machine->name }}</h4>

            <div id="carouselControls-{{ $machine->id }}" class="carousel slide mb-2" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        @if ($machine->pic1)
                            <img src="{{ url('storage/' . $machine->pic1) }}" alt="img" class="d-block w-100"
                                style="max-height: 500px; object-fit: contain;">
                        @else
                            <img src="{{ asset('icon/no-image.png') }}" alt="img" class="d-block w-100"
                                style="max-height: 500px; object-fit: contain;">
                        @endif
                    </div>
                    @for ($i = 2; $i <= 7; $i++)
                        @php
                            $picAttribute = 'pic' . $i;
                        @endphp
                        <div class="carousel-item">
                            @if ($machine->$picAttribute)
                                <img src="{{ url('storage/' . $machine->$picAttribute) }}" alt="img"
                                    class="d-block w-100" style="max-height: 500px; object-fit: contain;">
                            @else
                                <img src="{{ asset('icon/no-image.png') }}" alt="img" class="d-block w-100"
                                    style="max-height: 500px; object-fit: contain;">
                            @endif
                        </div>
                    @endfor
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselControls-{{ $machine->id }}"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon rounded-2" aria-hidden="true"
                        style="background-color: #000000"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselControls-{{ $machine->id }}"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon rounded-2" aria-hidden="true"
                        style="background-color: #000000"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <hr>


            @foreach ($machine->resins->filter(function ($resin) use ($searchResin) {
            return stripos($resin->position, $searchResin) !== false;
        }) as $resin)
                @php

                    $schedulePlans = $resin
                        ->schedulePlans()
                        ->where('frequency_check_id', $frequencyCheck->id)
                        ->get()
                        ->filter(function ($schedulePlan) use ($shift) {
                            return !$schedulePlan->ScheduleRecords->contains(function ($scheduleRecord) use ($shift) {
                                return $scheduleRecord->shift_date == $shift['date'] &&
                                    $scheduleRecord->on_shift == $shift['shift'];
                            });
                        });

                @endphp

                @if ($schedulePlans->isNotEmpty())
                    @foreach ($schedulePlans as $schedulePlan)
                        <div class="col-sm-6">
                            <div class="shadow-sm mt-2">

                                <button class="btn btn-success btn-lg w-100" type="button">
                                    <div style="text-align: left">
                                        <h5 class="card-title">
                                            <strong>

                                                {{ $schedulePlan->resin->position }}
                                            </strong>
                                        </h5>
                                    </div>
                                </button>

                                <div class="card card-body">

                                    <table class="table">
                                        <tr>
                                            <th>รายละเอียด</th>
                                            <td>{{ $schedulePlan->resin->detail ?? '-' }}</td>
                                            <th>จำนวน </th>
                                            <td>{{ $schedulePlan->resin->total_resin ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>วัสดุ</th>
                                            <td>{{ $schedulePlan->resin->material ?? '-' }}</td>
                                            <th>สี</th>
                                            <td>{{ $schedulePlan->resin->color ?? '-' }}</td>
                                        </tr>
                                    </table>

                                    <form
                                        action="{{ route('new.app.resin.schedule.scheduleRecord', [$department->id, $app, $frequencyCheck->id, $schedulePlan->id, $schedulePlan->resin->id]) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf


                                        @if ($schedulePlan->resin->pic1)
                                            <img src="{{ url('storage/' . $schedulePlan->resin->pic1) }}" alt="img"
                                                class="d-block w-100" style="max-height: 500px; object-fit: contain;">
                                        @endif

                                        <div class="col border border-1 rounded-2 my-3 p-2" style="font-size: 20px">
                                            <strong>ความสะอาด :</strong><br>

                                            <input class="form-check-input" type="radio" name="clean" value="pass"
                                                required>
                                            <label class="form-check-label">ผ่าน</label>

                                            <input class="form-check-input" type="radio" name="clean" value="NOT">
                                            <label class="form-check-label">ไม่ผ่าน</label>
                                            <br>
                                        </div>
                                        <div class="col border border-1 rounded-2 my-3 p-2" style="font-size: 20px">
                                            <strong>ความสมบูรณ์ :</strong>
                                            <br>

                                            <input class="form-check-input" type="radio" name="complete" value="pass"
                                                required>
                                            <label class="form-check-label">ผ่าน</label>

                                            <input class="form-check-input" type="radio" name="complete"
                                                value="NOT">
                                            <label class="form-check-label">ไม่ผ่าน</label>
                                            <br>

                                        </div>


                                        <strong class="form-label">หมายเหตุ</strong>
                                        <input type="text" name="detail" class="form-control">

                                        <div class="text-center">
                                            <img class="rounded m-2" id="{{ $schedulePlan->resin->id }}.pic1"
                                                width="200px" />
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <strong>รูปที่ 1:</strong>
                                                <input type="file" name="pic1" class="form-control"
                                                    data-id="{{ $schedulePlan->resin->id }}.pic1"
                                                    onchange="loadFile(event,this)">
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <img class="rounded m-2" id="{{ $schedulePlan->resin->id }}.pic2"
                                                width="200px" />
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <strong>รูปที่ 2:</strong>
                                                <input type="file" name="pic2" class="form-control"
                                                    data-id="{{ $schedulePlan->resin->id }}.pic2"
                                                    onchange="loadFile(event,this)">
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <img class="rounded m-2" id="{{ $schedulePlan->resin->id }}.pic3"
                                                width="200px" />
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <strong>รูปที่ 3:</strong>
                                                <input type="file" name="pic3" class="form-control"
                                                    data-id="{{ $schedulePlan->resin->id }}.pic3"
                                                    onchange="loadFile(event,this)">
                                            </div>
                                        </div>
                                        <br>
                                        <button type="submit" class="btn btn-success w-100"
                                            onclick="return confirm('ต้องการบันทึก ?')">บันทึก</button>
                                    </form>

                                </div>

                            </div>
                        </div>
                    @endforeach
                @endif
            @endforeach


        </div>
    </div>
@endsection
