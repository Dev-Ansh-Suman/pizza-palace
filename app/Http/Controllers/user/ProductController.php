<?php

namespace App\Http\Controllers\user;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Product;
use App\Model\UserAddress;
use App\Helper\UserHelper;
use Illuminate\Support\Facades\View;

class ProductController extends Controller
{

	/**
     * Display a listing of the resource.
     *
     * @param  required \Illuminate\Http\Request $request
     * @param  optional int $perPage
     * @return \Illuminate\Http\Response
 	*/
    public function index(Request $request,$perPage=20)
    {
    	$products = UserHelper::getProducts($perPage);
        
		/*$listPage = View::make('product-list',['products'=>$products]);
		$listPage = $listPage->render();*/
		return  response()->json(['status'=>true,'products'=>$products->toArray()]);
    } //end index()

    /**
     * Adds up item to the cart.
     *
     * @param  required \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
 	*/
    public function updateCart(Request $request)
    {
    	$addToCart = UserHelper::updateCart($request); //add product to cart
        if ($addToCart['status']) {
            $refreshCart = $this->refreshCart($request);
            return $refreshCart;
        } else {
            return['status'=>false];
        }
    } //end updateCart()

    /**
     * Refreshes cart.
     *
     * @param  required \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public function refreshCart(Request $request)
    {
        $itemCount = 0;
        $total = 0;
        $total_euro = 0;
        $cartId = UserHelper::getCartId($request);
        $getCart = [];
        if(!is_null($cartId)){
            $getCart = UserHelper::getCart($cartId);
        }
        if(!empty($getCart) && !is_null($getCart)) {
            foreach($getCart as $product){
                $total = $total + ($product->selling_price * $product->quantity);
                $total_euro = $total_euro + ($product->selling_price_euro * $product->quantity);
                $itemCount++;
            }
        }
		$sideCart = View::make('cart-list',['products'=>$getCart]);
    	$sideCart = $sideCart->render();
		return  response()->json(['status'=>true,'view'=>$sideCart,'item_count'=>$itemCount,'total'=>$total,'total_euro'=>$total_euro]);
    }//end refreshCart()

    /**
     * Set and Get Prefered Currency.
     *
     * @param  required \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public function getCurrency(Request $request)
    {
        $currency = UserHelper::setGetCurrency($request);
        return  response()->json(['status'=>true,'currency'=>$currency]);
    }//end getCurrency()

}

//$request->ajax()