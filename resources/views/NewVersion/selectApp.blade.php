@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row">
                <div class="col">
                    <h4><strong>Main App</strong></h4>
                </div>
            </div>
            <hr>

            @foreach ($departments as $department)
                <h4><strong>แผนก :</strong> {{ $department->name }}</h4>

                <a href="{{ route('new.appSelect', [$department->id, 'resin']) }}" class="btn m-2"
                    style="width: 24rem; background-color: #157347;">
                    <div class="card-body">
                        <img src="{{ asset('icon/resin.png') }}" alt="Icon" style="width:75px" class="rounded m-2">
                        <h5 class="card-title">ตรวจสอบ เรซิ่น</h5>
                    </div>
                </a>
                <a href="{{ route('new.appSelect', [$department->id, 'part']) }}" class="btn m-2"
                    style="width: 24rem; background-color: #007bff;">
                    <div class="card-body">
                        <img src="{{ asset('icon/part.png') }}" alt="Icon" style="width:75px" class="rounded m-2">
                        <h5 class="card-title">ตรวจสอบ ชิ้นส่วน</h5>
                    </div>
                </a>
                <a href="{{ route('new.appSelect', [$department->id, 'alc']) }}" class="btn m-2"
                    style="width: 24rem; background-color: #ffc107;">
                    <div class="card-body">
                        <img src="{{ asset('icon/alc.png') }}" alt="Icon" style="width:75px" class="rounded m-2">
                        <h5 class="card-title">ตรวจสอบ แอลกอฮอล์ และ คลอรีน</h5>
                    </div>
                </a>

                <hr>
            @endforeach

        </div>

    </div>
@endsection
