@extends('layouts.app')



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

        </div>

        <div class="d-flex flex-wrap">
            @foreach ($frequencyChecks as $frequencyCheck)
                <div class="card m-2" style="flex: 1 0 21%; min-width: 200px;">
                    <a href="{{ route('schedule_plan_check', [$department->id, $onshift, $selected, $line->id, $machine->id, $shiftDate, $frequencyCheck->id]) }}"
                        class="btn btn-primary">{{ $frequencyCheck->name }}</a>
                </div>
            @endforeach
        </div>

    </div>
@endsection
