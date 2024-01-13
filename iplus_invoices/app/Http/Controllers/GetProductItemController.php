<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;


class GetProductItemController extends Controller
{
    public function getItems()
    {
        $items = Product::all();
        return response()->json($items);
    }


    public function edit($itemId)
    {
        $item = Product::find($itemId);
        return view('invoices.edit.blade.php', compact('item'));
    }
}
