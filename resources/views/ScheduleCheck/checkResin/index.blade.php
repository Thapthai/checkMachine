@extends('layouts.app')

@push('styles')
    <style>
        body {
            background-color: #eefdee;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: black;
            width: 30px;
            height: 30px;
            border-radius: 5px;

        }
    </style>
@endpush


@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">

            <h5><strong>กะ : {{ $onshift }} | วันที่ {{ $shiftDate }} </strong></h5>
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

        </div>

        <div class="row">
            <div class="col">
                <a href="{{ route('machines', [$department->id, $onshift, $selected, $line->id, $shiftDate]) }}"
                    class="btn btn-warning">กลับ</a>
                <a href="{{ url('/') }}" class="btn btn-primary">หน้าแรก</a>

            </div>

        </div>
        <hr>
        <h1><strong>{{ $frequencyCheck->name }}</strong></h1>


        <h3 class="mt-4"> <strong>เครื่องจักร {{ $machine->name }} </strong></h3>

        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @for ($i = 0; $i < 10; $i++)
                    @if (!is_null($machine->{'pic' . ($i + 1)}))
                        <button type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide-to="{{ $i }}"
                            @if ($i == 0) class="active" aria-current="true" @endif
                            aria-label="Slide {{ $i + 1 }}"></button>
                    @endif
                @endfor
            </div>
            <div class="carousel-inner text-center">
                @for ($i = 0; $i < 10; $i++)
                    @if (!is_null($machine->{'pic' . ($i + 1)}))
                        <div class="carousel-item  @if ($i == 0) active @endif">
                            <img src="{{ url('storage/' . $machine->{'pic' . ($i + 1)}) }}" alt="img"
                                draggable="false" class="rounded-2" height="350px" class="mt-1">
                        </div>
                    @endif
                @endfor
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <br>



        @php

            $week = date('W', strtotime($shiftDate));
            $year = date('Y', strtotime($shiftDate));

            // วันที่เริ่มต้นของสัปดาห์ (วันจันทร์)
            $startOfWeek = new DateTime();
            $startOfWeek->setISODate($year, $week, 1); // 1 = วันจันทร์
            $startOfWeekFormatted = $startOfWeek->format('Y-m-d');

            // วันที่สิ้นสุดของสัปดาห์ (วันอาทิตย์)
            $endOfWeek = clone $startOfWeek;
            $endOfWeek->modify('+6 days');
            $endOfWeekFormatted = $endOfWeek->format('Y-m-d');

        @endphp

        <div class="row">
            @foreach ($schedulePlans->sortBy('resin.sequence') as $schedulePlan)
                @include('ScheduleCheck.checkResin.monthly.index')
                @include('ScheduleCheck.checkResin.weekly.index')
                @include('ScheduleCheck.checkResin.daily.index')
            @endforeach
        </div>

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
