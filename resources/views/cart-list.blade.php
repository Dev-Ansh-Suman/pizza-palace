@if(sizeof($products))
@php $total = 0; @endphp
	@foreach($products as $product)
		<div class="row" style="padding-top: 10px;padding-left: 10px;">
			<div class="col-4">
				<img src="{{url($product->image_url)}}" width="80" height="80">
			</div>
			<div class="col-6">
				<strong>{{ $product->title }}</strong> <br>
				<small>
					<b>
						Quantity : {{ $product->quantity }} x 
						<span class="price usd-price">${{$product->selling_price}}</span>
                    	<span class="price euro-price">€{{$product->selling_price_euro}}</span>
					</b>
				</small><br>
				<small>
					<b>
						Price : <span class="price usd-price">${{$product->quantity * $product->selling_price}}</span>
                    	<span class="price euro-price">€{{$product->quantity * $product->selling_price_euro}}</span>
					</b>
				</small><br>
				<div class="counter">
                    <div class="value-button decrease">-</div>
                    <input type="number" class="number input-wrap" value="{{ $product->quantity }}" size="2" data-pst="{{$product->slug}}" data-qty="{{ $product->quantity }}" />
                    <div class="value-button increase">+</div>
                </div>
			</div>
			<div class="col-2">
				<img class="update-cart" style="cursor: pointer;" src="{{url('/trash.jpg')}}" width="16" data-pst="{{$product->slug}}" data-qty="0">
			</div>
		</div>
		<hr>
		@php 
			$total = ($total + ($product->quantity * $product->selling_price)); 
		@endphp
	@endforeach
@else
<div class="text-center">
	<h4>Add Some</h4>
	<h4>Pizzas To</h4>
	<h4>This Cart</h4>
</div>
@endif