<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ItemOrder;
use App\Order;
use Illuminate\Support\Facades\Auth;
use Cart;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function checkout(Request $request)
    {
        $token = $request->input('stripeToken');

        //Retriieve cart information
        $cart = Cart::where('user_id',Auth::user()->id)->first();
        $items = $cart->cartItems;
        $total=0;
        foreach($items as $item){
            $total+=$item->product->price;
        }
        if(
            Auth::user()->charge($total*100, [
            'source' => $token,
            'receipt_email' => Auth::user()->email,
        ])){

            $order = new Order();
            $order->total_paid= $total;
            $order->user_id=Auth::user()->id;
            $order->save();

            foreach($items as $item){
                $orderItem = new OrderItem();
                $orderItem->order_id=$order->id;
                $orderItem->product_id=$item->product->id;
                $orderItem->file_id=$item->product->file->id;
                $orderItem->save();

                CartItem::destroy($item->id);
        }
            return redirect('/order/'.$order->id);

        }else{
            return redirect('/cart');
        }

    }

    // public function index(){
    //     $orders = Order::where('user_id',Auth::user()->id)->get();

    //     return view('order.list',['orders'=>$orders]);
    // }

    public function viewOrder($orderId){
        $order = Order::find($orderId);
        return view('order.view',['order'=>$order]);
    }

    // start here >> this should be for admin
    public function index(Request $request)
    {
    $query = Order::with([
      "user",
      "itemOrders.product.category"
    ]);
    $user = $request->input('user_id');
    if ($user)
    {
      $query->where("user_id", $user);
    }
    return $query->get();
    }
}
