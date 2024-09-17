@extends('layouts.app')

@push('styles')
    <style>
        body {
            background-color: #e1f5ff;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
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

        <h1>หน้าทดสอบ</h1>
        {{ $user->id }}
    @endsection
