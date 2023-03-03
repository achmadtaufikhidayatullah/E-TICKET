<?php

namespace App\Exports;

use App\Models\EventBatch;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BatchExport implements FromView , withTitle , ShouldAutoSize , WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $bookedTickets;
    protected $batch;

    function __construct($bookedTickets , $batch) {
      $this->bookedTickets = $bookedTickets;
      $this->batch = $batch;
    }

    public function view(): View
    {
         $data = $this->bookedTickets;
         return view('backEnd.report.excel', compact('data'));
    }

    public function title(): string
    {
        return $this->batch->name;
    }

     public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:M1')->getFont()->setBold(true);
    }
}
