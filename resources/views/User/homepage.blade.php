@extends('layouts.user.layout')
@section('styles')
    <link href="/css/user/owl.carousel.css" rel="stylesheet">
    <link href="/css/user/owl.theme.css" rel="stylesheet">
@endsection
@section('content')
    <div id="all">
        <section>
            <div class="home-carousel">
                <div class="dark-mask"></div>
                <div class="container">
                    <div class="homepage owl-carousel" style="text-align: center;">
                        @foreach($Slide as $item)
                            <?php
                            if($item->link){
                                $link = $item->link;
                            }
                            else{
                                $link = "javascript:void(0)";
                            }
                            ?>
                            <div class="item">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <a href="{{$link}}"><img class="img-responsive banner" src="/images/user/slides/{{$item->url}}" style="" alt=""></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- *** HOMEPAGE CAROUSEL END *** -->
        </section>
        @if(sizeof($Simple_index)>0)
            @foreach($Simple_index as $item)
                <section class="bar background-gray no-mb">

                    <div class="container" data-animate="fadeInUp">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="heading" style="text-align: center"><h3 style="border-bottom: none;color:darkmagenta;">{{$item->name}}</h3></div>
                                <div class="promo-items">
                                    @foreach($item->simple_belongs as $item2)
                                        <div class="single-promo-item">
                                            <div class="promo-bg promo-bg-2" style="background-image:url('/images/{{$item2->photo}}')">
                                            </div>
                                            <div class="item-content">
                                                <h3>{{$item2->heading}}</h3>
                                                <p>{{$item2->label}}</p>
                                                <a href="/subCatagoryWiseProduct/{{$item2->sub_catagorie_id}}"> Shop Now</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.container -->
                </section><br>
            @endforeach
        @endif
    </div>
@endsection