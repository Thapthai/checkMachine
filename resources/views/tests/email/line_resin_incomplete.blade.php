<div style="1080px">

    <h2>รายงานการบันทึก เรซิ่น</h2>
    <p>
    <h4><Strong>รายงานการบันทึก เรซิ่น ที่ไม่สมบูรณ์</Strong></h4>
    <h5><strong>แผนก : {{ $department->name }} | ไลน์ :
            {{ $line->name }} |
            ตั้งแต่
            {{ date('d/m/Y', strtotime('+543 year' . $since_date)) }} ถึง
            {{ date('d/m/Y', strtotime('+543 year' . $to_date)) }}</strong></h5>
    </p>
    <table style=" border-collapse: collapse;width:100%;font-size: 13px">
        <thead>
            <tr>
                <th colspan="10" class="align-center" style="text-align: center">รายงานการบันทึก เรซิ่น</th>
            </tr>
            <tr>
                <td colspan="10">วันที่ออกเอกสาร : {{ date('d/m/Y H:i:s', strtotime('+543 year')) }}</td>
            </tr>
            <tr>
                <td colspan="10"></td>
            </tr>

            <tr style="text-align: center">
                <th colspan="5" style="border: 1px solid black;height:15px;text-align: center">รายละเอียด เรซิน</th>
                <th colspan="5" style="border: 1px solid black;height:15px;text-align: center">รายการตรวจ</th>
            </tr>
            <tr>
                <th class="align-middle" style="text-align: center; border: 1px solid black;height:15px;">ตำแหน่ง</th>
                <th class="align-middle" style="text-align: center ; border: 1px solid black;height:15px;">จำนวน</th>
                <th class="align-middle" style="text-align: center ; border: 1px solid black;height:15px;">
                    ชนิดวัสดุ(Material)</th>
                <th class="align-middle" style="text-align: center ; border: 1px solid black;height:15px;">สี</th>
                <th class="align-middle" style="text-align: center ; border: 1px solid black;height:15px;">รายละเอียด
                </th>
                <th class="align-middle" style="text-align: center ; border: 1px solid black;height:15px;">ลำดับ</th>

                <th class="align-middle" style="text-align: center ; border: 1px solid black;height:15px;">กะ</th>
                <th class="align-middle" style="text-align: center ; border: 1px solid black;height:15px;">ความสะอาด
                </th>
                <th class="align-middle" style="text-align: center ; border: 1px solid black;height:15px;">สถานะ</th>
                <th class="align-middle" style="text-align: center ; border: 1px solid black;height:15px;">ซ่อม</th>
            </tr>
        </thead>
        @foreach ($resin_records->groupBy(function ($item) {
        return $item->created_at->format('Y-m-d');
    }) as $created_at => $resin_records)
            <tr>
                <td colspan="10" style="border: 1px solid black;height:15px;  ">
                    {{ date('d/m/Y', strtotime('+543 year' . $created_at)) }}</td>
            </tr>
            @foreach ($resin_records->groupBy('machine.name') as $machine_name => $machine_records)
                @php $i = 1;@endphp

                @foreach ($machine_records->groupBy('resin.position') as $resin_position => $resin_records)
                    @php
                        $resin = $resin_records->first()->resin;
                        $rowspan = count($resin_records) + 1;
                        $i = 0;
                        $j = 1;
                    @endphp
                    <tr>
                        <td rowspan="{{ $rowspan }}"
                            style="border: 1px solid black;height:15px; vertical-align: top;">
                            {{ $resin->position }}</td>
                        <td rowspan="{{ $rowspan }}"
                            style="border: 1px solid black;height:15px; vertical-align: top;">
                            {{ $resin->total_resin }}</td>
                        <td rowspan="{{ $rowspan }}"
                            style="border: 1px solid black;height:15px; vertical-align: top;">
                            {{ $resin->material }}</td>
                        <td rowspan="{{ $rowspan }}"
                            style="border: 1px solid black;height:15px; vertical-align: top;">
                            {{ $resin->color }}
                        </td>
                        <td rowspan="{{ $rowspan }}"
                            style="border: 1px solid black;height:15px; vertical-align: top;">
                            {{ $resin->detail }}</td>
                        <td colspan="5" class="align-center"
                            style="border: 1px solid black;height:15px;text-align: center">การบันทึกผล</td>
                    </tr>
                    @foreach ($resin_records->sortBy('on_shift') as $resin_record)
                        <tr>
                            @php $i++; @endphp
                            <td style="border: 1px solid black;height:15px;">{{ $j++ }}</td>

                            <td style="border: 1px solid black;height:15px;">{{ $resin_record->on_shift }}
                                {{ $resin_record->check_in }}</td>

                            <td class="align-center" style="text-align: center;border: 1px solid black;height:15px;">

                                @if ($resin_record->clean == 'NOT')
                                    X
                                @endif

                                @if ($resin_record->clean == 'pass')
                                    /
                                @endif

                            </td>
                            <td class="align-center" style="text-align: center;border: 1px solid black;height:15px;">

                                @if ($resin_record->status == 'pass')
                                    /
                                @endif

                                @if ($resin_record->status == 'NOT')
                                    X
                                @endif
                            </td>
                            <td class="align-center" style="text-align: center;border: 1px solid black;height:15px;">
                                @if (!empty($resin_record->repair_date))
                                    {{ date('d/m/Y', strtotime('+543 year' . $resin_record->repair_date)) }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            @endforeach
        @endforeach
    </table>
    <p>ขอบคุณครับ </p>
</div>
