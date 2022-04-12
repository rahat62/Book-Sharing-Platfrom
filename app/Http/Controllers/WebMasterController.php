<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users_user;
use App;
Use Mail;
use Validator;
use App\Http\Controllers\User\MasterController;

class WebMasterController extends Controller
{
    public function login()
    {
        return view('web.login');
    }
    public function loginAction(Request $request)
    {
        $master = new MasterController;
        return $master->postLogin($request);
    }
    public function register()
    {
        return view('web.register');
    }
    public function registerAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|email|unique:users,email',
            'phone'      => 'required',
            'address'    => 'required',
            'password'   => 'required'
        ]);
        if ($validator->passes()) {
            $user_id = Users_user::create([
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'email'      => $request->email,
                'phone'      => $request->phone,
                'address'    => $request->address,
                'password'   => bcrypt($request->password),
                'valid'      => 1
            ]);

            $details = [
                'link' => url('userVerification/'.$user_id->id),
                // 'link' => url('userVerification/1'),
                'userName' => $request->first_name,
            ];

            Mail::to($request->email)->send(new \App\Mail\MyTestMail($details));
            // Mail::to('dinocajic+test@gmail.com')->send(new RandomEmail($name));

            $output['message'] = 'Registration Successfully Please check your email';
            $output['msgType'] = 'success';

            return redirect()->back()->with($output);
     
        } else {
            return redirect()->back()->withErrors($validator);
        }
    }

    public function userVerification($id)
    {
        $user = Users_user::find($id);       
        if ($user) {
            $user->update([
                'email_verified' => 1
            ]);
            $output['message'] = 'Email Verified Successfully';
            $output['msgType'] = 'success';

            // return view('web.login', $output);
            return redirect('login')->with($output);
        }else {
            $output['message'] = 'Email Verification Failed';
            $output['msgType'] = 'danger';

            return redirect('login')->withErrors($output);
        }
    }
}