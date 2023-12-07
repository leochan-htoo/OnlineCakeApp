<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Session;

use Stripe;
use App\Models\Comment;
use App\Models\Reply;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {

        $userId = Auth::user()->id;
        $totalQuantity = Cart::where('user_id', $userId)->count();

        }
        else
        {
            $totalQuantity=0;
        }




        // can limit data product category in user viewpage "$product=Product::paginate(10);"
        $product=Product::paginate(6);

        $comment=comment::orderby('id','desc')->get();

        $reply=reply::all();

        return view('home.userpage', compact('product', 'totalQuantity','comment','reply'));
    }
    public function redirect()
        {
            $usertype = Auth::user()->usertype;

            // create total price from user of record in Admin panel
            if ($usertype == '1') {

                //it is count total amout of product display in admin panel
                $total_product = Product::all()->count();

                //it is count total amout of  total order product
                $total_order = Order::all()->count();

                //it is count total amout of user
                $total_user = User::all()->count();

                $order = Order::all();

                $total_revenue = 0;

                foreach ($order as $order) {
                    $total_revenue = $total_revenue + $order->price;
                }

                //it is count total amout of total of delivery
                $total_delivered=order::where('delivery_status','=','delivered')->get()->count();

                //it is count total amout of total processing
                $total_processing=order::where('delivery_status','=','processing')->get()->count();


                return view('admin.home', compact('total_product', 'total_order', 'total_user', 'total_revenue','total_delivered', 'total_processing'));
            } else {
                // Cart number logic
                $userId = Auth::user()->id;
                $totalQuantity = Cart::where('user_id', $userId)->count();

                // Use the same product of home.userpage to view product
                $product = Product::paginate(10);
                // use this for comment defined
                $comment=comment::orderby('id','desc')->get();
                $reply=reply::all();

                return view('home.userpage', compact('product', 'totalQuantity','comment','reply'));
            }
        }


    // this controller function logic is for view product_details before buying
    public function product_details($id)

    {
        $product=product::find($id);
        return view('home.product_details', compact('product'));
    }
    // add this route function to add product in the cart
    public function add_cart(Request $request, $id)
            {
                if(Auth::id())
                    {
                        $user=Auth::user();
                        $userid=$user->id;
                        $product=product::find($id);

                        $product_exist_id=cart::where('product_id','=',$id)->where('user_id', '=',  $userid)->get('id')->first();

                        if($product_exist_id)
                            {
                                $cart=cart::find($product_exist_id)->first();

                                $quatity=$cart->quantity;

                                $cart->quantity=$quatity + $request->quantity;

                                    if($product->dis_price!=null)
                                        {
                                            //add this "* $request->quantity" conditional statement that calculates the price of a product
                                            $cart->price=$product->discount_price * $cart->quantity;
                                        }
                                    else
                                        {
                                            //add this "* $request->quantity" conditional statement that calculates the price of a product
                                            $cart->price=$product->price * $cart->quantity;
                                        }

                                $cart->save();

                                return redirect()->back()->with('message','Product Added Successfully');

                            }

                        else
                            {
                                $cart=new cart;
                                $cart->name=$user->name;
                                $cart->email=$user->email;
                                $cart->phone=$user->phone;
                                $cart->address=$user->address;
                                $cart->user_id=$user->id;

                                $cart->Product_title=$product->title;

                                if($product->dis_price!=null)
                                    {
                                        //add this "* $request->quantity" conditional statement that calculates the price of a product
                                        $cart->price=$product->discount_price * $request->quantity;
                                    }
                                else
                                    {
                                        //add this "* $request->quantity" conditional statement that calculates the price of a product
                                        $cart->price=$product->price * $request->quantity;
                                    }

                                        $cart->image=$product->image;
                                        $cart->Product_id=$product->id;

                                        $cart->quantity=$request->quantity;

                                        $cart->save();

                                        return redirect()->back()->with('message','Product Added Successfully');
                            }





                    }
                else
                    {
                        return redirect('login');
                    }
            }
    //this function will show cart notification sign after user add card
    //use this logic function "$id=Auth::user()->id;" makesure to know user
    //authticate user add cart after login
    public function show_cart()
    {
        //use "if(Auth::id())" to check which user is auth adding cart
        if(Auth::id())
        {
            $userId = Auth::user()->id;

            $totalQuantity = Cart::where('user_id', $userId)->count();


                $id=Auth::user()->id;
            $cart=cart::where('user_id','=',$id)->get();
            return view('home.showcart', compact('cart', 'totalQuantity'));
        }
        // if no user login authenticate will require to login page
        else
        {
            return redirect('login');
        }

    }
    //this function will remove product after adding product in package cart
    public function remove_cart($id)
    {
        $cart=cart::find($id);

        $cart->delete();

        return redirect()->back();
    }

    //this function will use for order payment for order items for order database to record in database attribute
    public function cash_order()
{
    $user = Auth::user();
    $userid = $user->id;

    $data = cart::where('user_id', '=', $userid)->get();

    foreach ($data as $item) {
        $order = new Order;

        $order->name = $item->name;
        $order->email = $item->email;
        $order->phone = $item->phone;
        $order->address = $item->address;
        $order->user_id = $item->user_id;

        $order->product_title = $item->product_title;
        $order->price = $item->price;
        $order->quantity = $item->quantity;
        $order->image = $item->image;
        $order->product_id = $item->product_id;

        $order->payment_status = 'cash on delivery';
        $order->delivery_status = 'processing';

        $order->save();


        $cart = cart::find($item->id);
        $cart->delete();
    }

    return redirect()->back()->with('message', 'We have received your order. We will connect with you soon...');
}

