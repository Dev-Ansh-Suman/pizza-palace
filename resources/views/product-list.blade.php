@foreach($products as $product)
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6" style="padding-bottom: 22px !important;">
    <div style="padding: 12px !important;border: 2px solid #fd509d !important;">
        <div class="text-center">
            <img class="img-fluid" src="{{url($product->image_url)}}" width="370" height="246">
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <h5 style="color: #fd509d;">{{$product->title}}</h5>
                <b><i>{{$product->add_ups}}</i></b>
            </div>
            <div class="col-6" style="left: 2% !important">
                <strong class="price-list" style="color: #fd509d;">
                    <span class="price usd-price">${{$product->selling_price}}</span>
                    <span class="price euro-price">€{{$product->selling_price_euro}}</span>
                </strong>
            </div>
            <div class="col-6 update-cart-div" style="left: 32% !important">
                <img class="update-cart add-to-cart" style="cursor:pointer" src="{{url('/cart.png')}}" width="30" data-pst="{{$product->slug}}" data-qty="1">
            </div>
            <div class="col-6 counter-div" style="display: none;">
                <div class="counter">
                    <div class="value-button decrease">-</div>
                    <input type="number" class="number input-wrap" value="1" size="2" data-pst="{{$product->slug}}" data-qty="1" />
                    <div class="value-button increase">+</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach