<?php


namespace Tofaha\Helper\TofahaTables;


use Maatwebsite\Excel\Concerns\FromArray;

class ExcelExporter implements FromArray
{
    protected  $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function array() : array
    {
        return  $this->data;
    }
}
