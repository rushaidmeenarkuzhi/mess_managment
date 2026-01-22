<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintLog extends Model
{
    use HasFactory;
    protected $table = "print_logs";
    
    protected $fillable = [
        'order_id',
        'item_id',
        'sale_qty',
        'gst',
        'color',
        'size',
        'price',
        'total_amount',
        'discount'
    ];
}
