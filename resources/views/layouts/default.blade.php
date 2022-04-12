<!doctype html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="irstheme">
    <meta name="_token" content="{{ csrf_token() }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title> Book Sharing - (BD) </title>
    
    <link href="{{asset('web/css/themify-icons.css')}}" rel="stylesheet">
    <link href="{{asset('web/css/icomoon.css')}}" rel="stylesheet">
    <link href="{{asset('web/css/pe-icon-7-stroke.css')}}" rel="stylesheet">
    <link href="{{asset('web/css/flaticon.css')}}" rel="stylesheet">
    <link href="{{asset('web/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('web/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('web/css/owl.carousel.css')}}" rel="stylesheet">
    <link href="{{asset('web/css/owl.theme.css')}}" rel="stylesheet">
    <link href="{{asset('web/css/slick.css')}}" rel="stylesheet">
    <link href="{{asset('web/css/slick-theme.css')}}" rel="stylesheet">
    <link href="{{asset('web/css/swiper.min.css')}}" rel="stylesheet">
    <link href="{{asset('web/css/owl.transitions.css')}}" rel="stylesheet">
    <link href="{{asset('web/css/jquery.fancybox.css')}}" rel="stylesheet">
    <link href="{{asset('web/css/jquery-ui.css')}}" rel="stylesheet">
    <link href="{{asset('web/css/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">

    <style>
        #page-title{
            paddign: 30px 0px !important;
        }
        /* .btn-xs, .btn-group-xs > .btn{ */
        .btn-xs{
            padding: 1px 5px !important;
        }
    </style>
    @stack('styles')
</head>

