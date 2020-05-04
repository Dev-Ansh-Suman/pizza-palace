<div class="col-12">
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
                <b class="cart-total-b">
                    <span class="cart-total price usd-price"></span>
                    <span class="cart-total-euro price euro-price"></span>
                </b><br><br>
                <a href="" class="btn btn-danger update-cart clear-cart" data-pst="{{Session::get('session_cart')}}" data-qty="-1">Clear Cart</a>
                <div class="btn-checkout"><a href="#" data-toggle="modal" data-target="#addAddress" class="btn btn-success">Checkout</a></div>
            </div>
        </div>
    </div>


    <div class="currency">
        <img src="{{url('currency.png')}}" width="30" style="cursor: pointer;">
        <div class="currency-items row text-center"> 
            <div class="col-12" style="padding-top: 5px;">
                <input type="radio" name="currency" value="1" id="usd" class="currency-switch">
                <label for="usd">USD</label>
            </div>  
            <hr>
            <div class="col-12">
                <input type="radio" name="currency" value="2" id="euro" class="currency-switch">
                <label for="euro">Euro</label>
            </div>
        </div>
    </div>

    <div class="user">
        @auth
        <span style="cursor: pointer;">{{ Auth::user()->name }}</span>
        <div class="profile-items text-center">
            <a href="#" data-toggle="modal" data-target="#orderList">Order List</a><br>
            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Logout</a>  
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>  
        </div>
        @else
        <a href="{{url('/login')}}">
            <img src="{{url('user.png')}}" width="30">
        </a>
        @endauth
    </div>
</div>