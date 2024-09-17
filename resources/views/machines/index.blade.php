@extends('layouts.app')

@push('styles')
    <style>
        div[id^="business"]:not(:target) {
            display: none;
        }

        .show-image {
            width: 570px;
            height: 520px;
            overflow: hidden;

        }

        .show-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        @media screen and (max-width: 900px) {

            .show-image {
                width: 275px;
                height: 415px;
                overflow: hidden;
            }

            .show-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                object-position: center;
            }

        }

        .showTitleImg {
            position: relative;
            display: inline-block;
            margin: 10px;
        }

        .hover-image {
            display: none;
            position: absolute;
            bottom: 100%;

            /* แสดงภาพด้านบนข้อความ */
            left: 50%;
            /* จัดกึ่งกลางแนวนอน */
            transform: translateX(-50%);
            z-index: 10;
            max-width: 200px;
            /* ปรับขนาดตามต้องการ */
            max-height: 200px;
            /* ปรับขนาดตามต้องการ */
        }

        .showTitleImg:hover .hover-image {
            display: block;
        }
    </style>
@endpush


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <table class="table">
                <tr>
                    <td>
                        <h4><strong>
                                เครื่องจักร | ตรวจสอบ @if ($selected == 'resin')
                                    เรซิ่น
                                @endif
                                @if ($selected == 'part')
                                    ชิ้นส่วน
                                @endif| ไลน์ผลิต: {{ $line->name }} | แผนก: {{ $department->name }}
                            </strong>
                        </h4>
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

            <form action="{{ route('machines', [$department->id, $onshift, $selected, $line->id, $shiftDate]) }}"
                method="GET">
                @csrf
                <div class="input-group my-3">
                    <input type="search" name="search" class="form-control rounded" placeholder="Search"
                        aria-label="Search" value="{{ request('search') }}" />
                    <button type="submit" class="btn btn-outline-primary">ค้นหา</button>
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col">
                <a href="{{ route('lines', [$department->id, $onshift, $selected, $shiftDate]) }}"
                    class="btn btn-warning">กลับ</a>
                <a href="{{ url('/') }}" class="btn btn-primary">หน้าแรก</a>
                <a href="{{ route('machines_list', [$department->id, $onshift, $selected, $line->id, $shiftDate]) }}"
                    class="btn btn-danger">ตาราง เครื่องจักร </a>
            </div>

            <div class="col-auto">
                @if (Auth::user()->is_admin == '1')
                    <div class="pull-right mb-2">
                        <button type="button" class="btn btn-success my-2 mt-2" style="width: 300px" data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">
                            เพิ่มเครื่องจักรที่จะตรวจสอบ
                        </button>
                    </div>
                @endif

            </div>
        </div>

        <div class="row">
            @foreach ($machines as $machine)
                <div class="col-sm-6 my-2">
                    <div class="card shadow-sm">
                        <table class="mt-2 mb-2 ms-2">
                            <tr>
                                <td class="w-75">
                                    <a href="#business-{{ $machine->id }}" class="text-decoration-none "
                                        style="color: black">

                                        <h5 class="card-title"><strong>{{ $machine->sequence }}. เครื่องจักร:</strong>
                                            {{ $machine->name }}</h5>


                                        @if ($machine->detail)
                                            <p class="card-text"> <strong>รายละเอียด:</strong> {{ $machine->detail }}</p>
                                        @else
                                            <p class="card-text"> <strong>รายละเอียด:</strong> ไม่มี</p>
                                        @endif

                                    </a>
                                </td>
                                <td>
                                    {{-- <a href="{{ route('machines_schedule_plan', [$department->id, $onshift, $selected, $line->id, $machine->id, $shiftDate]) }}"
                                        class="btn btn-secondary">วางแผน</a> --}}

                                    @if (Auth::user()->is_admin == '1')
                                        <!-- Button to open the modal -->
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                            data-bs-target="#schedulePlanModal-{{ $machine->id }}">
                                            วางแผน
                                        </button>
                                        <!-- The Modal -->
                                        <div class="modal fade" id="schedulePlanModal-{{ $machine->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Schedule Plan
                                                            {{ $machine->name }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <!-- Modal Body -->
                                                    <form
                                                        action="{{ route('schedule_plan', [$department->id, $onshift, $selected, $line->id, $machine->id, $shiftDate]) }}"
                                                        method="post" enctype="multipart/form-data">
                                                        <div class="modal-body">

                                                            {{ csrf_field() }}
                                                            @foreach ($frequenctChecks as $frequencyCheck)
                                                                <div class="border border-2 rounded-1 p-2 mb-3">
                                                                    {{-- <div class="alert alert-success mt-2"> --}}
                                                                    <h5><strong>

                                                                            @switch($frequencyCheck->name)
                                                                                @case('Weekly')
                                                                                    ตรวจสอบ ของสัปดาห์
                                                                                @break

                                                                                @case('Monthly')
                                                                                    ตรวจสอบ ของแต่ละเดือน
                                                                                @break

                                                                                @default
                                                                                    ตรวจสอบ ทุกวัน
                                                                            @endswitch
                                                                        </strong></h5>
                                                                    {{-- </div> --}}

                                                                    <div class="card card-body">
                                                                        @foreach ($machine->resins as $resin)
                                                                            <div class="form-check">

                                                                                <input class="form-check-input"
                                                                                    type="checkbox"
                                                                                    name="scheduleResins[{{ $frequencyCheck->id }}][{{ $resin->id }}]"
                                                                                    @foreach ($frequencyCheck->schedulePlans as $schedulePlan)
                                                                        @if ($resin->id == $schedulePlan->resin_id) checked @endif @endforeach>
                                                                                <label class="form-check-label mt-2">

                                                                                    <div class="showTitleImg">
                                                                                        @if ($resin->pic1)
                                                                                            <img src="{{ url('storage/' . $resin->pic1) }}"
                                                                                                alt="Image"
                                                                                                class="hover-image">
                                                                                        @else
                                                                                            <div class="hover-image alert alert-danger text-center"
                                                                                                style="width: 150px">
                                                                                                <p>ไม่มีรูปภาพ</p>
                                                                                            </div>
                                                                                        @endif
                                                                                        <span class="hover-text">
                                                                                            {{ $resin->position }}</span>

                                                                                    </div>
                                                                                </label>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>

                                                                </div>
                                                            @endforeach

                                                        </div>
                                                        <!-- Modal Footer -->
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">บันทึก</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td>

                                    <a href="{{ route('select_schedule_plan', [$department->id, $onshift, $selected, $line->id, $machine->id, $shiftDate]) }}"
                                        class="btn btn-primary">เลือก</a>

                                </td>
                                {{-- </tr>
                        </table> --}}

                                @include('machines.resins')
                                @include('machines.parts')
                    </div>
                </div>
        </div>
        @endforeach
        <div class="mt-4">
            {!! $machines->links() !!}
        </div>
    </div>


    @include('machines.create')
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
    $(function() {
        $('body').on('click', '.list-group-item', function() {
            $('.list-group-item').removeClass('active');
            $(this).closest('.list-group-item').addClass('active');
        });
    });
</script>



<script>
    document.querySelectorAll('.container').forEach(function(container) {
        container.addEventListener('mouseover', function() {
            // Add custom functionality if needed
        });

        container.addEventListener('mouseout', function() {
            // Add custom functionality if needed
        });
    });
</script>
