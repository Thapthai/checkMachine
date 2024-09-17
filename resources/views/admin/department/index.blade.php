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
        <a href="{{ route('admin') }}" class="btn btn-secondary mb-2">กลับ</a>

        <div class="row justify-content-center">
            <h3>แผนก {{ $department->name }} Dashboard</h3>
            <hr>


            <h4>รายงาน</h4>
            <a href="{{ route('admin.department.reports', [$department->id]) }}" class="btn m-2"
                style="width: 25rem;background-color: #e7beff;">
                <div class="card-body">
                    <img src="{{ asset('icon/report.png') }}" alt="Icon" style="height:75px" class="rounded m-2">
                    <h5 class="card-title">รายงาน </h5>
                </div>
            </a>

            <a href="{{ route('admin.department.dashboard', [$department->id]) }}" class="btn m-2"
                style="width: 25rem;background-color: #ffb2b2;">
                <div class="card-body">
                    <img src="{{ asset('icon/summary.png') }}" alt="Icon" style="height:75px" class="rounded m-2">
                    <h5 class="card-title">สรุปผล</h5>
                </div>
            </a>

            <hr>
            <h4>จัดการ</h4>
            <a href="{{ route('admin.department.manage.users', [$department->id]) }}" class="btn m-2"
                style="width: 25rem;background-color: #db9ece;">
                <div class="card-body">
                    <img src="{{ asset('icon/group.png') }}" alt="Icon" style="height:75px" class="rounded m-2">
                    <h5 class="card-title">จัดการผู้ใช้งาน </h5>
                </div>
            </a>

            <a href="{{ route('admin.department.manage.resinApp', [$department->id]) }}" class="btn m-2"
                style="width: 25rem;background-color: #aae9aa;">
                <div class="card-body">
                    <img src="{{ asset('icon/resin.png') }}" alt="Icon" style="height:75px" class="rounded m-2">
                    <h5 class="card-title">จัดการระบบ ตรวจสอบเรซิ่น</h5>
                </div>
            </a>

            <a href="#" class="btn m-2" style="width: 25rem;background-color: #82beff;">
                <div class="card-body">
                    <img src="{{ asset('icon/part.png') }}" alt="Icon" style="height:75px" class="rounded m-2">
                    <h5 class="card-title">จัดการระบบ ตรวจสอบชิ้นส่วน</h5>
                </div>
            </a>

            <a href="#" class="btn m-2" style="width: 25rem;background-color: #ffe187;">
                <div class="card-body">
                    <img src="{{ asset('icon/alc.png') }}" alt="Icon" style="height:75px" class="rounded m-2">
                    <h5 class="card-title">จัดการระบบ ตรวจสอบแอลกอฮอล์ และ คลอรีน</h5>
                </div>
            </a>

        </div>
    </div>
@endsection
