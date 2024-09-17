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

            <form action="{{ route('machines_list', [$department->id, $onshift, $selected, $line->id, $shiftDate]) }}"
                method="GET">
                @csrf
                <div class="input-group my-3">
                    <input type="search" name="search" class="form-control rounded" placeholder="Search"
                        aria-label="Search" value="{{ request('search') }}" />
                    <button type="submit" class="btn btn-outline-primary">ค้นหา</button>
                </div>
            </form>
            <div class="row">
                <div class="col">
                    <a href="{{ route('lines', [$department->id, $onshift, $selected, $shiftDate]) }}"
                        class="btn btn-warning">กลับ</a>
                    <a href="{{ url('/') }}" class="btn btn-primary">หน้าแรก</a>
                </div>

                <div class="col-auto">
                    <div class="row">
                        <div class="col">
                            @if (Auth::user()->is_admin == '1')
                                <div class="pull-right mb-2">
                                    <button type="button" class="btn btn-primary my-2 mt-2" style="width: 300px"
                                        data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                        เพิ่มเครื่องจักรที่จะตรวจสอบ
                                    </button>
                                </div>
                            @endif
                        </div>
                        <div class="col">
                            <a href="{{ route('department_excel', [$department->id]) }}"
                                class="btn btn-success my-2 mt-2">ดาวน์โหลดข้อมูล Department </a>
                        </div>
                    </div>
                </div>
            </div>
            @include('machines.create')

        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>name</th>
                    <th>รายละเอียด</th>
                    <th>สถานะ</th>
                    <th>ลำดับ</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($machines as $machine)
                    <tr>
                        <td>{{ $machine->name }}</td>
                        <td>{{ $machine->detail }}</td>
                        <td>{{ $machine->status }}</td>
                        <td>{{ $machine->sequence }}</td>
                        <td>
                            @if (Auth::user()->is_admin == '1')
                                <form
                                    action="{{ route('machines.destroy', [$department->id, $onshift, $selected, $line->id, $shiftDate, $machine->id]) }}"
                                    method="Post">
                                    @csrf
                                    @method('DELETE')
                                    <div class="row">
                                        <div class="col">
                                            <a class="btn btn-warning w-100"
                                                href="{{ route('machines.edit', [$department->id, $onshift, $selected, $line->id, $shiftDate, $machine->id]) }}">
                                                แก้ไข</a>
                                        </div>
                                        <div class="col">
                                            <button type="submit" class="btn btn-danger w-100"
                                                onclick="return confirm('Are you sure?')">ลบ</button>

                                        </div>
                                    </div>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
        {{ $machines->links() }}
    </div>
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
