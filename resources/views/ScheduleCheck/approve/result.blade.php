@extends('layouts.app')


@section('content')
    <div class="container">

        <div class="alert alert-success">
            <h3 class=" text-center"><strong>{{ $message }}</strong></h3>
            <hr>

            <h3>ผลการ Approve: {{ $approve->status }}</h3>
            <h3>รายละเอียด: {{ $approve->detail }} </h3>

            <h3>โดย {{ $approve->user_approve }} </h3>

        </div>
    </div>
@endsection
