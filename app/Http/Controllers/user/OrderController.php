<?php

namespace App\Http\Controllers\user;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Product;
use App\Model\UserAddress;
use App\Model\Order;
use App\Helper\UserHelper;
use Illuminate\Support\Facades\View;

class OrderController extends Controller
{
    /**
     * Add Delivery Address.
     *
     * @param  required \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public function storeAddress(Request $request)
    {
        $data = $request->all();
        $insertArray = [];
        foreach($data as $key => $value)
        {
            if($key != '_token' && $key != 'submit')
                $insertArray[$key] = $value;
        }
        $insertArray['session_cart'] = $request->session()->get('session_cart');
        if(Auth::check()){
            $insertArray['user_id'] = Auth::user()->id;
        }
        UserAddress::updateOrCreate(['session_cart'=>$insertArray['session_cart'],'order_token'=>null],$insertArray);
        return  response()->json(['status'=>true]);
    }//end storeAddress()

    /**
     * Place Order.
     *
     * @param  required \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public function placeOrder(Request $request)
    {
        $order = UserHelper::placeOrder($request);
        return  response()->json(['status'=>$order['status']]);
    }//end placeOrder()

    /**
     * Get Order Bill.
     *
     * @param  required \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
    */
    public function show($orderToken)
    {
        $order = UserHelper::getOrder($orderToken);
        $view = View::make('order',['order'=>$order['order'],'products'=>$order['products']]);
        $view = $view->render();
        return  response()->json(['status'=>true,'view'=>$view]);
    }//end show()

    /**
     * Display a listing of the resource.
     *
     * @param  required \Illuminate\Http\Request $request
     * @param  optional int $perPage
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $orders = UserHelper::getOrderList();
        $view = View::make('order-list',['orders'=>$orders]);
        $view = $view->render();
        return  response()->json(['status'=>true,'view'=>$view]);
    } //end index()
}
