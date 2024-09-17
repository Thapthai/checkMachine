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
                    <h4><strong>บันทึกแอลกอฮอล์ และ คลอรีน</strong></h4>
                </td>
                <td style="text-align: right">
                    <h5><strong>กะ : {{ $onshift }} | วันที่ {{ $shiftDate }} </strong></h5>
                </td>
            </tr>

        </table>

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
                <a href="{{ route('alc_usage.index', [$department_id, $onshift, $selected, $shiftDate]) }}" class="btn btn-warning">กลับ</a>

                <a href="{{ url('/') }}" class="btn btn-primary">หน้าแรก</a>
            </div>

        </div>

        <hr>
        <h5><strong>รายการขวดที่เสียหาย </strong></h5>

        <table class="table">

            <thead>
                <tr>
                    <th>หมายเลข ขวด</th>
                    <td></td>

                </tr>
            </thead>
            @foreach ($alc_checking->alc_brokeds as $alc_broked)
                @if (count($alc_broked->alc_broked_pictures) < 1)
                    <tr>
                        <td>{{ $alc_broked->alc_usage_bottle->alc_bottle->bottle_no }}</td>
                        <td>
                            <form
                                action="{{ route('alc_broked.store', [$department_id, $onshift, $selected, $shiftDate, $alc_broked->id]) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf


                                <div class="row">

                                    <div class="col-6">
                                        <label>รายละเอียด</label>
                                        <input type="text" name="detail" class="form-control">
                                    </div>

                                    <div class="col">
                                        <label>รูปภาพ</label>
                                        <div class="field_wrapper_{{ $alc_broked->id }} form-control">
                                            <div>
                                                <input type="file" name="images[0]" accept="image/*"
                                                    id="images_{{ $alc_broked->id }}" required/>
                                            </div>
                                        </div><button type="button" class="add_button btn btn-outline-primary mt-2"
                                            data-id="{{ $alc_broked->id }}">เพิ่มรูป</button>
                                    </div>

                                    <button type="submit" class="btn btn-success mt-2">บันทึก</button>
                                </div>

                            </form>
                        </td>
                    </tr>
                @endif
            @endforeach
        </table>

        <hr>

        <h5><strong>รายการเสียหาย ที่เพิ่มรูปภาพแล้ว </strong></h5>

        <table class="table">
            <thead>
                <tr>
                    <th>หมายเลข ขวด</th>
                    <th>รายละเอียด</th>
                    <th style="text-align: center">รูปภาพ</th>
                    {{-- <th>Action</th> --}}
                </tr>

            </thead>
            <tbody>
                @foreach ($alc_checking->alc_brokeds as $alc_broked)
                    @if (count($alc_broked->alc_broked_pictures) > 0)
                        <tr>
                            <td> {{ $alc_broked->alc_usage_bottle->alc_bottle->bottle_no }} </td>
                            <td> {{ $alc_broked->detail }} </td>
                            <td style="text-align: center; width:800px">
                                @foreach ($alc_broked->alc_broked_pictures as $alc_broked_picture)
                                    <img src="{{ asset('storage/' . $alc_broked_picture->path) }}" alt="รูปภาพ"
                                        width="150px">
                                @endforeach
                            </td>

                        </tr>
                    @endif
                @endforeach
            </tbody>

        </table>


    </div>

    @include('alc.script')
@endsection
