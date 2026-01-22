<?php

namespace App\Http\Controllers;

use App\Models\PrintLog;
use App\Models\Sale;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

    
        $stock = PrintLog::join('items', 'items.id', '=', 'print_logs.item_id')
        ->select('items.item_qty',DB::raw('SUM(print_logs.sale_qty) as total_sale_qty'))->groupBy('items.item_qty')
        ->first();

        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

        $monthlySalesRaw = PrintLog::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(sale_qty) as total')
        )
        ->whereYear('created_at', Carbon::now()->year)
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->pluck('total', 'month');
       
        $monthlySales = [];

        for($i = 1; $i <= 12; $i++){

            $monthlySales[] = $monthlySalesRaw[$i] ?? 0;
        }
    
        $pieData = [
            'Stock' => $stock->item_qty ?? 0,
            'Sale'  => $stock->total_sale_qty ?? 0,
        ];
        // dd($stock) ;
        return view('home',compact('stock','months','monthlySales','pieData'));
    }

   
}
