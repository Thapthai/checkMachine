@extends('layouts.app')

@push('styles')
    <style>
        .table-container {
            overflow-x: auto;
        }

        @media screen and (max-width: 767px) {
            .table-responsive {
                display: block;
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                -ms-overflow-style: -ms-autohiding-scrollbar;
                border-collapse: collapse;
                border-spacing: 0;
            }

            .table-responsive>.table {
                margin-bottom: 0;
            }

            .table-responsive>.table>thead>tr>th,
            .table-responsive>.table>tbody>tr>th,
            .table-responsive>.table>tfoot>tr>th,
            .table-responsive>.table>thead>tr>td,
            .table-responsive>.table>tbody>tr>td,
            .table-responsive>.table>tfoot>tr>td {
                white-space: nowrap;
            }
        }

        /* Modal Box  */

        .modal-box {
            width: 100%;
            max-width: 500px;
            margin: 0px auto;
        }
    </style>
@endpush

@section('content')
    <div class="container">

        <table class="table">
            <tr>
                <td>
                    <h4><strong>ตรวจสอบแอลกอฮอล์ และ คลอรีน</strong></h4>
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
                <a href="{{ route('onshift.index', [$department_id]) }}" class="btn btn-warning">กลับ</a>

                <a href="{{ url('/') }}" class="btn btn-primary">หน้าแรก</a>
            </div>

        </div>
        <hr>

        <form id="dateForm" method="get">
            <h5>วันที่ {{ date('d F Y', strtotime($shiftDate)) }}</h5>
            <div class="input-group my-3">
                <input id="searchDateInput" type="date" name="searchDate" class="form-control"
                    value="{{ $shiftDate }}" />
                <a id="searchDateLink" href="#" class="btn btn-outline-primary d-print-none">เลือกวันที่</a>
            </div>
        </form>
        {{-- <a class="btn btn-outline-primary">รายงาน</a> --}}

        <div class="row mt-2">
            <!-- ส่วนซ้าย -->
            <div class="col-md-6">
                @if (Auth::user()->is_admin == '1')
                    <button type="button" class="btn btn-success" style="width: 200px" data-toggle="modal"
                        data-target="#create-standard">
                        เพิ่ม standard
                    </button>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="{{ route('alc_bottles.index', [$department_id]) }}" target="_blank"
                            class="btn btn-primary">ขวดแอลกอฮอล์ และ
                            คลอรีน</a>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addBottle">
                            เพิ่มขวด
                        </button>
                    </div>
                @endif
            </div>

            <!-- ส่วนขวา -->
            <div class="col-md-6" style="text-align: right">
                <button type="button" class="btn btn-primary" style="width: 200px" data-toggle="modal" data-target="#usage"
                    onclick="openModal('contentpackageB')">
                    จ่ายออก
                </button>

                <a href="{{ route('alc_usage.index', [$department_id, $onshift, $selected, $shiftDate]) }}"
                    class="btn btn-success" style="width: 200px">
                    บันทึกการใช้งาน
                </a>
            </div>
        </div>
        <div class="modal" id="addBottle">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title">เพิ่มขวด</h4>
                        <button type="button" class="btn close" data-dismiss="modal">X</button>
                    </div>

                    <form action="{{ route('alc_bottles.store', [$department_id]) }}" method="POST"
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
        <hr>


        <h5><strong>กำหนด มาตรฐาน</strong></h5>
        <div class="table-container table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>แผนก</th>
                        <th>ไลน์</th>
                        <th>ส่วนงาน</th>
                        <th>ชนิด</th>
                        <th style="text-align: center">จำนวนที่ใช้</th>
                        <th style="text-align: center">จำนวนครั้ง</th>
                        <th style="text-align: center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($alc_standards as $alc_standard)
                        <tr>
                            <td>{{ $alc_standard->department->name }}</td>
                            <td>{{ $alc_standard->line->name }}</td>
                            <td>{{ $alc_standard->name }}</td>
                            <td>{{ $alc_standard->type }}</td>
                            <td style="text-align: center">{{ $alc_standard->quantity }}</td>
                            <td style="text-align: center">
                                {{ count($alc_standard->alc_usage->where('shift_date', $shiftDate . ' 00:00:00')) }}
                            </td>
                            <td style="text-align: center">
                                <form action="{{ route('alc_standard_delete', $alc_standard->id) }}" method="POST">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#edit-standard-{{ $alc_standard->id }}">
                                            แก้ไข
                                        </button>

                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Are you sure?')">ลบข้อมูล</button>
                                    </div>
                                </form>
                            </td>
                        </tr>


                        <!-- The Edit Modal -->
                        <div class="modal" id="edit-standard-{{ $alc_standard->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title"> แก้ไข {{ $alc_standard->id }}</h4>
                                        <button type="button" class="btn close" data-dismiss="modal">X</button>
                                    </div>

                                    <form action="{{ route('alc_standard_update', [$alc_standard->id]) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <!-- Modal Body -->
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="department">ไลน์ผลิต{{ $alc_standard->id }}</label>
                                                <select class="form-select" id="department" name="line_id">
                                                    @foreach ($lines as $line)
                                                        <option value="{{ $line->id }}"
                                                            @if ($line->id == $alc_standard->line_id) selected @endif>
                                                            {{ $line->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <label>ส่วนงาน</label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ $alc_standard->name }}">

                                            <label>ชนิด</label>
                                            <select name="type" class="form-select">
                                                <option value="Alc" @if ($alc_standard->type == 'Alc') selected @endif>
                                                    แอลกอฮอล์</option>
                                                <option value="Cl" @if ($alc_standard->type == 'Cl') selected @endif>
                                                    คลอรีน</option>

                                            </select>

                                            <label>จำนวน</label>
                                            <input type="number" name="quantity" class="form-control"
                                                value="{{ $alc_standard->quantity }}" required>

                                        </div>

                                        <!-- Modal Footer -->
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-warning">แก้ไข</button>
                                            <button type="button" class="btn btn-danger"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>

            {{ $alc_standards->appends(['alc_standards'])->links() }}


            <hr>
            <h5><strong>รายการ จ่ายออก</strong></h5>

            <table class="table table-striped table-hover">
                <thead>

                    <tr>
                        <th>ส่วนงาน</th>
                        <th style="text-align: center">จำนวนมาตฐาน</th>
                        <th style="text-align: center">จำนวนที่เบิก</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($alc_usages as $alc_usage)
                        <tr>
                            <td>{{ $alc_usage->alc_standard->name }} </td>
                            <td style="text-align: center">{{ $alc_usage->alc_standard->quantity }}</td>
                            <td style="text-align: center">{{ $alc_usage->used_quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $alc_usages->appends(['alc_usages'])->links() }}

        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://bsite.net/savrajdutta/cdn/multi-select.js"></script>
        <script>
            $(document).ready(function() {
                $(".sd-CustomSelect").multipleSelect({
                    selectAll: false,
                    onOptgroupClick: function(view) {
                        $(view).parents("label").addClass("selected-optgroup");
                    }
                });
            });
        </script>
        <script>
            document.getElementById('searchDateLink').addEventListener('click', function(event) {
                event.preventDefault(); // ป้องกันการโหลดหน้าใหม่เมื่อคลิกลิงก์

                var searchDate = document.getElementById('searchDateInput').value;
                var department_id = '{{ $department_id }}';
                var onshift = '{{ $onshift }}';
                var selected = '{{ $selected }}';

                var url = `/department/${department_id}/onshift/${onshift}/select/${selected}/alcs/${searchDate}`;

                window.location.href = url; // นำผู้ใช้ไปยัง URL ที่มีค่าวันที่จากฟิลด์ input
            });
        </script>

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


        <script>
            function openModal(usage) {

                $('.select_bottles').select2({
                    placeholder: 'เลือกขวด',
                    width: '100%',
                    border: '1px solid #e4e5e7'
                });

                $('.select_bottles').on('change', function() {
                    var selectedCount = $(this).find(':selected').length;
                    if ($(this).val() && $(this).val().includes('all')) {
                        selectedCount -= 1;
                    }

                    $('#selectedCountDisplay').val(selectedCount);

                });


                $('.select_bottles').on("select2:select", function(e) {
                    var data = e.params.data.text;
                    if (data == 'all') {
                        $(".select_bottles > option").prop("selected", "selected");
                        $(".select_bottles").trigger("change");
                    }
                });

            }
        </script>
    </div>
    @include('alc.modal')
@endsection

@include('alc.script')
