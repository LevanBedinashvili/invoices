<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.settings');
    }


    public function change_password(ChangePasswordRequest $request)
    {
        if($request->new_password == $request->retry_password AND !empty($request->new_password)) {
            $User = User::findOrFail(Auth::user()->id);
            $User->password = Hash::make($request->new_password);
            $User->save();
            return redirect()->route('user.logout');
        }
        else {
            return back()->with('Error', 'შეცდომა, პაროლები არ ემთხვევა ერთმანეთს');
        }
    }
}
