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
    	$select = ['slug','title','selling_price','image_url','add_ups'];
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
    	$sessionCart = NULL;
    	if(Auth::check()){
    		$sessionCart = DB::table('carts')->where('user_id',Auth::user()->id)->value('session_cart');
    		$request->session()->put('session_cart', $sessionCart);
    	}
    	if($sessionCart == NULL || empty($sessionCart)){
            $request->session()->put('session_cart', 'CART_'.uniqid());
	    	$sessionCart = $request->session()->get('session_cart');
    	}
        return $sessionCart;
    } //end getSessionCart()

    public static function updateCart($request)
    {
        $updateCart = true;
        $data = $request->all();
    	$cartId = self::getCartId($request); // returns cart id
        if(is_null($cartId)){
            $cartId = self::createCart($request); // returns cart id
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
    	$userId = self::getLoggedUserId(); //gets logged in user id
    	$sessionCart = self::getSessionCart($request); //gets logged in user id
        //Creates new cart for user if not exist
    	$cart = Cart::updateOrCreate(
            ['session_cart' => $sessionCart],['user_id' => $userId,'ip_address' => $ipAddress]
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
  		if($request->session()->has('session_cart')){
  			$session_cart = $request->session()->get('session_cart');
  			$cartId = Cart::where('session_cart',$session_cart)->first();
            if(Auth::check() && $cartId->user_id == NULL){
                Cart::where('session_cart',$session_cart)->update(['user_id'=> Auth::user()->id]);
            }
            if(isset($cartId->id))
                $cartId = $cartId->id;
  		}elseif(Auth::check()){
            $cartId = Cart::where('user_id',Auth::user()->id)->first();
            $request->session()->put('session_cart',$cartId->session_cart);
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
                ->select('cart_products.id','cart_products.quantity','cart_products.product_id','products.selling_price','products.title','products.image_url','products.slug')
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
        $cartId = Cart::where('session_cart',$data['sct'])->value('id');
        $cart = self::getCart($cartId);
        $total = 0;
        $payStatus = $data['pay'];
        $user = NULL;
        if(Auth::check()){
            $user = Auth::user()->id;
        }
        if(!empty($cart)){
            DB::beginTransaction();
            $orderId = Order::create(['session_cart'=>$data['sct'],'user_id'=>$user,'payment_status'=>$payStatus,'payment_method'=>$payStatus])->id;
            $orderProduct = [];
            foreach($cart as $key=>$order){
                $orderProduct[$key]['order_id'] = $orderId;
                $orderProduct[$key]['product_id'] = $order->product_id;
                $orderProduct[$key]['quantity'] = $order->quantity;
                $total = $total + ($order->selling_price);
            }
            OrderProduct::insert($orderProduct);
            Order::where('id',$orderId)->update(['total_amount'=>$total]);
            CartProduct::where('cart_id',$cartId)->delete();
            DB::commit();
            return ['status'=>true];
        }else{
            return ['status'=>false];
        }
    }//end placeOrder()
}