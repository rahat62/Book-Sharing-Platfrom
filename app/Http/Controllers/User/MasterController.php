<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Validator;
use App\Models\User;

class MasterController extends Controller
{
    public function getLogin()
    {
        return view('user.login');
    }
    public function postLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|min:8'
        ]);
        $data = array(
            'email'          => $request->email,
            'password'       => $request->password,
            'email_verified' => 1,
            'active_status'  => 1,
            'valid'          => 1
        );
        if (isset($request->from_web) == 'yes') {
            if (Auth::guard('web')->attempt($data)) {
                return redirect()->route('home');
            } else {
                return redirect()->route('login')->with('error', 'Email or password is not correct.');
            }
        }else{
            if (Auth::guard('web')->attempt($data)) {
                return redirect()->route('user.home');
            } else {
                return redirect()->route('user.login')->with('error', 'Email or password is not correct.');
            }
        }
    }
    public function logout()
    {
        Auth::logout();
        $notification = array(
            'message' => 'Logout Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('home')->with($notification);
        // return redirect()->route('home');
    }
    public function home(){
        $authId = Auth::id();
        $data['userInfo'] = User::where('valid', 1)->find($authId);
        return view('user.home', $data);
    }

}
