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

        <a href="{{ route('admin.department.manage.resinApp', [$department->id]) }}" class="btn btn-secondary mb-2">กลับ</a>

        <h3>แผนก {{ $department->name }} Resin App</h3>
        <hr>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createLineModal">
            <i class="fa-solid fa-plus"></i> เพิ่มไลน์
        </button>

        <!-- Modal -->
        <div class="modal fade" id="createLineModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">เพิ่มไลน์</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('line.store', ['department' => $department->id]) }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <label>ชื่อ</label>
                            <input type="text" name="name" class="form-control">

                            <label>รายละเอียด</label>
                            <input type="text" name="detail" class="form-control">

                            <label>สถานะ</label>
                            <select name="status" class="form-select">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>

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

            @foreach ($lines as $line)
                @php
                    $colorIndex = ($line->id % 3) + 1;
                    $color = $colorSet[$colorIndex];
                    $Isempty = '';
                    if (count($line->machines) < 1) {
                        $color = '#ffadad';
                    } else {
                    }
                @endphp


                <div class="col-md-6 my-2">
                    <div class="card" style="background-color: {{ $color }};">
                        <div class="card-body">
                            <div class="text-start">

                                @if (count($line->machines) < 1)
                                    ชื่อ: {{ $line->name }} (!!! ไม่มีเครื่องจักร !!!)
                                @else
                                    ชื่อ: {{ $line->name }}
                                @endif

                                <p>รายละเอียด: {{ $line->detail }}</p>
                                <p>สถานะ: {{ $line->status }}</p>
                                <div class="row">
                                    <div class="col">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#editLineModal-{{ $line->id }}">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                                แก้ไข
                                            </button>
                                            <div class="modal fade" id="editLineModal-{{ $line->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">แก้ไขไลน์
                                                                {{ $line->name }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <form
                                                            action="{{ route('line.update', ['department' => $department->id, 'line' => $line->id]) }}"
                                                            method="post">
                                                            @method('PUT')
                                                            @csrf
                                                            <div class="modal-body">
                                                                <label>ชื่อ</label>
                                                                <input type="text" name="name" class="form-control"
                                                                    value="{{ $line->name }}">

                                                                <label>รายละเอียด</label>
                                                                <input type="text" name="detail" class="form-control"
                                                                    value="{{ $line->detail }}">

                                                                <label>สถานะ</label>
                                                                <select name="status" class="form-select">
                                                                    <option value="Active"
                                                                        @if ($line->status == 'Active') selected @endif>
                                                                        Active
                                                                    </option>
                                                                    <option value="Inactive"
                                                                        @if ($line->status == 'Inactive') selected @endif>
                                                                        Inactive</option>
                                                                </select>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">บันทึก</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <form
                                                action="{{ route('line.destroy', ['department' => $department->id, 'line' => $line->id]) }}"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger"
                                                    onclick="return confirm('Are you sure ?')">ลบ</button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="col-auto">
                                        @if (count($line->machines) > 0)
                                            <a href="{{ route('admin.department.manage.resinApp.machine', ['department' => $department->id, 'line' => $line->id]) }}"
                                                class="btn btn-secondary">
                                                เครื่องจักรในไลน์
                                            </a>
                                        @else
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#appMachineModal-{{ $line->id }}"
                                                title="เพิ่มเครื่องจักร">
                                                <i class="fa-solid fa-plus"></i> เพิ่มเครื่องจักร
                                            </button>
                                        @endif
                                    </div>
                                </div>

                            </div>

                            <div class="text-start">

                                <!-- Add Machine Modal -->

                                <!-- Modal -->
                                <div class="modal fade" id="appMachineModal-{{ $line->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">เพิ่มเครื่องจักร
                                                    {{ $line->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>

                                            <form action="{{ route('machines.store', [$department->id, $line->id]) }}"
                                                method="post" enctype="multipart/form-data">
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
                                                            <select name="status" class="form-select">
                                                                <option value="Active">
                                                                    Active
                                                                </option>
                                                                <option value="Inactive">
                                                                    Inactive</option>

                                                            </select>

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
                                                            <img class="rounded m-2"
                                                                id="{{ $line->id }}.machinePic.{{ $i }}"
                                                                width="200px" />
                                                        </div>

                                                        <div class="input-group my-3">
                                                            <input type="file" name="pic.{{ $i }}"
                                                                class="form-control" placeholder="image"
                                                                data-id="{{ $line->id }}.machinePic.{{ $i }}"
                                                                onchange="loadFile(event,this)" accept="image/*">
                                                        </div>
                                                    @endfor

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-success">บันทึก</button>
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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
