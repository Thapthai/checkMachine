@extends('layouts.app')
@push('styles')
    <style>
        body {
            /* background-color: #eefdee; */
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
    <div class="container">
        <div class="row justify-content-center">

            <h3>ระบบ Approve </h3>
            <hr>

            <h4> {{ $scheduleRecord->schedule_plan->frequency_check->name }}</h4>

            <h3>รูปชิ้นส่วน เรซิ่น</h3>
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    @for ($i = 0; $i < 10; $i++)
                        @if (!is_null($resin->machine->{'pic' . ($i + 1)}))
                            <button type="button" data-bs-target="#carouselExampleIndicators"
                                data-bs-slide-to="{{ $i }}"
                                @if ($i == 0) class="active" aria-current="true" @endif
                                aria-label="Slide {{ $i + 1 }}"></button>
                        @endif
                    @endfor
                </div>
                <div class="carousel-inner text-center">
                    @for ($i = 0; $i < 10; $i++)
                        @if (!is_null($resin->machine->{'pic' . ($i + 1)}))
                            <div class="carousel-item  @if ($i == 0) active @endif">
                                <img src="{{ url('storage/' . $resin->machine->{'pic' . ($i + 1)}) }}" alt="img"
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
            <br>

            <table class="table table-bordered mt-2">
                <tr>
                    <th colspan="4" class="text-center">เครื่องจักร {{ $resin->machine->name }}</th>
                </tr>
                <tr>
                    <th colspan="4" class="text-center">
                        ตำแหน่งเรซิ่น {{ $resin->position }}
                    </th>
                </tr>
                <tr>
                    <th>รายละเอียด</th>
                    <th>จำนวน </th>
                    <th>วัสดุ</th>
                    <th>สี</th>
                </tr>
                <tr>
                    <td>{{ $resin->detail ?? '-' }}</td>
                    <td>{{ $resin->total_resin ?? '-' }}</td>
                    <td>{{ $resin->material ?? '-' }}</td>
                    <td>{{ $resin->color ?? '-' }}</td>
                </tr>
            </table>

            <br>

            @if ($scheduleRecord->approve)
                <div class="alert alert-success">
                    <h3 class=" text-center">Approve เรียบร้อย โดย {{ $scheduleRecord->approve->user_approve }}</h3>
                </div>
            @else
                @if ($scheduleRecord->pic1 || $scheduleRecord->pic2 || $scheduleRecord->pic3)
                    <div id="carouselResinRecord" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            @for ($i = 0; $i < 10; $i++)
                                @if (!is_null($scheduleRecord->{'pic' . ($i + 1)}))
                                    <button type="button" data-bs-target="#carouselResinRecord"
                                        data-bs-slide-to="{{ $i }}"
                                        @if ($i == 0) class="active" aria-current="true" @endif
                                        aria-label="Slide {{ $i + 1 }}"></button>
                                @endif
                            @endfor
                        </div>
                        <div class="carousel-inner text-center">
                            @for ($i = 0; $i < 10; $i++)
                                @if (!is_null($scheduleRecord->{'pic' . ($i + 1)}))
                                    <div class="carousel-item  @if ($i == 0) active @endif">
                                        <img src="{{ url('storage/' . $scheduleRecord->{'pic' . ($i + 1)}) }}"
                                            alt="img" draggable="false" class="rounded-2" height="350px"
                                            class="mt-1">
                                    </div>
                                @endif
                            @endfor
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselResinRecord"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselResinRecord"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <hr>
                @endif

                <h4>รายละเอียดการตรวจ</h4>

                <div class="row">
                    <div class="col">

                        @if ($scheduleRecord->clean == 'NOT')
                            <h5>ความสะอาด: </h5>
                            <h5><strong style="color:#aa3c34">ไม่ผ่าน</strong></h5>
                        @else
                            <h5>ความสะอาด: </h5>
                            <h5><strong style="color:#34aa34">ผ่าน</strong></h5>
                        @endif
                    </div>
                    <div class="col">
                        @if ($scheduleRecord->complete == 'NOT')
                            <h5>ความสมบูนณ์:</h5>
                            <h5> <strong style="color:#aa3c34">ไม่ผ่าน</strong></h5>
                        @else
                            <h5>ความสมบูนณ์:</h5>
                            <h5> <strong style="color:#34aa34">ผ่าน</strong></h5>
                        @endif

                    </div>
                </div>


                <hr>

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#approveModal">
                    Approve
                </button>

                <!-- Modal -->
                <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('approve.store', [$line_user->getName(), $scheduleRecord->id]) }}"
                                method="POST" enctype="multipart/form-data">

                                {{ csrf_field() }}
                                <div class="modal-header">
                                    <h5 class="modal-title">Approve โดย {{ $line_user->getName() }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <select name="approve_status" class="form-select">
                                        @foreach ($approve_status as $value => $approve_status)
                                            <option value="{{ $approve_status }}">{{ $approve_status }}</option>
                                        @endforeach
                                    </select>
                                    <label>รายละเอียดการตรวจ</label>
                                    <input type="text" class="form-control" name="detail">

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Approve</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            @endif



        </div>
    </div>
@endsection
