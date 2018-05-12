@extends('layouts.user.layout')
@section('content')
    <div id="content">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="heading">
                        <h3>WOMAN'S WARE</h3>
                    </div>
                    <div class="row products">
                        @foreach($Product as $item)
                            <div class="col-md-3 col-sm-6">
                            <div class="product">
                                <div class="image">
                                    <a href="/productDetail/{{encrypt($item->product_id)}}">
                                        @foreach($Photo as $photo)
                                            @if($photo->product_id == $item->product_id)
                                                <img src="/images/{{ $photo->url }}" alt="" style="height:262.5px; width:242.5px" class="img-responsive image1">
                                            @endif
                                        @endforeach
                                    </a>
                                </div>
                                <!-- /.image -->
                                <div class="text">
                                    <h3><a href="/productDetail/{{encrypt($item->product_id)}}">{{$item->title}}</a></h3>
                                    @if(floatval($item->discout)>0)
                                        <?php
                                            $unitPrice =((float)$item->price);
                                            $discount = ((float)$item->discout*$unitPrice/100);
                                            if($item->currency == 'gbp'){
                                                $newPrice = ceil((float)($GBP->rate)*($unitPrice-$discount));
                                            }
                                            else{
                                                $newPrice = ceil((float)($unitPrice-$discount));
                                            }
                                        ?>
                                        <p class="price">
                                            <del>
                                                <?php
                                                if($item->currency == 'gbp'){
                                                    echo (ceil($unitPrice*(float)$GBP->rate));
                                                    }
                                                    else{
                                                        echo (ceil($unitPrice));
                                                    }

                                                ?>tk</del>{{$newPrice}} tk</p>
                                        @else
                                            <p class="price">
                                                <?php
                                                if($item->currency == 'gbp'){
                                                    echo (ceil(floatval($item->price)*(float)($GBP->rate)));
                                                    }
                                                    else{
                                                        echo (ceil(floatval($item->price)));
                                                    }
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
                        <!-- /.col-md-4 -->

                        <div class="row">

                            <div class="col-md-12 banner">
                                <a href="#">
                                    <img src="img/discount1.jpg" alt="" class="img-responsive">
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container -->
    </div>
@endsection