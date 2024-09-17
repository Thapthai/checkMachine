@extends('layouts.app')

@push('styles')
    <style>

    </style>
@endpush

@section('content')
    <div class="container">

        @if ($approve)
            <div class="row">
                <div class="col">
                    <h4> ใบยืนยันเลขที่: {{ $approve->id }}</h4>
                </div>
                <div class="col-auto">
                    <form action="{{ route('checkApprove', [$approve->id]) }}" method="POST" enctype="multipart/form-data">

                        @csrf
                        <input class="form-check-input" type="radio" name="status" value="pass" checked>
                        ผ่าน
                        <input class="form-check-input" type="radio" name="status" value="not">
                        ไม่ผ่าน
                        <button type="submit" class="btn btn-primary">Approve</button>
                    </form>
                </div>
            </div>
        @endif
        <table class="table ">
            <thead>

                <tr>
                    <th style="text-align: center ">เครื่องจักร</th>
                    <th class="align-middle" style="text-align: center ">ลำดับ</th>
                    <th class="align-middle" style="text-align: center ">ตำแหน่ง</th>
                    <th class="align-middle" style="text-align: center ">จำนวน</th>
                    <th class="align-middle" style="text-align: center ">ชนิดวัสดุ(Material)</th>
                    <th class="align-middle" style="text-align: center ">สี</th>
                    <th class="align-middle" style="text-align: center ">รายละเอียด</th>
                    <th class="align-middle" style="text-align: center ">รูป</th>
                    <th class="align-middle" style="text-align: center ">กะ</th>
                    <th class="align-middle" style="text-align: center ">ความสะอาด</th>
                    <th class="align-middle" style="text-align: center ">สถานะ</th>
                    <th class="align-middle" style="text-align: center ">ซ่อม</th>
                </tr>


                </tr>
            </thead>


            <tbody>

                @foreach ($approve->approve_details->groupBy('machine.id') as $machine_id => $approve_details)
                    @php
                        $machine = $approve_details->first()->machine;

                    @endphp
                    <tr>
                        <td rowspan="{{ count($approve_details) + 1 }}" style="text-align: center ">
                            {{ $machine_id }}</td>
                    </tr>


                    @foreach ($approve_details as $approve_detail)
                        <tr>
                            <td style="text-align: center ">{{ $approve_detail->resin_record->resin->sequence ?? '' }}</td>
                            <td style="text-align: center ">
                                {{ $approve_detail->resin_record->resin->position ?? '-' }}
                            </td>
                            <td style="text-align: center ">{{ $approve_detail->resin_record->resin->total_resin ?? '' }}
                            </td>
                            <td style="text-align: center ">{{ $approve_detail->resin_record->resin->material ?? '' }}
                            </td>
                            <td style="text-align: center ">{{ $approve_detail->resin_record->resin->color ?? '' }}</td>
                            <td style="text-align: center ">{{ $approve_detail->resin_record->resin->detail ?? '' }}</td>

                            <td class="align-middle" style="text-align: center;width:180px">
                                @if (!empty($resin_record->pic1))
                                    <img src="{{ url('storage/' . $approve_detail->$resin_record->pic1) }}" alt="img"
                                        width="170px">
                                @else
                                    ไม่มี
                                @endif

                                @if (!empty($resin_record->pic2))
                                    <img src="{{ url('storage/' . $approve_detail->$resin_record->pic2) }}" alt="img"
                                        width="170px">
                                @endif

                                @if (!empty($resin_record->pic3))
                                    <img src="{{ url('storage/' . $approve_detail->$resin_record->pic3) }}" alt="img"
                                        width="170px">
                                @endif


                            </td>

                            <td>{{ date('d/m/Y', strtotime($approve->shift_date . '543 year')) }} /
                                {{ $approve->on_shift }}</td>

                            <td style="text-align: center ">

                                @if ($approve_detail->resin_record->clean == 'NOT')
                                    <h4><i class='bx bx-x bx-xs rounded-5 btn-danger '></i>
                                    </h4>
                                @endif

                                @if ($approve_detail->resin_record->clean == 'pass')
                                    <h4><i class='bx bx-check bx-xs rounded-5 btn-success '></i>
                                    </h4>
                                @endif

                            </td>
                            <td style="text-align: center ">

                                @if ($approve_detail->resin_record->status == 'NOT')
                                    <h4><i class='bx bx-x bx-xs rounded-5 btn-danger '></i>
                                    </h4>
                                @endif

                                @if ($approve_detail->resin_record->status == 'pass')
                                    <h4><i class='bx bx-check bx-xs rounded-5 btn-success '></i>
                                    </h4>
                                @endif
                            </td>
                            <td style="text-align: center ">
                                @if ($approve_detail->resin_record->status == 'pass')
                                    <h4><i class='bx bx-check bx-xs rounded-5 btn-success'></i>
                                    </h4>
                                @endif

                                @if ($approve_detail->resin_record->status == 'NOT')
                                    <h4><i class='bx bx-x bx-xs rounded-5 btn-danger'></i>
                                    </h4>
                                    @if (empty($resin_record->repair_date))
                                        <a href="{{ route('repair_resins', [$approve->department_id, $approve->line_id, $machine->id, $approve_detail->resin_record->resins_id]) }}"
                                            class="btn btn-warning d-print-none mb-2 btn-sm" target="_blank">ซ่อม</a>
                                    @endif
                                @endif
                            </td>


                        </tr>
                    @endforeach
                @endforeach


            </tbody>
        </table>
    </div>
@endsection
