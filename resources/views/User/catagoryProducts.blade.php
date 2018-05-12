@extends('layouts.user.layout')
@section('content')
    <div id="content">
        <div class="container">
            <div class="row">
                @if(sizeof($Product)==0)
                    <div class="col-md-12">
                        <p class="text-muted lead" style="text-align: center">No Item found of {{$Catagory}}</p>
                    </div>
                @else
                    <div class="col-sm-12">
                    <div class="heading">
                        <h3>{{$Catagory}}</h3>
                    </div>
                        <div class="row products">
                            @foreach($Product as $item)
                                <div class="col-md-3 col-sm-6">
                                    <div class="product">
                                        <div class="image">
                                            <a href="/productDetail/{{encrypt($item->product_id)}}">
                                                <?php $src = $item['photo']; ?>
                                                @if($src[0]->url)
                                                    <img src="/images/{{$src[0]->url }}" alt="" style="height:262.5px; width:242.5px" class="img-responsive image1">
                                                @else
                                                    <img src="/images/product.jpg" alt="" style="height:262.5px; width:242.5px" class="img-responsive image1">
                                                @endif
                                            </a>
                                        </div>
                                        <!-- /.image -->
                                        <div class="text">
                                            <h3><a href="/productDetail/{{encrypt($item->product_id)}}">{{$item->title}}</a></h3>
                                            @if($item->discout)
                                                <?php
                                                $shipping_cost = floatval($item->delivery_cost_id)*floatval($Shipping_cost->dlv_charge);
                                                $unitPrice =(floatval($item->price));
                                                $discount = ceil(((float)$item->discout*$unitPrice/100));
                                                $rate = 1;
                                                if($item->currency == 'gbp'){
                                                    foreach($GBP as $item2){
                                                        $upper = floatval($item2->upper);
                                                        $lower = floatval($item2->lower);
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
                                                $newPrice = ceil(((float)($rate)*($unitPrice-$discount))+floatval($shipping_cost));
                                                ?>
                                                <p class="price">
                                                    <del>
                                                        <?php
                                                        echo (ceil($unitPrice*(float)$rate+floatval($shipping_cost)));

                                                        ?>tk</del>{{$newPrice}} tk</p>
                                            @else
                                                <p class="price">
                                                    <?php
                                                    $shipping_cost = floatval($item->delivery_cost_id)*floatval($Shipping_cost->dlv_charge);
                                                    $unitPrice =ceil(floatval($item->price));
                                                    $rate = 1;
                                                    if($item->currency == 'gbp'){
                                                        foreach($GBP as $item2){
                                                            $upper = floatval($item2->upper);
                                                            $lower = floatval($item2->lower);
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
                                                    echo (ceil(floatval(floatval($item->price)*(float)($rate)+floatval($shipping_cost))));
                                                    ?> tk</p>
                                            @endif
                                            <p class="buttons">
                                                <a href="product-details.html" class="btn btn-default">View detail</a>
                                                <a href="shop-basket.html" class="btn btn-template-main"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                            </p>
                                        </div>
                                        @if($item->discout)
                                            <div class="ribbon sale">
                                                <div class="theribbon">{{ $item->discout }}% off</div>
                                                <div class="ribbon-background"></div>
                                            </div>
                                    @endif
                                    <!-- /.text -->
                                    </div>
                                    <!-- /.product -->
                                </div>
                            @endforeach
                        </div>
                </div>
                @endif
                    {{ $Product->links() }}
            </div>
        </div>
        <!-- /.container -->
    </div>
@endsection