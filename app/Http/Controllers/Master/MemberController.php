<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $i = 0;
        $members = Member::where('deleted_at', null)->get();
        // dd($member);
        return view('Master.member',['members' => $members, 'i' => $i]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Master.create_member');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->all();
        $this->Validate($request,[
             'member_name' => 'required'
        ]);

        $member = new Member([
            'member_name' => $request->get('member_name'),
            'address' => $request->get('address'),
            'room_no' => $request->get('room_no'),
            'joining_date' => $request->get('joining_date'),
            'status' => $request->get('status'),
        ]);
        // dd($member);
        $member->save();

        return redirect()->route('member.index')->with('success', 'New Member Added Successfully');
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
        $member = Member::where('id', $id)->first();
        // dd($member);
        return view('Master.create_member',compact('member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->Validate($request,[
             'member_name' => 'required'
        ]);

        $member = Member::findOrFail($id);
        $member->member_name = $request->member_name;
        $member->address = $request->address;
        $member->room_no = $request->room_no;
        $member->joining_date = $request->joining_date;
        $member->status = $request->status;
        $member->save();

        return redirect()->route('member.index')->with('success', 'Member Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $member = Member::find($id);
        $result = $member->delete();

        if($result){
            return redirect()->route('member.index')->with('success', 'Member Deleted Successfully');
        }
    }
}
