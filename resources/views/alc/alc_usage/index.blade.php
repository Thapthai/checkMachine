@extends('layouts.app')

@push('styles')
    <style>
        :root {
            --theme-color: #ff7f27;
            --theme-color-hover: #fc914a;
            --theme-color2: #000c7b;
        }

        /* Modal Box  */

        .modal-box {
            width: 100%;
            max-width: 500px;
            margin: 0px auto;
        }

        /* Custom Multi Select */
        .sd-multiSelect {
            position: relative;
        }

        .sd-multiSelect .placeholder {
            opacity: 1;
            background-color: transparent;
            cursor: pointer;
        }

        .sd-multiSelect .ms-offscreen {
            height: 1px;
            width: 1px;
            opacity: 0;
            overflow: hidden;
            display: none;
        }

        .sd-multiSelect .sd-CustomSelect {
            width: 100% !important;
        }

        .sd-multiSelect .ms-choice {
            position: relative;
            text-align: left !important;
            width: 100%;
            border: 1px solid #e3e3e3;
            background: #ffff;
            box-shadow: none;
            font-size: 15px;
            height: 44px;
            font-weight: 500;
            color: #212529;
            line-height: 1.5;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .sd-multiSelect .ms-choice:after {
            content: "\f107 ";
            font-family: "FontAwesome";
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
        }

        .sd-multiSelect .ms-choice:focus {
            border-color: var(--theme-color);
        }

        .sd-multiSelect .ms-drop.bottom {
            display: none;
            background: #fff;
            border: 1px solid #e5e5e5;
            padding: 10px;
            overflow-y: auto;
        }

        .sd-multiSelect .ms-drop li {
            position: relative;
            margin-bottom: 10px;
        }

        .sd-multiSelect .ms-drop li input[type="checkbox"] {
            padding: 0;
            height: initial;
            width: initial;
            margin-bottom: 0;
            display: none;
            cursor: pointer;
        }

        .sd-multiSelect .ms-drop li label {
            cursor: pointer;
            user-select: none;
            -ms-user-select: none;
            -moz-user-select: none;
            -webkit-user-select: none;
        }

        .sd-multiSelect .ms-drop li label:before {
            content: "";
            -webkit-appearance: none;
            background-color: transparent;
            border: 2px solid var(--theme-color);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05),
                inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05);
            padding: 8px;
            display: inline-block;
            position: relative;
            vertical-align: middle;
            cursor: pointer;
            margin-right: 5px;
        }

        .sd-multiSelect .ms-drop li input:checked+span:after {
            content: "";
            display: block;
            position: absolute;
            top: 9px;
            left: 5px;
            width: 10px;
            height: 10px;
            background: var(--theme-color);
            border-width: 0 2px 2px 0;
        }
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
                <a href="{{ route('alcs', [$department_id, $onshift, $shiftDate, 'selected' => 'alc']) }}"
                    class="btn btn-warning">กลับ</a>

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
        @if (count($alc_usages) > 0)
            <h5><strong>รายการที่ต้องบันทึก แอลกอฮอล์ และ คลอรีน</strong></h5>

            <table class="table ">

                <thead>
                    <tr>
                        <th>ส่วนงาน</th>
                        <th>จำนวนมาตฐาน</th>
                        <th>จำนวนที่เบิก</th>
                        <th>จำนวนที่ใช้จริง</th>
                        <th>จำนวนที่ เสียหาย</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alc_usages as $alc_usage)
                        @if (count($alc_usage->alc_checkings) < 1)
                            <tr>
                                <td>{{ $alc_usage->alc_standard->name }} </td>
                                <td>{{ $alc_usage->alc_standard->quantity }}</td>
                                <td>{{ $alc_usage->used_quantity }}</td>

                                <form
                                    action="{{ route('alc_checking.store', [$department_id, $onshift, $selected, $shiftDate, $alc_usage->id]) }}"
                                    method="POST" enctype="multipart/form-data">

                                    @csrf
                                    <td>

                                        <input type="number" name="num_alc_usage" class="form-control"
                                            id="selectedUsageCountDisplay" min="0" value="0"
                                            max="{{ $alc_usage->used_quantity }}">

                                        @if (count($alc_usage->alc_usage_bottles) > 0)
                                            <div class="modal-box">
                                                <div class="sd-multiSelect form-group">
                                                    <label for="current-job-role">เลือกขวดที่ใช้</label>

                                                    <select multiple="multiple" class="select_bottles form-control "
                                                        name="alc_bottle_usage[]">
                                                        <option value="all">all</option>
                                                        @foreach ($alc_usage->alc_usage_bottles as $alc_usage_bottle)
                                                            <option value="{{ $alc_usage_bottle->id }}">
                                                                {{ $alc_usage_bottle->alc_bottle->name }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <input type="number" name="num_alc_broked" class="form-control"
                                            id="selectedBrokedCountDisplay" min="0" value="0"
                                            max="{{ $alc_usage->used_quantity }}">
                                        @if (count($alc_usage->alc_usage_bottles) > 0)
                                            <div class="modal-box">
                                                <div class="sd-multiSelect form-group">
                                                    <label for="current-job-role">เลือกขวดที่เสียหาย</label>

                                                    <select multiple="multiple"
                                                        class="select_alc_bottle_broked form-control "
                                                        name="alc_bottle_broked[]">
                                                        <option value="all">all</option>
                                                        @foreach ($alc_usage->alc_usage_bottles as $alc_usage_bottle)
                                                            <option value="{{ $alc_usage_bottle->id }}">
                                                                {{ $alc_usage_bottle->alc_bottle->name }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td><button class="btn btn-outline-success">บันทึก</button></td>
                                </form>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>

            {{ $alc_usages->appends('alc_standards')->links() }}
        @else
            <div class="alert alert-warning">
                <h3 style="text-align: center">!!! ~~~~~~ ยังไม่ได้ทำการเบิก ~~~~~~ !!!</h3>
            </div>
        @endif

        <hr>
        <h5><strong>รายการที่ บันทึก </strong></h5>

        <table class="table">
            <thead>
                <tr>
                    <th>ส่วนงาน</th>
                    <th>จำนวนมาตฐาน</th>
                    <th>จำนวนที่เบิก</th>
                    <th>จำนวนที่ใช้จริง</th>
                    <th>จำนวนที่ เสียหาย</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($alc_usages as $alc_usage)
                    @if ($alc_usage->alc_checkings->isEmpty())
                        <tr>
                            <td colspan="5" style="text-align: center">ไม่พบข้อมูลการตรวจสอบ</td>
                        </tr>
                    @else
                        @foreach ($alc_usage->alc_checkings as $alc_checking)
                            <tr>
                                <td>{{ $alc_usage->alc_standard->name }}</td>
                                <td>{{ $alc_usage->alc_standard->quantity }}</td>

                                <td>{{ $alc_usage->used_quantity }}</td>
                                <td>{{ $alc_checking->quantity_alc_usage }} ขวด

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>หมายเลขขวด</th>
                                                <th>ชื่อ</th>
                                                <th>ชนิด</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($alc_checking->alc_normals as $alc_normal)
                                                <tr>
                                                    <td>
                                                        {{ $alc_normal->alc_usage_bottle->alc_bottle->bottle_no }}
                                                    </td>
                                                    <td>
                                                        {{ $alc_normal->alc_usage_bottle->alc_bottle->name}}
                                                    </td>
                                                    <td>
                                                        {{ $alc_normal->alc_usage_bottle->alc_bottle->type }}

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </td>
                                @if (count($alc_checking->alc_brokeds) > 0)
                                    <td>{{ $alc_checking->quantity_alc_broked }} ขวด
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>หมายเลขขวด</th>
                                                    <th>ชื่อ</th>
                                                    <th>ชนิด</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($alc_checking->alc_brokeds as $alc_broked)
                                                    <tr>
                                                        <td>
                                                            {{ $alc_broked->alc_usage_bottle->alc_bottle->bottle_no }}
                                                        </td>
                                                        <td>
                                                            {{ $alc_broked->alc_usage_bottle->alc_bottle->name }}
                                                        </td>
                                                        <td>
                                                            {{ $alc_broked->alc_usage_bottle->alc_bottle->type }}

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <a href="{{ route('alc_broked.index', [$department_id, $onshift, $selected, $shiftDate, $alc_checking->id]) }}"
                                            class="btn btn-danger w-100">บันทึกความเสียหาย</a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                @endforeach
            </tbody>
        </table>


        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
            $(document).ready(function() {
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

                    $('#selectedUsageCountDisplay').val(selectedCount);

                });


                $('.select_bottles').on("select2:select", function(e) {
                    var data = e.params.data.text;
                    if (data == 'all') {
                        $(".select_bottles > option").prop("selected", "selected");
                        $(".select_bottles").trigger("change");
                    }
                });

                $('.select_alc_bottle_broked').select2({
                    placeholder: 'เลือกขวด',
                    width: '100%',
                    border: '1px solid #e4e5e7'
                });

                $('.select_alc_bottle_broked').on('change', function() {
                    var selectedCount = $(this).find(':selected').length;
                    if ($(this).val() && $(this).val().includes('all')) {
                        selectedCount -= 1;
                    }

                    $('#selectedBrokedCountDisplay').val(selectedCount);

                });


                $('.select_alc_bottle_broked').on("select2:select", function(e) {
                    var data = e.params.data.text;
                    if (data == 'all') {
                        $(".select_alc_bottle_broked > option").prop("selected", "selected");
                        $(".select_alc_bottle_broked").trigger("change");
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

                var url =
                    `/department/${department_id}/onshift/${onshift}/select/${selected}/alcs/${searchDate}/alc_usage`;

                window.location.href = url;
            });
        </script>



    </div>
@endsection
