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

use App\Services\SmsService;

class WarrantyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

     public function index()
     {
         if (Auth::user()->role_id == 1) {
             $get_all_warranty_from_database = Warranty::with(['user', 'branch'])
                                                       ->orderBy('id', 'desc')
                                                       ->paginate(50);
         } else if (Auth::user()->role_id == 2) {
             $get_all_warranty_from_database = Warranty::with(['user', 'branch'])
                                                       ->where('user_id', Auth::user()->id)
                                                       ->orderBy('id', 'desc')
                                                       ->paginate(50);
         } else if (Auth::user()->role_id == 3) {
             $get_all_warranty_from_database = Warranty::with(['user', 'branch'])
                                                       ->where('branch_id', Auth::user()->branch_id)
                                                       ->orderBy('id', 'desc')
                                                       ->paginate(50);
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
        $get_warranty = Warranty::where('id', $id)->firstOrFail();
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
     * Send signing SMS with public link to user (admin panel action)
     */
    public function sendSignSms($id)
    {
        $warranty = Warranty::findOrFail($id);
        // Generate uuid if not exists
        if (!$warranty->uuid) {
            $warranty->uuid = Warranty::generateSignToken();
            $warranty->save();
        }
        $link = url('/warranty/sign/' . $warranty->uuid);
        $text = "თქვენი საგარანტიო დოკუმენტი: {$link}";
        $sms = new SmsService();
        $sms->send($warranty->phone_number, $text, $warranty->id);
        return back()->with('success', 'SMS წარმატებით გაიგზავნა!');
    }
}
