<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Branch;
use App\Models\Template;


class GetProductItemController extends Controller
{
    public function getItems()
    {
        $items = Product::all();
        return response()->json($items);
    }

    public function getBranchItems()
    {
        $branchitems = Branch::all();
        return response()->json($branchitems);
    }

    public function getTemplateItems()
    {
        $templateitems = Template::all();
        return response()->json($templateitems);
    }
}
