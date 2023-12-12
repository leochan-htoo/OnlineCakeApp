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
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <style>
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
    </style>
   </head>
   <body>
      <div class="hero_area">
         <!-- header section strats -->
            @include('home.header')

      @include('home.product_view')
      <!-- end product section -->

      {{-- comment and reply system start here --}}

        <div style="text-align: center; padding-bottom: 30px;">
            <h1 style="font-size: 30px; text-align: center; padding-top: 20px; padding-bottom: 20px;">
                Comment
            </h1>
            <form action="{{url('add_comment')}}" method="POST">
                @csrf
                <textarea style="heght: 150px; width: 600px;" placeholder="Comment something here" name="comment"></textarea>
                <br>
                <input type="submit" class="btn btn-primary" value="Comment">

            </form>
        </div>

        <div style="padding-left: 20%;">
            <h1 style="font-size: 20px; padding-bottom: 20px">All Comments</h1>

            @foreach ($comment as $comment )

                <div>
                    <b>{{$comment->name}}</b>
                    <p>{{$comment->comment}}</p>
                    <a href="javascript:void(0);" onclick="reply(this)" data-Commentid='{{$comment->id}}' style="color: blue">Reply</a>

                    {{-- add in foreach loop for show the user reply on the comment --}}
                        @foreach ($reply as $rep)
                            {{-- check connection just show the reply only the userID comment --}}
                            @if($rep->comment_id==$comment->id)
                                <div style="padding-left: 3%; paddding-bottom: 10px; padding-bottom: 10px;">


                                    <b>{{$rep->name}}</b>
                                    <p>{{$rep->reply}}</p>
                                    <a href="javascript:void(0);" onclick="reply(this)" data-Commentid='{{$comment->id}}' style="color: blue">Reply</a>


                                </div>
                            @endif

                        @endforeach
                </div>
            @endforeach



            {{-- Reply Textbox --}}

            <div style="display: none;" class="replyDiv">

                <form action="{{url('add_reply')}}" method="POST">

                    @csrf
                    <input type="text" id="commentId" name="commentId" hidden="">
                    <textarea style="height: 100px; width: 500px;" name="reply" onclick="reply(this)" placeholder="write something here"></textarea>
                    <br>
                    <button type="submit" class="btn btn-warning"> Reply</button>
                    <a href="javascript::void(0);" class="btn" onclick="reply_close(this)">Close</a>
                </form>

            </div>


        </div>


      {{-- comment and reply system end here --}}

      <!-- subscribe section -->

      <!-- end subscribe section -->
      <!-- client section -->
      @include('home.client')
      <!-- end client section -->
      <!-- footer start -->
      @include('home.footer')
      <!-- footer end -->
      <div class="cpy_">
        <p class="mx-auto">© 2023 All Rights Reserved By <a href="https://onlinecake.kanyawitguys.tech">Online Cake App</a><br>

           Distributed By <a href="https://onlinecake.kanyawitguys.tech" target="_blank">OnlineCake</a>

        </p>
     </div>

      <script type="text/javascript">

        function reply(caller)

            {
                document.getElementById('commentId').value=$(caller).attr('data-CommentId')
                $('.replyDiv').insertAfter($(caller));
                $('.replyDiv').show();
            }


            function reply_close(caller)

            {

                $('.replyDiv').hide();
            }
            </script>

                <script>
                    document.addEventListener("DOMContentLoaded", function(event) {
                        var scrollpos = localStorage.getItem('scrollpos');
                        if (scrollpos) window.scrollTo(0, scrollpos);
                    });

                    window.onbeforeunload = function(e) {
                        localStorage.setItem('scrollpos', window.scrollY);
                    };
                </script>


      <!-- jQery -->
      <script src="home/js/jquery-3.4.1.min.js"></script>
      <!-- popper js -->
      <script src="home/js/popper.min.js"></script>
      <!-- bootstrap js -->
      <script src="home/js/bootstrap.js"></script>
      <!-- custom js -->
      <script src="home/js/custom.js"></script>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
   </body>
</html>
