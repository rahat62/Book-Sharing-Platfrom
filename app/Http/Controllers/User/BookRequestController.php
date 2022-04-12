<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Auth;
use Validator;
use App\Models\BookRequests_user;
use App\Models\Book_user;

class BookRequestController extends Controller
{
    public function index(){
        $authId = Auth::id();
        // $data['userInfo'] = User::where('valid', 1)->find($authId);

        $data['bookRequestInfos'] = BookRequests_user::join('users', 'users.id', '=', 'book_requests.sender_id')
            ->join('books', 'books.id', '=', 'book_requests.book_id')
            ->join('authors', 'authors.id', '=', 'books.author_id')
            ->select('book_requests.*', 'users.first_name as user_first_name', 'users.last_name as user_last_name', 'books.title as book_title', 'books.book_thumb', 'authors.name as author_name')
            ->where('book_requests.owner_id', $authId)
            ->where('book_requests.valid', 1)
            ->get();

        return view('user.bookRequest.listData', $data);
    }

    public function requestControl(Request $request, $id)
    {
        $data['bookRequestInfo'] = BookRequests_user::find($id);
        return view('user.bookRequest.requestControl', $data);
    }
    public function requestControlAction(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required'
        ]);
        if ($validator->passes()) {
            // DB::transaction();
            BookRequests_user::find($id)->update([
                'status' => $request->status
            ]);
            Book_user::find($request->book_id)->update([
                'available_status' => $request->status == 1 ? 0 : 1
            ]);
            // DB::commit();
            $output['messege'] = 'Book request has been updated';
            $output['msgType'] = 'success';

            return redirect()->back()->with($output);
        }else {
            return redirect()->back()->withErrors($validator);
        }
    }
    public function returnBookByOwner($id)
    {
        $data['bookRequest'] = BookRequests_user::join('users', 'users.id', '=', 'book_requests.owner_id')
            ->select('book_requests.id', 'users.first_name as user_first_name', 'users.last_name as user_last_name', 'book_requests.return_accept_by_owner_status')
            ->where('book_requests.id', $id)
            ->where('book_requests.valid', 1)
            ->first();

        return view('user.bookRequest.returnBookByOwner', $data);
    }


    public function returnBookByOwnerAction(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'return_accept_by_owner_status' => 'required'
        ]);
        if ($validator->passes()) {
            $bookRequest = BookRequests_user::find($id);
            $bookRequest->update([
                'return_accept_by_owner_status' => $request->return_accept_by_owner_status,
                'return_accept_by_owner_time'   => date('Y-m-d H:i:s')
            ]);
            Book_user::find($bookRequest->book_id)->update([
                'available_status' => 1
            ]);
            
            $output['messege'] = 'Return Status has been Updated';
            $output['msgType'] = 'success';
            return redirect()->back()->with($output);
        } else {
            return redirect()->back()->withErrors($validator);
        }
    }
}
