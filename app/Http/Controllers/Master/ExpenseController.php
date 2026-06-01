<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Member;
use App\Models\SubExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $i = 0;
        $expenses = Expense::Join('members','expenses.paid_by', '=', 'members.id')
                             ->select('expenses.*','members.member_name')
                             ->whereNull('expenses.deleted_at')->get();
        
        return view('Master.expense',['i' => $i, 'expenses' => $expenses]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $members = Member::where('status', 'active')->get();
        $allmembers = Member::all();
        // dd($allmembers);
        // dd($members);
        return view('Master.create_expense',compact('members','allmembers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      try {

            DB::beginTransaction();
            
            // dd($request->all());
            $this->validate($request,[
                'exp_type' => 'required'
            ]);

        


            $fileName = null;
            if($request->hasFile('bill_file')){
                 $file = $request->file('bill_file');
                 $fileName = time() . '.' . $file->getClientOriginalExtension();
                 $file->move(public_path('uploads/bills'), $fileName);
             }
            // dd($fileName);
        if($request->exp_type == 'daily_expense'){
             $status = 1;
        }else{
             $status = 2;
        }

         $expense = new Expense([
            'exp_type' => $request->get('exp_type'),
             'amount'     => $request->get('amount'),
             'paid_by'  => $request->get('paid_by'),
             'date'       => $request->get('date'),
             'bill_file'  => $fileName, 
             'description' => $request->get('description'),
             'status'      => $status      
         ]);
        //  dd($expense);
         $expense->save();
        //  dd($expense);
        // dd($request->member_ids);
        // dd($expense->id);
     if($request->member_ids){
        // dd(123);
          foreach ($request->member_ids as $memberid){
              $expensesub = new SubExpense([
                 'expense_id' => $expense->id,
                 'member_id' => $memberid

              ]);
            $expensesub->save();
        }
     }
        
         
        DB::commit();

         return redirect()->route('expense.index')->with('success','Expense Added SuccessFully');

      } catch(\Exception $e){
       
        DB::rollBack();

        return back()->with('error', $e->getMessage());

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
        $expense = Expense::where('expenses.id', $id)
                            ->Join('members', 'expenses.paid_by', '=', 'members.id')
                            ->select('expenses.*', 'members.member_name')->first();
                            // dd($expense);
        $members = Member::where('status', 'active')->get();
         $allmembers = Member::all();
      
        return view('Master.create_expense',compact('expense','members','allmembers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    try {
        DB::beginTransaction();

         $this->validate($request,[
                    'exp_type' => 'required'
                ]);

       

        $expense = Expense::findOrFail($id);
    //   dd($expense);
        $fileName = $expense->bill_file;
        if($request->hasFile('bill_file')) {
             if($expense->bill_file && file_exists(public_path('uploads/bills/' . $expense->bill_file))) {
            unlink(public_path('uploads/bills/' . $expense->bill_file));
             }
           $file = $request->file('bill_file');
           $fileName = time() . '.' . $file->getClientOriginalExtension();
           $file->move(public_path('uploads/bills'), $fileName);
        }
        $expense->exp_type = $request->exp_type;
        $expense->amount = $request->amount;
        $expense->member_id = $request->member_id;
        $expense->date = $request->date;
        $expense->bill_file = $fileName;
        $expense->description = $request->description;
        // dd($expense);
        $expense->save();

        

        DB::commit();

       return redirect()->route('expense.index')->with('success','Expense Updated SuccessFully');


     }catch(\Exception $e){
       
        DB::rollBack();

        return back()->with('error', $e->getMessage());

      }
        
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $expense = Expense::find($id);
        $result = $expense->delete();
        if($result){
            return redirect()->route('expense.index')->with('success', 'Expense Deleted Successfully');
        }
    }
}
