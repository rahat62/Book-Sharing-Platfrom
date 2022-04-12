@extends('layouts.default')
@section('page-name', 'Home')
@push('styles')
    <style>
        .selected{
            color: #305f90 !important;
        }
        .rate {
            float: left;
            /* height: 46px; */
            padding: 0 10px;
        }
        .rate:not(:checked) > input {
            position:absolute;
            top:-9999px;
        }
        .rate:not(:checked) > label {
            float:right;
            width:1em;
            overflow:hidden;
            white-space:nowrap;
            cursor:pointer;
            font-size:20px;
            color:#ccc;
        }
        .rate:not(:checked) > label:before {
            content: '★ ';
        }
        .rate > input:checked ~ label {
            color: #ffc700;    
        }
        .rate:not(:checked) > label:hover,
        .rate:not(:checked) > label:hover ~ label {
            color: #deb217;  
        }
        .rate > input:checked + label:hover,
        .rate > input:checked + label:hover ~ label,
        .rate > input:checked ~ label:hover,
        .rate > input:checked ~ label:hover ~ label,
        .rate > label:hover ~ input:checked ~ label {
            color: #c59b08;
        }
    </style>
@endpush

@section('content')
<!-- start shop-section -->
<section class="shop-section section-padding">
    <div class="container-fluid">
        <div class="row">
            <div class="col col-xs-12">
                <div class="shop-area clearfix">
                    <div class="woocommerce-content-wrap">
                        <div class="woocommerce-content-inner">
                            {{-- SHOP SEARCH AND SORTING SECTION START--}}
                            <div class="woocommerce-toolbar-top">
                                <p class="woocommerce-result-count">Choose your books</p>
                                <div class="products-sizes">
                                    <a href="#" class="grid-4 active">
                                        <div class="grid-draw">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                        <div class="grid-draw">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                        <div class="grid-draw">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                    </a>
                                    <a href="#" class="grid-3">
                                        <div class="grid-draw">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                        <div class="grid-draw">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                        <div class="grid-draw">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                    </a>
                                    <a href="#" class="list-view">
                                        <div class="grid-draw-line">
                                            <span></span>
                                            <span></span>
                                        </div>
                                        <div class="grid-draw-line">
                                            <span></span>
                                            <span></span>
                                        </div>
                                        <div class="grid-draw-line">
                                            <span></span>
                                            <span></span>
                                        </div>
                                    </a>
                                </div>
                                {{-- <form class="woocommerce-ordering" method="get">
                                    <select name="orderby" class="orderby">
                                         <option value="menu_order" selected='selected'>Default sorting</option>
                                        <option value="popularity">Sort by popularity</option>
                                        <option value="rating">Sort by average rating</option>
                                        <option value="date">Sort by newness</option>
                                        <option value="price">Sort by price: low to high</option>
                                        <option value="price-desc">Sort by price: high to low</option>
                                    </select>
                                    <input type="hidden" name="post_type" value="product" />                    
                                </form>                             --}}
                            </div>
                            {{-- SHOP SEARCH AND SORTING SECTION END--}}
                            {{-- PRODUCT LIST START --}}
                            @if (count($mainCategories)>0)
                            @foreach ($mainCategories as $category)
                            <div class="panel panel-default">
                                <div class="panel-heading">{{$category->name}}</div>
                                <div class="panel-body">
                                    @if (count($category->books)>0)
                                    <ul class="products">
                                        @foreach ($category->books as $book)
                                            <li class="product">
                                                <div class="product-holder">
                                                    <a href="{{ route('bookSingle', [$book->id]) }}"><img src="{{asset("uploads/book/".$book->book_thumb)}}" alt></a>
                                                    <div class="shop-action-wrap">
                                                        <ul class="shop-action">
                                                            <li><a href="#"  title="Quick view!"><i class="fi flaticon-view"></i></a></li>
                                                            {{-- <li><a href="#" title="Add to Wishlist!"><i class="fi icon-heart-shape-outline"></i></a></li> --}}
                                                            <li><a title="Add to cart!" onclick="addToCart({{$book->id}})" style="cursor: pointer;"><i class="fi flaticon-shopping-cart"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product-info">
                                                    <h4><a href="{{ route('bookSingle', [$book->id]) }}">{{$book->title}}</a></h4>
                                                    <p class="product-description">{{Str::words(strip_tags($book->summery), 50)}} </p>
                                                </div>
            
                                                <div class="quick-view-single-product">
                                                    <div class="view-single-product-inner clearfix">
                                                        <button class="btn quick-view-single-product-close-btn"><i class="pe-7s-close-circle"></i></button>
                                                        <div class="img-holder">
                                                            <img src="{{asset("uploads/book/".$book->book_thumb)}}" alt>
                                                        </div>
                                                        <div class="product-details">
                                                            <h4>{{$book->title}}</h4>
                                                            {{-- <div class="rating">
                                                                <i class="fi flaticon-star"></i>
                                                                <i class="fi flaticon-star"></i>
                                                                <i class="fi flaticon-star"></i>
                                                                <i class="fi flaticon-star"></i>
                                                                <i class="fi flaticon-star-social-favorite-middle-full"></i>
                                                                <span>(2 Customer review)</span>
                                                            </div> --}}
                                                            @php($avg_book_rating = App\Models\BookRating_web::where('book_id', $book->id)->avg('rating'))
                                                                
                                                            <p class="text-danger">
                                                                <b>Rating of this book: {{number_format($avg_book_rating)}}</b>
                                                            </p>

                                                            @if (Auth::check())
                                                            {{-- @php($book_rating = App\Models\BookRating_web::where('book_id', $book->id)->where('user_id', Auth::id())->first()) --}}

                                                            <form class="rate" action="{{route('addRating', [$book->id])}}" method="post" id="addRating">
                                                                <input type="radio" id="star5" name="rate" value="5" />
                                                                <label for="star5" title="5 star">5 stars</label>
                                                                <input type="radio" id="star4" name="rate" value="4" />
                                                                <label for="star4" title="4 star">4 stars</label>
                                                                <input type="radio" id="star3" name="rate" value="3" />
                                                                <label for="star3" title="3 star">3 stars</label>
                                                                <input type="radio" id="star2" name="rate" value="2" />
                                                                <label for="star2" title="2 star">2 stars</label>
                                                                <input type="radio" id="star1" name="rate" value="1" />
                                                                <label for="star1" title="1 star">1 star</label>
                                                            </form>
                                                            <br>
                                                            <br>
                                                            @endif
                                                            <div>
                                                                <p>{{Str::words(strip_tags($book->summery), 50)}}</p>
                                                            </div>
                                                            <div class="product-option">
                                                                {{-- <form class="form" id="add-to-cart-form">
                                                                    <input type="hidden" name="bood_id" value="{{ $book->id }}">
                                                                </form> --}}
                                                                <div class="addToCartDiv">
                                                                    <button type="button" onclick="addToCart({{$book->id}})" >Add to cart</button>
                                                                </div>
                                                                {{-- <div class="loader" >
                                                                    <img src="{{ asset('public/web/images/ajax-loader.gif') }}" alt="">
                                                                </div> --}}
                                                            </div> 
                                                            <div class="thb-product-meta-before">
                                                                <div class="product_meta">
                                                                    <span class="posted_in">Author: 
                                                                        <a href="#">{{$book->author_name}}</a>
                                                                    </span>
                                                                    <span class="posted_in">Categories: 
                                                                        <a href="#">{{$book->category_name}}</a>
                                                                    </span>
                                                                    <span class="posted_in">Language: 
                                                                        <a href="#">{{$book->language_name}}</a>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> <!-- end quick-view-single-product -->
                                            </li>
                                        @endforeach
                                    </ul>
                                    <a href="{{ route('booksByCategory', [$category->id]) }}" class="pull-right">View All</a>
                                    @else
                                        <p>No Book Found</p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                            @endif
                            {{-- PRODUCT LIST END --}}
                        </div>
                        {{-- {{ $books->links('web.paginate') }} --}}
                    </div>
                    {{-- SIDEBAR START --}}
                    <div class="shop-sidebar">
                        <div class="widget widget_search">
                            <div class="search-widget">
                               <form class="searchform" action="{{ route('booksByCategory', [0]) }}" method="GET">
                                    <div>
                                        <input type="text" name="search" required placeholder="Search By Book">
                                        <button type="submit"><i class="ti-search"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>  

                        <div class="widget woocommerce widget_product_categories">
                            <h3>Filter by categories</h3>
                            <ul class="product-categories">
                                <li class="cat-item">
                                    <a href="{{ route('home') }}" class="{{empty($category_id) ? 'selected' : ''}}">All</a>
                                </li>
                                @if ($categories)
                                    @foreach ($categories as $category)
                                    <li class="cat-item">
                                        <a href="{{ route('home', ['category_id'=>$category->id]) }}" class="{{@$category_id == $category->id ? 'selected' : ''}}">{{$category->name}}</a>
                                    </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>

                    </div>
                    {{-- SIDEBAR END --}}
                </div>
            </div>
        </div>                  
    </div> <!-- end container -->
