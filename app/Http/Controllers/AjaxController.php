<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
   
    public function getItems(Request $request)
    {
        // dd(12);
         $items = \App\Models\Item::where('id', $request->item_id)
                ->select('id','item_name','item_qty')->first();
    //   dd($items);
          return response()->json($items);
    }
}
