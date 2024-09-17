@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row">
                <div class="col">
                    <h4><strong>แผนก</strong></h4>
                </div>
            </div>
            <hr>

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

            @if (Auth::user()->is_admin == '1')
                <div class="row">
                    <div class="col">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">
                            เพิ่มแผนก
                        </button>
                    </div>
                </div>
            @endif

            <div class="row">

                @foreach ($departments as $department)
                    <div class="col-sm-6 my-2">
                        <div class="card">
                            {{-- <a href="#" class="text-decoration-none ms-2">จุดตรวจสอบ </a> --}}
                            <div class="card-body">
                                <h5 class="card-title"><strong>แผนก:</strong> {{ $department->name }}</h5>
                                <p class="card-text"><strong>สถานะ:</strong> {{ $department->status }}</p>
                                <p class="card-text"> <strong>รายละเอียด:</strong> {{ $department->detail }}</p>

                                <div class="btn-toolbar justify-content-between" role="toolbar"
                                    aria-label="Toolbar with button groups">
                                    <div class="btn-group" role="group" aria-label="First group">
                                        @if (Auth::user()->is_admin == '1')
                                            <form action="{{ route('departments.destroy', $department->id) }}"
                                                method="Post">
                                                <a class="btn btn-primary my-1"
                                                    href="{{ route('departments.show', $department->id) }}">รายละเอียด</a>

                                                <a class="btn btn-warning my-1"
                                                    href="{{ route('departments.edit', $department->id) }}">แก้ไข</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('Are you sure?')">ลบ</button>

                                            </form>
                                        @endif
                                    </div>
                                    <div class="input-groupm">

                                        <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton1"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            รายงาน
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li> <a href="{{ route('lines_reports', $department->id) }}"
                                                    class="dropdown-item">รายงาน เครื่องจักร</a></li>
                                            <li><a href="{{ route('alc_report', $department->id) }}"
                                                    class="dropdown-item">รายงาน
                                                    แอลกอฮอล์
                                                    และ
                                                    คลอรีน</a></li>
                                            <li><a href="{{ route('department_excel', [$department->id]) }}"
                                                    class="dropdown-item">ดาวน์โหลดข้อมูล เครื่องจักร และ เรซิ่น </a></li>

                                        </ul>

                                        <a href="{{ route('onshift.index', $department->id) }}"
                                            class="btn btn-success my-1">ตรวจสอบ
                                        </a>

                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                @endforeach
            </div>


        </div>
    </div>

    <!-- Create -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">เพิ่มแผนก</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('departments.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>ชื่อแผนก</strong>
                                <input type="text" name="name" class="form-control">

                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Status :</strong>
                                <input type="text" name="status" class="form-control">

                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>detail :</strong>
                                <input type="text" name="detail" class="form-control">

                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="subnit" class="btn btn-primary">เพิ่ม</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    {{-- for test --}}
    {{-- <div class="container mx-2">

        <a href="{{ route('test.index') }}" class="btn btn-success">Test</a>
    </div> --}}
@endsection
