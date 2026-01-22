<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionSub extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "transaction_sub";
    protected $fillable = [
        'transaction_id',
        'item_id',
        'price',
        'quantity',
        'total_price',
        'status'
    ];
}
