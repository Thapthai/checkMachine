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
                <div class="pull-right mb-2">
                    <a href="{{ route('reports.index', [$department->id, $line->id]) }}"
                        class="btn btn-warning d-print-none">กลับ</a>
                    <a href="{{ url('/') }}" class="btn btn-primary d-print-none">หน้าแรก</a>

                </div>
            </div>

            <h4 style=" text-align: center;"><Strong>รายงานการบันทึก เรซิ่น</Strong></h4>
            <h5 class="mt-2" style=" text-align: center;"><strong>แผนก : {{ $department->name }} | เครื่องจักร :
                    {{ $machine->name }}</strong></h5>
            <form action="{{ route('resins_reports', [$department->id, $line->id, $machine->id]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="row my-3">
                    <div class="col">
                        <label>ตั้งแต่</label>
                        <input type="date" name="since_date" class="form-control rounded"
                            @if (!empty($to_date)) value="{{ date('Y-m-d', strtotime($since_date)) }}" @endif
                            required />
                    </div>
                    <div class="col">
                        <label>ถึง</label>
                        <input type="date" name="to_date" class="form-control rounded"
                            @if (!empty($to_date)) value="{{ date('Y-m-d', strtotime($to_date)) }}" @endif
                            required />
                    </div>
                    <div class="col col-2">
                        <label>&nbsp; </label>
                        <button type="submit" class="btn btn-success rounded w-100">เลือก</button>
                    </div>
                </div>
            </form>

            <table class="table table-borderless">
                <tr>
                    <td class="w-50" style="text-align:left">
                        <h5><strong>วันที่:</strong> {{ date('d F Y', strtotime($since_date . '+543 year')) }} -
                            {{ date('d F Y', strtotime($to_date . '+543 year')) }}</h5>
                    </td>
                </tr>
                <tr>
                    <td class="w-100" style="text-align:left">
                        <form action="{{ route('resins_report_excel') }}">
                            @csrf
                            <input type="hidden" name="department_name" value="{{ $department->name }}">
                            <input type="hidden" value="{{ $since_date }}" name="start_date">
                            <input type="hidden" value="{{ $to_date }}" name="end_date">
                            <input type="hidden" value="{{ $department->id }}" name="department_id">
                            <input type="hidden" value="{{ $line->id }}" name="line_id">
                            <input type="hidden" value="{{ $machine->id }}" name="machine_id">

                            <input type="hidden" name="machine_id" value="{{ $machine->id }}">
                            <a onclick=" window.print()" class="btn btn-success d-print-none">กดพิมพ์ หรือ save เป็น
                                PDF</a>
                            <button type="submit" class="btn btn-danger d-print-none">Excel</button>
                        </form>
                    </td>
                </tr>
            </table>

        </div>
    </div>
    <div class="text-center">

        @if (!is_null($machine->pic1))
            <img src="{{ url('storage/' . $machine->pic1) }}" alt="img" draggable="false" width="250px"
                class="mt-1">
        @else
        @endif

        @if (!is_null($machine->pic2))
            <img src="{{ url('storage/' . $machine->pic2) }}" alt="img" draggable="false" width="250px"
                class="mt-1">
        @else
        @endif
        @if (!is_null($machine->pic3))
            <img src="{{ url('storage/' . $machine->pic3) }}" alt="img" draggable="false" width="250px"
                class="mt-1">
        @else
        @endif
        @if (!is_null($machine->pic4))
            <img src="{{ url('storage/' . $machine->pic4) }}" alt="img" draggable="false" width="250px"
                class="mt-1">
        @else
        @endif
        @if (!is_null($machine->pic5))
            <img src="{{ url('storage/' . $machine->pic5) }}" alt="img" draggable="false" width="250px"
                class="mt-1">
        @else
        @endif
        @if (!is_null($machine->pic6))
            <img src="{{ url('storage/' . $machine->pic6) }}" alt="img" draggable="false" width="250px"
                class="mt-1">
        @else
        @endif
        @if (!is_null($machine->pic7))
            <img src="{{ url('storage/' . $machine->pic7) }}" alt="img" draggable="false" width="250px"
                class="mt-1">
        @else
        @endif
        @if (!is_null($machine->pic8))
            <img src="{{ url('storage/' . $machine->pic8) }}" alt="img" draggable="false" width="250px"
                class="mt-1">
        @else
        @endif
        @if (!is_null($machine->pic9))
            <img src="{{ url('storage/' . $machine->pic9) }}" alt="img" draggable="false" width="250px"
                class="mt-1">
        @else
        @endif
        @if (!is_null($machine->pic10))
            <img src="{{ url('storage/' . $machine->pic10) }}" alt="img" draggable="false" width="250px"
                class="mt-1">
        @else
        @endif

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
                            <h5> เครื่องจักร {{ $machine->name }}</h5>
                        </th>
                    </tr>

                    <tr style="text-align: center">
                        <th colspan="6">รายละเอียด เรซิน</th>
                        <th colspan="6">รายการตรวจ</th>

                    </tr>
                    <tr>
                        <th class="align-middle" style="text-align:">ตำแหน่ง</th>
                        <th class="align-middle" style="text-align:">รูปเรซิ่น</th>
                        <th class="align-middle" style="text-align:">จำนวน</th>
                        <th class="align-middle" style="text-align:">ชนิดวัสดุ(Material)</th>
                        <th class="align-middle" style="text-align:">สี</th>
                        <th class="align-middle" style="text-align:">รายละเอียด</th>
                        <th class="align-middle" style="text-align:">ลำดับ</th>
                        <th class="align-middle" style="text-align:">รูป</th>
                        <th class="align-middle" style="text-align:">กะ</th>
                        <th class="align-middle" style="text-align:">ความสะอาด</th>
                        <th class="align-middle" style="text-align:">ความสมบูรณ์</th>
                        <th class="align-middle" style="text-align:">ซ่อม</th>
                    </tr>

                    @php
                        $i = 1;

                    @endphp

                    @foreach ($machine_records->groupBy('resin.position') as $resin_position => $resin_records)
                        @php
                            $resin = $resin_records->first()->resin;
                            $rowspan = count($resin_records) + 1;
                        @endphp
                        <tr>

                            <td rowspan="{{ $rowspan }}" style="vertical-align: top;">ตำแหน่งของ Resin:
                                {{ $resin_position }}</td>
                            <td rowspan="{{ $rowspan }}" style="vertical-align: top;width:180px">
                                @if (!empty($resin->pic1))
                                    <img src="{{ url('storage/' . $resin->pic1) }}" alt="img" width="170px"
                                        class="my-1">
                                @else
                                    ไม่มี
                                @endif

                                @if (!empty($resin->pic2))
                                    <img src="{{ url('storage/' . $resin->pic2) }}" alt="img" width="170px"
                                        class="my-1">
                                @endif

                                @if (!empty($resin->pic3))
                                    <img src="{{ url('storage/' . $resin->pic3) }}" alt="img" width="170px"
                                        class="my-1">
                                @endif

                            </td>
                            <td rowspan="{{ $rowspan }}" style="vertical-align: top;">
                                {{ $resin->total_resin ?? '' }}
                            </td>
                            <td rowspan="{{ $rowspan }}" style="vertical-align: top;">{{ $resin->material ?? '' }}
                            </td>
                            <td rowspan="{{ $rowspan }}" style="vertical-align: top;">{{ $resin->color ?? '' }}
                            </td>
                            <td rowspan="{{ $rowspan }}" style="vertical-align: top;">{{ $resin->detail ?? '' }}
                            </td>
                        </tr>
                        @php
                            $i = 0;
                            $j = 1;
                        @endphp
                        @foreach ($resin_records->sortBy('on_shift') as $resin_record)
                            <tr>
                                @php $i++; @endphp
                                <td>{{ $j++ }}</td>
                                <td class="align-middle" style="vertical-align: top;width:180px">
                                    @if (!empty($resin_record->pic1))
                                        <img src="{{ url('storage/' . $resin_record->pic1) }}" alt="img"
                                            width="170px" class="my-1">
                                    @else
                                        ไม่มี
                                    @endif

                                    @if (!empty($resin_record->pic2))
                                        <img src="{{ url('storage/' . $resin_record->pic2) }}" alt="img"
                                            width="170px" class="my-1">
                                    @endif

                                    @if (!empty($resin_record->pic3))
                                        <img src="{{ url('storage/' . $resin_record->pic3) }}" alt="img"
                                            width="170px" class="my-1">
                                    @endif


                                </td>
                                <td>{{ $resin_record->on_shift }} {{ $resin_record->check_in }}</td>

                                <td class="align-center" style="text-align: center">

                                    @if ($resin_record->clean == 'NOT')
                                        <h4><i class='bx bx-x bx-xs rounded-5 btn-danger '></i>
                                        </h4>
                                    @endif

                                    @if ($resin_record->clean == 'pass')
                                        <h4><i class='bx bx-check bx-xs rounded-5 btn-success '></i>
                                        </h4>
                                    @endif

                                </td>
                                <td>
                                    @if ($resin_record->status == 'pass')
                                        <h4><i class='bx bx-check bx-xs rounded-5 btn-success'></i>
                                        </h4>
                                    @endif

                                    @if ($resin_record->status == 'NOT')
                                        <h4><i class='bx bx-x bx-xs rounded-5 btn-danger'></i>
                                        </h4>

                                        @if (empty($resin_record->repair_date))
                                            <a href="{{ route('repair_resins', [$department->id, $line->id, $machine->id, $resin_record->resins_id]) }}"
                                                class="btn btn-warning d-print-none mb-2 btn-sm" target="_blank">ซ่อม</a>
                                        @endif
                                    @endif
                                </td>


                                </td>
                                <td>
                                    @if (!empty($resin_record->repair_date))
                                        <h5 class="mt-1">
                                            <i class="bi bi-wrench-adjustable-circle"></i>
                                        </h5>

                                        @if (Auth::user()->is_admin == '1')
                                            <button type="button" class="btn btn-sm" data-toggle="modal"
                                                data-target="#myModal{{ $resin_record->id }}">
                                                {{ date('d/m/Y', strtotime('+543 year' . $resin_record->repair_date)) }}


                                            </button>

                                            <div class="modal fade" id="myModal{{ $resin_record->id }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form
                                                            action="{{ route('update_repair_date', $resin_record->id) }}"
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
                                                                <label for="">ID : {{ $resin_record->id }}
                                                                    วันที่ซ่อม</label>
                                                                <input type="datetime-local" name="repair_date"
                                                                    class="form-control"
                                                                    value="{{ date('Y-m-d H:i', strtotime($resin_record->repair_date)) }}">
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
                                            {{ date('d/m/Y', strtotime('+543 year' . strtotime('Y-m-d', $resin_record->repair_date))) }}
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
            @endforeach
        </table>
    </div>
@endsection
