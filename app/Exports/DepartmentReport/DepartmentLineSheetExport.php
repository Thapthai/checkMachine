<?php

namespace App\Exports\DepartmentReport;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use Illuminate\Contracts\View\View;

class DepartmentLineSheetExport implements FromView, WithTitle, WithColumnWidths, WithStyles
{
    protected $startDate;
    protected $endDate;
    protected $line;

    public function __construct($startDate, $endDate, $line)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->line = $line;
    }
    public function title(): string
    {
        return $this->line->name;
    }

    public function view(): View
    {
        $startDate = $this->startDate;
        $endDate = $this->endDate;

        $dates = [];
        $currentDate = strtotime($startDate);

        while ($currentDate <= strtotime($endDate)) {
            $dates[] = date('Y-m-d', $currentDate);
            $currentDate = strtotime('+1 day', $currentDate);
        }

        return view('exports.departments.departmentReportExcel', [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'dates' => $dates,
            'line' => $this->line,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 11,
                ],
            ],

            'A:Z' => ['font' => ['size' => 10], 'alignment' => ['wrapText' => true]],

        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 50,
            // 'C' => 20,
            // 'D' => 10,
            // 'E' => 25,
            // 'F' => 10,
            // 'G' => 50,
            // 'H' => 10,
            // 'I' => 15,
            // 'J' => 10,
            // 'K' => 40,
            // 'L' => 40,
            // 'M' => 40,
            // 'N' => 40,
            // 'O' => 40,
            // 'P' => 40,
            // 'Q' => 4,
            // 'R' => 4,
            // 'S' => 4,
            // 'T' => 4,
            // 'U' => 4,
            // 'V' => 4,
            // 'W' => 4,
            // 'X' => 4,
            // 'Y' => 4,
            // 'Z' => 4,
        ];
    }
}
