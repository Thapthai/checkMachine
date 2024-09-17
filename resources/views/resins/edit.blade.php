@extends('layouts.app')

@section('content')
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Edit Resin : {{ $resin->name }}</h2>
                </div>
                <div class="pull-right mb-2">
                    <div class="pull-right">
                        <form action="{{ route('machines', [$department_id, $onshift, $selected, $line_id, $shiftDate]) }}"
                        method="GET">
                        @csrf
                        <button type="submit" class="btn btn-warning">กลับ</button>
                        <button type="submit" class="btn btn-success">เครื่องจักรทั้งหมด</button>
                        <a href="{{ url('/') }}" class="btn btn-primary">หน้าแรก</a>
                    </form>
                    </div>
                </div>
                <hr>
            </div>
        </div>
        @if (session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif
        <form
            action="{{ route('resins.update', [$department_id, $onshift, $selected, $line_id, $shiftDate, $machine_id, $resin->id]) }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')


            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>ที่ตั้งหรือตำแหน่ง :</strong>
                    <input type="text" name="position" class="form-control" value="{{$resin->position}}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>จำนวนของ resin :</strong>
                    <input type="text" name="total_resin" class="form-control" value="{{$resin->total_resin}}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>วัสดุ :</strong>
                    <input type="text" name="material" class="form-control" value="{{$resin->material}}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>สี :</strong>
                    <input type="text" name="color" class="form-control" value="{{$resin->color}}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>ลำดับการตรวจ :</strong>
                    <input type="text" name="sequence" class="form-control" value="{{$resin->sequence}}">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>รายละเอียด :</strong>
                    <input type="text" name="detail" class="form-control" value="{{$resin->detail}}">
                </div>
            </div>


            <div class="modal-footer mt-2">
                <button type="submit" class="btn btn-warning w-100">แก้ไข</button>
            </div>
        </form>
    </div>
@endsection
