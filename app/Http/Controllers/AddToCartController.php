<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book_web;
use App\Models\BookCategory_web;
use App;

class AddToCartController extends Controller
{
    public function cartAdd(Request $request)
    {
        $data['title'] = "Add To Cart";
        $book = Book_web::join('languages', 'languages.id', '=', 'books.language_id')
            ->select('books.*', 'languages.name as language_name')
            ->where('books.id',$request->book_id)
            ->first();
        // $data['work_flow'] = EduCompanyWorkFlow_Web::valid()->latest()->first();
        // dd($request->session()->has('cart'));
        $data['id'] = $book->id;

        if ($request->session()->has('cart')) {
            if (count($request->session()->get('cart')) > 0) {
                foreach ($request->session()->get('cart') as $key => $cartItem) {
                    if ($cartItem['id'] == (int)$request->book_id) {
                        return response()->json([
                            'data' => 1
                        ]);
                    }
                }
            }
        }

        $data['name']          = $book->title;
        $data['language_name'] = $book->language_name;
        $data['thumbnail']     = $book->book_thumb;
        $data['owner']         = $book->created_by;
        $data['author']        = $book->author_id;
        
        if ($request->session()->has('cart')) {
            $cart = $request->session()->get('cart', collect([]));
            $cart->push($data);
        } else {
            $cart = collect([$data]);
            $request->session()->put('cart', $cart);
        }

        return response()->json([
            'data' => $data
        ]);
        // return view('web.home', $data);
    }
    
    public function nav_cart()
    {
        return view('web.partial.nav_cart');
    }
    public function toolbar()
    {
        return count(session('cart'));
    }

    public function removeFromCart(Request $request)
    {
        if ($request->session()->has('cart')) {
            $cart = $request->session()->get('cart', collect([]));
            $cart->forget($request->key);
            $request->session()->put('cart', $cart);
        }
        // session()->forget('shipping_method_id');

        return view('web.partial.nav_cart');
    }
    public function updateViewCartPage(Request $request)
    {
        return view('web.partial.update_view_cart_page');
    }
    
    // public function home()
    // {
    //     $data['books'] = Book_web::join('book_categories', 'book_categories.id', '=', 'books.category_id')
    //         ->join('authors', 'authors.id', '=', 'books.author_id')
    //         ->join('countries', 'countries.id', '=', 'books.country_id')
    //         ->join('languages', 'languages.id', '=', 'books.language_id')
    //         ->select('books.*', 'book_categories.name as category_name', 'authors.name as author_name', 'countries.country_name', 'languages.name as language_name')
    //         ->where('books.valid', 1)
    //         ->orderBy('books.id', 'DESC')
    //         ->paginate(12);
    //     $data['categories'] = BookCategory_web::valid()->latest()->get();
    //     // $data['student_reviews'] = EduStudentReview_Web::valid()->latest()->limit(5)->get();
    //     // $data['galleries_photos'] = EduPhotoGallery_Web::valid()->latest()->limit(4)->get();
    //     return view('web.home', $data);
    // }
    
    
}
