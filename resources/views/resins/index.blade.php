@extends('layouts.app')

@push('styles')
    <style>
        body {
            background-color: #eefdee;
        }

        div[id^="business"]:not(:target) {
            display: none;
        }

        #panel,
        #flip {
            padding: 5px;
            text-align: center;
            background-color: #e5eecc;
            border: solid 1px #c3c3c3;
        }

        #panel {
            padding: 50px;
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
                width: 300px;
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
    <div class="container-fluid">
        <h4><strong>
                @if ($check_in == 'before')
                    ตรวจสอบชิ้นส่วน Resins : ก่อนการใช้งาน
                @endif
                @if ($check_in == 'after')
                    ตรวจสอบชิ้นส่วน Resins : หลังการใช้งาน
                @endif
            </strong></h4>
        <h4><strong>

                @if ($onshift == 'b')
                    กะ B
                @endif
                @if ($onshift == 'c')
                    กะ C
                @endif | ไลน์ผลิต: {{ $line_name }} | แผนก:
                {{ $department_name }}
            </strong></h4>
        <hr>

        <div class="row">
            <div class="col-lg-12 margin-tb">

                <div class="pull-right mb-2">
                    <div class="pull-right">
                        <form action="{{ route('machines', [$department_id, $onshift, $selected, $line_id, $shiftDate]) }}"
                            method="GET">
                            @csrf
                            <button type="submit" class="btn btn-warning">กลับ</button>
                            <button type="submit" class="btn btn-success">เครื่องจักรทั้งหมด</button>
                            <a href="{{ url('/') }}" class="btn btn-primary">หน้าแรก</a>
                        </form>
                    </div>
                </div>
                <br>
                <h2>ชิ้นส่วนของเครื่องจักร : {{ $machine_name }} |
                    <strong>
                        @if ($check_in == 'before')
                            บันทึก ก่อนการใช้งาน
                        @endif

                        @if ($check_in == 'after')
                            บันทึก หลังการใช้งาน
                        @endif
                    </strong>

                </h2>
                @if (Auth::user()->is_admin == '1')
                    <button type="button" class="btn btn-primary my-2 mt-2" style="width: 300px" data-bs-toggle="modal"
                        data-bs-target="#staticBackdrop">
                        เพิ่มชิ้นส่วนเรซิน
                    </button>
                    <br>
                @endif

            </div>
        </div>
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
            <br>
            <h5><strong>เลือกวัน </strong></h5>
            <form
                action="{{ route('resins.index', [$department_id, $onshift, $selected, $line_id, $machine_id, $check_in]) }}"
                method="GET">
                @csrf
                <div class="input-group my-3">
                    <input type="text" name="shiftDate" value="{{ $shiftDate }}" hidden>
                    <input type="date" class="form-control rounded" name="search" />
                    <button type="submit" class="btn btn-outline-primary">เลือกวัน</button>
                </div>
            </form>

            <h5>วัน {{ $search_date }}</h5>
            <hr>
        @endif
        @include('machines.img_slide')
        <hr>
        <br>
        <div class="row">
            @include('resins.toCheck')
            {{-- {!! $resins->links() !!} --}}
        </div>
        @if (Auth::user()->is_admin == '1')
            @include('resins.checked')
        @endif

    </div>

    @include('resins.create')
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
    $(document).ready(function() {
        $("#flip").click(function() {
            $("#panel").slideToggle("slow");
        });
    });
</script>
