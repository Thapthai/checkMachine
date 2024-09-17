    <h3><strong>ชิ้นส่วน Resins ที่ต้องตรวจสอบ</strong></h3>

    @foreach ($resins_recorded as $resin)
        @if (count($resin->resin_records) > 0)
            <div class="col-sm-6 my-3">
                <div class="card bg-success rounded">
                    <a href="#business-{{ $resin->id }}old" class="text-decoration-none m-3" style="color: #ffffff">
                        <h4 class="card-title"><strong>{{ $resin->sequence }}. {{ $resin->position }}</strong> </h4>
                    </a>
                    <div class="card-body bg-light" id="business-{{ $resin->id }}old">
                        <table class="table">
                            <tr>
                                <th>รายละเอียด</th>
                                <td>{{ $resin->detail ?? '-' }}</td>
                                <th>จำนวน </th>
                                <td>{{ $resin->total_resin ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>วัสดุ</th>
                                <td>{{ $resin->material ?? '-' }}</td>
                                <th>สี</th>
                                <td>{{ $resin->color ?? '-' }}</td>
                            </tr>
                        </table>
                        @if (Auth::user()->is_admin == '1')
                            <form
                                action="{{ route('resins.update', [$department_id, $onshift, $selected, $line_id, $shiftDate, $machine_id, $resin->id]) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="text-center">
                                    <img class="rounded m-2" id="{{ $resin->id }}.pic1master" width="200px" />
                                </div>
                                <strong>เพิ่มรูปภาพ:</strong>
                                <div class="input-group my-3">
                                    <input type="file" name="pic1" class="form-control" placeholder="image"
                                        data-id="{{ $resin->id }}.pic1master" onchange="loadFile(event,this)">
                                    <button type="submit" class="btn btn-outline-primary">เพิ่ม</button>
                                </div>
                            </form>
                        @endif

                        @if (Auth::user()->is_admin == '1')
                            <div class="row">
                                <div class="col">
                                    <form
                                        action="{{ route('resins.destroy', [$department_id, $onshift, $selected, $line_id, $shiftDate, $machine_id, $resin->id]) }}"
                                        method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger w-100">ลบ</button>
                                    </form>
                                </div>
                                <div class="col">
                                    <button type="button" class="btn btn-warning w-100" data-toggle="modal"
                                        data-target="#resinEditModal-{{ $resin->id }}-old">
                                        แก้ไข
                                    </button>
                                    <!-- The Modal -->
                                    <div class="modal" id="resinEditModal-{{ $resin->id }}-old" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form
                                                    action="{{ route('resins.update', [$department_id, $onshift, $selected, $line_id, $shiftDate, $machine_id, $resin->id]) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">แก้ไข เรซิ่น
                                                            {{ $resin->position }}</h5>
                                                        <button type="button" class="close btn btn-danger"
                                                            data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">X</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>ที่ตั้งหรือตำแหน่ง :</strong>
                                                                <input type="text" name="position"
                                                                    class="form-control"
                                                                    value="{{ $resin->position }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>จำนวนของ resin :</strong>
                                                                <input type="text" name="total_resin"
                                                                    class="form-control"
                                                                    value="{{ $resin->total_resin }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>วัสดุ :</strong>
                                                                <input type="text" name="material"
                                                                    class="form-control"
                                                                    value="{{ $resin->material }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>สี :</strong>
                                                                <input type="text" name="color"
                                                                    class="form-control" value="{{ $resin->color }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>ลำดับการตรวจ :</strong>
                                                                <input type="text" name="sequence"
                                                                    class="form-control"
                                                                    value="{{ $resin->sequence }}">
                                                            </div>
                                                        </div>

                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>รายละเอียด :</strong>
                                                                <input type="text" name="detail"
                                                                    class="form-control" value="{{ $resin->detail }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">ปิด</button>
                                                        <button type="submit" class="btn btn-primary">บันทึก</button>
                                                    </div>
                                            </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <form
                            action="{{ route('resin_records.store', [$department_id, $onshift, $selected, $line_id, $machine_id, $check_in, $resin->id]) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="text-center">
                                @if (!is_null($resin->pic1))
                                    <img src="{{ url('storage/' . $resin->pic1) }}" alt="img" width="300px"
                                        class="rounded show-image">
                                @else
                                    <h4>ไม่มีรูปภาพ</h4>
                                @endif

                                @if (!is_null($resin->pic2))
                                    <div class="show-image">
                                        <img src="{{ url('storage/' . $resin->pic2) }}" alt="img"
                                            width="300px" class="rounded show-image">
                                    </div>
                                @else
                                @endif

                                @if (!is_null($resin->pic3))
                                    <div class="show-image">
                                        <img src="{{ url('storage/' . $resin->pic3) }}" alt="img"
                                            width="300px"class="show-image rounded">
                                    </div>
                                @else
                                @endif
                            </div><br>

                            <strong>ความสะอาด :</strong>
                            <br>
                            <input class="form-check-input" type="radio" name="clean" value="pass" required>
                            <label class="form-check-label">ผ่าน</label>

                            <input class="form-check-input" type="radio" name="clean" value="NOT">
                            <label class="form-check-label">ไม่ผ่าน</label>
                            <br>

                            <strong>ความสมบูรณ์ :</strong>
                            <br>
                            <input class="form-check-input" type="radio" name="status" value="pass" required>
                            <label class="form-check-label">ผ่าน</label>

                            <input class="form-check-input" type="radio" name="status" value="NOT">
                            <label class="form-check-label">ไม่ผ่าน</label>
                            <br>

                            <strong class="form-label">หมายเหตุ</strong>
                            <input type="text" name="detail" class="form-control">

                            <div class="text-center">
                                <img class="rounded m-2" id="{{ $resin->id }}.pic1" width="200px" />
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <strong>รูปที่ 1:</strong>
                                    <input type="file" name="pic1" class="form-control"
                                        data-id="{{ $resin->id }}.pic1" onchange="loadFile(event,this)">
                                </div>
                            </div>
                            <div class="text-center">
                                <img class="rounded m-2" id="{{ $resin->id }}.pic2" width="200px" />
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <strong>รูปที่ 2:</strong>
                                    <input type="file" name="pic2" class="form-control"
                                        data-id="{{ $resin->id }}.pic2" onchange="loadFile(event,this)">
                                </div>
                            </div>
                            <div class="text-center">
                                <img class="rounded m-2" id="{{ $resin->id }}.pic3" width="200px" />
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <strong>รูปที่ 3:</strong>
                                    <input type="file" name="pic3" class="form-control"
                                        data-id="{{ $resin->id }}.pic3" onchange="loadFile(event,this)">
                                </div>
                            </div>
                            <br>
                            <input type="text" value="{{ $shiftDate }}" name="shiftDate" hidden>
                            <input type="text" value="{{ $search_date }}" name="search_date" hidden>


                            <div class="d-grid gap-2 col-6 mx-auto">
                                <button type="submit" class="btn btn-success">บันทึก</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="col-sm-6 my-3">
                <div class="card bg-success rounded">
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning"
                        style="height: 36px">
                        <h5><i class="bi bi-exclamation-diamond-fill" style="color: black"></i></h5>
                    </span>
                    <a href="#business-{{ $resin->id }}new" class="text-decoration-none m-3"
                        style="color: white">
                        <h4 class="card-title"><strong>{{ $resin->sequence }}. {{ $resin->position }}</strong> </h4>
                    </a>

                    <div class="card-body bg-light" id="business-{{ $resin->id }}new">
                        <table class="table">
                            <tr>
                                <th>รายละเอียด</th>
                                <td>{{ $resin->detail ?? '-' }}</td>
                                <th>จำนวน </th>
                                <td>{{ $resin->total_resin ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>วัสดุ</th>
                                <td>{{ $resin->material ?? '-' }}</td>
                                <th>สี</th>
                                <td>{{ $resin->color ?? '-' }}</td>
                            </tr>
                        </table>
                        @if (Auth::user()->is_admin == '1')
                            <div class="row">
                                <div class="col">
                                    <form
                                        action="{{ route('resins.destroy', [$department_id, $onshift, $selected, $line_id, $shiftDate, $machine_id, $resin->id]) }}"
                                        method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger w-100">ลบ</button>
                                    </form>
                                </div>
                                <div class="col">
                                    <button type="button" class="btn btn-warning w-100" data-toggle="modal"
                                        data-target="#resinEditModal-{{ $resin->id }}-new">
                                        แก้ไข
                                    </button>
                                    <!-- The Modal -->
                                    <div class="modal" id="resinEditModal-{{ $resin->id }}-new" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form
                                                    action="{{ route('resins.update', [$department_id, $onshift, $selected, $line_id, $shiftDate, $machine_id, $resin->id]) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">แก้ไข เรซิ่น
                                                            {{ $resin->position }}
                                                        </h5>
                                                        <button type="button" class="close btn btn-danger"
                                                            data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">X</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>ที่ตั้งหรือตำแหน่ง :</strong>
                                                                <input type="text" name="position"
                                                                    class="form-control"
                                                                    value="{{ $resin->position }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>จำนวนของ resin :</strong>
                                                                <input type="text" name="total_resin"
                                                                    class="form-control"
                                                                    value="{{ $resin->total_resin }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>วัสดุ :</strong>
                                                                <input type="text" name="material"
                                                                    class="form-control"
                                                                    value="{{ $resin->material }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>สี :</strong>
                                                                <input type="text" name="color"
                                                                    class="form-control" value="{{ $resin->color }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>ลำดับการตรวจ :</strong>
                                                                <input type="text" name="sequence"
                                                                    class="form-control"
                                                                    value="{{ $resin->sequence }}">
                                                            </div>
                                                        </div>

                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <strong>รายละเอียด :</strong>
                                                                <input type="text" name="detail"
                                                                    class="form-control"
                                                                    value="{{ $resin->detail }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">ปิด</button>
                                                        <button type="submit" class="btn btn-primary">บันทึก</button>
                                                    </div>
                                            </div>
                                            </form>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endif
                        <form
                            action="{{ route('resins.update', [$department_id, $onshift, $selected, $line_id, $shiftDate, $machine_id, $resin->id]) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="text-center">
                                <img class="rounded m-2" id="{{ $resin->id }}.pic1master" width="200px" />
                            </div>
                            <strong>เพิ่มรูปภาพ:</strong>
                            <div class="input-group my-3">
                                <input type="file" name="pic1" class="form-control" placeholder="image"
                                    data-id="{{ $resin->id }}.pic1master" onchange="loadFile(event,this)">
                                <button type="submit" class="btn btn-outline-primary">เพิ่ม</button>
                            </div>
                        </form>

                        <form
                            action="{{ route('resin_records.store', [$department_id, $onshift, $selected, $line_id, $machine_id, $check_in, $resin->id]) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="text-center">
                                @if (!is_null($resin->pic1))
                                    <img src="{{ url('storage/' . $resin->pic1) }}" alt="img" width="300px"
                                        class="m-1">
                                @else
                                    <h4>ไม่มีรูปภาพ</h4>
                                @endif

                                @if (!is_null($resin->pic2))
                                    <img src="{{ url('storage/' . $resin->pic2) }}" alt="img"
                                        width="300px"class="m-1">
                                @else
                                @endif

                                @if (!is_null($resin->pic3))
                                    <img src="{{ url('storage/' . $resin->pic3) }}" alt="img"
                                        width="300px"class="m-1">
                                @else
                                @endif
                            </div>

                            <strong>ความสะอาด :</strong>
                            <br>
                            <input class="form-check-input" type="radio" name="clean" value="pass" required>
                            <label class="form-check-label">ผ่าน</label>

                            <input class="form-check-input" type="radio" name="clean" value="NOT">
                            <label class="form-check-label">ไม่ผ่าน</label>
                            <br>

                            <strong>ความสมบูรณ์ :</strong>
                            <br>
                            <input class="form-check-input" type="radio" name="status" value="pass" required>
                            <label class="form-check-label">ผ่าน</label>

                            <input class="form-check-input" type="radio" name="status" value="NOT">
                            <label class="form-check-label">ไม่ผ่าน</label>
                            <br>

                            <label class="form-label">หมายเหตุ</label>
                            <input type="text" name="detail" class="form-control">
                            <br>
                            <div class="text-center">
                                <img class="rounded m-2" id="{{ $resin->id }}.pic1" width="200px" />
                            </div>
                            <br>
                            <div class="col">
                                <div class="form-group">
                                    <strong>รูปที่ 1:</strong>
                                    <input type="file" name="pic1" class="form-control"
                                        data-id="{{ $resin->id }}.pic1" onchange="loadFile(event,this)">
                                </div>
                            </div>
                            <br>
                            <div class="text-center">
                                <img class="rounded m-2" id="{{ $resin->id }}.pic2" width="200px" />
                            </div>
                            <br>
                            <div class="col">
                                <div class="form-group">
                                    <strong>รูปที่ 2:</strong>
                                    <input type="file" name="pic2" class="form-control"
                                        data-id="{{ $resin->id }}.pic2" onchange="loadFile(event,this)">
                                </div>
                            </div>
                            <br>
                            <div class="text-center">
                                <img class="rounded m-2" id="{{ $resin->id }}.pic3" width="200px" />
                            </div>
                            <br>
                            <div class="col">
                                <div class="form-group">
                                    <strong>รูปที่ 3:</strong>
                                    <input type="file" name="pic3" class="form-control"
                                        data-id="{{ $resin->id }}.pic3" onchange="loadFile(event,this)">
                                </div>
                            </div>
                            <br>
                            <input type="text" value="{{ $shiftDate }}" name="shiftDate" hidden>
                            <input type="text" value="{{ $search_date }}" name="search_date" hidden>
                            <div class="d-grid gap-2 col-6 mx-auto">
                                <button type="submit" class="btn btn-success">บันทึก</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
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
