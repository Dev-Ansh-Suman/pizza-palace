@if(!is_null($orders))
@if(sizeof($orders))
<table class="table table-striped order-list-table">
    <thead>
        <tr>
            <th>Order No</th>
            <th>Amount</th>
            <th>Payment</th>
            <th>Date</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($orders as $order)
    	<tr>
            <td>{{$order->order_token}}</td>
            <td>{{$order->total_amount}}</td>
            <td>
            	@if($order->payment_status)
            	<span style="color: green;">Paid</span> (Online)
            	@else
            	<span style="color: red;">Unpaid</span>
            	@endif
            </td>
            <td>{{date('d M y',$order->created_at)}}</td>
            <td><a style="cursor: pointer;" class="view-order" data-order="{{$order->order_token}}">View</a></td>
        </tr>
	@endforeach
    </tbody>
</table>
@else
<div style="display: table;">
	<strong class="text-center">You Don't have any past order record</strong>
</div>
@endif
@else
<div style="display: table;">
	<strong>You Don't have any past order record</strong>
</div>
@endif
	