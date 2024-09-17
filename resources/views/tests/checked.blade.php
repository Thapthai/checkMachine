<h3> <strong>ตรวจสอบแล้ว</strong></h3>
<div class="row">
    @foreach ($parts as $index => $part)
        @if (isset($part->part_records))
            @foreach ($part->part_records as $part_record)
            @endforeach
            @if ($part_record->created_at->format('Y-m-d') == date('Y-m-d'))
                <div class="col-sm-6 my-1">
                    <div class="card">
                        <div class="card-body">

                            @if (Auth::user()->is_admin == '1')
                                <a href="{{ route('checklist_plans.index', [$department_id, $machine_id, $part->id]) }}"
                                    class="btn btn-primary">เพิ่มจุดตรวจสอบ</a>

                                <a href="{{ route('part_records.index', [$department_id, $machine_id, $part->id]) }}"
                                    class="btn btn-success">แสดงข้อมูลที่ตรวจ</a>
                                <hr>
                            @endif
                            <form
                                action="{{ route('part_records.update', [$department_id, $machine_id, $part->id, $part->part_records[1]->id]) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="text-center">
                                    @if (!is_null($part->pic1))
                                        <img src="{{ url('storage', $part->pic1) }}" alt="img" width="300px"
                                            class="m-1">
                                    @else
                                    @endif
                                </div>
                                <br>
                                <strong>
                                    <h4>{{ $part->name }}</h4>
                                </strong>
                                <br>
                                @foreach ($part->part_records as $part_record)
                                    @if ($part_record->created_at->format('Y-m-d') == date('Y-m-d'))
                                        <div class="form-check">
                                            <strong>
                                                {{ $part_record->checklist_plan->checklist->id }}
                                                {{ $part_record->checklist_plan->checklist->name }}

                                                {{ $part_record->id ?? '-' }}
                                            </strong>
                                            <br><br>
                                            <input type="checkbox" name="status[{{ $part_record->id }}]"
                                                id="status[{{ $part_record->id }}][]" value="pass"
                                                @isset($part_record->status)
                                                    @if ($part_record->status == 'pass')
                                                        checked
                                                    @endif
                                                @endisset>
                                            <label>
                                                <h5>ปกติ</h5>
                                            </label>

                                            <input type="checkbox" name="status[{{ $part_record->id }}]"
                                                id="status[{{ $part_record->id }}][]" value="NOT"
                                                @isset($part_record->status)
                                                    @if ($part_record->status == 'NOT')
                                                        checked
                                                    @endif
                                                 @endisset>
                                            <label>
                                                <h5>ไม่ปกติ</h5>
                                            </label>
                                            <hr>

                                        </div>
                                    @endif
                                @endforeach

                                <label class="form-label">หมายเหตุ</label>
                                <input type="text" name="detail" class="form-control">

                                <div class="col mt-2">
                                    <div class="form-group">
                                        <strong>รูป :</strong>
                                        <input type="file" name="pic1" class="form-control" placeholder="image">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-warning mt-2 " style="width: 500px"
                                        onclick="return confirm('ต้องการแก้ไข ?')">แก้ไข</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
                </form>
            @endif
        @endif
    @endforeach
    {!! $parts->links() !!}
</div>
