<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GenericExport implements FromCollection, WithHeadings
{
    protected $query;
    protected $headings;

    public function __construct($query, $headings)
    {
        $this->query = $query;
        $this->headings = $headings;
    }

    public function collection()
    {
        return $this->query;
    }

    public function headings(): array
    {
        return $this->headings;
    }
}
