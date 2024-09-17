@extends('layouts.app')

@push('styles')
    <style>
        body {
            /* background-color: #e1f5ff; */
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <a href="{{ route('admin.department.manage.resinApp', [$department->id]) }}" class="btn btn-secondary mb-2">จัดการ Resin App</a>

        <a href="{{ route('admin.department.manage.resinApp.line', [$department->id, $line->id]) }}" class="btn btn-secondary mb-2">กลับ</a>


        <h3> Resin App ไลน์ {{ $line->name }} </h3>
        <hr>
        <form action="{{ route('admin.department.manage.resinApp.machine', [$department->id, $line->id]) }}" method="get"
            enctype="multipart/form-data">
            @csrf
            <div class="input-group mb-2">
                <input type="text" name="searchMachine" class="form-control" placeholder="ค้นหาชื่อ...เครื่องจักร..."
                    value="{{ $searchMachine }}">
                <div class="input-group-append mx-2">
                    <a href="{{ route('admin.department.manage.resinApp.machine', [$department->id, $line->id]) }}"
                        class="btn btn-secondary" title="คืนค่า"><i class="fa-solid fa-rotate-right"></i></a>
                </div>
                <div class="input-group-append">
                    <button type="submit" class="btn btn-secondary" title="ค้นหา"><i
                            class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </div>
        </form>


        <!-- Button trigger modal -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createMachineModal">
            <i class="fa-solid fa-plus"></i> เพิ่มเครื่องจักร
        </button>

        <!-- Modal -->
        <div class="modal fade" id="createMachineModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">เพิ่มเครื่องจักร</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('machines.store', [$department->id, $line->id]) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>ชื่่อเครื่องจักร :</strong>
                                    <input type="text" name="name" class="form-control">

                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>สถานะ :</strong>
                                    <input type="text" name="status" class="form-control">

                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>ลำดับการตรวจ :</strong>
                                    <input type="number" name="sequence" class="form-control">

                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>ข้อมูล :</strong>
                                    <input type="text" name="detail" class="form-control">

                                </div>
                            </div>
                            <hr>
                            @for ($i = 1; $i <= 10; $i++)
                                <strong>รูปที่ {{ $i }}:</strong>
                                <div class="text-center">
                                    <img class="rounded m-2" id="{{ $line->id }}.machinePic.{{ $i }}"
                                        width="200px" />
                                </div>

                                <div class="input-group my-3">
                                    <input type="file" name="pic.{{ $i }}" class="form-control"
                                        placeholder="image" data-id="{{ $line->id }}.machinePic.{{ $i }}"
                                        onchange="loadFile(event,this)" accept="image/*">
                                </div>
                            @endfor

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">บันทึก</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="row justify-content-center">
            @foreach ($machines as $machine)
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
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editLineModal-{{ $machine->id }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            แก้ไข
                                        </button>
                                        <div class="modal fade" id="editLineModal-{{ $machine->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">แก้ไข เครื่องจักร
                                                            {{ $machine->name }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form
                                                        action="{{ route('machines.update', [$department->id, $line->id, $machine->id]) }}"
                                                        method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                                <div class="form-group">
                                                                    <strong>ชื่่อเครื่องจักร :</strong>
                                                                    <input type="text" name="name"
                                                                        class="form-control"
                                                                        value="{{ $machine->name }}">

                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                                <div class="form-group">
                                                                    <strong>สถานะ :</strong>
                                                                    <select name="status" class="form-select">
                                                                        <option value="Active"
                                                                            @if ($machine->status == 'Active') selected @endif>
                                                                            Active
                                                                        </option>
                                                                        <option value="Inactive"
                                                                            @if ($machine->status == 'Inactive') selected @endif>
                                                                            Inactive</option>

                                                                    </select>


                                                                </div>
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                                <div class="form-group">
                                                                    <strong>ลำดับการตรวจ :</strong>
                                                                    <input type="number" name="sequence"
                                                                        class="form-control"
                                                                        value="{{ $machine->sequence }}">

                                                                </div>
                                                            </div>

                                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                                <div class="form-group">
                                                                    <strong>ข้อมูล :</strong>
                                                                    <input type="text" name="detail"
                                                                        class="form-control"
                                                                        value="{{ $machine->detail }}">

                                                                </div>
                                                            </div>
                                                            <hr>
                                                            @for ($i = 1; $i <= 10; $i++)
                                                                @php
                                                                    $picAttributeEdit = 'pic' . $i; // สร้างชื่อ attribute ของรูปภาพ
                                                                @endphp
                                                                <strong>รูปที่ {{ $i }}:</strong>
                                                                <div class="text-center">
                                                                    <img class="rounded m-2"
                                                                        id="{{ $line->id }}.machinePicEdit.{{ $i }}"
                                                                        width="200px"
                                                                        @if ($machine->$picAttributeEdit) src="{{ url('storage/' . $machine->$picAttributeEdit) }}" @endif />

                                                                </div>

                                                                <div class="input-group my-3">

                                                                    <input type="file" name="{{ $picAttributeEdit }}"
                                                                        class="form-control" placeholder="image"
                                                                        data-id="{{ $line->id }}.machinePicEdit.{{ $i }}"
                                                                        onchange="loadFile(event,this)" accept="image/*">
                                                                </div>
                                                            @endfor

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button type="submit"
                                                                    class="btn btn-success">บันทึก</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <form
                                            action="{{ route('machines.destroy', [$department->id, $line->id, $machine->id]) }}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger"
                                                onclick="return confirm('Are you sure ?')">ลบ</button>
                                        </form>
                                    </div>
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
                                                            <input type="text" name="position"
                                                                class="form-control mb-2">

                                                            <label>ลำดับการตรวจ</label>
                                                            <input type="number" name="sequence"
                                                                class="form-control mb-2">

                                                            <label>Material</label>
                                                            <input type="text" name="material"
                                                                class="form-control mb-2">

                                                            <label>จำนวน เรซิ่นทั้งหมด</label>
                                                            <input type="number" name="total_resin"
                                                                class="form-control mb-2">

                                                            <label>สี</label>
                                                            <input type="text" name="color"
                                                                class="form-control mb-2">

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
                                        <a href="{{ route('admin.department.manage.resinApp.resin', [$department->id, $line->id, $machine->id]) }}"
                                            class="btn btn-secondary">เรซิ่น ในเครื่องจักร</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
