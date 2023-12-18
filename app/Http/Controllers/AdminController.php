<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;

use App\Models\Product;

use App\Models\Order;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Validator;

use Illuminate\Validation\Rule;

use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Facades\Input;


use PDF;

class AdminController extends Controller

{
    // this code function is for view product catagory for admin catagory
    public function view_catagory(Request $request)
    {
        if (Auth::id()) {
            if ($request->isMethod('post')) {
                // Validation rules
                $rules = [
                    'category_name' => [
                        'required',
                        Rule::unique('categories', 'name')->ignore($request->category_id)->whereNull('deleted_at')
                    ],
                ];

                // Custom error messages
                $messages = [
                    'category_name.required' => 'Category name is required.',
                    'category_name.unique' => 'Category name already exists.',
                ];

                // Validate the request data
                $validator = Validator::make($request->all(), $rules, $messages);

                // Check if validation fails
                if ($validator->fails()) {
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
                }

                // If validation passes, create/update the category
                $category = \App\Models\Category::find($request->category_id);
                if (!$category) {
                    $category = new \App\Models\Category;
                }
                $category->name = $request->input('category_name');
                $category->save();

                return redirect()->route('admin.category')->with('success', 'Category added/updated successfully.');
            }

            // If it's a GET request, just retrieve and show the categories
            $data = \App\Models\Category::all();
            return view('admin.category', compact('data'));
        } else {
            return redirect('login');
        }
    }
    // this code function is for add product catagory for admin catagory
        public function add_catagory(Request $request)
    {
        // Validation rules
        $rules = [
            'category' => 'required|unique:categories,category_name',
        ];

        // Custom error messages
        $messages = [
            'category.required' => 'Category name is required.',
            'category.unique' => 'Category name already exists.',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules, $messages);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // If validation passes, create the category
        $category = new Category;
        $category->category_name = $request->category;
        $category->save();

        return redirect()->back()->with('message', 'Category Added Successfully');
    }

    // this code function is for delete action for admin catagory
    public function delete_category($id)
    {
        // Find the category by ID
        $category = Category::find($id);

        // Check if the category exists
        if ($category) {
            // Find products with the given category title
            $products = Product::where('category', $category->category_name)->get();

            // Delete each product
            foreach ($products as $product) {
                $product->delete();
            }

            // Delete the category
            $category->delete();

            return redirect()->back()->with('message', 'Category Deleted Successfully');
        }

        // Handle the case where the category is not found
        return redirect()->back()->with('message', 'Category not found');
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
            $products = Product::paginate(4);
        return view('admin.show_product', compact('products'));
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
            // Use paginate() to get a paginated result
            $orders = Order::paginate(5);
            return view('admin.order', compact('orders'));
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

            // Get the collection
            $collection = Order::where('name', 'LIKE', '%' . $searchText . '%')
                ->orWhere('phone', 'LIKE', '%' . $searchText . '%')
                ->orWhere('product_title', 'LIKE', '%' . $searchText . '%')
                ->get();

            // Define how many items we want to be visible in each page
            $perPage = 4;

            // Slice the collection to get the items to display in current page
            $currentPageItems = $collection->slice(($request->page - 1) * $perPage, $perPage)->all();

            // Create our paginator and pass it to the view
            $paginatedItems = new LengthAwarePaginator($currentPageItems , count($collection), $perPage);

            // set url path for generated links
            $paginatedItems->setPath($request->url());

            return view('admin.order', ['orders' => $paginatedItems, 'product' => $paginatedItems]);
            }
        public function searchproduct(Request $request)
        {
            $searchText = $request->search;
            $searchCategory = $request->category;

            // Build the query
            $query = Product::query();

            if ($searchText) {
                $query->where('title', 'LIKE', '%' . $searchText . '%');
            }

            if ($searchCategory) {
                $query->where('category', 'LIKE', '%' . $searchCategory . '%');
            }

            // Retrieve the collection
            $collection = $query->get();

            // Define how many items we want to be visible in each page
            $perPage = 4;

            // The current page is determined by the request 'page' parameter
            $currentPage = $request->input('page', 1);

            // Calculate the offset
            $offset = ($currentPage - 1) * $perPage;

            // Slice the collection to get the items to display in the current page
            $currentPageItems = $collection->slice($offset, $perPage)->all();

            // Create our paginator and pass it to the view
            $paginatedItems = new LengthAwarePaginator($currentPageItems, count($collection), $perPage, $currentPage, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);

            return view('admin.show_product', ['products' => $paginatedItems]);
        }


}
