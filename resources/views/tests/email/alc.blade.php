<div style="1080px">

    <h2>รายงานการบันทึก แอลกอฮอล์ และ คลอรีน</h2>
    <p>
    <h4><Strong>รายงานการบันทึก แอลกอฮอล์ และ คลอรีน</Strong></h4>
    <h5><strong>แผนก : {{ $department->name }}
            ตั้งแต่
            {{ date('d/m/Y', strtotime('+543 year' . $since_date)) }} ถึง
            {{ date('d/m/Y', strtotime('+543 year' . $to_date)) }}</strong></h5>
    </p>
    <table style="border-collapse: collapse;width:100%;font-size: 13px">
        <tr>
            <th colspan="8" style="height: 30px;border: 1px solid black;"> แผนก {{ $department_name }}</th>
        </tr>
        <tr>
            <th style="text-align: center;border: 1px solid black;">ไลน์</th>
            <th style="text-align: center;border: 1px solid black;">ส่วนงาน</th>
            <th style="text-align: center;border: 1px solid black;">จำนวนที่กำหนด</th>
            <th style="text-align: center">จำนวนที่เบิก</th>
            <th colspan="2" style="text-align: center;border: 1px solid black;">จำนวนที่ใช้งาน</th>
            <th colspan="2" style="text-align: center;border: 1px solid black;">จำนวนที่เสียหาย</th>

        </tr>

        @foreach ($alc_usages->groupBy('shift_date') as $shift_date => $alc_usages)
            <tr>
                <th colspan="8" style="border: 1px solid black;">กะ {{ date('d F Y', strtotime($shift_date)) }}</th>
            </tr>
            @foreach ($alc_usages->groupBy('on_shift') as $on_shift => $alc_usages)
                <tr>
                    <th colspan="8" style="text-align: center;border: 1px solid black;">กะ {{ $on_shift }}</th>
                </tr>

                @foreach ($alc_usages as $alc_usage)
                    @if ($alc_usage->alc_checkings->count() > 0)
                        @foreach ($alc_usage->alc_checkings as $alc_checking)
                            <tr>
                                <td style="vertical-align: top;border: 1px solid black;">
                                    {{ $alc_usage->alc_standard->name ?? '-' }}</td>
                                <td style="vertical-align: top;border: 1px solid black;">
                                    {{ $alc_usage->alc_standard->line->name ?? '-' }}</td>
                                <td style="vertical-align: top;border: 1px solid black;">
                                    {{ $alc_usage->alc_standard->quantity ?? '-' }} ขวด</td>

                                <td style="vertical-align: top;border: 1px solid black;">
                                    {{ $alc_usage->used_quantity ?? '-' }} ขวด
                                </td>
                                <td style="vertical-align: top;border: 1px solid black;">
                                    {{ $alc_checking->quantity_alc_usage ?? '-' }} ขวด</td>

                                <td style="vertical-align: top;border: 1px solid black;">
                                    หมายเลขขวด / ชนิด
                                    @foreach ($alc_checking->alc_normals as $alc_normal)
                                        {{ $alc_normal->alc_usage_bottle->alc_bottle->bottle_no ?? '-' }}/
                                        {{ $alc_normal->alc_usage_bottle->alc_bottle->type ?? '-' }} : <br>
                                    @endforeach

                                </td>


                                @if (count($alc_checking->alc_brokeds) > 0)
                                    <td style="vertical-align: top;border: 1px solid black;">
                                        {{ $alc_checking->quantity_alc_broked }} ขวด</td>
                                    <td style="vertical-align: top;border: 1px solid black;">
                                        หมายเลขขวด | ชนิด : รายละเอียด
                                        @foreach ($alc_checking->alc_brokeds as $alc_broked)
                                            {{ $alc_broked->alc_usage_bottle->alc_bottle->bottle_no ?? '-' }}/
                                            {{ $alc_broked->alc_usage_bottle->alc_bottle->type ?? '-' }} :
                                            {{ $alc_broked->detail }}
                                            <br>
                                        @endforeach

                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                @endforeach
            @endforeach
        @endforeach

    </table>

    <p>ขอบคุณครับ </p>
</div>
