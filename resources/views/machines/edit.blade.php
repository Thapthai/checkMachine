@extends('layouts.app')
@push('styles')
    <style>
    </style>
@endpush


@section('content')
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">

                <div class="pull-right">
                    <div class="pull-right">
                        <a href="{{ route('machines.index', [$department->id, $onshift, $selected, $line->id, $shiftDate]) }}"
                            class="btn btn-warning">กลับ</a>
                        <a class="btn btn-primary"
                            href="{{ route('machines.index', [$department->id, $onshift, $selected, $line->id, $shiftDate]) }}">เครื่องจักรทั้งหมด</a>
                    </div>
                </div>
                <hr>
                <div class="pull-left mt-2">
                    <h2>แก้ไข เครื่องจักร</h2>
                </div>

            </div>
        </div>
        @if (session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif
        <form
            action="{{ route('machines.update', [$department->id, $onshift, $selected, $line->id, $shiftDate, $machine->id]) }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>ชื่่อเครื่องจักร:</strong>
                    <input type="text" name="name" class="form-control" value="{{ $machine->name }}">

                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>สถานะ :</strong>

                    <select name="status" class="form-select">
                        <option value="Active" @if ($machine->status == 'Active') selected @endif>Active</option>
                        <option value="Active" @if ($machine->status == 'Inactive') selected @endif>Inactive</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>ลำดับการตรวจ :</strong>
                    <input type="number" name="sequence" class="form-control" value="{{ $machine->sequence }}">

                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>ข้อมูล :</strong>
                    <input type="text" name="detail" class="form-control" value="{{ $machine->detail }}">

                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <strong>pic 1:</strong>

                        @if (!is_null($machine->pic1))
                            <a href="{{ route('machines_picDelete', [$department->id, $onshift, $selected, $line->id, 'pic1', $machine->id]) }}"
                                class="btn btn-danger" style="float: left">X</a>
                            <img src="{{ url('storage/' . $machine->pic1) }}" style="width:200px" class="rounded m-2">
                        @else
                            ไม่มี
                        @endif
                        <img class="rounded m-2" id="{{ $machine->id }}.pic1" width="200px" />
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light">1</span>

                            <input type="file" name="pic1" id="pic1" class="form-control" placeholder="image"
                                data-id="{{ $machine->id }}.pic1" onchange="loadFile(event,this)">
                            <a class="btn btn-danger" onclick="pic1()">X</a>
                        </div>
                    </div>
                </div>


                <div class="col">
                    <div class="form-group">
                        <strong>pic 2:</strong>

                        @if (!is_null($machine->pic2))
                            <a href="{{ route('machines_picDelete', [$department->id, $onshift, $selected, $line->id, 'pic2', $machine->id]) }}"
                                class="btn btn-danger" style="float: left">X</a>
                            <img src="{{ url('storage/' . $machine->pic2) }}" style="width: 200px" class="rounded m-2">
                        @else
                            ไม่มี
                        @endif
                        <img class="rounded m-2" id="{{ $machine->id }}.pic2" width="200px" />
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light">2</span>
                            <input type="file" name="pic2" id="pic2" class="form-control" placeholder="image"
                                data-id="{{ $machine->id }}.pic2" onchange="loadFile(event,this)">
                            <a class="btn btn-danger" onclick="pic2()">X</a>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <strong>pic 3:</strong>

                        @if (!is_null($machine->pic3))
                            <a href="{{ route('machines_picDelete', [$department->id, $onshift, $selected, $line->id, 'pic3', $machine->id]) }}"
                                class="btn btn-danger" style="float: left">X</a>
                            <img src="{{ url('storage/' . $machine->pic3) }}" style="width: 200px" class="rounded m-2">
                        @else
                            ไม่มี
                        @endif
                        <img class="rounded m-2" id="{{ $machine->id }}.pic3" width="200px" />
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light">3</span>
                            <input type="file" name="pic3" id="pic3" class="form-control" placeholder="image"
                                data-id="{{ $machine->id }}.pic3" onchange="loadFile(event,this)">
                            <a class="btn btn-danger" onclick="pic3()">X</a>

                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <strong>pic 4:</strong>

                        @if (!is_null($machine->pic4))
                            <a href="{{ route('machines_picDelete', [$department->id, $onshift, $selected, $line->id, 'pic4', $machine->id]) }}"
                                class="btn btn-danger" style="float: left">X</a>
                            <img src="{{ url('storage/' . $machine->pic4) }}" style="width: 200px" class="rounded m-2">
                        @else
                            ไม่มี
                        @endif
                        <img class="rounded m-2" id="{{ $machine->id }}.pic4" width="200px" />
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light">4</span>
                            <input type="file" name="pic4" id="pic4" class="form-control"
                                placeholder="image" data-id="{{ $machine->id }}.pic4" onchange="loadFile(event,this)">
                            <a class="btn btn-danger" onclick="pic4()">X</a>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <strong>pic 5:</strong>

                        @if (!is_null($machine->pic5))
                            <a href="{{ route('machines_picDelete', [$department->id, $onshift, $selected, $line->id, 'pic5', $machine->id]) }}"
                                class="btn btn-danger" style="float: left">X</a>
                            <img src="{{ url('storage/' . $machine->pic5) }}" style="width: 200px" class="rounded m-2">
                        @else
                            ไม่มี
                        @endif
                        <img class="rounded m-2" id="{{ $machine->id }}.pic5" width="200px" />

                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light">5</span>
                            <input type="file" name="pic5" id="pic5" class="form-control"
                                placeholder="image" data-id="{{ $machine->id }}.pic5" onchange="loadFile(event,this)">
                            <a class="btn btn-danger" onclick="pic5()">X</a>

                        </div>

                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <strong>pic 6:</strong>

                        @if (!is_null($machine->pic6))
                            <a href="{{ route('machines_picDelete', [$department->id, $onshift, $selected, $line->id, 'pic6', $machine->id]) }}"
                                class="btn btn-danger" style="float: left">X</a>
                            <img src="{{ url('storage/' . $machine->pic6) }}" style="width: 200px" class="rounded m-2">
                        @else
                            ไม่มี
                        @endif
                        <img class="rounded m-2" id="{{ $machine->id }}.pic6" width="200px" />

                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light">6</span>
                            <input type="file" name="pic6" id="pic2" class="form-control"
                                placeholder="image" data-id="{{ $machine->id }}.pic6" onchange="loadFile(event,this)">
                            <a class="btn btn-danger" onclick="pic6()">X</a>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <strong>pic 7:</strong>

                        @if (!is_null($machine->pic7))
                            <a href="{{ route('machines_picDelete', [$department->id, $onshift, $selected, $line->id, 'pic7', $machine->id]) }}"
                                class="btn btn-danger" style="float: left">X</a>
                            <img src="{{ url('storage/' . $machine->pic7) }}" style="width: 200px" class="rounded m-2">
                        @else
                            ไม่มี
                        @endif
                        <img class="rounded m-2" id="{{ $machine->id }}.pic7" width="200px" />

                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light">7</span>
                            <input type="file" name="pic7" class="form-control" placeholder="image"
                                data-id="{{ $machine->id }}.pic7" onchange="loadFile(event,this)">
                            <a class="btn btn-danger" onclick="pic7()">X</a>

                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <strong>pic 8:</strong>

                        @if (!is_null($machine->pic8))
                            <a href="{{ route('machines_picDelete', [$department->id, $onshift, $selected, $line->id, 'pic8', $machine->id]) }}"
                                class="btn btn-danger" style="float: left">X</a>
                            <img src="{{ url('storage/' . $machine->pic8) }}" style="width: 200px" class="rounded m-2">
                        @else
                            ไม่มี
                        @endif
                        <img class="rounded m-2" id="{{ $machine->id }}.pic8" width="200px" />

                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light">8</span>
                            <input type="file" name="pic8" id="pic8" class="form-control"
                                placeholder="image" data-id="{{ $machine->id }}.pic8" onchange="loadFile(event,this)">
                            <a class="btn btn-danger" onclick="pic8()">X</a>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <strong>pic 9:</strong>

                        @if (!is_null($machine->pic9))
                            <a href="{{ route('machines_picDelete', [$department->id, $onshift, $selected, $line->id, 'pic9', $machine->id]) }}"
                                class="btn btn-danger" style="float: left">X</a>
                            <img src="{{ url('storage/' . $machine->pic9) }}" style="width: 200px" class="rounded m-2">
                        @else
                            ไม่มี
                        @endif
                        <img class="rounded m-2" id="{{ $machine->id }}.pic9" width="200px" />


                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light">9</span>
                            <input type="file" name="pic9" id="pic9" class="form-control"
                                placeholder="image" data-id="{{ $machine->id }}.pic9" onchange="loadFile(event,this)">
                            <a class="btn btn-danger" onclick="pic9()">X</a>

                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <strong>pic 10:</strong>

                        @if (!is_null($machine->pic10))
                            <a href="{{ route('machines_picDelete', [$department->id, $onshift, $selected, $line->id, 'pic10', $machine->id]) }}"
                                class="btn btn-danger" style="float: left">X</a>
                            <img src="{{ url('storage/' . $machine->pic10) }}" style="width: 200px" class="rounded m-2">
                        @else
                            ไม่มี
                        @endif
                        <img class="rounded m-2" id="{{ $machine->id }}.pic10" width="200px" />

                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light">10</span>
                            <input type="file" name="pic10" id="pic10" class="form-control"
                                placeholder="image" data-id="{{ $machine->id }}.pic10" onchange="loadFile(event,this)"
                                id="file-to-upload">
                            <a class="btn btn-danger" onclick="pic10()">X</a>

                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success mt-3 w-100">แก้ไข</button>

        </form>

    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

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


    function pic1() {
        document.getElementById("pic1").value = "";
    }

    function pic2() {
        document.getElementById("pic2").value = "";
    }

    function pic3() {
        document.getElementById("pic3").value = "";
    }

    function pic4() {
        document.getElementById("pic4").value = "";
    }

    function pic5() {
        document.getElementById("pic5").value = "";
    }

    function pic6() {
        document.getElementById("pic6").value = "";
    }

    function pic7() {
        document.getElementById("pic7").value = "";
    }

    function pic8() {
        document.getElementById("pic8").value = "";
    }

    function pic9() {
        document.getElementById("pic9").value = "";
    }

    function pic10() {
        document.getElementById("pic10").value = "";
    }
</script>
