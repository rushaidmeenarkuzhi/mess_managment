<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\PrintLog;
use App\Models\Sale;
use Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $latestOrder = Sale::orderBy('id', 'desc')->first();
        if($latestOrder &&  $latestOrder->order_no){
            $lastNumber = (int) str_replace('RR', '' , $latestOrder->order_no);
            $newNumber = $lastNumber + 1;
        }else{
            $newNumber = 1;
        }
    
        $orderNo = 'RR' . str_pad($newNumber, 5, '0', STR_PAD_LEFT); $newNumber;
        // dd($orderNo);
        $itemcode = Item::select('id','item_code','item_name','item_qty')->get();
        // dd($itemcode);
        return view('Master.sales',compact('itemcode','orderNo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

          $request->validate([
            'customer_name'    => 'required',

        ]);

        DB::beginTransaction();
      
        try {

        
         $latestOrder = Sale::orderBy('id', 'desc')->first();
         if ($latestOrder && $latestOrder->order_no) {
            $lastNumber = (int) str_replace('RR', '', $latestOrder->order_no);
            $newNumber = $lastNumber + 1;
        }  else {
            $newNumber = 1; 
        }
        $orderNo = 'RR' . str_pad($newNumber, 5, '0', STR_PAD_LEFT); $newNumber;
        
        $user = Auth::user()->id;
       
        $sale = new Sale([
            'order_no'      => $orderNo,
            'customer_name' => $request->customer_name,
            'mob_no'        => $request->mob_no,
            'status'        => $request->status,
            'address'        => $request->address,
            'user_id'          => $user,
        ]);
        // dd($sale);
        $sale->save();

        // dd($sale);
        
        // dd($count);

      
     
        for ($i = 0; $i < count($request->item_id); $i++) {

         $saleQty = (int) $request->sale_qty[$i];
         $item = Item::where('id',$request->item_id[$i])->lockForUpdate()->first();
    //    dd($item);
        
         if ($item->item_qty < $saleQty) {
                Alert::toast('Insufficient stock for item', 'error')->autoClose(3000);
                return redirect()->route('sales.index');
            }

            $item->item_qty = $item->item_qty - $saleQty;
            $item->save();

            $saleordersub = new PrintLog([
                'order_id' => $sale->id,
                'item_id' => $request->item_id[$i],
                'sale_qty' => $saleQty,
                'color' => $request->color[$i],
                'size' => $request->size[$i],
                'price' => $request->price[$i],
                'total_amount' => $request->total_amount[$i],
            ]);
            // dd($saleordersub);

            $saleordersub->save();   
        }
         DB::commit();


        if($request->action_type === 'print'){

            // dd($sale->id);
            return redirect()->route('sales.show',$sale->id);
        }

          return back()->with('success','Saved Successfully');
        
      }  catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', $e->getMessage());
    }
    }

    public function printview()
    {
        return view('print.sale_print');
    }

    // public function print($id)
    // {
        
    // }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //   dd($id);
         $sale = Sale::findOrFail($id);

         $data = Sale::select('items.item_name','sales.customer_name','sales.user_id','sales.order_no','sales.mob_no','sales.status','print_logs.item_id','print_logs.sale_qty','print_logs.price',
                             'print_logs.total_amount','print_logs.color','print_logs.size')
                      ->Join('print_logs', 'print_logs.order_id', '=', 'sales.id')
                      ->Join('items', 'items.id', '=', 'print_logs.item_id')
                      ->Join('users', 'sales.user_id', '=', 'users.id')
                      ->where('sales.id',$id)->get();
                    //   dd($data);

            return view('print.sale_print',compact('data','sale'));
      
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
