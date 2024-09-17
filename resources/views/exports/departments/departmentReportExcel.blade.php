<table>
    <tr>
        <td colspan="2">ไลน์ผลิต: {{ $line->name }}</td>
        @foreach ($dates as $date)
            <td style="width: 300px">{{ $date }}</td>
        @endforeach
    </tr>
    @foreach ($line->machines as $machine)
        @php
            $filteredResins = $machine->resins->filter(function ($resin) use ($startDate, $endDate) {
                // กรอง schedule_records ตามช่วงวันที่ที่ต้องการ
                $scheduleRecords = $resin->schedule_records->whereBetween('shift_date', [$startDate, $endDate]);

                // ตรวจสอบว่ามี schedule_records ที่ผ่านเงื่อนไข
                return $scheduleRecords->isNotEmpty();
            });
        @endphp
        <tr>
            <th>เครื่องจักร</th>
            <th>เรซิ่น</th>
            <th colspan="{{ count($dates) }}" class="text-center">ผลตรวจ</th>

        </tr>
        <tr>
            <td rowspan="{{ count($filteredResins) + 1 }}">{{ $machine->name }}</td>
        </tr>

        @foreach ($filteredResins as $filteredResin)
            <tr>
                <td>{{ $filteredResin->position }}</td>


                @foreach ($dates as $date)
                    @php
                        $schedule_records = $filteredResin->schedule_records->where('shift_date', $date);

                    @endphp

                    @if (count($schedule_records) > 0)
                        <td>
                            @foreach ($schedule_records->groupBy('on_shift') as $shift => $schedule_records)
                                <p>
                                    @if ($shift != 'all day')
                                        {{ $shift }} :
                                    @endif
                                    @foreach ($schedule_records as $schedule_record)
                                        @if ($schedule_record->clean == 'notuse')
                                            ไม่ได้ใช้งาน
                                        @else
                                            @switch($schedule_record->clean)
                                                @case('pass')
                                                    ความสะอาด ผ่าน ,
                                                @break

                                                @case('NOT')
                                                    ความสะอาด ไม่ผ่าน ,
                                                @break

                                                @default
                                            @endswitch

                                            @switch($schedule_record->complete)
                                                @case('pass')
                                                    ความสมบูรณ์ ผ่าน
                                                @break

                                                @case('NOT')
                                                    ความสมบูรณ์ ผ่าน
                                                @break

                                                @default
                                            @endswitch
                                        @endif
                                    @endforeach
                                </p>
                            @endforeach
                        </td>
                    @else
                        <td></td>
                    @endif
                @endforeach
            </tr>
        @endforeach
    @endforeach

</table>
