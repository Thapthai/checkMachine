<hr>
<div class="row">
    <div class="col">
        <h4> <strong>เรชิ้นที่ตรวจสอบแล้ว</strong></h4>

    </div>

</div>

<div class="row">
    @foreach ($resins as $index => $resin)
        @if (count($resin->resin_records) > 0)
            @if (isset($resin->resin_records))
                <div class="col-sm-6 my-1">
                    <div class="card">
                        <div class="card-body">

                            <h4><strong> ตรวจสอบแล้ว {{ $resin->name }} {{ $resin->position }} <i
                                        class='bx bx-check rounded-5 btn-success'></i>
                                </strong></h4>
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
                            <div class="text-center">
                                @if (!is_null($resin->pic1))
                                    <img src="{{ url('storage/' . $resin->pic1) }}" alt="img" height="300px"
                                        class="rounded  show-image">
                                @else
                                    <h4>ไม่มีรูปภาพ</h4>
                                @endif

                                @if (!is_null($resin->pic2))
                                    <img src="{{ url('storage/' . $resin->pic2) }}" alt="img" height="300px"
                                        class="rounded  show-image">
                                @else
                                @endif

                                @if (!is_null($resin->pic3))
                                    <img src="{{ url('storage/' . $resin->pic3) }}" alt="img" height="300px"
                                        class="rounded  show-image">
                                @else
                                @endif
                            </div><br>

                            @foreach ($resin->resin_records->where('on_shift', $onshift) as $resin_record)
                                @if (
                                    $resin_record->created_at->format('Y-m-d') == $search_date and
                                        $resin_record->on_shift == $onshift and
                                        $resin_record->check_in == $check_in)
                                    <h4> <strong>
                                            {{ $resin->name }}
                                        </strong>

                                        @php
                                            $tmp = [];
                                            $tmp['resin_record'] = $resin_record->id;
                                            $test[] = $tmp;
                                        @endphp

                                    </h4>

                                    <form
                                        action="{{ route('resin_records.update', [$department_id, $onshift, $selected, $line_id, $machine_id, $check_in, $shiftDate, $resin_record->id]) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <strong>ความสะอาด :</strong>
                                        <br>
                                        <input type="radio" name="clean" value="pass" class="form-check-input"
                                            @isset($resin_record->clean)
                                                        @if ($resin_record->clean == 'pass')
                                                            checked
                                                        @endif
                                                    @endisset>
                                        <label class="form-check-label">ปกติ</label>

                                        <input type="radio" name="clean" value="NOT" class="form-check-input"
                                            @isset($resin_record->clean)
                                                        @if ($resin_record->clean == 'NOT')
                                                           checked
                                                        @endif
                                                     @endisset>
                                        <label class="form-check-label">ไม่ปกติ</label>
                                        <br>

                                        <strong>ความสมบูรณ์ :</strong>
                                        <br>
                                        <input type="radio" name="status" value="pass" class="form-check-input"
                                            @isset($resin_record->status)
                                                        @if ($resin_record->status == 'pass')
                                                            checked
                                                        @endif
                                                    @endisset>
                                        <label class="form-check-label">ปกติ</label>

                                        <input type="radio" name="status" value="NOT" class="form-check-input"
                                            @isset($resin_record->status)
                                                        @if ($resin_record->status == 'NOT')
                                                           checked
                                                        @endif
                                                     @endisset>
                                        <label class="form-check-label">ไม่ปกติ</label>

                                        <hr>

                                        <br>
                                        <strong>รายละเอียด :</strong>
                                        {{ $resin_record->detail }}
                                        <br>
                                        <strong>ตรวจสอบโดย :</strong>
                                        {{ $resin_record->user->username }}
                                        <br>
                                        <br>

                                        <label class="form-label">หมายเหตุ</label>
                                        <input type="text" name="detail" class="form-control"
                                            value="{{ $resin_record->detail }}">

                                        <br>

                                        @if (!is_null($resin_record->pic1))
                                            <div class="text-center">
                                                <img src="{{ url('storage/' . $resin_record->pic1) }}"
                                                    class="rounded show-image" width="200px">
                                            </div>
                                        @else
                                            <div class="text-center">
                                                <i class="text-danger">*** ไม่มีรูป ***</i>
                                            </div>
                                        @endif

                                        <div class="text-center">
                                            <img class="rounded " id="{{ $resin_record->id }}.pic1_checked"
                                                width="200px" />
                                        </div>

                                        <div class="col">
                                            <div class="form-group">
                                                <strong>รูปที่ 1:</strong>
                                                <input type="file" name="pic1" class="form-control"
                                                    data-id="{{ $resin_record->id }}.pic1_checked"
                                                    onchange="loadFile(event,this)">
                                            </div>
                                        </div>
                                        <br>
                                        @if (!is_null($resin_record->pic2))
                                            <div class="text-center">
                                                <img src="{{ url('storage/' . $resin_record->pic2) }}"
                                                    class="rounded show-image" width="200px">
                                            </div>
                                        @else
                                            <div class="text-center">
                                                <i class="text-danger">*** ไม่มีรูป ***</i>
                                            </div>
                                        @endif

                                        <div class="text-center">
                                            <img class="rounded m-2" id="{{ $resin_record->id }}.pic2_checked"
                                                width="200px" />
                                        </div>

                                        <div class="col">
                                            <div class="form-group">
                                                <strong>รูปที่ 2:</strong>
                                                <input type="file" name="pic2" class="form-control"
                                                    data-id="{{ $resin_record->id }}.pic2_checked"
                                                    onchange="loadFile(event,this)">
                                            </div>
                                        </div>

                                        <br>

                                        @if (!is_null($resin_record->pic3))
                                            <div class="text-center">
                                                <img src="{{ url('storage/' . $resin_record->pic3) }}"
                                                    class="rounded show-image" width="200px">
                                            </div>
                                        @else
                                            <div class="text-center">
                                                <i class="text-danger">*** ไม่มีรูป ***</i>
                                            </div>
                                        @endif

                                        <div class="text-center">
                                            <img class="rounded m-2" id="{{ $resin_record->id }}.pic3_checked"
                                                width="200px" />
                                        </div>

                                        <div class="col">
                                            <div class="form-group">
                                                <strong>รูปที่ 3:</strong>
                                                <input type="file" name="pic3" class="form-control"
                                                    data-id="{{ $resin_record->id }}.pic3_checked"
                                                    onchange="loadFile(event,this)">
                                            </div>
                                        </div>

                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-warning mt-2"
                                                onclick="return confirm('คุณต้องการที่จะแก้ไข ?')">แก้ไข
                                            </button>
                                        </div>

                                    </form>

                                    <form
                                        action="{{ route('resin_records.destroy', [$department_id, $onshift, $selected, $line_id, $machine_id, $check_in, $shiftDate, $resin_record->id]) }}"
                                        method="Post">
                                        @csrf
                                        @method('DELETE')

                                        @if (Auth::user()->is_admin == '1')
                                            <div class="d-grid gap-2">
                                                <button type="submit" class="btn btn-danger mt-2"
                                                    onclick="return confirm('ต้องการ ลบ ?')">ลบ</button>
                                            </div>
                                        @endif
                                    </form>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                </form>
            @endif
        @endif

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
