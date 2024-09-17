@if ($selected == 'resin')

    @php
        $count_resin_records_before = [];
    @endphp

    @foreach ($machine->resin_records as $resin_record)
        @if (
            $resin_record->check_in == 'before' &&
                $resin_record->created_at->format('Y-m-d') == $shiftDate &&
                $resin_record->on_shift == $onshift)
            @php
                $checked_before = $resin_record;
                $count_resin_records_before[] = $resin_record->id;
            @endphp
        @endif
    @endforeach

    @php
        $count_resin_records_after = [];
    @endphp

    @foreach ($machine->resin_records as $resin_record)
        @if (
            $resin_record->check_in == 'after' &&
                $resin_record->created_at->format('Y-m-d') == $shiftDate &&
                $resin_record->on_shift == $onshift)
            @php
                $checked_after = $resin_record;
                $count_resin_records_after[] = $resin_record->id;
            @endphp
        @endif
    @endforeach
    {{-- =========================== RESINs BEFORE =========================== --}}

    {{-- @if ($machine->resins->count() == count($count_resin_records_before))
        @if (isset($checked_before))
            @if (count($machine->resin_records) > 0 && $checked_before->machines_id == $machine->id)
                <th style="text-align: right" class="w-100">
                    <a href="{{ route('resin_records_checked', [$department->id, $onshift, $selected, $line->id, $machine->id, 'check_in' => 'before', 'shiftDate' => $shiftDate]) }}"
                        class="btn btn-success">
                        ก่อน
                    </a>
                </th>
            @endif
        @endif
    @else
        <form
            action="{{ route('resins.index', [$department->id, $onshift, $selected, $line->id, $machine->id, 'check_in' => 'before']) }}"
            method="GET">
            <input type="text" value="{{ $shiftDate }}" name="shiftDate" hidden>
            <th>

                <button type="submit" class="btn btn-danger">
                    ก่อน
                </button>
            </th>
        </form>
    @endif --}}

    {{-- =========================== RESINs AFTER =========================== --}}

    {{-- @if ($machine->resins->count() == count($count_resin_records_after))
        <th style="text-align: right">

            @if (isset($checked_after))
                @if (count($machine->resin_records) > 0 && $checked_after->machines_id == $machine->id)
                    @if ($machine->resins->count() == count($count_resin_records_after))
                        <a href="{{ route('resin_records_checked', [$department->id, $onshift, $selected, $line->id, $machine->id, 'check_in' => 'before', 'shiftDate' => $shiftDate]) }}"
                            class="btn btn-success">
                            หลัง
                        </a>
                    @endif
                @endif
            @endif
        </th>
    @else
        <form
            action="{{ route('resins.index', [$department->id, $onshift, $selected, $line->id, $machine->id, 'check_in' => 'after']) }}"
            method="GET">
            <input type="text" value="{{ $shiftDate }}" name="shiftDate" hidden>
            <th style="text-align: right">

                <button type="submit" class="btn btn-danger">
                    หลัง
                </button>
            </th>
        </form>
    @endif --}}

    <td style="text-align: right">
        <a href="#business-{{ $machine->id }}" class="text-decoration-none " style="color: black">
            <i class='bx bx-chevron-down btn'></i> </a>
    </td>
    </tr>
    </table>
    <div class="card-body bg-light" id="business-{{ $machine->id }}">


        {{-- <strong>เพิ่มเรซิ่น โดย ไฟล์ xlsx <a href="{{ route('resinExample_import') }}" class="link-primary">ตัวอย่างไฟล์
                สำหรับ เรซิ่น</a></strong>

        <form action="{{ route('resin_importByxlsx', $machine->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="input-group my-2 mt-2">
                <input type="file" name="file_resins" class="form-control " accept=".xlsx" required>
                <button type="submit" class="input-group-text btn btn-primary" id="basic-addon1">เพิ่ม</button>
            </div>
        </form>
        <hr> --}}


        <div class="text-center">

            @if (!is_null($machine->pic1))
                <div class="show-image">
                    <img src="{{ url('storage/' . $machine->pic1) }}" class="m-1" style="height: 520px">
                </div>
            @else
                <h5>ไม่มีรูปภาพ</h5>
            @endif
        </div>

        <p class="card-text"> <strong>รายละเอียด:</strong> {{ $machine->detail }}</p>
        <hr>
        @if (Auth::user()->is_admin == '1')
            <form
                action="{{ route('machines.destroy', [$department->id, $onshift, $selected, $line->id, $shiftDate, $machine->id]) }}"
                method="Post">
                @csrf
                @method('DELETE')
                <div class="row">
                    <div class="col">
                        <a class="btn btn-warning w-100"
                            href="{{ route('machines.edit', [$department->id, $onshift, $selected, $line->id, $shiftDate, $machine->id]) }}">
                            แก้ไข</a>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-danger w-100"
                            onclick="return confirm('Are you sure?')">ลบ</button>

                    </div>
                </div>
            </form>
            <hr>
        @endif


        <div class="row">
            <div class="col">
                <form
                    action="{{ route('resins.index', [$department->id, $onshift, $selected, $line->id, $machine->id, 'check_in' => 'before']) }}"
                    method="GET">
                    <div class="btn-group w-100">
                        <input type="text" value="{{ $shiftDate }}" name="shiftDate" hidden>

                        @if ($machine->resins->count() == count($count_resin_records_before))
                            <button type="submit" class="btn btn-success">
                                เรซิ่น ก่อนการใช้งาน
                            </button>
                        @else
                            <button type="submit" class="btn btn-secondary">
                                เรซิ่น ก่อนการใช้งาน
                            </button>
                        @endif


                        @if (isset($checked_before))
                            @if (count($machine->resin_records) > 0 && $checked_before->machines_id == $machine->id)
                                <a href="{{ route('resin_records_checked', [$department->id, $onshift, $selected, $line->id, $machine->id, 'check_in' => 'before', 'shiftDate' => $shiftDate]) }}"
                                    class="btn btn-success">
                                    <i class='bx bx-check'></i>
                                </a>
                            @else
                            @endif
                        @endif

                    </div>
                </form>
            </div>
            <div class="col">
                <form
                    action="{{ route('resins.index', [$department->id, $onshift, $selected, $line->id, $machine->id, 'check_in' => 'after']) }}"
                    method="GET">

                    <input type="text" value="{{ $shiftDate }}" name="shiftDate" hidden>
                    <div class="btn-group w-100">

                        @if ($machine->resins->count() == count($count_resin_records_after))
                            <button type="submit" class="btn btn-success">
                                เรซิ่น หลังการใช้งาน
                            </button>
                        @else
                            <button type="submit" class="btn btn-secondary">
                                เรซิ่น หลังการใช้งาน
                            </button>
                        @endif

                        @if (isset($checked_after))
                            @if (count($machine->resin_records) > 0 && $checked_after->machines_id == $machine->id)
                                @if ($machine->resins->count() == count($count_resin_records_after))
                                    <a href="{{ route('resin_records_checked', [$department->id, $onshift, $selected, $line->id, $machine->id, 'check_in' => 'before', 'shiftDate' => $shiftDate]) }}"
                                        class="btn btn-success">
                                        <i class='bx bx-check'></i>
                                    </a>
                                @else
                                    <a href="{{ route('resin_records_checked', [$department->id, $onshift, $selected, $line->id, $machine->id, 'check_in' => 'after', 'shiftDate' => $shiftDate]) }}"
                                        class="btn btn-warning">
                                        <i class='bx bx-check'></i>
                                    </a>
                                @endif
                            @endif
                        @endif
                    </div>
                </form>

            </div>
        </div>
@endif
