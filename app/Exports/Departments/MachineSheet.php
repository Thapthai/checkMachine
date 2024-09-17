<?php

namespace App\Exports\Departments;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Illuminate\Contracts\View\View;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;

class MachineSheet implements FromView, WithDrawings, WithColumnWidths, WithStyles, WithTitle
{
    private $line;

    public function __construct($line)
    {
        $this->line = $line;
    }
    public function title(): string
    {
        return 'ไลน์-' . $this->line->name; // ชื่อของ sheet
    }

    public function view(): View
    {
        return view('exports.department.exportData.machineData', [
            'line' => $this->line
        ]);
    }

    public function drawings()
    {
        $drawings = [];
        $rowNumber = 3; // Start after the header row

        foreach ($this->line->machines as $machine) {
            if (count($machine->resins) > 0) {

                foreach ($machine->resins as $resin) {
                    if ($resin->pic1) {
                        $imagePath = public_path('storage/' . $resin->pic1);
                        if (file_exists($imagePath)) {
                            $drawing = new Drawing();
                            $drawing->setName($resin->position);
                            $drawing->setDescription($resin->detail ?? '');
                            $drawing->setPath($imagePath);
                            $drawing->setHeight(150);
                            $drawing->setCoordinates('G' . $rowNumber);

                            // Ensure image is centered within the cell
                            $drawing->setOffsetX(5); // Adjust horizontal offset as needed
                            $drawing->setOffsetY(5); // Adjust vertical offset as needed

                            $drawings[] = $drawing;
                        }
                    }
                    $rowNumber++; // Increment row number for each resin
                }
            }
            $rowNumber++; // Increment row number for each machine
        }


        return $drawings;
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
            'B' => 30,
            'C' => 20,
            'D' => 10,
            'E' => 25,
            'F' => 10,
            'G' => 50,
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
