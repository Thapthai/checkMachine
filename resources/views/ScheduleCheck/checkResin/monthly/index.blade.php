@if ($schedulePlan->frequency_check->name == 'Monthly')
    @if (date('Y-m-d', strtotime($shiftDate)) >= $inspectionStartDate &&
            date('Y-m-d', strtotime($shiftDate)) <= $inspectionEndDate)
        @if (count(
                $schedulePlan->resin->schedule_records->whereBetween('shift_date', [$inspectionStartDate, $inspectionEndDate])->where('schedule_plan_id', $schedulePlan->id)) > 0)
        @else
            <div class="col-sm-6">
                <div class="shadow-sm mt-2">

                    <button class="btn btn-success btn-lg w-100" type="button">
                        <div style="text-align: left">
                            <h5 class="card-title">
                                <strong>
                                    {{ $schedulePlan->resin->sequence }}.
                                    {{ $schedulePlan->resin->position }}
                                </strong>
                            </h5>
                        </div>
                    </button>

                    <div class="card card-body">
                        @if ($schedulePlan->resin->machine->detail)
                            <p class="card-text"><strong>รายละเอียด:</strong>
                                {{ $schedulePlan->resin->machine->detail }}</p>
                        @else
                            <p class="card-text"><strong>รายละเอียด:</strong> ไม่มี</p>
                        @endif
                        <table class="table">
                            <tr>
                                <th>รายละเอียด</th>
                                <td>{{ $schedulePlan->resin->detail ?? '-' }}</td>
                                <th>จำนวน </th>
                                <td>{{ $schedulePlan->resin->total_resin ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>วัสดุ</th>
                                <td>{{ $schedulePlan->resin->material ?? '-' }}</td>
                                <th>สี</th>
                                <td>{{ $schedulePlan->resin->color ?? '-' }}</td>
                            </tr>
                        </table>



                        <form
                            action="{{ route('machines_schedule_record', [$department->id, $onshift, $selected, $line->id, $machine->id, $shiftDate, $schedulePlan->resin->id, $schedulePlan->id]) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="text-center">
                                @if (!is_null($schedulePlan->resin->pic1))
                                    <img src="{{ url('storage/' . $schedulePlan->resin->pic1) }}" alt="img"
                                        width="300px" class="rounded show-image">
                                @else
                                    <h4>ไม่มีรูปภาพ</h4>
                                @endif

                                @if (!is_null($schedulePlan->resin->pic2))
                                    <div class="show-image">
                                        <img src="{{ url('storage/' . $schedulePlan->resin->pic2) }}" alt="img"
                                            width="300px" class="rounded show-image">
                                    </div>
                                @else
                                @endif

                                @if (!is_null($schedulePlan->resin->pic3))
                                    <div class="show-image">
                                        <img src="{{ url('storage/' . $schedulePlan->resin->pic3) }}" alt="img"
                                            width="300px"class="show-image rounded">
                                    </div>
                                @else
                                @endif
                            </div><br>

                            {{-- <div class="row"> --}}
                            {{-- <div class="col border border-1 rounded-2 m-1"> --}}
                            <div class="col border border-1 rounded-2 my-3 p-2" style="font-size: 20px">
                                <strong>ความสะอาด :</strong>

                                <input class="form-check-input" type="radio" name="clean" value="pass" required>
                                <label class="form-check-label">ผ่าน</label>

                                <input class="form-check-input" type="radio" name="clean" value="NOT">
                                <label class="form-check-label">ไม่ผ่าน</label>
                                <br>
                            </div>
                            {{-- <div class="col border border-1 rounded-2 m-1"> --}}
                            <div class="col border border-1 rounded-2 my-3 p-2" style="font-size: 20px">
                                <strong>ความสมบูรณ์ :</strong>

                                <input class="form-check-input" type="radio" name="complete" value="pass" required>
                                <label class="form-check-label">ผ่าน</label>

                                <input class="form-check-input" type="radio" name="complete" value="NOT">
                                <label class="form-check-label">ไม่ผ่าน</label>
                                <br>

                            </div>
                            {{-- </div> --}}

                            <strong class="form-label">หมายเหตุ</strong>
                            <input type="text" name="detail" class="form-control">

                            <div class="text-center">
                                <img class="rounded m-2" id="{{ $schedulePlan->resin->id }}.pic1" width="200px" />
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <strong>รูปที่ 1:</strong>
                                    <input type="file" name="pic1" class="form-control"
                                        data-id="{{ $schedulePlan->resin->id }}.pic1" onchange="loadFile(event,this)">
                                </div>
                            </div>
                            <div class="text-center">
                                <img class="rounded m-2" id="{{ $schedulePlan->resin->id }}.pic2" width="200px" />
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <strong>รูปที่ 2:</strong>
                                    <input type="file" name="pic2" class="form-control"
                                        data-id="{{ $schedulePlan->resin->id }}.pic2" onchange="loadFile(event,this)">
                                </div>
                            </div>
                            <div class="text-center">
                                <img class="rounded m-2" id="{{ $schedulePlan->resin->id }}.pic3" width="200px" />
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <strong>รูปที่ 3:</strong>
                                    <input type="file" name="pic3" class="form-control"
                                        data-id="{{ $schedulePlan->resin->id }}.pic3" onchange="loadFile(event,this)">
                                </div>
                            </div>
                            <br>
                            <input type="text" value="{{ $shiftDate }}" name="shiftDate" hidden>

                            {{-- <div class="d-grid gap-2 col-6 mx-auto">
                            </div> --}}
                            <button type="submit" class="btn btn-success w-100">บันทึก</button>


                        </form>

                    </div>



                </div>
            </div>
        @endif

    @endif
@endif
