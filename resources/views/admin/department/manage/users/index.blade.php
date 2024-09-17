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
            <h3>จัดการผู้ใช้งาน {{ $department->name }}</h3>
            <hr>

            <div class="row">
                <div class="col">
                    <h5>ผู้ใช้งาน</h5>
                </div>

                <div class="col-auto">

                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addUserModal">
                        <i class="fa-solid fa-user-plus"></i> เพิ่ม ผู้ใช้งาน
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="addUserModal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">เพิ่ม ผู้ใช้งาน</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <form action="{{ route('admin.department.manage.addUsers', $department->id) }}"
                                    method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <label>ชื่อ</label>
                                        <input type="text" name="name" class="form-control mb-2" required>

                                        <label>Username</label>
                                        <input type="text" name="username" class="form-control mb-2" required>

                                        <label>E-Mail</label>
                                        <input type="email" name="email" class="form-control mb-2" required>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success">เพิ่ม ผู้ใช้งาน</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ชื่อ</th>
                            <th>Username</th>
                            <th>E-Mail</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>

                                    <!-- Modal -->
                                    <div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">แก้ไข ผู้ใช้งาน {{ $user->name }}</h5>
                                                    <button type="button" class="btn-close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    </button>
                                                </div>
                                                <form
                                                    action="{{ route('admin.department.manage.editUsers', [$department->id, $user->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="name">ชื่อ</label>
                                                            <input type="text" name="name" class="form-control mb-2"
                                                                value="{{ old('name', $user->name) }}" required>
                                                            @error('name')
                                                                <div class="alert alert-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="username">ชื่อผู้ใช้</label>
                                                            <input type="text" name="username" class="form-control mb-2"
                                                                value="{{ old('username', $user->username) }}" required>
                                                            @error('username')
                                                                <div class="alert alert-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="email">อีเมล</label>
                                                            <input type="email" name="email" class="form-control mb-2"
                                                                value="{{ old('email', $user->email) }}" required>
                                                            @error('email')
                                                                <div class="alert alert-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit"
                                                            class="btn btn-success">บันทึกการเปลี่ยนแปลง</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>




                                    <form
                                        action="{{ route('admin.department.manage.deleteUser', [$department->id, $user->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="btn-group" role="group" aria-label="Basic example">

                                            <button type="button" class="btn btn-warning" data-toggle="modal"
                                                data-target="#editUserModal-{{ $user->id }}">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                                แก้ไข
                                            </button>

                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('ต้องการลบ ?')" onsubmit="">
                                                <i class="fa-solid fa-trash"></i> ลบ</button>
                                        </div>


                                    </form>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $users->links() }}


        </div>
    </div>
@endsection
