@if ($selected == 'part')


    {{-- parts --}}
    @php
        $count_part_records_before = [];
    @endphp

    @foreach ($machine->part_records as $part_record)
        @if (
            $part_record->check_in == 'before' &&
                $part_record->created_at->format('Y-m-d') == $shiftDate &&
                $part_record->on_shift == $onshift)
            @php
                $checked_before = $part_record;

                $count_part_records_before[] = $part_record->id;
            @endphp
        @endif
    @endforeach

    @php
        $count_part_records_after = [];
    @endphp

    @foreach ($machine->part_records as $part_record)
        @if (
            $part_record->check_in == 'after' &&
                $part_record->created_at->format('Y-m-d') == $shiftDate &&
                $part_record->on_shift == $onshift)
            @php
                $checked_after = $part_record;
                $count_part_records_after[] = $part_record->id;
            @endphp
        @endif
    @endforeach

    {{-- =========================== Parts BEFORE =========================== --}}

    @if ($machine->parts->count() == count($count_part_records_before))
        @if (isset($checked_before))
            @if (count($machine->part_records) > 0 && $checked_before->machines_id == $machine->id)
                <th style="text-align: right" class="w-100">
                    <a href="{{ route('part_records_checked', [$department->id, $onshift, $selected, $line->id , $machine->id, 'check_in' => 'before', 'shiftDate' => $shiftDate]) }}"
                        class="btn btn-primary">
                        ก่อน
                    </a>
                </th>
            @endif
        @endif
    @else
        <form
            action="{{ route('parts.index', [$department->id, $onshift, $selected, $line->id , $machine->id, 'check_in' => 'before']) }}"
            method="GET">
            <input type="text" value="{{ $shiftDate }}" name="shiftDate" hidden>
            <th>
                <div class="btn-group w-100">

                    <button type="submit" class="btn btn-primary">
                        ก่อน
                    </button>
                    <a href="{{ route('part_records_checked', [$department->id, $onshift, $selected, $line->id , $machine->id, 'check_in' => 'before', 'shiftDate' => $shiftDate]) }}"
                        class="btn btn-success">
                        <i class='bx bx-task'></i>
                    </a>
                </div>
            </th>
        </form>
    @endif

    {{-- =========================== Parts AFTER =========================== --}}

    @if ($machine->parts->count() == count($count_part_records_after))
        <th style="text-align: right">

            @if (isset($checked_after))
                @if (count($machine->part_records) > 0 && $checked_after->machines_id == $machine->id)
                    @if ($machine->parts->count() == count($count_part_records_after))
                        <a href="{{ route('part_records_checked', [$department->id, $onshift, $selected, $line->id , $machine->id, 'check_in' => 'before', 'shiftDate' => $shiftDate]) }}"
                            class="btn btn-primary">
                            หลัง
                        </a>
                    @endif
                @endif
            @endif
        </th>
    @else
        <form
            action="{{ route('parts.index', [$department->id, $onshift, $selected, $line->id , $machine->id, 'check_in' => 'after']) }}"
            method="GET">
            <input type="text" value="{{ $shiftDate }}" name="shiftDate" hidden>
            <th style="text-align: right">
                <div class="btn-group w-100">
                    <button type="submit" class="btn btn-primary">
                        หลัง
                    </button>
                    <a href="{{ route('part_records_checked', [$department->id, $onshift, $selected, $line->id , $machine->id, 'check_in' => 'before', 'shiftDate' => $shiftDate]) }}"
                        class="btn btn-success">
                        <i class='bx bx-task'></i>
                    </a>
            </th>
            </div>
        </form>
    @endif

    <td style="text-align: right">
        <a href="#business-{{ $machine->id }}" class="text-decoration-none " style="color: black">
            <i class='bx bx-chevron-down btn'></i> </a>
    </td>
    </tr>
    </table>
    <div class="card-body bg-light" id="business-{{ $machine->id }}">
        <div class="text-center">
            @if (!is_null($machine->pic1))
                <div class="show-image">
                    <img src="{{ url('storage/' . $machine->pic1) }}" class="m-1" style="width: 520px">
                </div>
            @else
                <h5>ไม่มีรูปภาพ</h5>
            @endif
        </div>

        <p class="card-text"> <strong>รายละเอียด:</strong> {{ $machine->detail }}</p>
        <hr>
        @if (Auth::user()->is_admin == '1')
            <form
                action="{{ route('machines.destroy', [$department->id, $onshift, $selected, $line->id , $shiftDate, $machine->id]) }}"
                method="Post">
                @csrf
                @method('DELETE')
                <div class="row">
                    <div class="col">
                        <a class="btn btn-warning w-100"
                            href="{{ route('machines.edit', [$department->id, $onshift, $selected, $line->id , $shiftDate, $machine->id]) }}">
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
                    action="{{ route('parts.index', [$department->id, $onshift, $selected, $line->id , $machine->id, 'check_in' => 'before']) }}"
                    method="GET">
                    <div class="btn-group w-100">
                        <input type="text" value="{{ $shiftDate }}" name="shiftDate" hidden>


                        <button type="submit" class="btn btn-primary">
                            ชื้นส่วน ก่อนการใช้งาน
                        </button>

                        <a href="{{ route('part_records_checked', [$department->id, $onshift, $selected, $line->id , $machine->id, 'check_in' => 'before', 'shiftDate' => $shiftDate]) }}"
                            class="btn btn-success">
                            <i class='bx bx-task'></i>
                        </a>
                    </div>
                </form>
            </div>
            <div class="col">
                <form
                    action="{{ route('parts.index', [$department->id, $onshift, $selected, $line->id , $machine->id, 'check_in' => 'after']) }}"
                    method="GET">

                    <input type="text" value="{{ $shiftDate }}" name="shiftDate" hidden>
                    <div class="btn-group w-100">


                        <button type="submit" class="btn btn-primary">
                            ชิ้นส่วน หลังการใช้งาน
                        </button>


                        <a href="{{ route('part_records_checked', [$department->id, $onshift, $selected, $line->id , $machine->id, 'check_in' => 'before', 'shiftDate' => $shiftDate]) }}"
                            class="btn btn-success">
                            <i class='bx bx-task'></i>
                        </a>
                    </div>
                </form>

            </div>
        </div>
@endif
