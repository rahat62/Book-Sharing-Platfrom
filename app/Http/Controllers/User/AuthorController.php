<?php

namespace App\Http\Controllers\User;

use Auth;
use File;
use Helper;
use Validator;
use Illuminate\Http\Request;
use App\Models\Author_user;
use App\Http\Controllers\Controller;

class AuthorController extends Controller
{
    public function index()
    {
        $data['authors'] = Author_user::where('created_by', Auth::id())->latest()->get();
        return view('user.author.listData', $data);
    }

    public function create()
    {
        return view('user.author.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required',
            'details' => 'required'
        ]);
        if ($validator->passes()) {
            Author_user::create([
                'name' => $request->name,
                'details' => $request->details
            ]);
            $output['messege'] = 'Author has been created';
            $output['msgType'] = 'success';
            
            return redirect()->back()->with($output);
        } else {
            return redirect()->back()->withErrors($validator);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data['author'] = Author_user::valid()->find($id);
        return view('user.author.update', $data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required',
            'details' => 'required'
        ]);
        if ($validator->passes()) {
            Author_user::find($id)->update([
                'name'    => $request->name,
                'details' => $request->details
            ]);
            $output['messege'] = 'Author has been updated';
            $output['msgType'] = 'success';
        
            return redirect()->back()->with($output);
        } else {
            return redirect()->back()->withErrors($validator);
        }
    }

    public function destroy($id)
    {
        Author_user::valid()->find($id)->delete();
    }
}
