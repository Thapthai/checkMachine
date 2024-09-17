@extends('layouts.app')

@push('styles')
    <style>

    </style>
@endpush

@section('content')
    <div class="container">

        <table class="table">
            <tr>
                <td>
                    <h4><strong>ขวดแอลกอฮอล์ และ คลอรีน | แผนก {{ $department->name }}</strong></h4>
                </td>

            </tr>

        </table>

        @if ($message = Session::get('success'))
            <div class="alert alert-success d-print-none">
                <p>{{ $message }}</p>
            </div>
        @endif
        @if ($message = Session::get('error'))
            <div class="alert alert-warning d-print-none">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="row d-print-none">
            <div class="pull-right mb-2">
                <a href="{{ url('/') }}" class="btn btn-primary">หน้าแรก</a>
            </div>
            <hr>
        </div>


        <div class="pull-right d-print-none">

            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addBottle">
                เพิ่มขวด
            </button>
            <a onclick=" window.print()" class="btn btn-secondary d-print-none">กดเพื่อพิมพ์ หรือ save เป็น
                PDF</a>
        </div>

        <div class="modal" id="addBottle">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title">เพิ่มขวด</h4>
                        <button type="button" class="btn close" data-dismiss="modal">X</button>
                    </div>


                    <form action="{{ route('alc_bottles.store', [$department->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">

                            <label>เลือก ไลน์ผลิต</label>
                            <select name="line_id" class="form form-select">
                                @foreach ($lines as $line)
                                    <option value="{{ $line->id }}">{{ $line->name }}</option>
                                @endforeach
                            </select>

                            <label>หมายเลขขวด</label>
                            <input type="text" name="bottle_no" class="form-control" required>


                            <label>ชนิดสารเคมี</label>
                            <select name="type" class="form-select">
                                <option value="Alc">แอลกอฮอล์ </option>
                                <option value="Cl">คลอรีน </option>
                            </select>

                            <label>ปริมาตร</label>
                            <input type="number" name="volume" class="form-control" step="0.01" required>

                            <label>หน่วย</label>
                            <select name="unit_id" class="form form-select">
                                @foreach ($units as $unit_id => $unit_name)
                                    <option value="{{ $unit_id }}">{{ $unit_name }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">เพิ่มขวด</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>
    <div class="container-fluid">

        @foreach ($alc_bottles->groupBy('type') as $type => $alc_bottles)
            <div class="col">
                <h3>
                    @switch($type)
                        @case('Alc')
                            แอลกอฮอล์
                        @break

                        @case('Cl')
                            คลอรีน
                        @break

                        @default
                            ค่าเริ่มต้นหรือไม่ระบุ
                    @endswitch
                </h3>
            </div>
            <div class="row row-cols-1 row-cols-md-5 g-3">
                @foreach ($alc_bottles as $alc_bottle)
                    <div class="col mb-3">
                        <div class="card" style="border: 1px solid black">
                            <div class="card-body">
                                <h5 class="card-title"><strong>{{ $alc_bottle->name }}</strong></h5>
                                <div class="card-text">
                                    {{-- <strong>ID:</strong> {{ $alc_bottle->id ?? '-' }}<br> --}}
                                    <div class="row">
                                        <div class="col">
                                            <strong>ปริมาตร:</strong> {{ $alc_bottle->volume }}
                                            {{ $alc_bottle->unit->name ?? '' }}
                                        </div>
                                        <div class="col">
                                            <strong>ชนิด:</strong>
                                            @switch($alc_bottle->type)
                                                @case('Alc')
                                                    แอลกอฮอล์
                                                @break

                                                @case('Cl')
                                                    คลอรีน
                                                @break

                                                @default
                                                    ค่าเริ่มต้นหรือไม่ระบุ
                                            @endswitch
                                        </div>
                                    </div>

                                </div>
                                <div style="text-align: center">
                                    <img src="{{ $alc_bottle->barcode }}" alt="Barcode" width="250px" height="50px">
                                </div>
                                <div class="d-print-none">
                                    <hr>
                                    <button type="button" class="btn btn-warning" data-toggle="modal"
                                        data-target="#edit-bottle-{{ $alc_bottle->id }}">แก้ไข</button>
                                    <form action="{{ route('alc_bottles.destroy', [$department->id, $alc_bottle->id]) }}"
                                        method="post" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">ลบ</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Modal แก้ไขขวด -->
                        <div class="modal" id="edit-bottle-{{ $alc_bottle->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">แก้ไข</h4>
                                        <button type="button" class="btn close" data-dismiss="modal">X</button>
                                    </div>
                                    <form action="{{ route('alc_bottles.update', [$department->id, $alc_bottle->id]) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <label>เลือก ไลน์ผลิต</label>
                                            <select name="line_id" class="form form-select">
                                                @foreach ($lines as $line)
                                                    <option value="{{ $line->id }}"
                                                        @if ($alc_bottle->line_id == $line->id) selected @endif>
                                                        {{ $line->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label>หมายเลขขวด</label>
                                            <input type="text" name="bottle_no" class="form-control"
                                                value="{{ $alc_bottle->bottle_no }}">
                                            <label>ชนิด</label>
                                            <select name="type" class="form-select">
                                                <option value="Alc" @if ($alc_bottle->type == 'Alc') selected @endif>
                                                    แอลกอฮอล์</option>
                                                <option value="Cl" @if ($alc_bottle->type == 'Cl') selected @endif>
                                                    คลอรีน</option>
                                            </select>
                                            <label>สถานะ</label>
                                            <select name="status" class="form-select">
                                                <option value="Active" @if ($alc_bottle->status == 'Active') selected @endif>
                                                    Active</option>
                                                <option value="Inactive"
                                                    @if ($alc_bottle->status == 'Inactive') selected @endif>
                                                    Inactive</option>
                                            </select>
                                            <label>ปริมาตร</label>
                                            <input type="number" name="volume" class="form-control" step="0.01"
                                                value="{{ $alc_bottle->volume }}">
                                            <label>หน่วย</label>
                                            <select name="unit_id" class="form form-select">
                                                @foreach ($units as $unit_id => $unit_name)
                                                    <option value="{{ $unit_id }}"
                                                        @if ($alc_bottle->unit_id == $unit_id) selected @endif>
                                                        {{ $unit_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-warning">แก้ไข</button>
                                            <button type="button" class="btn btn-danger"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach



        {{-- {{ $alc_bottles_paginate->links() }} --}}


    </div>
@endsection
