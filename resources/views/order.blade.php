@php 
$cur_sign = '$'; 
@endphp
@if($order->pay_currency == 2)
@php $cur_sign = '€'; @endphp
@endif
<div class="row">
	<div class="col-12" style="padding-bottom: 22px !important;">
		<h3>Order Number : {{$order->order_token}}</h3>
	</div>
	<div class="col-6" style="padding-bottom: 22px !important;">
	    <div style="padding: 12px !important;border: 2px solid #fd509d !important;">
	        <p><strong>Payment Details</strong></p>
	        <p><b>Total Amount :  {{$cur_sign.''.$order->total_amount}}</b></p>
	        <p><b>Payment Status :  
	        	@if($order->payment_status)
	        		<span style="color: green">Paid</span>
	        	@else
	        		<span style="color: red">Unpaid</span>
	        	@endif
        	</b></p>
        	<p><b>Payment Method :  
	        	@if($order->payment_method) Online @else Offline @endif
        	</b></p>
	    </div>
	</div>
	<div class="col-6" style="padding-bottom: 22px !important;">
	    <div style="padding: 12px !important;border: 2px solid #fd509d !important;">
	        <p><strong>Delivery Details</strong></p>
	        <p><b>{{$order->username}}</b></p>
	        <p><b>{{$order->mobile}}</b></p>
	        <p><b>{{$order->address_line_1}}</b></p>
	    </div>
	</div>
	@foreach($products as $product)
	<div class="col-4">
		<img src="{{url($product->image_url)}}" width="80" height="80">
	</div>
	<div class="col-6">
		<strong>{{ $product->title }}</strong> <br>
		<small>
			<b>
				Quantity : {{ $product->quantity }} x {{$cur_sign.''.$product->sp}}
			</b>
		</small>
	</div>
	<div class="col-2">
		<small>
			<b>
				Price : {{$cur_sign.''.($product->quantity * $product->sp)}}
			</b>
		</small>
	</div>
	@endforeach
</div>