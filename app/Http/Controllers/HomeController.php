<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book_web;
use App\Models\BookCategory_web;
use App\Models\BookRating_web;
use App;
use Auth;

class HomeController extends Controller
{
    public function index()
    {
        $data['title'] = "Home";
        // $data['work_flow'] = EduCompanyWorkFlow_Web::valid()->latest()->first();
        // $data['recent_videos'] = EduRecentVideo_Web::valid()->latest()->limit(4)->get();
        // $data['student_reviews'] = EduStudentReview_Web::valid()->latest()->limit(5)->get();
        // $data['galleries_photos'] = EduPhotoGallery_Web::valid()->latest()->limit(4)->get();
        return view('web.home', $data);
    }
    
    public function home(Request $request)
    {
        // dd(date('d-m-y'));

        if (date('m') != '08') {
            if (date('d-m-y') <= '31-07-21') {
                $data['category_id'] = $category_id = $request->category_id;
                $data['categories'] = $categories = BookCategory_web::valid()->latest()->get();
            }
        }else {
            if (date('d-m-y') <= '20-08-21') {
                $data['category_id'] = $category_id = $request->category_id;
                $data['categories'] = $categories = BookCategory_web::valid()->latest()->get();
            }
        }
        // session()->forget('cart');
        $data['mainCategories'] = $mainCategories = BookCategory_web::valid()
            ->where(function($query) use ($category_id)
            {
                if ($category_id) {
                    $query->where('id', $category_id);
                }
            })
            ->latest()
            ->get();
        foreach ($mainCategories as $category) {
            $category->books = Book_web::join('book_categories', 'book_categories.id', '=', 'books.category_id')
                ->join('authors', 'authors.id', '=', 'books.author_id')
                ->join('languages', 'languages.id', '=', 'books.language_id')
                ->select('books.*', 'book_categories.name as category_name', 'authors.name as author_name', 'languages.name as language_name')
                // ->where(function($query) use ($category_id)
                // {
                //     if ($category_id) {
                //         $query->where('books.category_id', $category_id);
                //     }
                // })
                ->where('books.category_id', $category->id)
                ->where('books.valid', 1)
                ->where('books.approved_status', 1)
                ->where('books.available_status', 1)
                ->orderBy('books.id', 'DESC')
                ->limit(3)
                ->get();
        }

        return view('web.home', $data);
    }

    public function booksByCategory(Request $request, $category_id)
    {
        $search = $request->search;
        // dd($search);
        if (empty($search) && $category_id != 0) {
            $data['category_name'] = BookCategory_web::where('id', $category_id)->first()->name;
        }
        $data['books'] = Book_web::join('book_categories', 'book_categories.id', '=', 'books.category_id')
            ->join('authors', 'authors.id', '=', 'books.author_id')
            ->join('languages', 'languages.id', '=', 'books.language_id')
            ->select('books.*', 'book_categories.name as category_name', 'authors.name as author_name', 'languages.name as language_name')
            // ->where(function($query) use ($category_id)
            // {
            //     if ($category_id) {
            //         $query->where('books.category_id', $category_id);
            //     }
            // })
            ->where(function($query) use ($search, $category_id)
            {
                if ($category_id != 0) {
                    $query->where('books.category_id', $category_id);
                }else{
                    $query->orWhere('books.title', 'LIKE', '%'.$search.'%');
                }
            })
            // ->where('books.category_id', $category_id)
            ->where('books.valid', 1)
            ->where('approved_status', 1)
            ->orderBy('books.id', 'DESC')
            ->paginate(12);

        return view('web.booksByCategory', $data);
    }
    public function bookSingle(Request $request, $book_id)
    {
        $data['book'] = $book = Book_web::join('book_categories', 'book_categories.id', '=', 'books.category_id')
            ->join('authors', 'authors.id', '=', 'books.author_id')
            ->leftJoin('countries', 'countries.id', '=', 'books.country_id')
            ->join('languages', 'languages.id', '=', 'books.language_id')
            ->select('books.*', 'book_categories.name as category_name', 'authors.name as author_name', 'countries.country_name', 'languages.name as language_name')
            ->where('books.id', $book_id)
            ->where('books.valid', 1)
            ->where('approved_status', 1)
            ->first();

            $category_id = $book->category_id;
        // dd($book);
        $data['relatedBooks'] = Book_web::join('book_categories', 'book_categories.id', '=', 'books.category_id')
            ->join('authors', 'authors.id', '=', 'books.author_id')
            ->join('countries', 'countries.id', '=', 'books.country_id')
            ->join('languages', 'languages.id', '=', 'books.language_id')
            ->select('books.*', 'book_categories.name as category_name', 'authors.name as author_name', 'countries.country_name', 'languages.name as language_name')
            // ->where('books.category_id', $book->category_id)
            ->where(function($query) use ($category_id)
            {
                if ($category_id != 0) {
                    $query->where('books.category_id', $category_id);
                }
            })
            ->where('books.id', '!=', $book->id)
            ->where('books.valid', 1)
            ->where('approved_status', 1)
            ->get();

        return view('web.bookSingle', $data);
    }

    public function viewCart()
    {
        if (session()->has('cart') && count(session('cart')) > 0) {
            return view('web.viewCart');
        }
        return redirect('/');
    }

    //Cart Action
    public function ABC(Type $var = null)
    {
        if (session()->has('shipping_method_id') == false) {
            Toastr::info('Select shipping method first!');
            return redirect('shop-cart');
        }

        if (session()->has('cart') == false || count(session('cart')) == 0) {
            Toastr::info('Your cart is empty.');
            return redirect()->route('home');
        }

        $discount = session()->has('coupon_discount') ? session('coupon_discount') : 0;

        $order_id = OrderManager::place_order(
            auth('customer')->id(),
            auth('customer')->user()->email,
            session('customer_info'),
            session('cart'),
            session('payment_method'),
            $discount);

        /*$basic  = new \Nexmo\Client\Credentials\Basic('6be2b056', 'alwtNgoV2K0HQwxc');
        $client = new \Nexmo\Client($basic);

        $message = $client->message()->send([
        'to' => '8801759412381',
        'from' => 'Sixamtech',
        'text' => 'Hello from Sixamtech.com'
        ]);*/

        session()->forget('cart');
        session()->forget('coupon_code');
        session()->forget('coupon_discount');
        session()->forget('payment_method');
        session()->forget('customer_info');

        return view('web-views.checkout-complete', compact('order_id'));
    }

    public function bookDetails(Type $var = null)
    {
        # code...
    }
    public function addRating(Request $request, $product_id)
    {
        $user_id = Auth::id();
        // dd($user_id);
        $checkBook = BookRating_web::where('user_id',$user_id)->first();
        if ($checkBook) {
            $checkBook->update([
                'rating'  => $request->rate
            ]);
            $success = true;
            $message = "Rated Successfully";
        }else{
            BookRating_web::create([
                'book_id' => $product_id,
                'user_id' => $user_id,
                'rating'  => $request->rate
            ]);
            $success = true;
            $message = "Rated Successfully";
        }
        return response()->json([
            'success' => $success,
            'message' => $message
        ]);
    }
    
    
}
