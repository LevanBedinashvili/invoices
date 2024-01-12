<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Http\Response;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(RoleMiddleware::class . ':1')->except('index');
    }


   public function index()
   {
       $get_all_products = Product::orderBy('id', 'asc')->get();
       return view('products.index', compact('get_all_products'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
   public function create()
   {
       //
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param Request $request
    * @return Response
    */
   public function store(CreateProductRequest $request)
   {
       $requestData = $request->all();

       Product::create($requestData);

       return back()->with('Success', 'პროდუქტი წარმატებით დაემატა');
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
   public function show($id)
   {
       //
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
   public function edit($id)
   {
       $edit_product_data = Product::where('id', $id)->firstOrFail();
       return view('products.edit', compact('edit_product_data'));
   }

   /**
    * Update the specified resource in storage.
    *
    * @param Request $request
    * @param  int  $id
    * @return Response
    */
   public function update(UpdateProductRequest $request, $id)
   {
       $requestData = $request->except('_method', '_token');

       Product::where('id', $id)->update($requestData);

       return redirect()->route('product.index')->with('Success', 'მონაცემთა ბაზა წარმატებით განახლდა');
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
   public function destroy($id)
   {
       $product = Product::findOrFail($id);

       $product->delete();

       return redirect()->back()->with('Success', 'პროდუქტი წარმატებით წაიშალა');
   }
}