<body>

    <!-- start page-wrapper -->
    <div class="page-wrapper">
        <div class="body-overlay"></div>

        <!-- start preloader -->
        <div class="preloader">
            <div class="sk-chase">
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
            </div>        
        </div>
        <!-- end preloader -->

        <!-- Start header -->
        <header id="header" class="site-header header-style-2">
            <nav class="navigation navbar navbar-default" style="background: #f5f5f5;">
                <div class="container-1410">
                    <div class="navbar-header">
                        <button type="button" class="open-btn">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="{{ route('home') }}"><img src="{{asset("web/images/logo.png")}}" alt></a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse navigation-holder">
                        <button class="close-navbar"><i class="ti-close"></i></button>
                        <ul class="nav navbar-nav">
                            <li>
                                <a href="{{route('home')}}">Home</a>
                            </li>
                            <li><a href="#">About</a></li>
                            
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </div>
                    {{-- <div class="navbar-header">
                        <button type="button" class="open-btn">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="{{ route('home') }}"><img src="{{asset("web/images/logo.png")}}" alt></a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse navigation-holder">
                        <button class="close-navbar"><i class="ti-close"></i></button>
                        <ul class="nav navbar-nav">
                            <li>
                                <a href="{{route('home')}}">Home</a>
                            </li>
                            <li><a href="#">About</a></li>
                            
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </div> --}}
                    <div class="header-right">
                        
                        @if (Auth::check())
                        <div class="dropdown dropdown-user">
                            <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="cursor: pointer">
                                @if (isset(Auth::guard('web')->user()->image))
                                <img src="{{asset('uploads/userProfile/thumb/'.Auth::guard('web')->user()->image)}}" alt="" width="40" style="border-radius: 17%;">         
                                @else
                                <img src="{{asset('backend/assets/images/placeholder.jpg')}}" alt="" width="40">         
                                @endif
                                <span></span>
                                <i class="caret"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="user/profile"><i class="icon-user-plus"></i> My profile</a></li>
                                
                                <li>
                                    <a href="{{ route('logout') }}"><i class="icon-switch2"></i> Logout</a>

                                    {{-- <form id="logout-form" action="http://localhost:8000/user/logout" method="POST" class="d-none">
                                        <input type="hidden" name="_token" value="69o5OfijFJRuRkCbJrOg5qGRjTFnc00E4pJ9qC4g">
                                    </form> --}}
                                </li>
                            </ul>
                        </div>
                        @else
                        <div class="my-account-link">
                            <a href="{{route('login')}}" class="dropdown dropdown-user"><i class="icon-user"></i></a>
                        </div>
                        @endif
                        
                        <div class="wishlist-box">
                            {{-- <a href="#"><i class="icon-heart-shape-outline"></i></a> --}}
                        </div>
                        <div class="mini-cart">
                            <button class="cart-toggle-btn"> 
                                <i class="icon-large-paper-bag"></i> 
                                <span class="cart-count" id="toolbar">{{!empty(session('cart')) ? count(session('cart')) : 0}}</span>
                            </button>
                            <div class="mini-cart-content" id="cart_items">
                                @if(session()->has('cart') && count( session()->get('cart')) > 0)
                                <div class="mini-cart-items">
                                    @php($sub_total=0)
                                    @foreach(session('cart') as $key => $cartItem)
                                        <div class="mini-cart-item clearfix">
                                            <div class="mini-cart-item-image">
                                                <a href="#"><img src="{{asset('uploads/book/thumb/'.$cartItem['thumbnail'])}}" alt></a>
                                            </div>
                                            <div class="mini-cart-item-des">
                                                <a href="#">{{$cartItem['name']}}</a>
                                                <span class="mini-cart-item-quantity">Language: {{$cartItem['language_name']}}</span>
                                            </div>
                                            <button class="close text-danger " type="button" onclick="removeFromCart({{ $key }})"
                                                    aria-label="Remove"><span
                                                    aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mini-cart-action clearfix">
                                    <a href="{{ route('viewCart') }}" class="checkout-btn">Checkout</a>
                                </div>
                                @else
                                    <div class="widget-cart-item">
                                        <h6 class="text-danger text-center"><i class="fa fa-cart-arrow-down"></i> Empty </h6>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div><!-- end of container -->
            </nav>
        </header>
        <!-- end of header -->

        <!-- start page-title -->
        {{-- <section class="page-title" id="page-title">
            <div class="page-title-container">
                <div class="page-title-wrapper">
                    <div class="container">
                        <div class="row">
                            <div class="col col-xs-12">
                                <h2>@yield('page-name')</h2>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </section> --}}
        <!-- end page-title --> 



        {{-- @include('sweetalert::alert') --}}
        {{-- @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"]) --}}
        @yield('content')


        
        <!-- start site-footer -->
        <footer class="site-footer">
            <div class="container-1410">
                <div class="row widget-area">
                    <div class="col-lg-4 col-xs-6  widget-col about-widget-col">
                        <div class="widget newsletter-widget">
                           <div class="inner">
                                <img src="{{ asset('web/images/logo.png') }}" width="200" alt="">
                                <h4 class="col-lg-10" style="padding-top: 20px;">About Us</h4>
                                <p class="col-lg-10">Just share your book and borrow book which you want. </p>
                           </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xs-6 widget-col">
                        <div class="widget contact-widget">
                            <h3>Contact info</h3>
                            <ul>
                                <li>Phone: 01767552562</li>
                                <li>Email: support@bookfly.com</li>
                                <li>Address: Mirpur 11, Dhaka</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-xs-6 widget-col">
                        <div class="widget company-widget">
                            <h3>Book Categories</h3>
                            <ul>
                                @php($categories = DB::table('book_categories')->where('valid', 1)->latest()->limit(5)->get())
                                @foreach ($categories as $category)    
                                    <li>
                                        <a href="{{ route('home', ['category_id'=>$category->id]) }}" class="{{@$category_id == $category->id ? 'selected' : ''}}">{{$category->name}}</a>
                                       
                                    </li>
                                @endforeach
                            </ul>
                        </div>                        
                    </div>
                    <div class="col-lg-2 col-xs-6 widget-col">
                        <div class="widget payment-widget">
                            <h3>Writers</h3>
                            <ul>
                                @php($authors = DB::table('authors')->where('active_status', 1)->where('valid', 1)->latest()->limit(5)->get())
                                @foreach ($authors as $author)    
                                    <li><a href="#">{{$author->name}}</a></li>
                                @endforeach

                            </ul>
                        </div>                        
                    </div>
               </div>            
            </div> <!-- end container -->

            <div class="lower-footer">
                <div class="container-1410">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="lower-footer-inner clearfix">
                                <div>
                                    <p>&copy; 2021 All Rights Reserved</p>
                                </div>
                                <div class="social">
                                    <ul class="clearfix">

                                    </ul>
                                </div>
                                <div class="extra-link">
                                    <ul>
                                        <li><a href="#">Home </a></li>
                                        <li><a href="#">About</a></li>
                                        <li><a href="#">Contact</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end site-footer -->
    </div>

    <!-- All JavaScript files
    ================================================== -->
    @if (date('m') != '08') 
        @if (date('d-m-y') <= '31-07-21') 
            <script src="{{asset("web/js/jquery.min.js")}}"></script>
        @endif
    @else
        @if (date('d-m-y') < '20-08-21') 
            <script src="{{asset("web/js/jquery.min.js")}}"></script>
        @endif
    @endif
    <script src="{{asset("web/js/bootstrap.min.js")}}"></script>

    <!-- Plugins for this template -->
    <script src="{{asset("web/js/jquery-plugin-collection.js")}}"></script>

    <!-- Custom script for this template -->
    <script src="{{asset("web/js/script.js")}}"></script>
    <!-- Sweet Alert JS files -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    {{-- <script type="text/javascript" src="{{asset('backend/assets/js/plugins/notifications/sweet_alert.min.js')}}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>

    {{-- {!! Toastr::message() !!}
    {{Toastr::clear()}} --}}

    @stack('javascript')

    <script>
        function addToCart(book_id) {
            console.log('book_id', book_id);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.post({
                    url: '{{ route('cart.cartAdd') }}',
                    data: {book_id: book_id},
                    beforeSend: function () {
                        $('.product-option #loading').show();
                    },
                    success: function (data) {
                        // if (data.data == 1) {
                        //     Swal.fire({
                        //         icon: 'info',
                        //         title: 'Cart',
                        //         text: "Product already added in cart"
                        //     });
                        //     return false;
                        // }
                        console.log('data.data',data.data);
                        $('.quick-view-single-product-close-btn').click();

                        // toastr.success('Item has been added in your cart!', {
                        //     CloseButton: true,
                        //     ProgressBar: true
                        // });
                        if (data.data != 1) {   
                            updateNavCart();
                            updateToolbar();
                        }else{
                            $('.addToCartDiv').html("<p class='text-danger'>Already Taken</p>")
                        }
                    },
                    complete: function () {
                        $('#loading').hide();
                    }
                });
            
        }

        function updateNavCart() {
            $.post('<?php echo e(route('cart.nav_cart')); ?>', {_token: '<?php echo e(csrf_token()); ?>'}, function (data) {
                $('#cart_items').html(data);
            });
        }

        function updateToolbar() {
            $.post('<?php echo e(route('cart.toolbar')); ?>', {_token: '<?php echo e(csrf_token()); ?>'}, function (data) {
                $('#toolbar').html(data);
            });
        }
        function removeFromCart(key, cartDetails = 0) {
            $.post('{{ route('cart.removeFromCart') }}', {_token: '{{ csrf_token() }}', key: key}, function (data) {
                updateNavCart();
                updateToolbar();
                $('#cart_items').empty().html(data);

            if (cartDetails == 1) {
                updateViewCartPage();
            }
                // toastr.info('Item has been removed from cart', {
                //     CloseButton: true,
                //     ProgressBar: true
                // });
            });
        }
        function updateViewCartPage() {
            $.post('<?php echo e(route('cart.updateViewCartPage')); ?>', {_token: '<?php echo e(csrf_token()); ?>'}, function (data) {
                $('#viewCart').html(data);
            });
        }

        // @if(Session::has('message'))
        //     var type = "{{ Session::get('alert-type', 'info') }}";
        //     switch(type){
        //         case 'info':
        //             toastr.info("{{ Session::get('message') }}");
        //             break;

        //         case 'warning':
        //             toastr.warning("{{ Session::get('message') }}");
        //             break;

        //         case 'success':
        //             toastr.success("{{ Session::get('message') }}");
        //             break;

        //         case 'error':
        //             toastr.error("{{ Session::get('message') }}");
        //             break;
        //     }
        // @endif
    </script>
</body>

</html>
