<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;

class HomeController extends Controller
{
    public function index()
    {
        // can limit data product category in user viewpage "$product=Product::paginate(10);"
        $product=Product::paginate(10);
        return view('home.userpage', compact('product'));
    }
    public function redirect()
    {

        $usertype=Auth::user()->usertype;

        if($usertype=='1')

        {
            return view('admin.home');
        }
        else
        {
            // use the same product of home.userpage to view product
            $product=Product::paginate(10);
        return view('home.userpage', compact('product'));
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
                $product=product::find($id);
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

                return redirect()->back();

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
                $id=Auth::user()->id;
            $cart=cart::where('user_id','=',$id)->get();
            return view('home.showcart', compact('cart'));
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


}
