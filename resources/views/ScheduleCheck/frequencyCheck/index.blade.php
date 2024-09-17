@extends('layouts.app')
@push('styles')
    <style>

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
                        {{-- <a href="{{ route('reports.index', [$department->id, $line->id]) }}"
                            class="btn btn-warning d-print-none">กลับ</a> --}}
                        <a href="{{ url('/') }}" class="btn btn-primary d-print-none">หน้าแรก</a>
                    </div>
                </div>
                <div class="col">

                </div>
            </div>

            <h4 style=" text-align: center;"><Strong>Frequency Check</Strong></h4>

            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($frequencyChecks as $frequencyCheck)
                        <tr>
                            <td>{{ $frequencyCheck->id }}</td>
                            <td>{{ $frequencyCheck->name }}</td>
                            <td style="width: 150px">
                                <div class="row">
                                    <div class="col">
                                        <button class="btn btn-warning">แก้ไข</button>
                                    </div>

                                    <div class="col col-auto">

                                        <form action="" method="post">
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure?')">ลบ</button>
                                        </form>
                                    </div>

                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
@endsection
