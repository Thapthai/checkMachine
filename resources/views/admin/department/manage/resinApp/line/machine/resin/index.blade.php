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
        <a href="{{ route('admin.department.manage.resinApp', [$department->id]) }}" class="btn btn-secondary mb-2">จัดการ
            Resin App</a>

        <a href="{{ route('admin.department.manage.resinApp.machine', [$department->id, $line->id]) }}"
            class="btn btn-secondary mb-2">กลับ</a>

        <h3> Resin App เครื่องจักร {{ $machine->name }} </h3>
        <hr>
        <form action="{{ route('admin.department.manage.resinApp.resin', [$department->id, $line->id, $machine->id]) }}"
            method="get" enctype="multipart/form-data">
            @csrf
            <div class="input-group mb-2">
                <input type="text" name="searchResin" class="form-control" placeholder="ค้นหาชื่อ...เรซิ่น..."
                    value="{{ $searchResin }}">
                <div class="input-group-append mx-2">
                    <a href="{{ route('admin.department.manage.resinApp.resin', [$department->id, $line->id, $machine->id]) }}"
                        class="btn btn-secondary" title="คืนค่า"><i class="fa-solid fa-rotate-right"></i></a>
                </div>
                <div class="input-group-append">
                    <button type="submit" class="btn btn-secondary" title="ค้นหา"><i
                            class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </div>
        </form>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createResinModal">
            <i class="fa-solid fa-plus"></i> เพิ่มเรซิ่น
        </button>

        <!-- Modal -->
        <div class="modal fade" id="createResinModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">เพิ่มเรซิ่น</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('resins.store', [$department->id, $line->id, $machine->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <label>ตำแหน่ง</label>
                            <input type="text" name="position" class="form-control mb-2">

                            <label>ลำดับการตรวจ</label>
                            <input type="number" name="sequence" class="form-control mb-2">

                            <label>Material</label>
                            <input type="text" name="material" class="form-control mb-2">

                            <label>จำนวน เรซิ่นทั้งหมด</label>
                            <input type="number" name="total_resin" class="form-control mb-2">

                            <label>สี</label>
                            <input type="text" name="color" class="form-control mb-2">

                            <label>รายละเอียดเพิ่มเติม</label>
                            <input type="text" name="detail" class="form-control mb-2">

                            <div class="text-center">
                                <img class="rounded m-2" id="{{ $machine->id }}.machinePicResin" width="200px" />
                            </div>

                            <label>รูป</label>
                            <div class="input-group my-3">
                                <input type="file" name="pic1" class="form-control" placeholder="image"
                                    data-id="{{ $machine->id }}.machinePicResin" onchange="loadFile(event,this)"
                                    accept="image/*">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            @foreach ($resins as $resin)
                <div class="col-sm-6 my-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5>{{ $resin->sequence }}: {{ $resin->position }}</h5>
                                </div>
                                <div class="col-auto">
                                    <a class="link-secondary" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseDetail-{{ $resin->id }}" aria-expanded="false"
                                        aria-controls="collapseDetail-{{ $resin->id }}">
                                        <i class="fa-solid fa-angle-down"></i>
                                    </a>
                                </div>

                                <div class="collapse" id="collapseDetail-{{ $resin->id }}">
                                    <p class="card-title"><strong>รายละเอียดเพิ่มเติม:</strong>
                                        {{ $resin->detail }}</p>
                                    @if ($resin->pic1)
                                        <img src="{{ url('storage/' . $resin->pic1) }}" alt="img"
                                            class="d-block w-100" style="max-height: 500px; object-fit: contain;">
                                    @else
                                    @endif
                                </div>
                            </div>
                            <div class="btn-group mt-2">
                                <button class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#editResinModal-{{ $resin->id }}"><i
                                        class="fa-solid fa-pen-to-square"></i> แก้ไข</button>

                                <div class="modal fade" id="editResinModal-{{ $resin->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">แก้ไข เครื่องจักร
                                                    {{ $machine->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>

                                            <form
                                                action="{{ route('resins.update', [$department->id, $line->id, $machine->id, $resin->id]) }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <label>ตำแหน่ง</label>
                                                    <input type="text" name="position" class="form-control mb-2"
                                                        value="{{ $resin->position }}">

                                                    <label>ลำดับการตรวจ</label>
                                                    <input type="number" name="sequence" class="form-control mb-2"
                                                        value="{{ $resin->sequence }}">

                                                    <label>Material</label>
                                                    <input type="text" name="material" class="form-control mb-2"
                                                        value="{{ $resin->material }}">

                                                    <label>จำนวน เรซิ่นทั้งหมด</label>
                                                    <input type="number" name="total_resin" class="form-control mb-2"
                                                        value="{{ $resin->total_resin }}">

                                                    <label>สี</label>
                                                    <input type="text" name="color" class="form-control mb-2"
                                                        value="{{ $resin->color }}">

                                                    <label>รายละเอียดเพิ่มเติม</label>
                                                    <input type="text" name="detail" class="form-control mb-2"
                                                        value="{{ $resin->detail }}">

                                                    <div class="text-center">
                                                        <img class="rounded m-2" id="{{ $resin->id }}.machinePicResin"
                                                            width="200px" src="{{ url('storage/' . $resin->pic1) }}" />
                                                    </div>

                                                    <label>รูป</label>
                                                    <div class="input-group my-3">
                                                        <input type="file" name="pic1" class="form-control"
                                                            placeholder="image"
                                                            data-id="{{ $resin->id }}.machinePicResin"
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

                                <form
                                    action="{{ route('resins.destroy', [$department->id, $line->id, $machine->id, $resin->id]) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" onclick="return confirm('Are you sure ?')">ลบ</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endsection
