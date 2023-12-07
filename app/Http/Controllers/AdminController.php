<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;

use App\Models\Product;

use App\Models\Order;

use Illuminate\Support\Facades\Auth;


use PDF;

class AdminController extends Controller

{
    // this code function is for view product catagory for admin catagory
    public function view_catagory()
        {
            if(Auth::id())
            {
                $data=category::all();
                return view('admin.category',compact("data"));
            }
            else{
                return redirect('login');
            }



        }
    // this code function is for add product catagory for admin catagory
    public function add_catagory(Request $request)
        {
            $data=new category;

            $data->category_name=$request->category;

            $data->save();
            return redirect()->back()->with('message','Category Added Successfully');
        }
    // this code function is for delete action for admin catagory
    public function delete_catagory($id)
        {
            $data=category::find($id);
            $data->delete();
            return redirect()->back()->with('message','Catagory Deleted Successfully');
        }

    // this code function logic is for view product
    public function view_product()
        {
            $category=category::all();
            return view('admin.product',compact('category'));
        }

    // this code function is for add product catagory in admin part
    public function add_product(Request $request)
        {
            $product=new product;
            $product->title=$request->title;
            $product->description=$request->description;
            $product->price=$request->price;
            $product->quantity=$request->quantity;
            $product->discount_price=$request->dis_price;
            $product->category=$request->category;

            $image=$request->image;

            $imagename=time().'.'.$image->getClientOriginalExtension();
            $request->image->move(public_path('product'), $imagename);

            $product->image=$imagename;


            $product->save();

            return redirect()->back()->with('message','Product Added Successfully');
        }

    // create this controller function logic for show product in admin
    public function show_product()
        {
            $product=product::all();
        return view('admin.show_product', compact('product'));
        }

     // create this controller function logic for delete product id in database
     public function delete_product($id)
        {
            $product=product::find($id);

            $product->delete();

            return redirect()->back()->with('message','Product Deleted Successfully');
        }

    //create this controller function logic for update or edit product id in database
    public function update_product($id)
        {
            $product=product::find($id);
            $category=category::all();
            return view('admin.update_product',compact('product', 'category'));
        }
    //create this controller function logic for update to confirm product id to new in database
    public function update_product_confirm(Request $request, $id)
        {
            if(Auth::id())
            {
                $product=product::find($id);

            $product->title=$request->title;
            $product->description=$request->description;
            $product->price=$request->price;
            $product->discount_price=$request->dis_price;
            $product->category=$request->category;
            $product->quantity=$request->quantity;


            $image=$request->image;
            if($image)
            {
                $imagename=time().'.'.$image->getClientOriginalExtension();
                $request->image->move('product',$imagename);

                $product->image=$imagename;
            }

            $product->save();

            return redirect()->back()->with('message','Product Updated Successfully');
            }
            else
            {
                return redirect('login');
            }


        }
    public function order()
        {
        $order=order::all();
            return view('admin.order',compact('order'));
        }
    //create this controller function logic for delivered
    public function delivered($id)
        {
        $order=order::find($id);
        $order->delivery_status="delivered";
        $order->payment_status='Paid';

        $order->save();

        return redirect()->back();

        }

    // create this controller function logic for print pdf of user make order receit
    public function print_pdf($id)
        {
            $order=order::find($id);
            $pdf=PDF::loadView('admin.pdf',compact('order'));
            return $pdf->download('order_details.pdf');
        }

    //create this controller function logic for search product data
    public function searchdata(Request $request)
        {
            $searchText = $request->search;
            $order = Order::where('name', 'LIKE', '%' . $searchText . '%')->orWhere('phone', 'LIKE', '%' . $searchText . '%')
            ->orWhere('product_title', 'LIKE', '%' . $searchText . '%')->get();

            return view('admin.order', compact('order'));
        }

}
