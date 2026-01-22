<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SaleOrderExport implements FromCollection,WithHeadings,ShouldAutoSize,WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
     public function __construct($itemorder)
    {
        $this->itemorder = $itemorder;
    }

     public function headings():array{
        return[
    
            'SI.No',
            'Customer Name',
            'Item Name',
            'Item Crrent Qty',
            'Sale Qty',
            'Size',
            'Color',
            'Price',
            'Status',
            'Total Amount'
            
        ];
    
    
    }


    public function registerEvents(): array
        {
            return [
                AfterSheet::class    => function(AfterSheet $event) {
                    $cellRange = 'A1:J1';
                    $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
                    $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
                },
            ];
        }

    public  function  styles(Worksheet $sheet)
        {
            $sheet->getStyle('1')->getFont()->setBold(true);
    
            $sheet->getStyle('A1:J1')->applyFromArray([
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => "FFaeaaaa"]
                ]
            ]);
        }


   public function collection()
        {
            $data=$this->itemorder;
            $arr=[];
        
            $i=1;
            $totalSaleQty = 0;
            $grandTotal   = 0;

            foreach ($data as $dat){
            
                
                $totalSaleQty += $dat->sale_qty;
                $grandTotal   += $dat->total_amount;

                $datas['Slno']=$i;
                $datas['Customer Name']=$dat->customer_name;
                $datas['Item Name']=$dat->item_name;
                $datas['Item Crrent Qty']=$dat->item_qty;
                $datas['Sale Qty']=$dat->sale_qty;
                $datas['Size']=$dat->size;
                $datas['Color']=$dat->color;
                $datas['Price']=$dat->price;
                $datas['Status']=$dat->status == 1 ? 'Wholesale' : ($dat->status ==2 ? 'Retail' : '');
                $datas['Total Amount']=$dat->total_amount;
                $arr[$i]=$datas;
                $i++;

            }
 
              if ($i > 1) {
                $arr[] = [
                    'Slno'             => '',
                    'Customer Name'    => '',
                    'Item Name'        => 'Grand TOTAL',
                    'Item Crrent Qty'  => '',
                    'Sale Qty'         => $totalSaleQty,
                    'Size'             => '',
                    'Color'            => '',
                    'Price'            => '',
                    'Status'           => '',
                    'Total Amount'     => $grandTotal,
                ];
            }

             
            return collect($arr);
        }

}
