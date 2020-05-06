<?php

namespace App\Helper;

use Auth;
use App\User;
use App\Model\Cart;
use App\Model\CartProduct;
use App\Model\Order;
use App\Model\OrderProduct;
use App\Model\Product;
use App\Model\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UserHelper
{
	/**
     * Display a listing of the resource.
     *
     * @param  optional int $perPage
     * @return \Illuminate\Http\Response
 	*/
    public static function getProducts($perPage=20)
    {
    	$select = ['slug','title','selling_price','selling_price_euro','image_url','add_ups'];
    	$products = Product::select($select)->paginate($perPage);
    	return $products;
    } //end getProducts()

    /**
     * Gets Client IP.
     *
     * @return \Illuminate\Http\Response
 	*/
    public static function getClientIp()
    {
        $ip = NULL;
        if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
          $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
          $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        elseif (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR']))
        {
          $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    } //end getClientIp()

    /**
     * Gets Looged In User Id.
     *
     * @return \Illuminate\Http\Response
 	*/
    public static function getLoggedUserId()
    {
    	$userId = NULL;
        if(Auth::check()){
        	$userId = Auth::user()->id;
        }
        return $userId;
    } //end getLoggedUserId()

    /**
     * Gets or Creates Session Cart.
     *
     * @return \Illuminate\Http\Response
 	*/
    public static function getSessionCart($request)
    {
    	$sessionCart = 'CART_'.uniqid();
        return $sessionCart;
    } //end getSessionCart()

    public static function updateCart($request)
    {
        $updateCart = true;
        $data = $request->all();
    	$cartSession = $request->session_cart; // returns cart id
        if(is_null($cartSession) || $cartSession == ''){
            $cartId = self::createCart($request); // returns cart id
        }else{
            $cartId = self::getCartId($request);
        }
        $productId = self::getProductId($data['product']);
        if($data['quantity'] == 0){
            $updateCart = CartProduct::where(['cart_id'=>$cartId,'product_id'=>$productId])->delete();
        }elseif($data['quantity'] == -1){
            $updateCart = CartProduct::where('cart_id',$cartId)->delete();
        }else{
            $updateCart = CartProduct::updateOrCreate(
                ['cart_id' => $cartId, 'product_id' => $productId],
                ['quantity' => $data['quantity']]
            );
        }
            
        if ($updateCart) {
            return ['status'=>true];
        } else {
            return false;
        }
    } //end updateCart()

    /**
     * Creates cart.
     *
     * @return \Illuminate\Http\Response
 	*/
    public static function createCart($request)
    {
		$ipAddress = self::getClientIp(); //gets client ip address
    	//$userId = self::getLoggedUserId(); //gets logged in user id
    	$sessionCart = self::getSessionCart($request); //gets logged in user id
        //Creates new cart for user if not exist
    	$cart = Cart::updateOrCreate(
            ['session_cart' => $sessionCart],['user_id' => '','ip_address' => $ipAddress]
        );
        return $cart->id;
    } //end createCart()

    /**
     * Returns Cart ID.
     *
     * @param  required \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
 	*/
    public static function getCartId($request)
    {
    	$cartId = NULL;
        $session_cart = $request->session_cart;
        $cartId = Cart::where('session_cart',$session_cart)->first();
        if(isset($cartId->id)){
            $cartId = $cartId->id;
        }
        return $cartId;
    } //end getCartId()

    /**
     * Returns Cart Products.
     *
     * @param  required $cartId
     * @return \Illuminate\Http\Response
    */
    public static function getCart($cartId)
    {
        if($cartId){
            $cartData = CartProduct::join('products','cart_products.product_id','=','products.id','left')
                ->select('cart_products.id','cart_products.quantity','cart_products.product_id','products.selling_price','products.selling_price_euro','products.title','products.image_url','products.slug')
                ->where('cart_id',$cartId)
                ->get();
        }else {
            $cartData = NULL;
        }
        return $cartData;
    } //end getCart()

    /**
     * Returns Product Id.
     *
     * @param  required $slug
     * @return \Illuminate\Http\Response
    */
    public static function getProductId($slug)
    {
        $productId = Product::where('slug',$slug)->value('id');
        return $productId;
    } //end getCart()

    /**
     * Place Order.
     *
     * @param  required \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public static function placeOrder($request)
    {
        $data = $request->all();
        $cartId = Cart::where('session_cart',$data['sct'])->first();
        if(isset($cartId->id)){
            $cart = self::getCart($cartId->id);
            $currency = $cartId->prefered_currency;
        }else{
            return ['status'=>false];
        }
        $total = 0;
        $payStatus = $data['pay'];
        $user = NULL;
        $orderToken = 'ORDER_'.uniqid();
        if(Auth::check()){
            $user = Auth::user()->id;
        }
        if(!empty($cart)){
            DB::beginTransaction();
            $orderId = Order::create(['session_cart'=>$data['sct'],'user_id'=>$user,'payment_status'=>$payStatus,'payment_method'=>$payStatus,'pay_currency'=>$currency,'order_token'=>$orderToken])->id;
            $orderProduct = [];
            foreach($cart as $key=>$order){
                $orderProduct[$key]['order_id'] = $orderId;
                $orderProduct[$key]['product_id'] = $order->product_id;
                $orderProduct[$key]['quantity'] = $order->quantity;
                if($currency == 1){
                    $total = $total + ($order->selling_price);
                }else{
                    $total = $total + ($order->selling_price_euro);
                }
            }
            OrderProduct::insert($orderProduct);
            Order::where('id',$orderId)->update(['total_amount'=>$total]);
            CartProduct::where('cart_id',$cartId)->delete();
            UserAddress::where(['session_cart'=>$data['sct'],'order_token'=>null])->update(['order_token'=>$orderToken]);
            DB::commit();
            return ['status'=>true];
        }else{
            return ['status'=>false];
        }
    }//end placeOrder()

    /**
     * Place Order.
     *
     * @param  required \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public static function setGetCurrency($request)
    {
        $data = $request->all();
        if($data['curr'] == 0){
            if($request->session()->has('prefered_currency')){
                $data['curr'] = $request->session()->get('prefered_currency');
            }else{
                $data['curr'] = 1;
            }
        }
        $request->session()->put('prefered_currency', $data['curr']);
        $cartId = self::getCartId($request);
        if(!is_null($cartId) || !empty($cartId)){
            Cart::where('id',$cartId)->update(['prefered_currency'=>$data['curr']]);
        }
        return $data['curr'];
    }//end placeOrder()

    /**
     * Get Order Bill.
     *
     * @param  required \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public static function getOrder($orderToken)
    {
        $order = Order::join('user_addresses','orders.order_token','=','user_addresses.order_token','left')
        ->where('orders.order_token',$orderToken)
        ->select('orders.id','orders.order_token','orders.total_amount','orders.payment_status','orders.payment_method','orders.pay_currency','user_addresses.username','user_addresses.address_line_1','user_addresses.address_line_2','user_addresses.landmark','user_addresses.mobile')->first();
        $sp = DB::raw('products.selling_price as sp');
        if($order->pay_currency == 1){
            $sp = DB::raw('products.selling_price_euro as sp');
        }
        $orderProduct = OrderProduct::join('products','order_products.product_id','=','products.id','left')
            ->where('order_id',$order->id)
            ->select('order_products.quantity',$sp,'products.title','products.image_url')->get();
        return ['order'=>$order,'products'=>$orderProduct];
    }//end getOrder()

    /**
     * Get Order List for auth user.
     *
     * @param  required \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public static function getOrderList()
    {
        $orders = NULL;
        if(Auth::check()){
            $orders = Order::where('user_id',Auth::user()->id)
                ->select('orders.order_token','orders.total_amount','orders.payment_status','orders.payment_method','orders.pay_currency')->get();
        }
        return $orders;
    }//end getOrderList()
}