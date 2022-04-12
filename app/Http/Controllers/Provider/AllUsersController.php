<?php

namespace App\Http\Controllers\Provider;

use File;
use Helper;
use Validator;
use Illuminate\Http\Request;
use App\Models\User_provider;
use App\Models\Book_provider;
use App\Http\Controllers\Controller;

class AllUsersController extends Controller
{
    public function index()
    {
        $data['users'] = $users = User_provider::valid()->latest()->get();
        return view('provider.allUsers.listData', $data);
    }

    public function create()
    {
        return view('provider.allUsers.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required',
            'details' => 'required'
        ]);
        if ($validator->passes()) {
            User_provider::create([
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
        $data['author'] = User_provider::valid()->find($id);
        return view('provider.allUsers.update', $data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required',
            'details' => 'required'
        ]);
        if ($validator->passes()) {
            User_provider::find($id)->update([
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
        User_provider::valid()->find($id)->delete();
    }

    public function bookListByUser($user_id)
    {
        $data['books'] = Book_provider::join('book_categories', 'book_categories.id', '=', 'books.category_id')
            ->join('authors', 'authors.id', '=', 'books.author_id')
            ->join('languages', 'languages.id', '=', 'books.language_id')
            ->select('books.*', 'book_categories.name as category_name', 'authors.name as author_name', 'languages.name as language_name')
            ->where('books.created_by', $user_id)
            ->where('books.valid', 1)
            ->get();

        return view('provider.allUsers.bookListByUser', $data);
    }

    public function userActiveStatus($id)
    {
        $data['user'] = User_provider::where('id', $id)
            ->where('valid', 1)
            ->first();

        return view('provider.allUsers.userActiveStatus', $data);
    }

    public function userActiveStatusAction(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'active_status'     => 'required'
        ]);
        if ($validator->passes()) {
            User_provider::find($id)->update(['active_status' => $request->active_status]);
            
            $output['messege'] = 'User Active Status has been Updated';
            $output['msgType'] = 'success';
            return redirect()->back()->with($output);
        } else {
            return redirect()->back()->withErrors($validator);
        }
    }
}
