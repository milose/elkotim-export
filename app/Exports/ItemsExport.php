<?php

namespace App\Exports;

use App\Item;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;

class ItemsExport implements FromCollection, WithHeadings, Responsable
{
    use Exportable;

    private $fileName;
    private $type;

    public function __construct($fileName = 'items.xlsx', $type = null)
    {
        ini_set('max_execution_time', '300');
        $this->fileName = $fileName;
        $this->type = $type;
    }

    public function collection()
    {
        $function = 7 == $this->type
                        ? 'getSevens'
                        : (
                            2 == $this->type
                            ? 'getTwos'
                            : 'getOthers'
                        );

        return Item::$function();
    }

    public function headings(): array
    {
        return [
            'ident',
            'ean',
            'supplierCode',
            'name',
            'stock',
            'price',
            'discount',
            'category',
            'subCategory',
            'brand',
            'importedFrom',
            'material',
            'description',
            'unit',
        ];
    }
}
