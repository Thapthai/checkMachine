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
                    <h4><strong>เรซิ่นไม่สมบูรณ์ <i><u class="text-danger"> รอการแก้ไข </u></i></strong></h4>
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
                    <a href="{{ route('reports.index', [$department_id, $line_id]) }}"
                        class="btn btn-warning d-print-none">กลับ</a>
                    <a href="{{ url('/') }}" class="btn btn-primary d-print-none">หน้าแรก</a>

                </div>

                <div class="col">
                    <a onclick=" window.print()" class="btn btn-success d-print-none">กดเพื่อพิมพ์ หรือ save เป็น
                        PDF</a>
                </div>
            </div>

            <h4 style=" text-align: center;"><Strong>เรซิ่น ไม่สมบูรณ์ <i><u class="text-danger"> รอการแก้ไข
                        </u></i></Strong></h4>
            <h5 class="mt-2" style=" text-align: center;"><strong>แผนก : {{ $department_name }} | เครื่องจักร :
                    {{ $machine_name }}</strong></h5>
        </div>
    </div>
    <div class="container-fluid">
        @if (count($resin_records) > 0)
            <table class="center">
                @foreach ($resin_records->groupBy(function ($item) {
            return $item->created_at->format('Y-m-d');
        }) as $created_at => $resin_records)
                    <tr>
                        <td style="border: none;text-align: left">
                            <h5>วันที่ {{ date('d/m/Y', strtotime('+543 year' . $created_at)) }}</h5>
                        </td>
                    </tr>

                    @foreach ($resin_records->groupBy('resin.id') as $resin_name => $resin_records)
                        @php
                            $resin = $resin_records->first()->resin;
                            $rowspan = count($resin_records) + 1;
                        @endphp

                        <tr>
                            <th style="border: none;text-align: left">
                                <h5> ตำแหน่ง {{ $resin->position }}</h5>
                            </th>
                        </tr>
                        <tr>

                            <th class="align-middle" style="text-align:">ตำแหน่ง</th>
                            <th class="align-middle" style="text-align:">รูปเรซิ่น</th>
                            <th class="align-middle" style="text-align:">กะ</th>
                            <th class="align-middle" style="text-align:">รายละเอียด</th>
                            <th class="align-middle" style="text-align:">รูป</th>
                            <th class="align-middle" style="text-align:">ผู้บันทึก</th>
                            <th class="align-middle" style="text-align:">เวลา</th>
                            <th class="align-middle" style="text-align:">Action</th>
                        </tr>
                        @php
                            $i = 1;

                        @endphp
                        <tr>

                            <td rowspan="{{ $rowspan }}" style="vertical-align: top;">ตำแหน่งของ Resin:
                                {{ $resin->position }}</td>
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

                        </tr>

                        @foreach ($resin_records as $resin_record)
                            <tr>
                                <td style="vertical-align: top">
                                    {{ date('d/m/Y', strtotime($resin_record->shift_date . '+543 year')) }} /
                                    {{ $resin_record->on_shift }}</td>
                                <td style="vertical-align: top ">
                                    {{ $resin_record->detail }}
                                </td>

                                <td style="vertical-align: top;width:180px">

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

                                <td style="vertical-align: top">
                                    {{ $resin_record->user->name }}
                                </td>
                                <td style="vertical-align: top">{{ $resin_record->created_at->format('d/m/Y G:i') }}</td>
                                <td> <a href="{{ route('repair_resins', [$department_id, $line_id, $machine_id, $resin_record->resins_id]) }}"
                                        class="btn btn-warning">ซ่อม</a></td>
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach

            </table>


            {!! $resin_records_paginate->links() !!}
        @else
            <div class="alert alert-success">
                <h5>ไม่พบ เรซิ่น ไม่สมบูรณ์ รอการแก้ไข</h5>
            </div>
        @endif
    </div>
@endsection
