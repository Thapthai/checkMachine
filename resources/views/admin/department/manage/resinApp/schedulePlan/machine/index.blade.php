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
            margin: 10px 0px;
        }

        .hover-image {
            display: none;
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
            max-width: 200px;
            max-height: 200px;
        }

        .showTitleImg:hover .hover-image {
            display: block;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">

        <a href="{{ route('admin.department.manage.resinApp', [$department->id]) }}" class="btn btn-secondary mb-2">กลับ</a>

        <h3>แผนก {{ $department->name }} Resin App {{ $line->name }}</h3>
        <hr>

        <div class="row justify-content-center">

            @foreach ($line->machines as $machine)
                <div class="col-sm-6 my-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5>เครื่องจักร: {{ $machine->name }}</h5>
                                </div>
                                <div class="col-auto">
                                    <a class="link-secondary" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseDetail-{{ $machine->id }}" aria-expanded="false"
                                        aria-controls="collapseDetail-{{ $machine->id }}">
                                        <i class="fa-solid fa-angle-down"></i>
                                    </a>
                                </div>

                            </div>


                            <div class="collapse" id="collapseDetail-{{ $machine->id }}">
                                <p class="card-title"><strong>รายละเอียดเพิ่มเติม:</strong>
                                    {{ $machine->detail }}</p>


                                <div id="carouselControls-{{ $machine->id }}" class="carousel slide"
                                    data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            @if ($machine->pic1)
                                                <img src="{{ url('storage/' . $machine->pic1) }}" alt="img"
                                                    class="d-block w-100" style="max-height: 500px; object-fit: contain;">
                                            @else
                                                <img src="{{ asset('icon/no-image.png') }}" alt="img"
                                                    class="d-block w-100" style="height: 500px; object-fit: contain;">
                                            @endif
                                        </div>

                                        @for ($i = 2; $i <= 3; $i++)
                                            @php
                                                $picAttribute = 'pic' . $i; // สร้างชื่อ attribute ของรูปภาพ
                                            @endphp
                                            <div class="carousel-item">
                                                @if ($machine->$picAttribute)
                                                    <img src="{{ url('storage/' . $machine->$picAttribute) }}"
                                                        alt="img" class="d-block w-100"
                                                        style="max-height: 500px ; object-fit: contain;">
                                                @else
                                                    <img src="{{ asset('icon/no-image.png') }}" alt="img"
                                                        class="d-block w-100"
                                                        style="max-height: 500px; object-fit: contain;">
                                                @endif
                                            </div>
                                        @endfor
                                    </div>


                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#carouselControls-{{ $machine->id }}" data-bs-slide="prev">

                                        <span class="carousel-control-prev-icon rounded-2" aria-hidden="true"
                                            style="background-color: #000000"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#carouselControls-{{ $machine->id }}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon rounded-2" aria-hidden="true"
                                            style="background-color: #000000"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>

                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col">

                                </div>
                                <div class="col-auto">
                                    @if (count($machine->resins) <= 0)
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#addResinModal-{{ $machine->id }}">
                                            <i class="fa-solid fa-plus"></i> เพิ่ม เรซิ่น
                                        </button>
                                        <!-- Modal -->

                                        <div class="modal fade" id="addResinModal-{{ $machine->id }}" tabindex="-1"
                                            aria-labelledby="addResinModal-{{ $machine->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addResinModal-{{ $machine->id }}">
                                                            เพิ่ม เรซิ่น {{ $machine->name }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form
                                                        action="{{ route('resins.store', [$department->id, $line->id, $machine->id]) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <label>ตำแหน่ง</label>
                                                            <input type="text" name="position" class="form-control mb-2">

                                                            <label>ลำดับการตรวจ</label>
                                                            <input type="number" name="sequence" class="form-control mb-2">

                                                            <label>Material</label>
                                                            <input type="text" name="material" class="form-control mb-2">

                                                            <label>จำนวน เรซิ่นทั้งหมด</label>
                                                            <input type="number" name="total_resin"
                                                                class="form-control mb-2">

                                                            <label>สี</label>
                                                            <input type="text" name="color" class="form-control mb-2">

                                                            <label>รายละเอียดเพิ่มเติม</label>
                                                            <input type="text" name="detail"
                                                                class="form-control mb-2">

                                                            <div class="text-center">
                                                                <img class="rounded m-2"
                                                                    id="{{ $machine->id }}.machinePicResin"
                                                                    width="200px" />
                                                            </div>

                                                            <label>รูป</label>
                                                            <div class="input-group my-3">
                                                                <input type="file" name="pic1" class="form-control"
                                                                    placeholder="image"
                                                                    data-id="{{ $machine->id }}.machinePicResin"
                                                                    onchange="loadFile(event,this)" accept="image/*">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">บันทึก</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @else
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
                                                        action="{{ route('admin.department.manage.schedulePlan.machine.schedule_plan', [$department->id, $line->id, $machine->id]) }}"
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


                                                                    @foreach ($machine->resins as $resin)
                                                                        <div class="form-check text-start">

                                                                            <input type="checkbox"
                                                                                name="scheduleResins[{{ $frequencyCheck->id }}][{{ $resin->id }}]"
                                                                                @foreach ($frequencyCheck->schedulePlans as $schedulePlan)
                                                                                         @if ($resin->id == $schedulePlan->resin_id) checked @endif @endforeach>


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
                                                                                    {{ $resin->position }}
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach

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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        <script>
            function loadFile(event, value) {
                var id = $(value).attr('data-id');
                console.log(id);

                var reader = new FileReader();

                reader.onload = function() {
                    var output = document.getElementById(id);
                    output.src = reader.result;
                };
                reader.readAsDataURL(event.target.files[0]);
            };
        </script>
    @endsection
