@extends('layouts.user.layout')
@section('title')
    <title>Address</title>
@endsection

@section('content')
    <div id="heading-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <h1>Checkout - Address</h1>
                </div>
            </div>
        </div>
    </div>
    <div id="content">
        <div class="container">
            <div class="row">
                <div class="col-md-9 clearfix" id="checkout">
                    <div class="box">
                        <form method="post" action="shop-checkout2.html">
                            <ul class="nav nav-pills nav-justified">
                                <li class="active"><a href="javascript:void(0);"><i class="fa fa-map-marker"></i><br>Address</a>
                                </li>
                                <li class="disabled"><a href="javascript:void(0);"><i class="fa fa-money"></i><br>Payment Method</a>
                                </li>
                                <li class="disabled"><a href="javascript:void(0);"><i class="fa fa-eye"></i><br>Order Review</a>
                                </li>
                            </ul>

                            <div class="content">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="firstname">Address</label>
                                            <textarea id="address" class="form-control" placeholder="Address" rows="5" required>{{Auth::user()->address}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.row -->

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="company">Email</label>
                                            <input id="email" type="email" class="form-control" required value="{{Auth::user()->email}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="street">Phone No</label>
                                            <input id="phone" type="text" class="form-control" id="Phone" required value="{{Auth::user()->mobile}}">
                                        </div>
                                    </div>
                                </div>
                                <!-- /.row -->

                                <div class="row">
                                    <div class="col-sm-6 col-md-12">
                                        <div class="form-group">
                                            <label for="state">District</label>
                                            <select id="city" class="form-control" autocomplete="on" required>
                                            <option value="">Select City</option>
                                            @foreach($Districts as $item)
                                            <option value="{{trim($item)}}">{{$item}}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.row -->
                            </div>

                            <div class="box-footer">
                                {{--<div class="pull-left">--}}
                                    {{--<a href="shop-basket.html" class="btn btn-default"><i class="fa fa-chevron-left"></i>Back to basket</a>--}}
                                {{--</div>--}}
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-template-main">Continue to Payment Method<i class="fa fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.box -->


                </div>
                <!-- /.col-md-9 -->

                <div class="col-md-3">

                    <div class="box" id="order-summary">
                        <div class="box-header">
                            <h3>Order summary</h3>
                        </div>
                        <p class="text-muted">Shipping and additional costs are calculated based on the values you have entered.</p>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td>Order subtotal</td>
                                    <th id="final-total"></th>
                                </tr>
                                <tr>
                                    <td>Delivery and handling</td>
                                    <th>{{$GBP->shipping_cost}} tk</th>
                                </tr>
                                <tr class="total">
                                    <td>Total</td>
                                    <th id="totalWithShipping"></th>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
                <!-- /.col-md-3 -->

            </div>
            <!-- /.row -->

        </div>
        <!-- /.container -->
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            var dis = '{{trim(Auth::user()->district)}}';
            console.log(dis);
            $('#city').val(dis);
            var voucher = JSON.parse(localStorage.getItem('productId'));
            console.log(voucher);
            var subTotal = 0;
            var total = 0
            for(var i = 0; i < voucher.length; i++) {
                var unitPrice = parseFloat(voucher[i].price);
                console.log(voucher[i].weight);
                var discount = ((unitPrice)*parseFloat(voucher[i].quantity))-(Math.ceil((unitPrice-parseFloat(voucher[i].weight))*parseFloat(voucher[i].discount)*parseFloat(voucher[i].quantity)/100));
                subTotal = Math.ceil(subTotal+discount);
            }
            var shippingCost = parseFloat({{$GBP->shipping_cost}});
            total = (Math.ceil((subTotal+shippingCost)/5))*5;
            $('#final-total').text(subTotal+' tk');
            $('#totalWithShipping').text(total+' tk');
            $('form').submit(function (event) {
                event.preventDefault();
                var voucher = JSON.parse(localStorage.getItem('productId'));
                $('#final-total').text(subTotal+' tk');
                $('#totalWithShipping').text(total+' tk');
                var userId = "{{ $userId->id }}";
                var orderInfo = [];
                orderInfo.push({
                    'userId' : userId,
                    'address':$('#address').val(),
                    'phone' : $('#phone').val(),
                    'email':$('#email').val(),
                    'city' : $('#city').val(),
                    'productDetail' : voucher
                });
                localStorage.setItem('voucher',JSON.stringify(orderInfo));
                window.location.href = '/orderPlacementInfo/payment';
            })
        })
    </script>
    @endsection