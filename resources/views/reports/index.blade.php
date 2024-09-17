@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row">
                <div class="col">
                    <h4><strong>รายงานเครื่องจักร แผนก {{ $department->name }} | ไลน์ {{ $line->id }}</strong></h4>
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

            <div class="row">
                <div class="pull-right mb-2">
                    <a href="{{ route('lines_reports', [$department->id]) }}" class="btn btn-warning">กลับ</a>
                    <a href="{{ url('/') }}" class="btn btn-primary">หน้าแรก</a>
                </div>

                <form action="{{ route('reports.index', [$department->id, $line->id]) }}" method="GET">
                    @csrf
                    <div class="input-group my-3">
                        <input type="search" name="search" class="form-control rounded" placeholder="ค้นหา ... "
                            aria-label="Search" value="{{ request('search') }}" />
                        <button type="submit" class="btn btn-outline-primary">ค้นหา</button>
                    </div>
                </form>
                <div class="pull-right mb-2">
                    <div class="row">
                        <div class="col">
                            <h5><strong>รายงานทั้งหมด</strong></h5>
                            <form action="{{ route('line_report', [$department->id, $line->id]) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row my-3">
                                    <div class="col">
                                        <label>ตั้งแต่</label>
                                        <input type="date" name="since_date" class="form-control rounded"
                                            @if (!empty($resin_record_date)) value="{{ date('Y-m-d', strtotime('-5 day', strtotime($resin_record_date))) }}" @endif
                                            required />
                                    </div>
                                    <div class="col">
                                        <label>ถึง</label>
                                        <input type="date" name="to_date" class="form-control rounded"
                                            @if (!empty($resin_record_date)) value="{{ date('Y-m-d', strtotime($resin_record_date)) }}" @endif
                                            required />
                                    </div>
                                    <div class="col col-2">
                                        <label></label>
                                        <button type="submit" class="btn btn-success rounded w-100">เลือก</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col">
                            <h5><strong>รายงานเรชิ่นที่ไม่สมบูรณ์ ทั้งหมด</strong></h5>
                            <form action="{{ route('line_incomplete_resin_report', [$department->id, $line->id]) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row my-3">
                                    <div class="col">
                                        <label>ตั้งแต่</label>
                                        <input type="date" name="since_date" class="form-control rounded"
                                            @if (!empty($resin_record_incomplete_date)) value="{{ date('Y-m-d', strtotime('-5 day', strtotime($resin_record_incomplete_date))) }}" @endif
                                            required />
                                    </div>
                                    <div class="col">
                                        <label>ถึง</label>
                                        <input type="date" name="to_date" class="form-control rounded"
                                            @if (!empty($resin_record_incomplete_date)) value="{{ date('Y-m-d', strtotime($resin_record_incomplete_date)) }}" @endif
                                            required />
                                    </div>
                                    <div class="col col-2">
                                        <label></label>
                                        <button type="submit" class="btn btn-warning rounded w-100">เลือก</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @foreach ($machines as $machine)
                    <div class="col-sm-6 my-2">
                        <div class="card">
                            <div class="card-body bg-light">
                                <h5 class="card-title"><strong>{{ $machine->sequence }}. เครื่องจักร:</strong>
                                    {{ $machine->name }}</h5>
                                <hr>
                                <p class="card-text"><strong>สถานะ:</strong> {{ $machine->status }}</p>
                                <p class="card-text"> <strong>รายละเอียด:</strong> {{ $machine->detail }}</p>
                                <p class="card-text"> <strong>จำนวน เรซิน:</strong> {{ count($machine->resins) }} ชิ้น</p>
                                <p class="card-text"> <strong>จำนวน ชิ้นส่วน:</strong> {{ count($machine->parts) }} ชิ้น
                                </p>

                                <table class="table table-borderless ">
                                    <tr>
                                        <th>เรซิน</th>
                                        <th>ชิ้นส่วน</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="{{ route('resins_reports', [$department->id, $line->id, $machine->id]) }}"
                                                class="btn btn-success w-100">เรซิน ( {{ count($machine->resins) }} ชิ้น
                                                )</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('parts_reports', [$department->id, $line->id, $machine->id]) }}"
                                                class="btn btn-primary w-100">ชิ้นส่วน ( {{ count($machine->parts) }} ชิ้น
                                                )</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="{{ route('incomplete_resins', [$department->id, $line->id, $machine->id]) }}"
                                                class="btn btn-warning w-100"> เรซิ่นไม่สมบูรณ์</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('incomplete_parts', [$department->id, $line->id, $machine->id]) }}"
                                                class="btn btn-warning w-100">ชิ้นส่วนไม่สมบูรณ์</a>
                                        </td>

                                    </tr>

                                </table>

                                <a href="{{ route('fixed_report', [$department->id, $line->id, $machine->id]) }}"
                                    class="btn btn-secondary w-100">รายงานการซ่อม</a>
                            </div>
                        </div>
                    </div>
                @endforeach
                {!! $machines->links() !!}
            </div>
        </div>
    </div>
@endsection
