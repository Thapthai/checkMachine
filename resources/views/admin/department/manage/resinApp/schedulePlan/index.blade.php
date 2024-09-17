@extends('layouts.app')

@push('styles')
    <style>
        body {
            /* background-color: #e1f5ff; */
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">

        <a href="{{ route('admin.department.manage.resinApp', [$department->id]) }}" class="btn btn-secondary mb-2">กลับ</a>

        <h3>แผนก {{ $department->name }} Resin App</h3>
        <hr>

        <div class="row justify-content-center">

            @foreach ($department->lines as $line)
                <div class="col-md-6 my-2">

                    <a href="{{ route('admin.department.manage.schedulePlan.machine', [$department->id, $line->id]) }}"
                        class="btn btn-outline-secondary w-100">
                        <div class="text-start" style="color:black">
                            <h5><strong>
                                    @if (count($line->machines) < 1)
                                        ชื่อ: {{ $line->name }} (!!! ไม่มีเครื่องจักร !!!)
                                    @else
                                        ชื่อ: {{ $line->name }}
                                    @endif
                                </strong>
                            </h5>
                            <p>รายละเอียด: {{ $line->detail }}</p>
                            <p>สถานะ: {{ $line->status }}</p>
                        </div>
                    </a>
                </div>
            @endforeach

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
