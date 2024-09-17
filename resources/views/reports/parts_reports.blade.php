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
                <div class="pull-right mb-2">
                    <a href="{{ route('reports.index', [$department_id, $line_id]) }}"
                        class="btn btn-warning d-print-none">กลับ</a>
                    <a href="{{ url('/') }}" class="btn btn-primary d-print-none">หน้าแรก</a>

                </div>
            </div>
            <form action="{{ route('parts_reports', [$department_id, $line_id, $machine_id]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="input-group my-3">
                    <input type="text" name="datefilter" class="form-control mx-1 d-print-none"
                        value=" {{ date('Y-m-d') }}" />
                    <button type="submit" class="btn btn-outline-primary d-print-none">เลือกวันที่</button>
                </div>
            </form>


            <table class="table table-borderless">
                <tr>
                    <td class="w-50" style="text-align:left">
                        <h5>วันที่ {{ $start_date ?? '' }} - {{ $end_date ?? '' }}</h5>
                    </td>
                </tr>
                <tr>
                    <td class="w-100" style="text-align:left">
                        <form action="{{ route('resins_report_excel') }}">
                            @csrf
                            <input type="hidden" name="department_name" value="{{ $department_name }}">
                            <input type="hidden" value="{{ $start_date }}" name="start_date">
                            <input type="hidden" value="{{ $end_date }}" name="end_date">
                            <input type="hidden" value="{{ $department_id }}" name="department_id">
                            <input type="hidden" value="{{ $line_id }}" name="line_id">
                            <input type="hidden" value="{{ $machine_id }}" name="machine_id">

                            <input type="hidden" name="machine_id" value="{{ $machine_id }}">
                            <a onclick=" window.print()" class="btn btn-success d-print-none">กดพิมพ์ หรือ save เป็น
                                PDF</a>
                            <button type="submit" class="btn btn-danger d-print-none">Excel</button>
                        </form>
                    </td>
                </tr>
            </table>

            <h4 style=" text-align: center;"><Strong>รายงานการบันทึก เรซิ่น</Strong></h4>
            <h5 class="mt-2" style=" text-align: center;"><strong>แผนก : {{ $department_name }} | เครื่องจักร :
                    {{ $machine_name }}</strong></h5>
        </div>
    </div>

    <div class="container-fluid">

        <div class="text-center">

        </div>

        <hr>
        <table class="table table-bordered border-dark">

            <tr>
                <th class="align-middle" style="text-align: center;width: 50px ">ลำดับ</th>
                <th class="align-middle" style="text-align: center;width: 200px ">รายการ</th>

                @foreach ($cheklists as $cheklist)
                    <th class="align-middle" style="text-align: center ">{{ $cheklist->seq }}</th>
                @endforeach

            </tr>
            @php
                $colspan_num = count($cheklists) + 4;
            @endphp


            @isset($period)
                @foreach ($period as $dt)
                    <tr>
                        <td colspan="{{ $colspan_num }}"> <strong>{{ $dt->format('l d F Y') }}</strong></td>
                    </tr>
                    @include('reports.parts_record_data')
                @endforeach
            @endisset

        </table>

    </div>
@endsection

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript">
    $(function() {

        $('input[name="datefilter"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' | ' + picker.endDate.format(
                'YYYY-MM-DD'));
        });

        $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

    });
</script>
