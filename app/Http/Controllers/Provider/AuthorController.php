<?php

namespace App\Http\Controllers\Provider;

use File;
use Helper;
use Validator;
use Illuminate\Http\Request;
use App\Models\Author_provider;
use App\Http\Controllers\Controller;

class AuthorController extends Controller
{
    public function index()
    {
        $data['authors'] = Author_provider::valid()->latest()->get();
        return view('provider.author.listData', $data);
    }

    public function create()
    {
        return view('provider.author.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required',
            'details' => 'required'
        ]);
        if ($validator->passes()) {
            Author_provider::create([
                'name' => $request->name,
                'details' => $request->details,
                'active_status' => 1,
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
        $data['author'] = Author_provider::valid()->find($id);
        return view('provider.author.update', $data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required',
            'details' => 'required'
        ]);
        if ($validator->passes()) {
            Author_provider::find($id)->update([
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
        Author_provider::valid()->find($id)->delete();
    }

    public function authorActiveStatus($id)
    {
        $data['author'] = Author_provider::find($id);

        return view('provider.author.authorActiveStatus', $data);
    }


    public function authorActiveStatusAction(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'active_status' => 'required'
        ]);
        if ($validator->passes()) {
            $bookRequest = Author_provider::find($id);
            $bookRequest->update([
                'active_status' => $request->active_status
            ]);
            
            $output['messege'] = 'Active Status has been Updated';
            $output['msgType'] = 'success';
            return redirect()->back()->with($output);
        } else {
            return redirect()->back()->withErrors($validator);
        }
    }
}
