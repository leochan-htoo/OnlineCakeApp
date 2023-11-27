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
      <link rel="shortcut icon" href="images/favicon.png" type="">
      <title>Famms - Fashion HTML Template</title>
      <!-- bootstrap core css -->
      <link rel="stylesheet" type="text/css" href="home/css/bootstrap.css" />
      <!-- font awesome style -->
      <link href="home/css/font-awesome.min.css" rel="stylesheet" />
      <!-- Custom styles for this template -->
      <link href="home/css/style.css" rel="stylesheet" />
      <!-- responsive style -->
      <link href="home/css/responsive.css" rel="stylesheet" />

      <style type="text/css">

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
        font-size:30px;
        padding: 5px;
        background: rgb(41, 234, 41);
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


      </style>

   </head>
   <body>
      <div class="hero_area">
         <!-- header section strats -->
            @include('home.header')
         <!-- end header section -->
         <!-- slider section -->

         <!-- end slider section -->


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
                    <td>{{$cart->price}}BTH</td>
                    <td><img class="img_deg" src="/product/{{$cart->image}}" alt=""></td>
                        <td>
                            {{-- add this onclick="return confirm warning first poshup to bar of navbar before to remove --}}
                            <a class="btn btn-danger" onclick="return confirm('Are you sure to remove this product')" href="{{url('/remove_cart',$cart->id)}}">Remove</a>
                        </td>
                </tr>
                <?php $totalprice=$totalprice + $cart->price ?>
            @endforeach
            <tr>
                <td class="no-border"></td>
                <td class="no-border"></td>
                <td class="no-border"><h1 class="">Total Price: {{$totalprice}}BTH</h1></td>
                <td class="no-border"></td>
                <td class="no-border"></td>
            </tr>


        </table>



      </div>

      <!-- footer start -->
      @include('home.footer')
      <!-- footer end -->
      <div class="cpy_">
         <p class="mx-auto">© 2021 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a><br>

            Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>

         </p>
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
