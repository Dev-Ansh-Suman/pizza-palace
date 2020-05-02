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
                <strong class="price" style="color: #fd509d;">${{$product->selling_price}}</strong>
            </div>
            <div class="col-6 update-cart-div" style="left: 32% !important">
                <img class="update-cart add-to-cart" style="cursor:pointer" src="{{url('/cart.png')}}" width="30" data-pst="{{$product->slug}}" data-qty="1">
            </div>
            <div class="col-6 counter-div" style="display: none;">
                <form class="counter">
                    <div class="value-button" class="decrease" onclick="decreaseValue()" value="Decrease Value">-</div>
                    <input type="number" class="number input-wrap" value="0" size="2" />
                    <div class="value-button" class="increase" onclick="increaseValue()" value="Increase Value">+</div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach