<table>
    <tr>
        <th colspan="6" style="border: 1px solid black;height:25px;text-align: center">แผนก {{ $department->name }}
        </th>
    </tr>

    @foreach ($department->lines as $line)
        <tr>
            <th rowspan="{{ count($line->machines) + 1 }}"
                style="vertical-align:top;border: 1px solid black;height:25px;text-align: center">ไลน์ ผลิต
                {{ $line->name }}</th>
            @if (count($line->machines) > 0)
                <td style="border: 1px solid black;height:25px;text-align: center">ชื่อเครื่องจักร</td>
                <td style="border: 1px solid black;height:25px;text-align: center" colspan="4">รายละเอียด</td>
                <td style="border: 1px solid black;height:25px;text-align: center">รูปภาพเครื่องจักร</td>

            @else
                <th colspan="5"
                    style="color:brown;text-align: center;border: 1px solid black;height:25px;text-align: center">
                    ไม่มีข้อมูล เครื่องจักร</th>
            @endif

        </tr>
        @foreach ($line->machines as $machine)
            <tr>
                <th style="border: 1px solid black;height:160px;text-align: center"> {{ $machine->name }}</th>
                <th style="border: 1px solid black;height:160px;text-align: center" colspan="4">
                    {{ $machine->detail }}
                </th>
            </tr>
        @endforeach
    @endforeach
    <tr>
        <td colspan="6" style="height:30px;text-align: center"></td>
    </tr>

    <tr>
        <th colspan="6" style="border: 1px solid black;height:25px;text-align: center">เครื่องจักร</th>
    </tr>

    @foreach ($department->lines as $line)
        @foreach ($line->machines as $machine)
            <tr>
                <th rowspan="{{ count($machine->resins) + 1 }}"
                    style="vertical-align: top;border: 1px solid black;height:25px;text-align: center">
                    {{ $machine->name }}</th>
                @if (count($machine->resins) > 0)
                    <th style="border: 1px solid black;height:25px;text-align: center">ตำแหน่ง</th>
                    <th style="border: 1px solid black;height:25px;text-align: center">รายละเอียด</th>
                    <th style="border: 1px solid black;height:25px;text-align: center">จำนวน</th>
                    <th style="border: 1px solid black;height:25px;text-align: center">วัสดุ</th>
                    <th style="border: 1px solid black;height:25px;text-align: center">สี</th>
                @else
                    <th colspan="5"
                        style="color:brown;text-align: center;border: 1px solid black;height:25px;text-align: center">
                        ไม่มีข้อมูล Resin</th>
                @endif

            </tr>
            @if (count($machine->resins) > 0)
                @foreach ($machine->resins as $resin)
                    <tr>
                        <th style="border: 1px solid black;height:25px;text-align: center">{{ $resin->position ?? '-' }}
                        </th>
                        <th style="border: 1px solid black;height:25px;text-align: center">{{ $resin->detail ?? '-' }}
                        </th>
                        <th style="border: 1px solid black;height:25px;text-align: center">
                            {{ $resin->total_resin ?? '-' }}</th>
                        <th style="border: 1px solid black;height:25px;text-align: center">
                            {{ $resin->material ?? '-' }}</th>
                        <th style="border: 1px solid black;height:25px;text-align: center">{{ $resin->color ?? '-' }}
                        </th>
                    </tr>
                @endforeach
            @endif
        @endforeach
    @endforeach


</table>
