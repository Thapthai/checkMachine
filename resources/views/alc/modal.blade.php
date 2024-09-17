<!-- The Create Standard Modal -->
<div class="modal" id="create-standard">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"> เพิ่ม Standard</h4>
                <button type="button" class="btn close" data-dismiss="modal">X</button>
            </div>

            <form action="{{ route('alc_standard_store', [$onshift, $shiftDate]) }}" method="POST">
                @csrf
                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="department">ไลน์ผลิต</label>
                        <select class="form-select" id="department" name="line_id">
                            @foreach ($lines as $line)
                                <option value="{{ $line->id }}">{{ $line->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label>ส่วนงาน</label>
                    <input type="text" name="name" class="form-control">

                    <label>ชนิด</label>
                    <select name="type" class="form-select">
                        <option value="Alc">แอลกอฮอล์</option>
                        <option value="Cl">คลอรีน</option>

                    </select>

                    <label>จำนวน</label>
                    <input type="number" name="quantity" class="form-control" value="1" required>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">บันทึก</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

                </div>
            </form>

        </div>
    </div>
</div>


<!-- The Usage Modal -->
<div class="modal" id="usage">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"> บันทึกการเบิก</h4>
                <button type="button" class="btn close" data-dismiss="modal">X</button>
            </div>

            <form action="{{ route('alc_usage.store', [$department_id, $onshift, $selected, $shiftDate]) }}"
                method="POST">
                @csrf
                <!-- Modal Body -->
                <div class="modal-body">

                    <label>Standard</label>
                    <select name="alc_standard_id" class="form-select">
                        @foreach ($alc_standards_selects as $alc_standards_select)
                            <option value="{{ $alc_standards_select->id }}">{{ $alc_standards_select->type }} , แผนก:
                                {{ $alc_standards_select->department->name }}, ไลน์:
                                {{ $alc_standards_select->line->name }},
                                {{ $alc_standards_select->name }} , {{ $alc_standards_select->quantity }} </option>
                        @endforeach
                    </select>

                    <label>จำนวนที่เบิก</label>

                    <input type="number" name="used_quantity" class="form-control" id="selectedCountDisplay" required>

                    <div class="modal-box">
                        <div class="sd-multiSelect form-group">
                            <label for="current-job-role">เลือกขวด</label>
                            <select multiple="multiple" class="select_bottles form-control " name="alc_bottle_select[]"
                                required>
                                <option value="all">all</option>
                                @foreach ($alc_bottles as $alc_bottle_id => $alc_bottle_name)
                                    <option value="{{ $alc_bottle_id }}">{{ $alc_bottle_id }} - {{ $alc_bottle_name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">จ่ายออก</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
