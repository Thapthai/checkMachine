@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="row">
                <div class="col">
                    <h4><strong>ชิ้นส่วนไม่สมบูรณ์ <i><u class="text-danger"> รอการแก้ไข </u></i></strong></h4>
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
            </div>
            <div class="row">
                <div class="pull-right mb-2">
                    <a onclick=" window.print()" class="btn btn-success d-print-none">กดเพื่อพิมพ์ หรือ save เป็น PDF</a>
                </div>
            </div>

            <h4 style=" text-align: center;"><Strong>ชิ้นส่วนไม่สมบูรณ์ <i><u class="text-danger"> รอการแก้ไข </u></i>
                </Strong></h4>

            <h5 class="mt-2" style=" text-align: center;"><strong>แผนก : {{ $department_name }} | เครื่องจักร :
                    {{ $machine_name }}</strong></h5>


            <table class="table table-bordered">
                <thead>


                    <tr>
                        <th>ID</th>
                        <th>ชิ้นส่วน</th>
                        <th>กะ</th>
                        <th>บันทึกก่อน / หลัง</th>
                        <th>รายละเอียด</th>
                        <th>รูป</th>
                        <th>ผู้บันทึก</th>
                        <th>เวลา</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($incomplete_parts as $incomplete_part)
                        <tr>
                            <th colspan="9" class="bg-light"> ชิ้นส่วน
                                :{{ $incomplete_part->id }} {{ $incomplete_part->name }}</th>
                        </tr>
                        @foreach ($incomplete_part->part_records as $part_record)
                            @if ($part_record->status == 'NOT')
                                <tr>
                                    <td style="width: 20px"> {{ $part_record->id }}</td>
                                    <td> {{ $part_record->checklist->name }}</td>
                                    <td>
                                        @if ($part_record->on_shift == 'b')
                                            B
                                        @endif
                                        @if ($part_record->on_shift == 'c')
                                            C
                                        @endif


                                    </td>
                                    <td> {{ $part_record->check_in }}</td>
                                    <td> {{ $part_record->detail ?? '-' }}</td>
                                    <td style="width: 100px">
                                        @if (!is_null($part_record->pic2))
                                            <img src="{{ url('storage/' . $part_record->pic2) }}" width="100px">
                                        @else
                                            <i class="text-danger">*** ไม่มีรูป ***</i>
                                        @endif
                                    </td>
                                    <td>{{ $part_record->user->username }}</td>

                                    <td> {{ $part_record->created_at->format('d/m/Y G:i') }}</td>
                                    <td> <a href="{{ route('repair_parts', [$department_id, $line_id, $machine_id, $part_record->parts_id]) }}"
                                            class="btn btn-warning w-100">ซ่อม</a></td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                </tbody>
            </table>

            {!! $incomplete_parts->links() !!}
        </div>
    </div>
@endsection
