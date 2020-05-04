<!-- Address Modal -->
<div class="modal" id="addAddress">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Provide Your Delivery Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body form-group">
                <form class="user-address" method="post" action="{{url('store-address')}}">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Your Name (Required**)" required="">
                    </div>
                    <div class="form-group">
                        <input type="text" name="mobile" class="form-control" placeholder="Your Mobile (Required**)" required="">
                    </div>
                    <div class="form-group">
                        <input type="text" name="address_line_1" class="form-control" placeholder="Address Line 1 (Required**)" required="">
                    </div>
                    <div class="form-group">
                        <input type="text" name="address_line_2" class="form-control" placeholder="Address Line 2 (Optional**)">
                    </div>
                    <div class="form-group">
                        <input type="submit" name="post" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Address Modal End -->

<!-- Cart Review Modal -->
<div class="modal" id="reviewCart">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Review Your Cart</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="cart-items">
                    
                </div>
                <div class="cart-total-div">
                    <strong> Grand Total </strong>
                    <b class="cart-total-b">
                        <span class="cart-total price usd-price"></span>
                        <span class="cart-total-euro price euro-price"></span>
                    </b><br><br>
                    <b>Select Payment Method : </b>
                    <input type="radio" name="pay" value="1" checked="" id="online-pay">
                    <label for="online-pay">Online</label>
                    <input type="radio" name="pay" value="0" id="cod-pay">
                    <label for="cod-pay">After Delivery</label>
                    <br><br>
                    <a href="" class="btn btn-success place-order" data-sct="{{Session::get('session_cart')}}">Place Order</a>
                    <div class="btn-checkout"><a href="#" class="btn btn-primary change-address" data-pst="{{Session::get('session_cart')}}" data-qty="-1">Change Adddress</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart Review Modal End -->

<!-- Order Bill Modal -->
<div class="modal" id="orderBill">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Your Order Bill</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="ordered-items">
                    
                </div>
                <div class="cart-total-div">
                    <strong> Grand Total </strong>
                    <b class="cart-total-b">
                        <span class="order-total price usd-price"></span>
                    </b>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Order Bill Modal End -->

<!-- Order Bill Modal -->
<div class="modal" id="orderList">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">
                    Your Order List
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body text-center order-list">
                
            </div>
        </div>
    </div>
</div>
<!-- Order Bill Modal End -->