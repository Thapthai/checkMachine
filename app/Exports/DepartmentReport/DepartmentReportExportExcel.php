<?php

namespace App\Exports\DepartmentReport;

use App\Models\Lines;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

// class DepartmentReportExportExcel implements FromView, WithColumnWidths, WithStyles, WithTitle
class DepartmentReportExportExcel implements WithMultipleSheets

{
    private $department;
    private $startDate;
    private $endDate;


    public function __construct($department, $startDate, $endDate)
    {
        $this->department = $department;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }


    public function sheets(): array
    {
        $sheets = [];
        $lines = Lines::where('department_id', $this->department->id)->get();

        foreach ($lines as $line) {
            $sheets[] = new DepartmentLineSheetExport($this->startDate, $this->endDate, $line);
        }

        return $sheets;
    }
}
