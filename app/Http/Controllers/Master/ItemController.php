<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\Imports\ItemImport;
use App\Models\Item;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Alert;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $i =0;
        $item = Item::where('deleted_at', null)->get();
        return view('Master.items',['item' => $item, 'i' => $i]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Master.create_items');
    }

      public function upload_item()
    {
        return view('Master.upload_items');
    }

     public function fileUpload(Request $request)
    {
        $current = date('Y-m-d_H-i-s');
        $file = $request->file('file')->store('file');
        // dd($file);
        Excel::import(new ItemImport, $file);

        $fileName = $current . '_' . $request->file->getClientOriginalName();
        $request->file->move(public_path('file'), $fileName);

        return redirect()->route('item.index')->with('success', 'Item Saved Sccesfully !');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'item_code'=> 'required'
        ]);


    //  $item = Item::where('color', $request->color)->orWhere('size', $request->size)->first();
    //     if ($item) {
    //         return redirect()->back()->with('error', 'This Item Color Or Size Alredy Exist!');
    //     }

      

        $item = new Item([
            'item_name' => $request->get('item_name'),
            'item_code' => $request->get('item_code'),
            // 'size' => $request->get('size'),
            // 'color' => $request->get('color'),
            'item_qty' => $request->item_qty,
            
        ]);
        // dd($item);

        $item->save();
        return redirect()->route('item.index')->with('success', 'Item Saved Sccesfully !');
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
        $item =  Item::where('id', $id)->first();
        return view('Master.create_items',compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $this->validate($request, [
           'item_code'=> 'required'
        ]);

        $item = Item::findOrFail($id);
        $item->item_name = $request->item_name;
        $item->item_code = $request->item_code;
        // $item->size = $request->size;
        // $item->color = $request->color;
        $item->item_qty = $request->item_qty;
        $item->save();

        return redirect()->route('item.index')->with('success', 'Item Updated Sccesfully !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Item::find($id);
        $result =  $item->delete();

        if($result){
            return redirect()->route('item.index')->with('success', 'Item Deleted Sccesfully !');

        }

    }
}
