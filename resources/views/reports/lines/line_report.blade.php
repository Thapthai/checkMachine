@extends('layouts.app')
@push('styles')
    <style>
        @media print {

            @page {
                size: A3;
            }

            .d-print-none {
                display: none;
            }

            .page-break {
                page-break-after: always;
            }

        }

        .center {
            border-collapse: collapse;
            max-width: 100%;
            margin-bottom: 1rem;
            width: 100%;
        }

        .center td,
        .center th {
            text-align: center;
            border: 1px solid #000;
            padding: 0px;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row d-print-none">
                <div class="col">
                    <h4><strong>รายงานการบันทึก เรซิ่น</strong></h4>
                </div>
            </div>
            <hr>

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

            <div class="row">
                <div class="col">
                    <div class="pull-right mb-2">
                        <a href="{{ route('reports.index', [$department->id, $line->id]) }}"
                            class="btn btn-warning d-print-none">กลับ</a>
                        <a href="{{ url('/') }}" class="btn btn-primary d-print-none">หน้าแรก</a>
                    </div>
                </div>
                <div class="col">
                    <div class="pull-right mb-2" style="text-align: right">


                        <form action="{{ route('lines_reports_export_xlsx', [$department->id, $line->id]) }}"
                            method="POST">
                            @csrf
                            <input type="hidden" name="department_id" value="{{ $department->id }}">
                            <input type="hidden" name="line_id" value="{{ $line->id }}">
                            <input type="hidden" name="since_date" value="{{ $since_date }}">
                            <input type="hidden" name="to_date" value="{{ $to_date }}">
                            <button type="submit" class="btn btn-success d-print-none">Excel</button>
                            <a onclick=" window.print()" class="btn btn-danger d-print-none">กดพิมพ์ หรือ save เป็น
                                PDF</a>
                        </form>
                        <form method="get"
                            action="{{ route('sendEmail_lineResinReport', [$department->id, $line->id, $since_date, $to_date]) }}">
                            @csrf
                            <input type="hidden" name="department_id" value="{{ $department->id }}">
                            <input type="hidden" name="line_id" value="{{ $line->id }}">

                            <button type="submit" class="btn btn-primary mt-2 d-print-none">Send Email</button>
                        </form>

                    </div>
                </div>
            </div>


            <h4 style=" text-align: center;"><Strong>รายงานการบันทึก เรซิ่น</Strong></h4>
            <h5 class="mt-2" style=" text-align: center;"><strong>แผนก : {{ $department->name }} | ไลน์ :
                    {{ $line->name }} |
                    ตั้งแต่
                    {{ date('d/m/Y', strtotime('+543 year' . $since_date)) }} ถึง
                    {{ date('d/m/Y', strtotime('+543 year' . $to_date)) }}</strong></h5>
        </div>
    </div>

    <div class="container-fluid" style="font-size: 13px">
        <hr>
        <table class="center">
            @foreach ($resin_records->groupBy(function ($item) {
            return $item->created_at->format('Y-m-d');
        }) as $created_at => $resin_records)
                <tr>
                    <td style="border: none;text-align: left">
                        <h5>วันที่ {{ date('d/m/Y', strtotime('+543 year' . $created_at)) }}</h5>
                    </td>
                </tr>

                @foreach ($resin_records->groupBy('machine.id') as $machine_name => $machine_records)
                    @php
                        $machine = $resin_records->first()->machine;
                    @endphp
                    <tr>
                        <th style="border: none;text-align: left">
                            <h5> {{ $machine->id }} เครื่องจักร {{ $machine->name }}</h5>
                        </th>
                    </tr>

                    @foreach ($machine_records->groupBy('on_shift') as $onShift => $machine_records)
                        @php

                            $firstRecord = $machine_records->first();
                            $lastRecord = $machine_records->last();

                            // แปลง created_at ของบันทึกเป็น timestamp
                            $firstTimestamp = strtotime($firstRecord->created_at);
                            $lastTimestamp = strtotime($lastRecord->created_at);

                            // คำนวณความแตกต่างของเวลาระหว่างบันทึกแรกและบันทึกสุดท้าย (เป็นวินาที)
                            $timeDifferenceInSeconds = $lastTimestamp - $firstTimestamp;

                            // แปลงวินาทีให้เป็นรูปแบบที่อ่านได้ (เช่น ชั่วโมง นาที วินาที)
                            $hours = floor($timeDifferenceInSeconds / 3600);
                            $minutes = floor(($timeDifferenceInSeconds / 60) % 60);
                            $seconds = $timeDifferenceInSeconds % 60;
                            $timeDifference = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
                        @endphp

                        <tr>

                            <th style="border: none;text-align: left">


                                <h5>
                                    @switch($onShift)
                                        @case('b')
                                            กะ B
                                        @break

                                        @case('c')
                                            กะ C
                                        @break

                                        @default
                                    @endswitch
                                </h5>
                            </th>

                        </tr>
                        <tr style="text-align: center">
                            <th colspan="5">รายละเอียด เรซิน </th>
                            <th colspan="6">รายการตรวจ</th>

                        </tr>
                        <tr>
                            <th class="align-middle" style="text-align:">ตำแหน่ง</th>
                            <th class="align-middle" style="text-align:">จำนวน</th>
                            <th class="align-middle" style="text-align:">ชนิดวัสดุ(Material)</th>
                            <th class="align-middle" style="text-align:">สี</th>
                            <th class="align-middle" style="text-align:">รายละเอียด</th>
                            <th class="align-middle" style="text-align:">รูป</th>
                            <th class="align-middle" style="text-align:">รอบ</th>
                            <th class="align-middle" style="text-align:">ความสะอาด</th>
                            <th class="align-middle" style="text-align:">ความสมบูรณ์</th>
                            <th class="align-middle" style="text-align:">ซ่อม</th>
                        </tr>

                        @php
                            $i = 1;
                        @endphp

                        @foreach ($machine_records as $machine_record)
                            <tr>
                                <td>
                                    {{ $machine_record->resin->id }} :
                                    {{ $machine_record->resin->position }}
                                </td>
                                <td>{{ $machine_record->resin->total_resin }}</td>
                                <td>{{ $machine_record->resin->material }}</td>
                                <td>{{ $machine_record->resin->color }}</td>
                                <td>{{ $machine_record->resin->detail }}</td>
                                <td class="align-middle" style="text-align: center;width:180px">
                                    @if (!empty($machine_record->pic1))
                                        <img src="{{ url('storage/' . $machine_record->pic1) }}" alt="img"
                                            width="170px" class="my-1">
                                    @else
                                        ไม่มี
                                    @endif

                                    @if (!empty($machine_record->pic2))
                                        <img src="{{ url('storage/' . $machine_record->pic2) }}" alt="img"
                                            width="170px" class="my-1">
                                    @endif

                                    @if (!empty($machine_record->pic3))
                                        <img src="{{ url('storage/' . $machine_record->pic3) }}" alt="img"
                                            width="170px" class="my-1">
                                    @endif
                                </td>

                                <td>
                                    @switch($machine_record->check_in)
                                        @case('before')
                                            ก่อนการใช้งาน
                                        @break

                                        @case('after')
                                            หลังการใช้งาน
                                        @break

                                        @default
                                    @endswitch
                                </td>

                                <td class="align-center" style="text-align: center">

                                    @if ($machine_record->clean == 'NOT')
                                        <h4><i class='bx bx-x bx-xs rounded-5 btn-danger '></i>
                                        </h4>
                                    @endif

                                    @if ($machine_record->clean == 'pass')
                                        <h4><i class='bx bx-check bx-xs rounded-5 btn-success '></i>
                                        </h4>
                                    @endif

                                </td>
                                <td>
                                    @if ($machine_record->status == 'pass')
                                        <h4><i class='bx bx-check bx-xs rounded-5 btn-success'></i>
                                        </h4>
                                    @endif

                                    @if ($machine_record->status == 'NOT')
                                        <h4><i class='bx bx-x bx-xs rounded-5 btn-danger'></i>
                                        </h4>

                                        @if (empty($machine_record->repair_date))
                                            <a href="{{ route('repair_resins', [$department->id, $line->id, $machine->id, $resin_record->resins_id]) }}"
                                                class="btn btn-warning d-print-none mb-2 btn-sm" target="_blank">ซ่อม</a>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if (!empty($machine_record->repair_date))
                                        <h5 class="mt-1">
                                            <i class="bi bi-wrench-adjustable-circle"></i>
                                        </h5>

                                        @if (Auth::user()->is_admin == '1')
                                            <button type="button" class="btn btn-sm" data-toggle="modal"
                                                data-target="#myModal{{ $machine_record->id }}">
                                                {{ date('d/m/Y', strtotime('+543 year' . $machine_record->repair_date)) }}


                                            </button>

                                            <div class="modal fade" id="myModal{{ $machine_record->id }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form
                                                            action="{{ route('update_repair_date', $machine_record->id) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf

                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">แก้ไข วันที่ซ่อม</h4>
                                                                <button type="button" class="close btn btn-secondary"
                                                                    data-dismiss="modal">X</button>
                                                            </div>

                                                            <!-- Modal Body -->
                                                            <div class="modal-body">
                                                                <label for="">ID : {{ $machine_record->id }}
                                                                    วันที่ซ่อม</label>
                                                                <input type="datetime-local" name="repair_date"
                                                                    class="form-control"
                                                                    value="{{ date('Y-m-d H:i', strtotime($machine_record->repair_date)) }}">
                                                            </div>

                                                            <!-- Modal Footer -->
                                                            <div class="modal-footer">
                                                                <button type="submit"
                                                                    class="btn btn-success">แก้ไข</button>
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            {{ date('d/m/Y', strtotime('+543 year' . strtotime('Y-m-d', $machine_record->repair_date))) }}
                                        @endif
                                    @else
                                        -
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <th style="text-align: center">เวลาที่ใช้ </th>
                            <th>{{ $timeDifference }}</th>
                        </tr>
                    @endforeach
                    <tr>
                        <th style="border: none;text-align: left">&nbsp; </th>
                    </tr>

                @endforeach
            @endforeach
        </table>
    </div>
@endsection
