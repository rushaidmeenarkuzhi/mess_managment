<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubExpense extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "expense_id",  
        "member_id"
    ];
    protected $table = "expense_sub";
}
