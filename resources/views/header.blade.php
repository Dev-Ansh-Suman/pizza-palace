<div class="col-12">
    <div class="user">
        @auth
        @else
        <a href="{{url('/login')}}">
            <img src="{{url('user/user.jpg')}}" width="30">
        </a>
        @endauth
    </div>
    <div class="cart">
        <span class="cart-count"></span>
        <img style="cursor:pointer;" src="{{url('/cart.png')}}" width="30"><br>
        <div class="cart-content">
            <div class="cart-heading">
                <h5 class="text-center"> My Pizza Cart </h5>
            </div>
            <div class="cart-items">
                
            </div>
            <div class="cart-total-div">
                <strong> Grand Total </strong>
                <b class="cart-total"></b><br><br>
                <a href="" class="btn btn-danger update-cart clear-cart" data-pst="{{Session::get('session_cart')}}" data-qty="-1">Clear Cart</a>
                <div class="btn-checkout"><a href="#" data-toggle="modal" data-target="#addAddress" class="btn btn-success">Checkout</a></div>
            </div>
        </div>
    </div>
</div>