</section>
<!-- end shop-section -->
@endsection

@push('javascript') 

<script>
    $('#addRating').change('.rate', function(e) {
        // console.log($(this).serialize());
        // var csrf = $('meta[name="_token"]').attr('content');
        // var data = $(this).serialize();
        // console.log(csrf, data);
        e.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Once Confirmed, You will not be able to recover this!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#FF7043",
            confirmButtonText: "Yes, delete it!",
            closeOnCancel: true
        }) 
        .then((isConfirm) => {
            if (isConfirm) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),
                    }
                });
                $.ajax({
                    type: 'POST',
                    cache: false,
                    dataType: 'JSON',
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    // data: {"_token": csrf, data}, 
                    success: function(data) {
                        console.log(data);
                        if (data.success === true) {
                            swal("Done!", data.message, "success");
                            // window.location.href = "{{ route('home')}}";
                        } else {
                            swal("Error!", data.message, "error");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        swal({
                              title: "Opps!!",
                              text: "Seems you couldn't submit form for a longtime. Please refresh your form & try again",
                              confirmButtonColor: "#EF5350",
                              type: "error"
                        });
                     }
                });
            }else {
                swal({
                    title: "Cancelled",
                    text: "You cancelled your request",
                    confirmButtonColor: "#2196F3",
                    type: "error"
                });
            }
        });
                    
    });
</script>

@endpush
