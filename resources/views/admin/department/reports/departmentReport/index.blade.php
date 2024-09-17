@extends('layouts.app')

@push('styles')
    <style>
        body {
            /* background-color: #e1f5ff; */
        }

        .btn-circle {
            width: 30px;
            height: 30px;
            padding: 6px 0px;
            border-radius: 15px;
            text-align: center;
            font-size: 12px;
            line-height: 1.42857;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <a href="{{ route('admin.department.reports', [$department->id]) }}" class="btn btn-secondary mb-2">
            กลับ</a>
        <div class="row justify-content-center">
            <div class="col">

                <h3>รายงาน {{ $department->name }}
                    @switch($typeDoc)
                        @case('departmentDocType')
                            <label>การตรวจทั้งแผนก</label>
                        @break
                    @endswitch

                </h3>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.department.reports.sendReportEmail', [$department, $startDate, $endDate]) }}"
                    class="btn btn-primary">
                    <i class="fa-solid fa-envelope"></i> Send E-Mail
                </a>
                <a href="{{ route('admin.department.reports.exportExcel', [$department, $startDate, $endDate]) }}"
                    class="btn btn-success">
                    <i class="fa-solid fa-file-excel"></i> Export Excel
                </a>
            </div>
            <hr>

            <table class="table table-bordered">

                @foreach ($lines as $line)
                    <tr>
                        <td colspan="2">ไลน์ผลิต: {{ $line->name }}</td>
                        @foreach ($dates as $date)
                            <td>{{ $date }}</td>
                        @endforeach
                    </tr>
                    @foreach ($line->machines as $machine)
                        @php
                            $filteredResins = $machine->resins->filter(function ($resin) use ($startDate, $endDate) {
                                // กรอง schedule_records ตามช่วงวันที่ที่ต้องการ
                                $scheduleRecords = $resin->schedule_records->whereBetween('shift_date', [
                                    $startDate,
                                    $endDate,
                                ]);

                                // ตรวจสอบว่ามี schedule_records ที่ผ่านเงื่อนไข
                                return $scheduleRecords->isNotEmpty();
                            });
                        @endphp
                        <tr>
                            <th>เครื่องจักร</th>
                            <th>เรซิ่น</th>
                            <th colspan="{{ count($dates) }}" class="text-center">ผลตรวจ</th>

                        </tr>
                        <tr>
                            <td rowspan="{{ count($filteredResins) + 1 }}">{{ $machine->name }}</td>
                        </tr>
                        @foreach ($filteredResins as $filteredResin)
                            <tr>
                                <td>{{ $filteredResin->position }}</td>


                                @foreach ($dates as $date)
                                    @php
                                        $schedule_records = $filteredResin->schedule_records->where(
                                            'shift_date',
                                            $date,
                                        );

                                    @endphp

                                    @if (count($schedule_records) > 0)
                                        <td>
                                            @foreach ($schedule_records->groupBy('on_shift') as $shift => $schedule_records)
                                                <p>
                                                    @if ($shift != 'all day')
                                                        {{ $shift }}
                                                    @endif
                                                    @foreach ($schedule_records as $schedule_record)
                                                        @if ($schedule_record->clean == 'notuse')
                                                            <span class="btn bg-warning" title="ไม่ได้ใช้งาน">
                                                                ไม่ได้ใช้งาน
                                                            </span>
                                                        @else
                                                            @switch($schedule_record->clean)
                                                                @case('pass')
                                                                    <span class="btn btn-circle bg-info" title="ความสะอาด">
                                                                        <i class="fa-solid fa-check"></i>
                                                                    </span>
                                                                @break

                                                                @case('NOT')
                                                                    <span class="btn btn-circle bg-info" title="ความสะอาด">
                                                                        <i class="fa-solid fa-xmark"></i>
                                                                    </span>
                                                                @break

                                                                @default
                                                            @endswitch

                                                            @switch($schedule_record->complete)
                                                                @case('pass')
                                                                    <span class="btn btn-circle bg-success" title="ความสมบูรณ์">
                                                                        <i class="fa-solid fa-check"></i>
                                                                    </span>
                                                                @break

                                                                @case('NOT')
                                                                    <span class="btn btn-circle bg-success" title="ความสมบูรณ์">
                                                                        <i class="fa-solid fa-xmark"></i>
                                                                    </span>
                                                                @break

                                                                @default
                                                            @endswitch
                                                        @endif
                                                    @endforeach
                                                </p>
                                            @endforeach
                                        </td>
                                    @else
                                        <td></td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach

            </table>


            {{ $lines->appends(['startDate' => $startDate, 'endDate' => $endDate])->links() }}

        </div>


    </div>

    @push('script')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $(document).ready(function() {
                // Initialize Select2
                $('#typeDocSelect').select2();

                // Handle the Select All button click
                $('#selectAllButton').click(function() {
                    // Select all options in the Select2 element
                    var options = $('#typeDocSelect option');
                    options.prop('selected', true);
                    $('#typeDocSelect').trigger('change'); // Trigger change event to update Select2 UI
                });
            });
        </script>
    @endpush
@endsection
