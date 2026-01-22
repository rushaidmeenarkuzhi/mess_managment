<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $i = 0;
        $users = User::get()->all();
        return view('master.user',['users' =>$users, 'i'=>$i]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master.create_user');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',

        ]);

       $usr = User::where('name', $request->name)->orWhere('username', $request->username);
        $usr = $usr->first();

        // $branch_id = Location::select('branch_id')->where('id', $request->location_id)->first();
        // dd($branch_id->branch_id);

        if ($usr) {
            // dd($usr);
            return redirect()->back()->with('error', 'User already exists!');
        }
        $pswd = Hash::make($request->password);
        $user = new User([
            'name' => $request->get('name'),
            'username' => $request->get('username'),
            'user_type' => $request->user_type,
            'email' => $request->email,
            'password' => $pswd

        ]);
        // dd($user);
        $user->save();


        return redirect()->route('user.index')->with('success', 'User Created successfully!');
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
         $user = User::where('id', $id)->first();
        return view('Master.create_user', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $this->validate($request, [
            'name' => 'required',
            'username' => 'required',
            'user_type' => 'required'

        ]);

        $usr = User::whereNotIn('id', [$id]);
        $usr = $usr->where(DB::raw("(name = '$request->name' OR username = '$request->username') and deleted_at"));
        $usr = $usr->first();
        if ($usr) {
             return redirect()->back()->with('error', 'User already exists!');
        }
        if ($request->password != null) {
            $pswd = Hash::make($request->password);
        }

        $user = User::where('id', $id)->first();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->user_type = $request->user_type;
        $user->email = $request->email;
        

        if (isset($pswd)) {
            $user->password = $pswd;
        }
        $user->save();
        return redirect()->route('user.index')->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $user = User::find($id);
         $result = $user->delete();
          if ($result) {
          return redirect()->route('user.index')->with('success', 'User Deleted successfully!');

        } else {
          return redirect()->route('user.index')->with('error', 'User deletion failed!');

        }
    }
}