<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    @include('admin.css')
    <style type="text/css">

    .center
    {
      margin:auto;
      width: 50%;
      border: 2px solid white;
      text-align: center;
      margin-top: 40px;
    }

    .font_size
    {
        text-align: center;
        font-size: 40px;
        padding-top: 20px;
    }

    .border-table {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #ddd;
    }

    .border-table th, .border-table td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    .border-table th {
        background-color: green;
        color: white;
    }

    </style>


  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      @include('admin.sidebar')
      <!-- partial -->
      @include('admin.header')
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">

                @if(session()->has('message'))

                    <div class="alert alert-success">

                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x

                        </button>

                    {{ session()->get('message') }}

                    </div>

                @endif


                <h2 class="font_size">All Products</h2>

                <table class="center border-table">
                    <tr>
                        <th>Product title</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Discount Price</th>
                        <th>Product Image</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>

                    @foreach ($product as $product)

                        <tr>
                            <td>{{$product->title}}</td>
                            <td>{{$product->description}}</td>
                            <td>{{$product->quantity}}</td>
                            <td>{{$product->category}}</td>
                            <td>{{$product->price}}</td>
                            <td>{{$product->discount_price}}</td>
                            <td>
                               <img src="/product/{{$product->image}}" width="150" height="150">
                            </td>

                            <td>
                                <a class="btn btn-danger" onclick="return confirm('Are You Sure to Delete this')" href="{{url('delete_product',$product->id)}}">Delete</a>
                            </td>
                            <td>
                                <a class="btn btn-success" href="{{url('update_product',$product->id)}}">Edit</a>
                            </td>

                        </tr>

                    @endforeach
                </table>

            </div>
        </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    @include('admin.script')
    <!-- End custom js for this page -->
  </body>
</html>
