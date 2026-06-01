<?php

namespace App\Http\Controllers;

use App\Exports\SaleOrderExport;
use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Item;
use App\Models\Member;
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
        $members = Member::where('status', 'active')->get();        
        return view('Report.report',compact('members'));
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
        $fromdate = $request->fromdate;
        $todate = $request->todate;
        $members = $request->member_name;
        $expensetype = $request->exp_type;

        if($request->button == 1){
            $data = Expense::reportsummary([
                'from_date'=>$fromdate,
                'to_date'=>$todate,
                'member_name'=>$members,
                'exp_type'=>$expensetype,
            ]);
            // dd($data);

            $i = 0;
            // dd($i);
            return view('Report.report_summary', ['master' => $data['report'], 'grandTotal' => $data['grandTotal'],'i'=> $i ]);
            return view('Report.report_summary', ['master' => $data['report'],'i'=> $i ]);
            // return view('Report.report_summary')->withMaster($expense)->withI($i)->withPerpage(10);

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
