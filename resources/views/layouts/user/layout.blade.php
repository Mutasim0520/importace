<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="all,follow">
    <meta name="googlebot" content="book,buy,sell,online">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="importace">

@yield('title')
<!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="/css/user/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <link href="/css/user/animate.css" rel="stylesheet">
    <link href="/css/user/style.default.css?v=14" rel="stylesheet" id="theme-stylesheet">
    <link href="/css/user/custom.css?v=10" rel="stylesheet">

    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>


    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="img/apple-touch-icon.png" />

    <link rel="apple-touch-icon" sizes="57x57" href="img/apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="76x76" href="img/apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon" sizes="120x120" href="img/apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="img/apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon" sizes="152x152" href="img/apple-touch-icon-152x152.png" />
    <title>ImportAce</title>
    @yield('styles')
</head>
<body>
<div id="all">
    @include('partials.user.topbar')
    @yield('content')
    <footer id="footer">
        <div class="container">
            <div class="col-md-4 col-sm-8">
                <h4>Contact</h4>
                <p><strong>Universal Ltd.</strong>
                    <br>13/25 New Avenue, Newtown upon River
                    <br>45Y 73J, England
                    <br>
                    <strong>Great Britain</strong>
                </p>
                <a href="javascript:void(0);" class="btn btn-small btn-template-main">Go to contact page</a>
                <hr class="hidden-md hidden-lg hidden-sm">
            </div>
            <div class="col-md-4 col-sm-8">
                <h4>About us</h4>
                <p></p>
            </div>
            <div class="col-md-4 col-sm-8">
                <h4>Join our monthly newsletter</h4>
                <p></p>
                @if(Auth::user())
                    @if(Auth::user()->subscriber)
                    @else
                        <form action="{{Route('user.subscribe')}}" method="post">
                            {{csrf_field()}}
                            <div class="input-group">
                                <input type="email" class="form-control" name="email" required>
                                <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="fa fa-send"></i></button>
                    </span>
                            </div>
                        </form>
                        <hr class="hidden-md hidden-lg hidden-sm">
                    @endif
                @else
                    <form action="{{Route('unauth.user.subscribe')}}" method="post">
                        {{csrf_field()}}
                        <div class="input-group">
                            <input type="email" class="form-control" name="email" required>
                            <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="fa fa-send"></i></button>
                            </span>
                        </div>
                    </form>
                    <hr class="hidden-md hidden-lg hidden-sm">
                @endif
            </div>
        </div>
    </footer>
    <div id="copyright">
        <div class="container">
            <div class="col-md-12">
                <p class="pull-left">&copy; </p>

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="estimated-cost" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
    <div class="modal-dialog modal-md">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="Login">Estimated Cost</h4>
            </div>
            <div class="modal-body">
                <p id="cost_estimated_product_price"><strong>Product Price: </strong></p>
                <p id="cost_estimated_product_website"><strong>Delivery Charge From The Website: </strong></p>
                <p id="cost_estimated_product_shipping"><strong>Shipping Cost: </strong></p>
                <p id="cost_estimated_total_cost"><strong>Total Cost: </strong></p>
            </div>
        </div>
    </div>
</div>

@include('partials.user._messages')

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>
    window.jQuery || document.write('<script src="js/jquery-1.11.0.min.js"><\/script>')
</script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

<script src="/js/user/jquery.cookie.js"></script>
<script src="/js/user/waypoints.min.js"></script>
<script src="/js/user/jquery.counterup.min.js"></script>
<script src="/js/user/jquery.parallax-1.1.3.js"></script>
<script src="/js/user/front.js"></script>
<script src="/js/user/owl.carousel.min.js"></script>

<script>
    $(document).ready(function(){
        @if(Auth::user())
            @if(sizeof(Auth::user()->unreadNotifications)>0)
            $('#user_notification').attr('data-original-title', 'Price of your requested item has been set.' );
                $('#user_notification').show();
                $('#user_notification').text('{{sizeof(Auth::user()->unreadNotifications)}}');
            @foreach(Auth::user()->unreadNotifications as $notification)
                 <?php
                $notification->markAsRead();
                ?>
            @endforeach
    @endif
@endif
        @if(Session::has('success_link_share'))
                   $('#success_link_share').modal('show');
        @endif
        @if(Session::has('has_request_share'))
                   $('#share-link').modal('show');
        @endif
        @if(Session::has('registration_confirmation'))
                   $('#registration_confirmation').modal('show');
        @endif
         @if(Session::has('correct_email_reset'))
                   $('#correct_email_reset').modal('show');
        @endif
         @if(Session::has('false_email_reset'))
                   $('#false_email_reset').modal('show');

        @endif

        @if(Session::has('success_password_reset'))
            $('#success_password_reset').modal('show');
        @endif

        @if(Session::has('success_subscriber_message'))
            $('#success_subscriber_message').modal('show');
        @endif
             @if(Session::has('subscriber_exist'))
            $('#subscriber_exist').modal('show');
        @endif
             @if(Session::has('unauth_success_subscriber'))
            $('#unauth_success_subscriber').modal('show');
        @endif



    $('[data-toggle="tooltip"]').tooltip();
        if(localStorage.getItem('productId')){
            if(JSON.parse(localStorage.getItem('productId')).length>0){
                $('.cart-sub').append("Yo have "+JSON.parse(localStorage.getItem('productId')).length+" items in your bag.");
            }
            else $('.cart-sub').append('Your bag is currently empty.');
        }
        else{
            $('.cart-sub').append('Your bag is currently empty.');
        }

        if(localStorage.getItem('productId')){
            if(JSON.parse(localStorage.getItem('productId')).length>0){
                $('#cartNotification').show();
                $('#cartNotification').text(JSON.parse(localStorage.getItem('productId')).length);
            }
            else {
                $('#cartNotification').css('display','none');
                $('#cartNotification').text('');
            }

        }
    });
    function estimateCost() {
            <?php
            use App\Cost_estimation as CST;
            use App\Gbp as gbp;
            $pound = gbp::all();
            $cst = CST::all();
            ?>
        var gbp_rate = parseFloat('{!! $pound[0]->rate !!}');
        var cost_estimation_array = JSON.parse('{!! $cst !!}');
        var cost = parseFloat($('#price_cost_estimation').val())*gbp_rate;
        var website = parseFloat($('#website_cost_estimation').val());
        var delivery_charge_website = 0;
        var shipping_cost_website = 0;
        for (var i = 0; i<cost_estimation_array.length; i++){
            if(website==cost_estimation_array[i].id){
                delivery_charge_website = parseFloat(cost_estimation_array[i].dlv_charge_website);
                shipping_cost_website = parseFloat(cost_estimation_array[i].shipping_cost);
                break;
            }
        }
        var delivery_charge_website_taka = delivery_charge_website*gbp_rate;
        var shipping_cost_website_taka = shipping_cost_website;
        var total_cost_estimation = delivery_charge_website_taka+shipping_cost_website_taka+cost;
        $('#cost_estimated_product_price').html('<strong>Product Price: </strong>'+cost+' tk');
        $('#cost_estimated_product_website').html('<strong>Delivery Charge From Website: </strong>'+delivery_charge_website_taka+' tk');
        $('#cost_estimated_product_shipping').html('<strong>Shipping Cost: </strong>'+shipping_cost_website_taka+' tk');
        $('#cost_estimated_total_cost').html('<strong>Total Cost: </strong>'+total_cost_estimation+' tk');
        $('#estimated-cost').modal('show');
        $('#cost-estimation').modal('hide');
    }
</script>
@yield('scripts')
</body>
</html>
