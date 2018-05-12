@extends('layouts.user.layout')
@section('title')
<title>Product Detail</title>
@endsection
@section('content')
    <div id="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading">
                        <h3>{{ $Product->title }}</h3>
                    </div>
                    <div class="row" id="productMain">
                        <div class="col-sm-1">
                            <div class="row" id="thumbs" style="">
                                @foreach($Photo->photo as $item)
                                    <div class="col-xs-12">
                                        <a href="/images/{{$item->url}}" class="thumb">
                                            <img src="/images/{{$item->url}}" alt="" class="img-responsive">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div id="mainImage">
                                <img id="photo" src="/images/{{$Photo->photo[0]->url}}" alt="" class="img-responsive" style="width: 100%; max-height: 550px;">
                            </div>
                            @if($Product->discout)
                                <div class="ribbon sale">
                                    <div class="theribbon">{{$Product->discout}} % Off</div>
                                    <div class="ribbon-background"></div>
                                </div>
                                @endif

                            <!-- /.ribbon -->
                            <!-- /.ribbon -->

                        </div>
                        <div class="col-sm-4">
                            <div class="box">
                                    <div class="sizes">
                                        <h5>Product Code: {{$Product->code}}</h5>
                                        @if($Product->discout)
                                            <?php
                                            $shipping_cost = floatval($Product->delivery_cost_id)*floatval($Shipping_cost->dlv_charge);
                                            $unitPrice =((float)$Product->price);
                                            $discount = ((float)$Product->discout*$unitPrice/100);
                                            $rate = 1;
                                            if($Product->currency == 'gbp'){
                                                foreach($GBP as $item2){
                                                    $upper = intval($item2->upper);
                                                    $lower = intval($item2->lower);
                                                    if($lower && $upper){
                                                        if($unitPrice>= $lower && $unitPrice<=$upper){
                                                            $rate = $item2->rate;
                                                            break;
                                                        }
                                                    }
                                                    elseif ($lower && !$upper){
                                                        if($unitPrice>= $lower){
                                                            $rate = $item2->rate;
                                                            break;
                                                        }
                                                    }
                                                }
                                            }
                                            $newPrice = ($unitPrice-$discount);
                                            $newPrice = ceil(floatval($shipping_cost)+(floatval($rate)*$newPrice));
                                            ?>
                                            <h5>Price: <del>
                                                    <?php
                                                    echo (ceil(($unitPrice*(float)$rate)+floatval($shipping_cost)));
                                                    ?>tk</del>{{$newPrice}} tk</h5>
                                        @else
                                            <h5> Price: <?php
                                                $unitPrice =((float)$Product->price);
                                                $shipping_cost = floatval($Product->delivery_cost_id)*floatval($Shipping_cost->dlv_charge);
                                                $rate = 1;
                                                if($Product->currency == 'gbp'){
                                                    foreach($GBP as $item2){
                                                        $upper = intval($item2->upper);
                                                        $lower = intval($item2->lower);
                                                        if($lower && $upper){
                                                            if($unitPrice>= $lower && $unitPrice<=$upper){
                                                                $rate = $item2->rate;
                                                                break;
                                                            }
                                                        }
                                                        elseif ($lower && !$upper){
                                                            $rate = $item2->rate;
                                                            break;
                                                        }
                                                    }
                                                }
                                                echo (ceil(($unitPrice*(float)$rate)+floatval($shipping_cost)));
                                                ?>tk</h5>

                                        @endif
                                <form action="javascript:cartAdder();">
                                    <?php $colorCounter = 0; ?>
                                        @if(sizeof($Color->color) > 0 )
                                            <div class="form-group">
                                                <h5>Available Color: </h5>
                                                @foreach($Color->color as $item)
                                                    <lable class="radio-inline">
                                                    <input class="size-input" style="margin-top: 3%;" name="color" value="{{$item->color}}" type="radio" id="color_{{$colorCounter}}" required>
                                                    <span style="background-color:{{$item->color}}; color:{{$item->color}} ">o</span>
                                                    </lable>
                                                    <?php $colorCounter = $colorCounter+1; ?>
                                                @endforeach
                                            </div>
                                        @endif
                                            <?php $sizeCounter = 0; ?>
                                                @if(sizeof($Size->size) >0 )
                                                    <div class="form-group">
                                                        <h5>Available Size:</h5>
                                                        <select name="size"  class="form-control center-div" id="sel1" required>
                                                            <option value="">Select Size</option>
                                                            @foreach($Size->size as $item)
                                                                @if(intval($item->quantity)>0)
                                                                    <option  value="{{$item->size}}">{{$item->size}}</option>
                                                                    <?php $sizeCounter = $sizeCounter+1; ?>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif
                                            @if(intval($Product->quantity)>0)
                                            <div class="form-group">
                                                <button style="margin-bottom: 20px" type="submit" class="btn btn-template-main" id="addToCart">
                                                <i class="fa fa-shopping-cart"></i>Add to cart
                                                </button>
                                                {{--<a href="/addToWishlist/{{encrypt($Product->product_id)}}" class="btn btn-default cart" style="margin-bottom: 20px" >--}}
                                                    {{--<i class="fa fa-heart-o"></i>--}}
                                                {{--</a>--}}
                                            </div>
                                                @else
                                                <p>This Product Is Currently Out Of Stock. Please Stay Tuned</p>
                                            @endif
                                        </form>
                                        <p id="product_add_message" style="display:none;color: orange;text-align: center;font-weight: bold;font-size: larger;"> Product has been successfuly added </p>
                                    </div>
                            </div>
                        </div>

                    </div>


                    <div class="box" id="details">
                        <blockquote>
                            <?php echo $Product->description;?>
                        </blockquote>
                    </div>
                </div>
                <!-- /.col-md-9 -->

            </div>
            <!-- /.row -->

        </div>
        <!-- /.container -->
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="/js/user/jquery.zoom.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#mainImage').zoom();
            var color_set = JSON.parse('{!! ($Color->color) !!}');
            console.log(color_set.length);
            if(color_set.length == 1){
                $('#color_0').prop('checked',true);
            }
        });
        function cartAdder() {
            var productIds = [];
            var id = "{{ $Product->product_id }}";
            var price = "<?php echo(ceil((floatval($Product->price)*(float)$rate)+floatval(floatval($Shipping_cost->dlv_charge)*floatval($Product['delivery_cost_id'])))); ?>";
            var discount = "{{$Product->discout}}";
            var title = "{{ $Product->title }}";
            var code = "{{$Product->code}}";
            var colors="";
            var weight = '{{$shipping_cost}}'
            var colorCounter = parseInt("{{ $colorCounter }}");
            if(colorCounter>0){
                colors = $('input[name=color]:checked').val();
            }

            var sizeCounter = parseInt("{{ $sizeCounter }}");
            if(sizeCounter>0){
                var sizes = $('#sel1 :selected').val();
            }
            else sizes="Not Applicable"
            var has_size = '{{$Product->has_size}}';
            var max_quantity = 0;
            var quantity_array =  JSON.constructor({!!  json_encode($Quantity_array)  !!});
            if(has_size=='1'){
                for(var i = 0; i<quantity_array.length; i++){
                   if(quantity_array[i]['size'] ==sizes ){
                       if(parseInt(quantity_array[i]['quantity'])>0) max_quantity = quantity_array[i]['quantity'];
                       else max_quantity = 1;
                   }
                }
            }

            else{
                if(parseInt('{{ $Product->quantity }}')>0) max_quantity = '{{ $Product->quantity }}';
                else max_quantity = 1;
            }

            if(localStorage.getItem('productId')){
                var pid = localStorage.getItem('productId');
                var productIds = JSON.parse(pid);
                productIds.push({
                    id : id,
                    code:code,
                    title : title,
                    price: price,
                    discount:discount,
                    colors:colors,
                    sizes:sizes,
                    photo:$('#photo').attr('src'),
                    quantity:'1',
                    maxQuantity:max_quantity,
                    weight:weight,
                });
                localStorage.setItem('productId', JSON.stringify(productIds));
                var notification = productIds.length;
                $('#cartNotification').text(notification);
                console.log(productIds);
            }
            else{
                //console.log(id);
                productIds.push({
                    id : id,
                    code:code,
                    title : title,
                    price: price,
                    discount:discount,
                    colors:colors,
                    sizes:sizes,
                    photo:$('#photo').attr('src'),
                    quantity:'1',
                    maxQuantity:max_quantity,
                    weight:weight,
                });
                localStorage.setItem('productId', JSON.stringify(productIds));
                var notification = productIds.length;
                $('#cartNotification').text(notification);
                console.log(productIds);
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
            if(localStorage.getItem('productId')){
                if(JSON.parse(localStorage.getItem('productId')).length>0){
                    $('.cart-sub').html('');
                    $('.cart-sub').append("Yo have "+JSON.parse(localStorage.getItem('productId')).length+" items in your bag.");
                }
                else {
                    $('.cart-sub').html('');
                    $('.cart-sub').append('Your bag is currently empty.');
                }
            }
            else{
                $('.cart-sub').html('');
                $('.cart-sub').append('Your bag is currently empty.');
            }

            $('#product_add_message').show();

        };

        function wishAdder(productId){
            console.log(productId);
            $.ajax({
                type:'POST',
                url:'/addToWishlist',
                data:{_token: "{{ csrf_token() }}", id:productId
                },
                success: function( msg ) {
                    location.reload();
                }
            });
        }
    </script>

@endsection