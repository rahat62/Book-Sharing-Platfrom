@extends('layouts.default')
@section('page-name', "Book Details")
@push('styles')
    
@endpush

@section('content')

    <!-- start shop-single-section -->
    <section class="shop-single-section section-padding">
        <div class="container-1410">
            <div class="row">
                <div class="col col-md-6">
                    <div class="shop-single-slider">
                        <div class="slider-for">
                            <div><img src="{{asset("uploads/book/".$book->book_thumb)}}" alt></div>
                        </div>
                        {{-- <div class="slider-nav">
                            <div><img src="{{asset("uploads/book/".$book->book_thumb)}}" alt></div>
                        </div> --}}
                    </div>
                </div>

                <div class="col col-md-6">
                    <div class="product-details">
                        <h2>{{$book->title}}</h2>
                        <div class="rating">
                            <i class="fi flaticon-star"></i>
                            <i class="fi flaticon-star"></i>
                            <i class="fi flaticon-star"></i>
                            <i class="fi flaticon-star"></i>
                            <i class="fi flaticon-star-social-favorite-middle-full"></i>
                            <span>(2 Customer review)</span>
                        </div>
                        <p>
                            {{Str::words(strip_tags($book->summery), 50)}}
                        </p>

                        <div class="addToCartDiv">
                            <button type="button" onclick="addToCart({{$book->id}})" >Add to List</button>
                        </div>

                        <div class="thb-product-meta-before" style="margin-top: 20px;">
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
                </div> <!-- end col -->
            </div> <!-- end row -->

            <div class="row">
                <div class="col col-xs-12">
                    <div class="single-product-info">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="active"><a href="#01" data-toggle="tab">Description</a></li>
                            {{-- <li><a href="#02" data-toggle="tab">Review (03)</a></li> --}}
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="01">
                                <p>
                                    {{strip_tags($book->summery)}}
                                </p>
                            </div>
                            {{-- <div role="tabpanel" class="tab-pane fade" id="02">
                                <div class="row">
                                    <div class="col col-xs-12">
                                        <div class="client-rv">
                                            <div class="client-pic">
                                                <img src="assets/images/shop/shop-single/review/img-1.jpg" alt>
                                            </div>
                                            <div class="details">
                                                <div class="name-rating-time">
                                                    <div class="name-rating">
                                                        <div>
                                                            <h4>Mice</h4>
                                                        </div>
                                                        <div class="rating">
                                                            <i class="fi flaticon-star"></i>
                                                            <i class="fi flaticon-star"></i>
                                                            <i class="fi flaticon-star"></i>
                                                            <i class="fi flaticon-star"></i>
                                                            <i class="fi flaticon-star"></i>
                                                        </div>
                                                    </div>
                                                    <div class="time">
                                                        <span>1 day ago</span>
                                                    </div>
                                                </div>
                                                <div class="review-body">
                                                    <p>Waved about helplessly as he looked What's happened to me he thought. It wasn't a dreamtrated magazine and housed in a nice, gilded frame. It showed a lady fitted out with a fur hat and fur boa who sat upright, raising a heavy fur muff that covered the whole of her lower arm towards the viewer. Gregor then turned to look out the window at the dull weather</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="client-rv">
                                            <div class="client-pic">
                                                <img src="assets/images/shop/shop-single/review/img-2.jpg" alt>
                                            </div>
                                            <div class="details">
                                                <div class="name-rating-time">
                                                    <div class="name-rating">
                                                        <div>
                                                            <h4>Hone</h4>
                                                        </div>
                                                        <div class="rating">
                                                            <i class="fi flaticon-star"></i>
                                                            <i class="fi flaticon-star"></i>
                                                            <i class="fi flaticon-star"></i>
                                                            <i class="fi flaticon-star"></i>
                                                            <i class="fi flaticon-star"></i>
                                                        </div>
                                                    </div>
                                                    <div class="time">
                                                        <span>1 day ago</span>
                                                    </div>
                                                </div>
                                                <div class="review-body">
                                                    <p>Waved about helplessly as he looked What's happened to me he thought. It wasn't a dreamtrated magazine and housed in a nice, gilded frame. It showed a lady fitted out with a fur hat and fur boa who sat upright, raising a heavy fur muff that covered the whole of her lower arm towards the viewer. Gregor then turned to look out the window at the dull weather</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="client-rv">
                                            <div class="client-pic">
                                                <img src="assets/images/shop/shop-single/review/img-3.jpg" alt>
                                            </div>
                                            <div class="details">
                                                <div class="name-rating-time">
                                                    <div class="name-rating">
                                                        <div>
                                                            <h4>Piloa</h4>
                                                        </div>
                                                        <div class="rating">
                                                            <i class="fi flaticon-star"></i>
                                                            <i class="fi flaticon-star"></i>
                                                            <i class="fi flaticon-star"></i>
                                                            <i class="fi flaticon-star"></i>
                                                            <i class="fi flaticon-star"></i>
                                                        </div>
                                                    </div>
                                                    <div class="time">
                                                        <span>2 days ago</span>
                                                    </div>
                                                </div>
                                                <div class="review-body">
                                                    <p>Waved about helplessly as he looked What's happened to me he thought. It wasn't a dreamtrated magazine and housed in a nice, gilded frame. It showed a lady fitted out with a fur hat and fur boa who sat upright, raising a heavy fur muff that covered the whole of her lower arm towards the viewer. Gregor then turned to look out the window at the dull weather</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- end col -->

                                    <div class="col col-xs-12 review-form-wrapper">
                                        <div class="review-form">
                                            <h4>Here you can review the item</h4>
                                            <form>
                                                <div>
                                                    <input type="text" class="form-control" placeholder="Name *" required>
                                                </div>
                                                <div>
                                                    <input type="email" class="form-control" placeholder="Email *" required>
                                                </div>
                                                <div>
                                                    <textarea class="form-control" placeholder="Review *"></textarea>
                                                </div>
                                                <div class="rating-wrapper">
                                                    <div class="rating">
                                                        <a href="#" class="star-1" >
                                                            <i class="ti-star"></i>
                                                        </a>
                                                        <a href="#" class="star-1" >
                                                            <i class="ti-star"></i>
                                                        </a>
                                                        <a href="#" class="star-1" >
                                                            <i class="ti-star"></i>
                                                        </a>
                                                        <a href="#" class="star-1" >
                                                            <i class="ti-star"></i>
                                                        </a>
                                                        <a href="#" class="star-1" >
                                                            <i class="ti-star"></i>
                                                        </a>
                                                    </div>
                                                    <div class="submit">
                                                        <button type="submit" class="theme-btn">Post review</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div> <!-- end row -->

            <div class="row">
                <div class="col col-xs-12">
                    <div class="realted-porduct">
                        <h3>Related Books</h3>
                        <ul class="products">
                            @foreach ($relatedBooks as $relatedBook)
                                <li class="product">
                                    <div class="product-holder" style="text-align: center;">
                                        <a href="{{ route('bookSingle', [$book->id]) }}" ><img src="{{asset("uploads/book/".$relatedBook->book_thumb)}}" width="200" alt></a>
                                        <div class="shop-action-wrap">
                                            <ul class="shop-action">
                                                <li><a href="#"  title="Quick view!"><i class="fi flaticon-view"></i></a></li>
                                                {{-- <li><a href="#" title="Add to Wishlist!"><i class="fi icon-heart-shape-outline"></i></a></li> --}}
                                                <li><a title="Add to cart!" onclick="addToCart({{$relatedBook->id}})" style="cursor: pointer;"><i class="fi flaticon-shopping-cart"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h4><a href="{{ route('bookSingle', [$relatedBook->id]) }}">{{$relatedBook->title}}</a></h4>
                                        <p class="product-description">{{Str::words(strip_tags($relatedBook->summery), 50)}} </p>
                                    </div>

                                    <div class="quick-view-single-product">
                                        <div class="view-single-product-inner clearfix">
                                            <button class="btn quick-view-single-product-close-btn"><i class="pe-7s-close-circle"></i></button>
                                            <div class="img-holder">
                                                <img src="{{asset("uploads/book/".$relatedBook->book_thumb)}}" alt>
                                            </div>
                                            <div class="product-details">
                                                <h4>{{$relatedBook->title}}</h4>
                                                <div class="rating">
                                                    <i class="fi flaticon-star"></i>
                                                    <i class="fi flaticon-star"></i>
                                                    <i class="fi flaticon-star"></i>
                                                    <i class="fi flaticon-star"></i>
                                                    <i class="fi flaticon-star-social-favorite-middle-full"></i>
                                                    <span>(2 Customer review)</span>
                                                </div>
                                                <p>{{Str::words(strip_tags($relatedBook->summery), 50)}}</p>
                                                <div class="product-option">
                                                    {{-- <form class="form" id="add-to-cart-form">
                                                        <input type="hidden" name="bood_id" value="{{ $relatedBook->id }}">
                                                    </form> --}}
                                                    <div class="addToCartDiv">
                                                        <button type="button" onclick="addToCart({{$relatedBook->id}})" >Add to cart</button>
                                                    </div>
                                                    {{-- <div class="loader" >
                                                        <img src="{{ asset('public/web/images/ajax-loader.gif') }}" alt="">
                                                    </div> --}}
                                                </div> 
                                                <div class="thb-product-meta-before">
                                                    <div class="product_meta">
                                                        <span class="posted_in">Author: 
                                                            <a href="#">{{$relatedBook->author_name}}</a>
                                                        </span>
                                                        <span class="posted_in">Categories: 
                                                            <a href="#">{{$relatedBook->category_name}}</a>
                                                        </span>
                                                        <span class="posted_in">Language: 
                                                            <a href="#">{{$relatedBook->language_name}}</a>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- end quick-view-single-product -->
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div> <!-- end of container -->
    </section>
    <!-- end of shop-single-section -->

@endsection

@push('javascript') 

@endpush
