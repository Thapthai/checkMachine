@extends('layouts.app')

@push('styles')
    <style>
        body {
            /* background-color: #e1f5ff; */
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <a href="{{ route('admin.department', [$department->id]) }}" class="btn btn-secondary mb-2">
            กลับ</a>
        <div class="row justify-content-center">
            <h3>รายงาน {{ $department->name }}</h3>
            <hr>
        </div>

        <div class="card card-body">
            <form action="" method="get">
                @csrf
                <label>ประเภทรายงาน</label>
                <select name="typeDoc" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option>เลือก</option>

                    <option value="departmentDocType" @if ($typeDoc == 'departmentDocType') selected @endif>รายงาน แผนก</option>
                    <option value="lineDocType" @if ($typeDoc == 'lineDocType') selected @endif>รายงาน
                        แต่ลละไลน์การผลิต</option>
                    <option value="machineDocType" @if ($typeDoc == 'machineDocType') selected @endif>รายงาน
                        แต่ลละเครื่องจักร</option>
                </select>
            </form>

            <hr>
            @if (isset($typeDoc))
                <h5>
                    <strong>ประเภทรายงาน
                        @switch($typeDoc)
                            @case('departmentDocType')
                                รายงาน แผนก
                            @break

                            @case('lineDocType')
                                รายงาน แต่ลละไลน์การผลิต
                            @break

                            @case('machineDocType')
                                รายงาน แต่ลละเครื่องจักร
                            @break
                        @endswitch
                    </strong>
                </h5>
                <form action="{{ route('admin.department.reports.view', [$department->id, $typeDoc]) }}" method="get">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label>ตั้งแต่</label>
                            <input type="date" name="startDate" class="form-control form-control-sm"
                                value="{{ date('Y-m-d', strtotime('-1 day')) }}">
                        </div>
                        <div class="col">
                            <label>ถึง</label>
                            <input type="date" name="endDate" class="form-control form-control-sm"
                                value="{{ date('Y-m-d') }}">
                        </div>
                    </div>


                    @switch($typeDoc)
                        @case('departmentDocType')
                        @break

                        @case('lineDocType')
                            <label>เลือกไลน์การผลิต:</label>
                            <select name="lineSelect[]" class="form-select form-select-sm" multiple id="typeDocSelect">

                                @foreach ($lines as $line_id => $line_name)
                                    <option value="{{ $line_id }}">{{ $line_name }}</option>
                                @endforeach
                            </select>
                            <input type="checkbox" id="selectAllButton" class="mt-2"> เลือกทั้งหมด
                        @break

                        @case('machineDocType')
                            <label>เลือกเครื่องจักร:</label>
                            <select name="machineSelect[]" class="form-select form-select-sm" multiple id="typeDocSelect">

                                @foreach ($machines as $machine_id => $machine_name)
                                    <option value="{{ $machine_id }}">{{ $machine_name }}</option>
                                @endforeach

                            </select>
                            <input type="checkbox" id="selectAllButton" class="mt-2"> เลือกทั้งหมด
                        @break

                        @default
                    @endswitch
                    <div class="text-end">
                        <button type="submit" class="btn btn-success mt-2">ดูรายงาน</button>
                    </div>
                </form>
            @endif

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
