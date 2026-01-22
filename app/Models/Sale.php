<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sale extends Model
{
    use HasFactory;
    protected $table = "sales";
    protected $fillable = [
        "order_no",
        "customer_name",
        "address",
        "mob_no",
        "status",
        "user_id",
    ];


     public static function reportsummary($filters = array()) 
     {
        // dd(2345);
         $item = (new Item())->getTable(); 
         $orderitem = (new Sale())->getTable(); 
         $suborderitem = (new PrintLog())->getTable(); 
         $user = (new User)->getTable(); 

          $orders = Sale::select("$item.item_qty","$item.item_name","$orderitem.order_no","$orderitem.status","$orderitem.customer_name","$orderitem.mob_no","$suborderitem.item_id",
                                 "$suborderitem.sale_qty", "$suborderitem.color","$suborderitem.size", "$suborderitem.price","$suborderitem.total_amount",DB::raw('SUM(print_logs.sale_qty) as total_sale_qty'),DB::raw('SUM(print_logs.total_amount) as total_quantity '), "$user.name")
                    ->leftJoin($suborderitem, "$orderitem.id", '=',"$suborderitem.order_id")
                     ->leftJoin($item, "$item.id", '=',"$suborderitem.item_id")
                    ->leftJoin($user, "$user.id", '=',"$orderitem.user_id")
                    ->groupBy('items.item_qty','items.item_name','sales.order_no','sales.status','sales.customer_name','sales.mob_no',
                              'print_logs.item_id','print_logs.sale_qty','print_logs.color','print_logs.size','print_logs.price','print_logs.total_amount','users.name');
//   dd($orders);
                    
                 if($filters['from_date']) $orders = $orders->where("$orderitem.created_at", '>=', date($filters['from_date']));
                 if($filters['to_date']) $orders = $orders->where("$orderitem.created_at", '<=', date($filters['to_date']));
                 if($filters['item_id']) $orders = $orders->where("$item.item_name", '=', $filters['item_id']);
                 if($filters['customer']) $orders = $orders->where("$orderitem.customer_name", '=', $filters['customer']);

        return $orders->get();
     }
}
