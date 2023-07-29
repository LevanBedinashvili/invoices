<?php

namespace App\Http\Controllers;

use App\Http\Middleware\RoleMiddleware;
use App\Http\Requests\CreateBranchRequest;
use App\Http\Requests\CreatePaymentRequest;
use App\Http\Requests\UpdateBranchRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\Branch;
use App\Models\Payment_type;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PaymentController extends Controller
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
        $get_all_payment_types = Payment_type::orderBy('id', 'asc')->get();
        return view('payments.index', compact('get_all_payment_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePaymentRequest $request)
    {
        $requestData = $request->all();

        Payment_type::create($requestData);

        return back()->with('Success', 'გადახდის ტიპი წარმატებით დაემატა');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit_payment_type = Payment_type::where('id', $id)->firstOrFail();
        return view('payments.edit', compact('edit_payment_type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(UpdatePaymentRequest $request, $id)
    {
        $requestData = $request->except('_method', '_token');

        Payment_type::where('id', $id)->update($requestData);

        return redirect()->route('payment.index')->with('Success', 'მონაცემთა ბაზა წარმატებით განახლდა');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
