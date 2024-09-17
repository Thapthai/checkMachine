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
        <h3>Admin Dashboard</h3>
        <hr>
        <div class="row">
            <div class="col">
                <h4>เลือกแผนก ที่จะจัดการ</h4>

            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createNewDepartmentModal">
                    <i class="fa-solid fa-plus"></i> เพิ่ม แผนก
                </button>
                <!-- Modal -->
                <div class="modal fade" id="createNewDepartmentModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">เพิ่มแผนก</h5>

                                <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <form action="{{ route('department.store') }}" method="post"
                                enctype="application/x-www-form-urlencoded">
                                @csrf

                                <div class="modal-body">
                                    <label>ชื่อ</label>
                                    <input type="text" name="name" class="form-control">

                                    <label>รายละเอียด</label>
                                    <textarea name="detail" rows="3" class="form-control mb-2"></textarea>

                                    <label>สถานะ</label>
                                    <select name="status" class="form-select mb-2">
                                        <option value="Active">
                                            Active</option>
                                        <option value="Inactive">
                                            Inactive</option>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">เพิ่มแผนก</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="row justify-content-center">
            @foreach ($departments as $department)
                <div class="card m-2" style="width: 24rem;">
                    <div class="card-body" style=" background-color: #ffffff">
                        <div class="text-start">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title">แผนก: {{ $department->name }}</h5>
                                </div>
                                <div class="col-auto">
                                    <form action="{{ route('department.destroy', $department->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('ต้องการลบ ?')">
                                            <i class="fa-solid fa-trash"></i> ลบ</button>
                                    </form>
                                </div>
                            </div>
                            <p>รายละเอียด: {{ $department->detail }}</p>

                        </div>
                        <div class="text-end">

                            <button type="button" class="btn btn-warning" data-toggle="modal"
                                data-target="#editModal-{{ $department->id }}">
                                <i class="fa-solid fa-pen-to-square"></i> แก้ไข
                            </button>

                            <a href="{{ route('admin.department', [$department->id]) }}" class="btn btn-primary">เลือก</a>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="editModal-{{ $department->id }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">แก้ไขข้อมูล แผนก
                                            {{ $department->name }}</h5>

                                        <button type="button" class="btn btn-close" data-dismiss="modal"
                                            aria-label="Close">
                                        </button>
                                    </div>
                                    <form action="{{ route('department.update', $department->id) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <label>ชื่อ</label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ $department->name }}" required>

                                            <label>รายละเอียด</label>
                                            <textarea name="detail" rows="3" class="form-control mb-2">{{ $department->detail }}</textarea>

                                            <label>สถานะ</label>
                                            <select name="status" class="form-select mb-2" required>
                                                <option value="Active" @if ($department->status == 'Active') selected @endif>
                                                    Active</option>
                                                <option value="Inactive" @if ($department->status == 'Inactive') selected @endif>
                                                    Inactive</option>
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach


        </div>
    </div>
@endsection
