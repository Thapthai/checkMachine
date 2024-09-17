<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>รายงานแผนก</title>
    <style>
        #lines {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #lines td,
        #lines th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #lines tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #lines tr:hover {
            background-color: #ddd;
        }

        #lines th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
            text-align: center;
        }
    </style>
</head>

<body>

    <h1>รายงานของแผนก: {{ $department->name }}</h1>
    <h3>วันที่: {{ date('d/m/Y', strtotime($date)) }}</h3>

    <table id="lines" style="width: 1000px">
        <tr>
            <th rowspan="2">
                <h4>ไลน์ผลิต</h4>
            </th>
            <th colspan="3">
                <h4>ผลสรุป</h4>
            </th>
        </tr>
        <tr>
            <th>ตรวจสอบ</th>
            <th>ไม่ใช้งาน</th>

            <th>รวม</th>

        </tr>


        @foreach ($lines as $line)
            @if (count($line->schedulePlans) > 0)
                @php
                    $schedulePlans = $line->schedulePlans->where('frequency_check_id', 1);
                    $schedulePlansRecord = $schedulePlans->filter(function ($schedulePlan) use ($date) {
                        return $schedulePlan->ScheduleRecords->contains(function ($scheduleRecord) use ($date) {
                            return $scheduleRecord->shift_date == $date && $scheduleRecord->detail != 'notuse';
                        });
                    });

                    $schedulePlansRecordNotUse = $schedulePlans->filter(function ($schedulePlan) use ($date) {
                        return $schedulePlan->ScheduleRecords->contains(function ($scheduleRecord) use ($date) {
                            return $scheduleRecord->shift_date == $date && $scheduleRecord->detail == 'notuse';
                        });
                    });

                    $checkingRecordCount = count($schedulePlansRecordNotUse) + count($schedulePlansRecord);

                @endphp
                <tr>
                    <td>
                        {{ $line->name }}
                    </td>
                    <td style="width: 100px">
                        {{ count($schedulePlansRecord) }} /
                        {{ count($schedulePlans) }}
                    </td>
                    <td style="width: 100px">
                        {{ count($schedulePlansRecordNotUse) }} /
                        {{ count($schedulePlans) }}
                    </td>
                    <td style="width: 100px">
                        {{ $checkingRecordCount }} /
                        {{ count($schedulePlans) }}
                    </td>
                </tr>
            @else
                <tr>
                    <td>
                        {{ $line->name }}
                    </td>
                    <td>{{ $line->name }} ไม่ได้กำหนดแผนการตรวจ
                    </td>
                </tr>
            @endif
        @endforeach
    </table>

    <a href="{{ route('admin.department.reports.exportExcel.download', [$department->id, $date, $date]) }}">
        <h2>ดาวโหลดไฟล์</h2>
    </a>
    <hr>
    <h4>
        ขอบคุณครับ <br>
        แผนก เทคโนโลยีสารสนเทศ (IT)
    </h4>
</body>

</html>
