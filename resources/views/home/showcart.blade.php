<!DOCTYPE html>
<html>
   <head>
      <!-- Basic -->
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <!-- Mobile Metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <!-- Site Metas -->
      <meta name="keywords" content="" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <link rel="shortcut icon" href="images/logo.png" type="">
      <title>Online Bakery Shop System</title>
      <!-- bootstrap core css -->
      <link rel="stylesheet" type="text/css" href="home/css/bootstrap.css" />
      <!-- font awesome style -->
      <link href="home/css/font-awesome.min.css" rel="stylesheet" />
      <!-- Custom styles for this template -->
      <link href="home/css/style.css" rel="stylesheet" />
      <!-- responsive style -->
      <link href="home/css/responsive.css" rel="stylesheet" />

      <style type="text/css">

        /* Custom styles for the cart icon and count */
        .cart-icon {
            display: flex;
            align-items: center;
            position: relative;
        }

        #cartCount {
            position: absolute;
            top: -10px; /* Adjust the top position to move the number higher */
            right: 5px;
            background-color: red; /* Customize the background color */
            color: white; /* Customize the text color */
            padding: 2px 6px;
            border-radius: 50%;
            font-size: 10px

        }


      .center
      {
        margin: auto;
        width: 50%;
        text-align: center;
        padding: 30px;
      }

      table,th,td
      {
        border:2px solid rgb(0, 0, 0);
        text-align: center;

      }
      table
      {
        padding: 0 90px 0 100px;
        width: 80%;
        margin: auto;
      }

      .th_deg
      {
        font-size:20px;
        padding: 4px;
        background: rgb(181, 186, 208);
      }
      .img_deg
      {
        height: 100px;
        width: 100px;

      }
      .total_deg
      {
        font-size: 20px;
        padding: 50px 0 0 200px;
      }
      /* Add a class to the specific td element you want to remove the border from */
        .no-border
        {
            border: none;
        }

        .order-section {
    margin-top: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .order-section h1 {
    font-size: 24px;
    margin-bottom: 10px;
    text-align: center;
  }

  .order-section .payment-buttons {
    display: flex;
    justify-content: center;
    margin-top: 10px;
  }

  .order-section .payment-buttons .btn {
    margin: 0 5px;
  }


      </style>

   </head>
   <body>
      <div class="hero_area">
         <!-- header section strats -->
            @include('home.header')
         <!-- end header section -->
         <!-- slider section -->

         <!-- end slider section -->

         @if(session()->has('message'))

            <div class="alert alert-success">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x

                </button>

                    {{ session()->get('message') }}

            </div>

        @endif


      <div class="">
        <table>
            <tr>
                <th class="th_deg">Product title</th>
                <th class="th_deg">Product quantity</th>
                <th class="th_deg">Price</th>
                <th class="th_deg">Image</th>
                <th class="th_deg">Action</th>

            </tr>
            {{-- use this $totalprice=0; below php to add total amount of all product id price in cart --}}
            <?php $totalprice=0; ?>

            @foreach($cart as $cart )
                <tr>
                    <td>{{$cart->product_title}}</td>
                    <td>{{$cart->quantity}}</td>
                    <td>{{$cart->price}} THB</td>

                    <td style="text-align: center; vertical-align: middle;">
                        <div style="display: flex; justify-content: center;">
                            <img class="img_deg" src="/product/{{$cart->image}}" alt="">
                        </div>
                    </td>

                        <td>
                            {{-- add this onclick="return confirm warning first poshup to bar of navbar before to remove --}}
                            <a class="btn btn-danger" onclick="return confirm('Are you sure to remove this product?')" href="{{url('/remove_cart',$cart->id)}}">Remove</a>
                        </td>
                </tr>
                <?php $totalprice=$totalprice + $cart->price ?>
            @endforeach
            <tr>
                <td class="no-border"></td>
                <td class="no-border"></td>
                <td class="no-border"><h1 class="">Total Price: {{$totalprice}} THB</h1></td>
                <td class="no-border"></td>
                <td class="no-border"></td>
            </tr>


        </table>

        <div class="order-section">
            <table>
              <!-- Table rows omitted for brevity -->
            </table>

            <div>
              <h1>Total Price: {{$totalprice}} THB</h1>
            </div>

            <div class="proceed-section">
              <h1>Proceed to Order</h1>
              <div class="payment-buttons">
                <a href="{{url('cash_order')}}" class="btn btn-danger">Cash On Delivery</a>
                <a href="{{url('stripe',$totalprice)}}" class="btn btn-danger">Pay Using Card</a>
              </div>
            </div>
          </div>

      </div>

      <!-- footer start -->
      @include('home.footer')
      <!-- footer end -->
      <div class="cpy_">
        <p class="mx-auto">© 2023 All Rights Reserved By <a href="https://onlinecake.kanyawitguys.tech">Online Cake App</a><br>

           Distributed By <a href="https://onlinecake.kanyawitguys.tech" target="_blank">OnlineCake</a>

        </p>
     </div>
     </div>
      <!-- jQery -->
      <script src="home/js/jquery-3.4.1.min.js"></script>
      <!-- popper js -->
      <script src="home/js/popper.min.js"></script>
      <!-- bootstrap js -->
      <script src="home/js/bootstrap.js"></script>
      <!-- custom js -->
      <script src="home/js/custom.js"></script>
   </body>
</html>
