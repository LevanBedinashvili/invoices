<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Http\Middleware\RoleMiddleware;
use App\Models\Role;

class UserController extends Controller
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
        $get_all_users_from_database = User::orderBy('id', 'asc')->get();
        return view('users.index', compact('get_all_users_from_database'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $get_all_user_roles = Role::orderBy('id', 'asc')->get();
        return view('users.create', compact('get_all_user_roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(CreateAdminRequest $request)
    {
        $requestData = $request->all();

        if (isset($requestData['password'])) {
            $requestData['password'] = Hash::make($requestData['password']);
        }

        User::create($requestData);

        return back()->with('Success', 'ადმინისტრატორი წარმატებით დაემატა');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $get_all_user_roles = Role::orderBy('id', 'asc')->get();
        $edit_user_data = User::where('id', $id)->firstOrFail();
        return view('users.edit', compact('get_all_user_roles','edit_user_data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(UpdateAdminRequest $request, $id)
    {

        $requestData = $request->except('_method', '_token');

        if (isset($requestData['password']) && !empty($requestData['password'])) {
            $requestData['password'] = Hash::make($requestData['password']);
        } else {
            unset($requestData['password']);
        }

        User::where('id', $id)->update($requestData);

        return redirect()->route('users.index')->with('Success', 'მონაცემთა ბაზა წარმატებით განახლდა');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {

        $user = User::findOrFail($id);

        if ($user->role_id == 1) {
            return redirect()->back()->with('Error', 'თქვენ არ გაქვთ ამ ანგარიშის წაშლის უფლება');
        }

        $user->delete();

        return redirect()->back()->with('Success', 'ადმინისტრატორის ანგარიში წარმატებით წაიშალა');
    }

}
