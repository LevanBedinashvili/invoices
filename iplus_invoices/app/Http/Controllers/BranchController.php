<?php

namespace App\Http\Controllers;

use App\Http\Middleware\RoleMiddleware;
use App\Http\Requests\CreateBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

     public function __construct()
     {
         $this->middleware(RoleMiddleware::class . ':1')->except('index');
     }


    public function index()
    {
        $get_all_branches = Branch::orderBy('id', 'asc')->get();
        return view('branches.index', compact('get_all_branches'));
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
    public function store(CreateBranchRequest $request)
    {
        $requestData = $request->all();

        Branch::create($requestData);

        return back()->with('Success', 'ფილიალი წარმატებით დაემატა');
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
        $edit_branch_data = Branch::where('id', $id)->firstOrFail();
        return view('branches.edit', compact('edit_branch_data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(UpdateBranchRequest $request, $id)
    {
        $requestData = $request->except('_method', '_token');

        Branch::where('id', $id)->update($requestData);

        return redirect()->route('branch.index')->with('Success', 'მონაცემთა ბაზა წარმატებით განახლდა');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);

        $branch->delete();

        return redirect()->back()->with('Success', 'ფილიალი წარმატებით წაიშალა');
    }
}
