<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateWarrantyRequest;
use App\Http\Requests\UpdateWarrantyRequest;
use App\Models\Branch;
use App\Models\Notification;
use App\Models\Template;
use App\Models\Warranty;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class WarrantyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index()
    {
        if(Auth::user()->role_id == 1)
            $get_all_warranty_from_database = Warranty::orderBy('id', 'desc')->get();
        else if(Auth::user()->role_id == 2) {
            $get_all_warranty_from_database = Warranty::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
        }
        else if (Auth::user()->role_id == 3) {
            $get_all_warranty_from_database = Warranty::where('branch_id', Auth::user()->branch_id)->orderBy('id', 'desc')->get();
        }
        return view('warranties.index', compact('get_all_warranty_from_database'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $get_all_branches_from_database = Branch::orderBy('id', 'asc')->get();
        $get_template = Template::orderBy('id', 'asc')->get();
        return view('warranties.create', compact('get_all_branches_from_database', 'get_template'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(CreateWarrantyRequest $request)
    {
        $requestData = $request->all();

        $requestData['user_id'] = Auth::user()->id;

        $info = Warranty::create($requestData);


        $notification = new Notification([
            'user_id' => auth()->user()->id,
            'message' => 'დაამატა საგარანტიო უნიკალური ნომრით - '. $info->id,
            'is_seen' => false,
        ]);
        $notification->save();

        return redirect()->route('warranty.index')->with('Success', 'საგარანტიო წარმატებით დაემატა');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $get_warranty = Warranty::findOrFail($id);
        return view('warranties.show', compact('get_warranty'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $get_all_branches_from_database = Branch::orderBy('id', 'asc')->get();
        $edit_warranty_data = Warranty::where('id', $id)->firstOrFail();
        $get_template = Template::orderBy('id', 'asc')->get();
        return view('warranties.edit', compact('get_all_branches_from_database','edit_warranty_data', 'get_template'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(UpdateWarrantyRequest $request, $id)
    {
        $requestData = $request->except('_method', '_token');

        Warranty::where('id', $id)->update($requestData);

        $info = Warranty::find($id);

        $notification = new Notification([
            'user_id' => auth()->user()->id,
            'message' => 'განაახლა საგარანტიო უნიკალური ნომრით - '. $info->id,
            'is_seen' => false,
        ]);
        $notification->save();

        return redirect()->route('warranty.index')->with('Success', 'მონაცემთა ბაზა წარმატებით განახლდა');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $warranty = Warranty::findOrFail($id);

        $warranty->delete();

        return redirect()->back()->with('Success', 'საგარანტიო  წარმატებით წაიშალა მონაცემთა ბაზიდან');
    }
}
