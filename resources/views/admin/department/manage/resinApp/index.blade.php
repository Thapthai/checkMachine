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
        <a href="{{ route('admin.department', [$department->id]) }}" class="btn btn-secondary mb-2">กลับ</a>


        <div class="row justify-content-center">
            <h3>แผนก {{ $department->name }} Resin App</h3>
            <hr>

            <a href="{{ route('admin.department.manage.schedulePlan', $department->id) }}" class="btn m-2"
                style="width: 25rem;background-color: #b2caff;">
                <div class="card-body">
                    <img src="{{ asset('icon/calendar.png') }}" alt="Icon" style="height:75px" class="rounded m-2">
                    <h5 class="card-title">วางแผน Schedule</h5>
                </div>
            </a>
            <a href="{{ route('admin.department.manage.resinApp.line', $department->id) }}" class="btn m-2"
                style="width: 25rem;background-color: #ffb2b2;">
                <div class="card-body">
                    <img src="{{ asset('icon/summary.png') }}" alt="Icon" style="height:75px" class="rounded m-2">
                    <h5 class="card-title">จัดการ เครื่องจักร และ เรซิ่น</h5>
                </div>
            </a>

        </div>
    </div>
@endsection
