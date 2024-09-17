@extends('layouts.app')
@push('styles')
    <style>

    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row">
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
                    <a href="{{ route('reports.index', $department_id) }}" class="btn btn-warning d-print-none">กลับ</a>
                    <a href="{{ url('/') }}" class="btn btn-primary">หน้าแรก</a>

                </div>
            </div>

            <form action="{{ route('resins_reports', [$department_id, $machine_id]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="input-group my-3">
                    <input type="date" class="form-control mx-1 d-print-none" name="date" />
                    <select class="form-select mx-1 d-print-none" name="on_shift">
                        <option selected>เลือก กะ</option>
                        <option value="b">กะ B</option>
                        <option value="c">กะ C</option>
                    </select>
                    <select class="form-select mx-1 d-print-none" name="check_in">
                        <option selected>การบันทึก</option>
                        <option value="before">ก่อน การผลิต</option>
                        <option value="after">หลัง การผลิต</option>
                    </select>
                    <button type="submit" class="btn btn-outline-primary d-print-none">search</button>
                </div>
            </form>



            <h4 style=" text-align: center;"><Strong>รายงานการบันทึก เรซิ่น</Strong></h4>
            <h5 class="mt-2" style=" text-align: center;"><strong>แผนก : {{ $department_name }} | เครื่องจักร :
                    {{ $machine_name }}</strong></h5>
            <div class="input-group my-3">

                @if (!is_null($on_shift) or !is_null($check_in))
                    <h5 class="form-control mx-1">
                        วัน {{ $date ?? '' }}
                    </h5>

                    @if ($on_shift == 'b')
                        <h5 class="form-control mx-1">
                            กะ B
                        </h5>
                    @endif
                    @if ($on_shift == 'c')
                        <h5 class="form-control mx-1">
                            กะ C
                        </h5>
                    @endif


                    @if ($check_in == 'before')
                        <h5 class="form-control mx-1">
                            ก่อนการผลิต
                        </h5>
                    @endif
                    @if ($check_in == 'after')
                        <h5 class="form-control mx-1">
                            หลังการผลิต
                        </h5>
                    @endif

                    <form action="{{ route('resins_report_excel') }}">
                        @csrf
                        <input type="hidden" name="department_name" value="{{ $department_name }}">
                        <input type="hidden" name="date" value="{{ $date }}">
                        <input type="hidden" name="on_shift" value="{{ $on_shift }}">
                        <input type="hidden" name="check_in" value="{{ $check_in }}">
                        <input type="hidden" name="machine_id" value="{{ $machine_id }}">
                        <a onclick=" window.print()" class="btn btn-success d-print-none">กดเพื่อพิมพ์ หรือ save เป็น
                            PDF</a>
                        <button type="submit" class="btn btn-danger d-print-none">Excel</button>
                    </form>
                @endif

            </div>
            <br>

            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th class="align-middle w-25" style="text-align: center" colspan="3">เครื่องจักร</th>
                        <th class="align-middle w-75" style="text-align: center" colspan="7" rowspan="2">เรชิ่น
                            ภายในเครื่อง</th>
                    </tr>
                    <tr>
                        <th class="align-middle" style="text-align: center ">No.</th>
                        <th class="align-middle" style="text-align: center ">ชื่อ</th>
                        <th class="align-middle" style="text-align: center ">รูปภาพ</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($machines as $machine)
                        <tr>
                            <td>{{ $machine->id }}</td>
                            <td>{{ $machine->name }}</td>
                            <td class="align-middle" style="text-align: center;width: 100px">
                                @if (!is_null($machine->pic1))
                                    <img src="{{ url('storage/' . $machine->pic1) }}" alt="img" draggable="false"
                                        width="100px">
                                @else
                                @endif
                                @if (!is_null($machine->pic2))
                                    <img src="{{ url('storage/' . $machine->pic2) }}" alt="img" draggable="false"
                                        width="100px">
                                @else
                                @endif
                                @if (!is_null($machine->pic3))
                                    <img src="{{ url('storage/' . $machine->pic3) }}" alt="img" draggable="false"
                                        width="100px">
                                @else
                                @endif
                            </td>

                            <td colspan="7">

                                <table class="table table-bordered">
                                    <tr>
                                        <th class="align-middle" style="text-align: center ">No. ของเรซิ่น</th>
                                        <th class="align-middle" style="text-align: center ">รูป</th>
                                        <th class="align-middle" style="text-align: center ">ตำแหน่ง</th>
                                        <th class="align-middle" style="text-align: center ">จำนวน</th>
                                        <th class="align-middle" style="text-align: center ">ชนิดวัสดุ(Material)</th>
                                        <th class="align-middle" style="text-align: center ">สี</th>
                                        <th class="align-middle" style="text-align: center ">สถานะ</th>
                                    </tr>
                                    @foreach ($machine->resins as $resin)
                                        <tr>

                                            <td>{{ $resin->sequence }}</td>
                                            <td class="align-middle" style="text-align: center;width: 100px">
                                                @if (!is_null($resin->pic1))
                                                    <img src="{{ url('storage/' . $resin->pic1) }}" alt="img"
                                                        draggable="false" width="100px">
                                                @else
                                                @endif
                                                @if (!is_null($resin->pic2))
                                                    <img src="{{ url('storage/' . $resin->pic2) }}" alt="img"
                                                        draggable="false" width="100px">
                                                @else
                                                @endif
                                                @if (!is_null($resin->pic3))
                                                    <img src="{{ url('storage/' . $resin->pic3) }}" alt="img"
                                                        draggable="false" width="100px">
                                                @else
                                                @endif
                                            </td>
                                            <td>{{ $resin->position }}</td>
                                            <td>{{ $resin->total_resin }}</td>
                                            <td>{{ $resin->material }}</td>
                                            <td>{{ $resin->color }}</td>

                                            @if (count($resin->resin_records) > 0)
                                                @if (isset($resin->resin_records))
                                                    @if ($resin_date == $date)
                                                        @if (isset($report[$resin->id]))
                                                            @if ($report[$resin->id]->status == 'pass')
                                                                <td class="align-middle"
                                                                    style="text-align: center ;width: 50px">
                                                                    <h4><i class='bx bx-check rounded-5 btn-success'></i>
                                                                    </h4>
                                                                </td>
                                                            @endif

                                                            @if ($report[$resin->id]->status == 'NOT')
                                                                <td class="align-middle"
                                                                    style="text-align: center ;width: 50px">
                                                                    <h4><i class='bx bx-x rounded-5 btn-danger'></i></h4>
                                                                </td>
                                                            @endif
                                                        @else
                                                            <td>
                                                                <i class="text-danger">**ไม่ได้บันทึก**</i>
                                                            </td>
                                                        @endif
                                                    @else
                                                        <td>
                                                            <i class="text-danger">**ไม่ได้บันทึก**</i>
                                                        </td>
                                                    @endif
                                                @endif
                                            @else
                                                <td> <i class="text-danger">**ไม่ได้บันทึก**</i>
                                                </td>
                                            @endif

                                        </tr>
                                    @endforeach
                                </table>
                            </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>

        </div>
    </div>
@endsection
