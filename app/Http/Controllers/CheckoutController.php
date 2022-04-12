<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookRequests_user;
use App\Models\Book_user;
use App;
use Auth;
// use Toastr;
Use Alert;

class CheckoutController extends Controller
{
    public function checkoutAction(Request $request)
    {
        $auth_id = Auth::id();
        $book_ids = $request->book_id;
        $owner_ids = $request->owner_id;
        // dd($auth_id, $owner_ids, in_array($auth_id ,$owner_ids));
        $preData = BookRequests_user::valid()->first();
        // echo "<pre>";
        // print_r($preData);
        // exit();
        // dd(in_array($auth_id ,$owner_ids));
        if (in_array($auth_id ,$owner_ids) == false) {
            if (!empty($preData)) {
                // $alreadyTaken = Book_user::where('valid', 1)
                //     ->whereIn('book_id', $book_ids)
                //     ->where('sender_id', $auth_id)
                //     ->first();

                $alreadyTaken = BookRequests_user::where('valid', 1)
                    ->whereIn('book_id', $book_ids)
                    ->where('sender_id', $auth_id)
                    ->first();
                if (empty($alreadyTaken)) {
                    // dd(1);
                    foreach ($book_ids as $key => $book_id) {
                        $bookData = Book_user::find($book_id);
                        BookRequests_user::create([
                            'book_id' => $book_id,
                            'sender_id' => $auth_id,
                            'owner_id' => $bookData->created_by,
                            'status_update_time' => now()
                        ]);
                    }
                    $success = true;
                    $message = "Borrowed Successfully";
                }else {
                    $success = false;
                    $message = "Book Already Borrowed";
                }
            }else {
                // if (count($book_ids) > 1) {
                    foreach ($book_ids as $key => $book_id) {
                        $bookData = Book_user::find($book_id);
                        BookRequests_user::create([
                            'book_id' => $book_id,
                            'sender_id' => $auth_id,
                            'owner_id' => $bookData->created_by,
                            'status_update_time' => now()
                        ]);
                    }
                    $success = true;
                    $message = "Borrowed Successfully";
                // }else{
                //     $bookData = Book_user::find($book_id[0]);
                //     BookRequests_user::create([
                //         'book_id' => $book_id[0],
                //         'sender_id' => $auth_id,
                //         'owner_id' => $bookData->created_by,
                //         'status_update_time' => now()
                //     ]);
                // }
            }
            session()->forget('cart');
        }else {
            // $output['message'] = "You can't borrow own books";
            // $output['msgType'] = 'warning';
            // Toastr::warning("");
            // alert()->success('SuccessAlert',"You can't borrow own books");
            // toast('Your Post as been submited!','success');
            // return response($output);
            $success = false;
            $message = "You can't borrow own books";
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    
    }
}
