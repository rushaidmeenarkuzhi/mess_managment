<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Expense extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
       "exp_type",
        "amount",
        "paid_by",
        "date",
        "bill_file",
        "description",
        "status"
    ];


   public static function reportsummaryddd ($filters =  [])
{
    $members = Member::all();

    $from = $filters['from_date'] ?? null;
    $to = $filters['to_date'] ?? null;

    // -------------------------
    // PRE-CALCULATE DAILY TOTAL
    // -------------------------
    $dailyTotal = Expense::where('status', 1)
        ->when($from, fn($q) => $q->whereDate('date', '>=', $from))
        ->when($to, fn($q) => $q->whereDate('date', '<=', $to))
        ->sum('amount');

    $activeMembers = $members->where('status', 'active')->count();

    // -------------------------
    // PRE-CALCULATE ROOM RENT MAP
    // -------------------------
    $rentMap = [];

    $roomExpenses = Expense::where('status', 2)
        ->when($from, fn($q) => $q->whereDate('date', '>=', $from))
        ->when($to, fn($q) => $q->whereDate('date', '<=', $to))
        ->get();

    foreach ($roomExpenses as $expense) {

        $subMembers = SubExpense::where('expense_id', $expense->id)->count();

        if ($subMembers > 0) {
            $share = $expense->amount / $subMembers;

            $subs = SubExpense::where('expense_id', $expense->id)->pluck('member_id');

            foreach ($subs as $mid) {
                $rentMap[$mid] = ($rentMap[$mid] ?? 0) + $share;
            }
        }
    }

    // -------------------------
    // FINAL REPORT
    // -------------------------
    $report = collect();

    foreach ($members as $member) {

        // Paid Amount
        $paidAmount = Expense::where('paid_by', $member->id)
            ->when($from, fn($q) => $q->whereDate('date', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('date', '<=', $to))
            ->sum('amount');

        // Daily share
        $dailyShare = 0;
        if ($member->status == 'active' && $activeMembers > 0) {
            $dailyShare = $dailyTotal / $activeMembers;
        }

        // Rent share from precomputed map
        $rentShare = $rentMap[$member->id] ?? 0;

        $totalShare = $dailyShare + $rentShare;

        $report->push((object)[
            'member_name' => $member->member_name,
            'paid_amount' => $paidAmount,
            'daily_share' => round($dailyShare, 2),
            'rent_share' => round($rentShare, 2),
            'total_share' => round($totalShare, 2),
            'balance' => round($paidAmount - $totalShare, 2),
            'status' => $member->status
        ]);
    }

    return [
        'report' => $report
    ];
}


 public static function reportsummary($filters = array())
    {
        //  dd(4567);
        

         $memberCount = Member::all();
        //  dd($memberCount);

        // $dailyTotal = Expense::where('status', 1)->sum('amount');
        $dailyExpense = Expense::where('status', 1);

           if($filters['from_date']) $dailyExpense = $dailyExpense->whereDate('created_at', '>=', date($filters['from_date']));
           if($filters['to_date']) $dailyExpense = $dailyExpense->whereDate('created_at', '<=', date($filters['to_date']));
           if($filters['exp_type']) $dailyExpense = $dailyExpense->where('exp_type', '=', $filters['exp_type']);
        
        $dailyTotal = $dailyExpense->sum('amount');
        // dd($dailyTotal);

        $activeMembers = $memberCount->where('status', 'active')->count();
        // dd($activeMembers);
        

         
        $otherexpense = Expense::where('status', 2);
        // dd($otherexpense);

           if($filters['from_date']) $otherexpense = $otherexpense->whereDate('created_at', '>=', date($filters['from_date']));
           if($filters['to_date']) $otherexpense = $otherexpense->whereDate('created_at', '<=', date($filters['to_date']));
           if($filters['exp_type']) $otherexpense = $otherexpense->where('exp_type', '=', $filters['exp_type']);
        
         $otherexpense = $otherexpense->get();
        //  dd($otherexpense);
        $otherMap = [];

        foreach($otherexpense as $expense){
            $submembrs = SubExpense::where('expense_id',$expense->id)->count();
            // dd($submembrs);
            // dd($expense->amount);
            if($submembrs > 0) {
                $share = $expense->amount / $submembrs;
                // dd($share);
                
                $subs = SubExpense::where('expense_id', $expense->id)->pluck('member_id');
            //    dd($subs);

            foreach ($subs as $mid) {
                $otherMap[$mid] = ($otherMap[$mid] ?? 0) + $share;
                // dd($otherMap[$mid]);

            }
               
            }
        }

        // FINAL REPORT

           $expensereport = collect();
            // dd($report);
            foreach ($memberCount as $member) {

                if (!empty($filters['exp_type']) && $filters['exp_type'] == 'daily_expense') {
                    if ($member->status != 'active') {
                        continue;
                    }
                }

               $paidQuery = Expense::where('paid_by', $member->id);
            //    dd($paidQuery);

                if($filters['from_date']) $paidQuery = $paidQuery->whereDate('created_at', '>=', $filters['from_date']);
                if($filters['to_date']) $paidQuery = $paidQuery->whereDate('created_at', '<=', $filters['to_date']);
                if($filters['exp_type']) $paidQuery = $paidQuery->where('exp_type', '=', $filters['exp_type']);
                
                // Paid Amount
                $paidAmount = $paidQuery->sum('amount');
                //  dd($paidAmount);
                // Daily share
                $dailyShare = 0;
                if ($member->status == 'active' && $activeMembers > 0) {
                    $dailyShare = $dailyTotal / $activeMembers;
                    // dd($dailyShare);
                } 

                // Other share from precomputed map
                $otherShare = $otherMap[$member->id] ?? 0;
                // dd($otherShare);
            
                $totalShare = $dailyShare + $otherShare;
                // dd($totalShare);
                $expensereport->push((object)[
                    'member_name' => $member->member_name,
                    'paid_amount' => $paidAmount,
                    'daily_share' => round($dailyShare, 2),
                    'other_share' => round($otherShare, 2),
                    'total_share' => round($totalShare, 2),
                    'balance' => round($paidAmount - $totalShare, 2),
                    'status' => $member->status
                ]);
            }


        //  dd($expensereport);  
        
        $grandTotal = $expensereport->sum('paid_amount');
       

        // dd($grandTotal);
       return [
        'report' => $expensereport,
        'grandTotal' => $grandTotal
    ];


    }

    // public static function reportsummary($filters = array())
    // {
    //     //  dd(4567);
    //      $expense = (new Expense())->getTable();
    //      $members = (new Member())->getTable();
    //      $subexpense = (new SubExpense())->getTable();

    //      $memberCount = Member::count();
    //     //  dd($memberCount);

    //      $expensereport = Expense::select("$members.member_name",DB::raw('SUM(expenses.amount) as total_amount'))
    //                                ->leftJoin($members, "$members.id", '=', "$expense.paid_by")
    //                                ->leftJoin($subexpense, "$expense.paid_by", '=', "$subexpense.id")
    //                                ->groupBy("$members.member_name","$expense.exp_type");
        


    //     //  dd($expensereport);  
        
       

    //      if($filters['from_date']) $expensereport = $expensereport->where("$expense.created_at", '>=', date($filters['from_date']));
    //      if($filters['to_date']) $expensereport = $expensereport->where("$expense.created_at", '<=', date($filters['to_date']));
    //      if($filters['exp_type']) $expensereport = $expensereport->where("$expense.exp_type", '=', $filters['exp_type']);
    //      if($filters['member_name']) $expensereport = $expensereport->where("$members.member_name", '=', $filters['member_name']);

    //     $expensereport =  $expensereport->get();
    //     // dd($expensereport);
    //     $grandTotal = $expensereport->sum('total_amount');
    //     // dd($grandTotal);


    //      $sharePerHead = 0;

    //     // dd($memberCount > 0);

    //     if($memberCount > 0){
    //     // dd($memberCount);
    //         $sharePerHead = $grandTotal/$memberCount;

    //     }

    //     foreach($expensereport as $report){

    //         $report->shared = $sharePerHead;
    //         //  dd($report->total_amount);
    //         // dd($sharePerHead);
    //         $report->balance = $report->total_amount - $sharePerHead;
    //     }

    //     return [
    //         'report' => $expensereport,
    //         'grandTotal' => $grandTotal,
    //         'sharePerHead' => $sharePerHead
    //     ];
         


    // }
}
