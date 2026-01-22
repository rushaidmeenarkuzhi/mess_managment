<?php

namespace App\Imports;

use App\Models\Item;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation ;

class ItemImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row 
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {


          return new Item([
            'item_name'    => $row['item_name'],
            'item_code'    => $row['item_code'],
            'item_qty'        => $row['item_qty'],
            'size'            => $row['size'],
            'color'            => $row['color'] 
        ]);

    }

     public function rules(): array
    {

        return [

            '*.item_code' => 'required|unique:items,item_code',
        ];
                    
    }
}
