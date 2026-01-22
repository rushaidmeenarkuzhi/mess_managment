<?php

namespace App\Http\Controllers;

use App\Exports\SaleOrderExport;
use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Sale;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::get()->all();
        $customers = Sale::get()->all();
        return view('Report.report',compact('items','customers'));
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
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $iteId = $request->item_id;
        $customer = $request->customer;


        if($request->button == 1){
            $itemorder = Sale::reportsummary([
                'from_date'=>$fromdate,
                'to_date'=>$todate,
                'item_id'=>$iteId,
                'customer' =>$customer
            ]);

            $i = 0;
            return view('Report.report_summary')->withMaster($itemorder)->withI($i)->withPerpage(10);

        }
        if($request->button == 2){
            $itemorder = Sale::reportsummary([
                'from_date'=>$fromdate,
                'to_date'=>$todate,
                'item_id'=>$iteId,
                'customer'=>$customer
            ]);

            return Excel::download(new SaleOrderExport ($itemorder),'Sale Order Summary Report.xlsx');

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
