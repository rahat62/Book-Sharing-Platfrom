{{-- @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"]) --}}
@extends('layouts.default')

@push('styles')

@endpush
@section('page-name', 'View Cart')
@section('content')
<style>
   .my-account-section .u-column1, .my-account-section .u-column2{
      float: none;
      margin: 0 auto;
   }
</style>
<!-- start cart-section -->
<section class="cart-section woocommerce-cart section-padding">
   <div class="container-1410">
      <div class="row">
         <div class="col col-xs-12">
               <div class="woocommerce">
                  <form action="{{ route('checkoutAction') }}" method="post" id="borrowForm">
                     @csrf
                     <table class="shop_table shop_table_responsive cart">
                        <thead>
                           <tr>
                              <th class="product-remove">&nbsp;</th>
                              <th class="product-thumbnail">&nbsp;</th>
                              <th class="product-name">Book</th>
                              <th class="product-price">Owner</th>
                              <th class="product-subtotal">Location</th>
                           </tr>
                        </thead>
                        <tbody id="viewCart">
                           @if (session('msgType'))
                              <tr>
                                 <div id="msgDiv" class="alert alert-{{session('msgType')}} alert-styled-left alert-arrow-left alert-bordered">
                                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                                    <span class="text-semibold">{{ session('msgType') }}!</span> {{ session('messege') }}
                                 </div>
                              </tr>
                           @endif
                           
                           @if(session()->has('cart') && count( session()->get('cart')) > 0)
                           @foreach(session('cart') as $key => $cartItem)
                              <tr class="cart_item">
                                 <td class="product-remove">
                                    <a class="remove" title="Remove this item" data-product_id="8" data-product_sku="my name is" onclick="removeFromCart({{ $key }}, 1)" style="cursor: pointer;">&times;</a> 
                                 </td>
                                 <td class="product-thumbnail">
                                    <a href="#">
                                       <img width="57" height="70" src="{{asset('uploads/book/thumb/'.$cartItem['thumbnail'])}}" 
                                       class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image" alt="#"  />
                                    </a>
                                 </td>
                                 <td class="product-name" data-title="Product">
                                    <a href="{{route('bookDetails')}}">{{$cartItem['name']}}</a> 
                                    <input type="hidden" class="book_id" value="{{$cartItem['id']}}" name="book_id[]">
                                    <input type="hidden" class="owner_id" value="{{$cartItem['owner']}}" name="owner_id[]">
                                 </td>

                                 <td class="product-price" data-title="Price">
                                    <span class="woocommerce-Price-amount amount">
                                       @php($userData = App\Models\Users_user::find($cartItem['owner']))
                                       {{$userData->first_name.' '.$userData->last_name}}
                                    </span>
                                    <input type="hidden" value="{{$cartItem['owner']}}" name="user_id[]">

                                 </td>
                                 <td class="product-subtotal" data-title="Total">
                                    {{$userData->address}}
                                 </td>
                              </tr>
                           @endforeach
                           @else
                              <tr style="text-align: center;">
                                 <td colspan="5"> Empty </td>
                              </tr>
                           @endif

                           <tr>
                              <td colspan="2">
                                 <a href="{{ route('home') }}" class="checkout-button button alt wc-forward">Choose Again</a>
                              </td>
                              <td colspan="4" class="actions">
                                    <input type="submit" class="button" name="update_cart" class="borrowBtn" value="Borrow Now" />
                                    {{-- <input type="hidden" id="_wpnonce" name="_wpnonce" value="918724a9c2" />
                                    <input type="hidden" name="_wp_http_referer" value="/wp/?page_id=5" />  --}}
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </form>

                  {{-- <div class="cart-collaterals">
                     <div class="cart_totals calculated_shipping">
                           <h2>Cart Totals</h2>
                           <table class="shop_table shop_table_responsive">
                              <tr class="cart-subtotal">
                                 <th>Subtotal</th>
                                 <td data-title="Subtotal"><span class="woocommerce-Price-amount amount">
                                       <span class="woocommerce-Price-currencySymbol">&pound;</span>430.00</span>
                                 </td>
                              </tr>
                              <tr class="shipping">
                                 <th>Shipping</th>
                                 <td data-title="Shipping">
                                       Free Shipping
                                       <input type="hidden" name="shipping_method[0]" data-index="0" id="shipping_method_0" value="free_shipping:1" class="shipping_method" />
                                       <form class="woocommerce-shipping-calculator" action="http://localhost/wp/?page_id=5" method="post">
                                          <p><a href="#" class="shipping-calculator-button">Calculate Shipping</a></p>
                                          <section class="shipping-calculator-form" style="display:none;">
                                             <h2 class="hidden">Cart total</h2>
                                             
                                             <p class="form-row form-row-wide" id="calc_shipping_state_field">
                                                   <input type="hidden" name="calc_shipping_state" id="calc_shipping_state" /> 
                                             </p>
                                             <p class="form-row form-row-wide" id="calc_shipping_postcode_field">
                                                   <input type="text" class="input-text" value="" placeholder="Postcode / ZIP" name="calc_shipping_postcode" id="calc_shipping_postcode" />
                                             </p>
                                             <p>
                                                   <button type="submit" name="calc_shipping" value="1" class="button">Update Totals</button>
                                             </p>
                                             <input type="hidden" id="_wpnonced" name="_wpnonce" value="918724a9c2" />
                                             <input type="hidden" name="_wp_http_referer" value="/wp/?page_id=5" /> </section>
                                       </form>
                                 </td>
                              </tr>

                              <tr class="order-total">
                                 <th>Total</th>
                                 <td data-title="Total"><strong><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">&pound;</span>430.00</span></strong> </td>
                              </tr>
                           </table>

                           <div class="wc-proceed-to-checkout">
                              <a href="checkout.html" class="checkout-button button alt wc-forward">Proceed to Checkout</a>
                           </div>
                     </div>
                  </div> --}}
               </div>
         </div>
      </div>
   </div>
</section>
<!-- end cart-section -->

@endsection

@push('javascript') 
   <script>
         $('form').submit(function(e) {
            e.preventDefault();
            // var book_id = $('.book_id').val();
            var book_ids = $('input[name="book_id[]"]').map(function(){
               return this.value;
            }).get();
            var owner_ids = $('input[name="owner_id[]"]').map(function(){
               return this.value;
            }).get();
            var csrf = $(this).find("input[name='_token']").val();
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
                  // $('input[type="submit"]').trigger('click');
                  // $('#borrowForm').submit();
                  $.ajax({
                     url : '{{ route('checkoutAction') }}',
                     type: "POST",
                     data: {"_token": csrf, 'book_id': book_ids, 'owner_id': owner_ids}, 
                     dataType: 'json',
                     success:function(data){
                        console.log('hello');
                        if (data.success === true) {
                           swal("Done!", data.message, "success");
                           window.location.href = "{{ route('home')}}";
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
               }
                  // window.location.href = href;
               else {
                  swal({
                     title: "Cancelled",
                     text: "You cancelled your request",
                     confirmButtonColor: "#2196F3",
                     type: "error"
                  });
               }
            });
            // function(isConfirm){
            //    if (isConfirm) {
            //       form.submit();
            //    }else {
            //       swal({
            //          title: "Cancelled",
            //          text: "Your imaginary file is safe :)",
            //          confirmButtonColor: "#2196F3",
            //          type: "error"
            //       });
            //    }
            // });
         });
   </script>
@endpush