// This function logic is for payment stripe
public function stripe($totalprice)
{
    $userId = Auth::user()->id;
    $totalQuantity = Cart::where('user_id', $userId)->count();


    return view('home.stripe', compact('totalprice','totalQuantity'));
}

public function stripePost(Request $request, $totalprice)
{
    // stripe_secret API key is set up in env
    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

    \Stripe\Charge::create([
        "amount" => $totalprice * 100,
        "currency" => "thb",
        "source" => $request->stripeToken,
        "description" => "Thank you for payment."
    ]);

            $user = Auth::user();
            $userid = $user->id;

            $data = cart::where('user_id', '=', $userid)->get();

            foreach ($data as $item) {
                $order = new Order;

                $order->name = $item->name;
                $order->email = $item->email;
                $order->phone = $item->phone;
                $order->address = $item->address;
                $order->user_id = $item->user_id;

                $order->product_title = $item->product_title;
                $order->price = $item->price;
                $order->quantity = $item->quantity;
                $order->image = $item->image;
                $order->product_id = $item->product_id;

                $order->payment_status = 'paid';
                $order->delivery_status = 'processing';

                $order->save();

                $cart = cart::find($item->id);
                $cart->delete();
            }
            Session::flash('success', 'Payment successful!');

            return back();
        }
        // This function logic is for view product for user
        public function product()
            {
                $product=Product::paginate(10);

                $userId = Auth::user()->id;

                $totalQuantity = Cart::where('user_id', $userId)->count();

                $comment=comment::orderby('id','desc')->get();

                $reply=reply::all();

                return view('home.all_product',compact('product','totalQuantity','comment','reply'));
            }
            // This function logic is for show user order in card
            public function show_order()
                {
                    if (Auth::id()) {
                        $user = Auth::user();
                        $userid = $user->id;

                        // Retrieve total quantity from the Cart model (assuming you have a Cart model)
                        $totalQuantity = Cart::where('user_id', $userid)->count();

                        // Retrieve orders from the Order model (assuming the model is named Order)
                        $orders = Order::where('user_id', $userid)->latest()->get();

                        return view('home.order', compact('orders', 'totalQuantity'));
                    } else {
                        return redirect('login');
                    }
                }


                // This function logic is for cancel after user order a few minute
                public function cancel_order($id)
                {

                    $order=order::find($id);
                    $order->delivery_status='You cancel the order';

                    $order->save();
                    return redirect()->back();

                }

                // This function logic is for adding comment from user
                public function add_comment(Request $request)
                {
                    if(Auth::id())
                    {

                        $comment=new comment;
                        $comment->name=Auth::user()->name;
                        $comment->user_id=Auth::user()->id;
                        $comment->comment=$request->comment;

                        $comment->save();
                        return redirect()->back();
                    }
                    else
                    {
                        return redirect('login');
                    }
                }
                public function add_reply(Request $request)
                {
                    if(Auth::id())
                    {
                        $reply=new reply;
                        $reply->name=Auth::user()->name;
                        $reply->user_id=Auth::user()->id;
                        $reply->comment_id=$request->commentId;
                        $reply->reply=$request->reply;
                        $reply->save();
                        return redirect()->back();
                    }
                    else
                    {
                        return redirect('login');
                    }
                }
                public function product_search(Request $request)
                {
                    $comment=comment::orderby('id','desc')->get();

                    $reply=reply::all();
                    $search_text=$request->search;

                    $product=product::where('title','LIKE',"%$search_text%")->orWhere('category','LIKE',"%$search_text%")->paginate(10);

                    return view('home.all_product',compact('product','comment','reply'));

                }

                public function search_product(Request $request)
                {
                    $comment=comment::orderby('id','desc')->get();

                    $reply=reply::all();
                    $search_text=$request->search;

                    $product=product::where('title','LIKE',"%$search_text%")->orWhere('category','LIKE',"%$search_text%")->paginate(10);

                    return view('home.all_product',compact('product','comment','reply'));

                }


    }






