@extends('layouts.user.layout')
@section('content')

    <div id="all">

        <div id="heading-breadcrumbs">
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <h1>Checkout - Payment method</h1>
                    </div>
                </div>
            </div>
        </div>

        <div id="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-9 clearfix" id="checkout">
                        <div class="box">
                            <form method="post" action="javascript:callAjax();">
                                <ul class="nav nav-pills nav-justified">
                                    <li><a href="javascript:void(0);"><i class="fa fa-map-marker"></i><br>Address</a>
                                    </li>
                                    <li class="active"><a href="javascript:void(0);"><i class="fa fa-money"></i><br>Payment Method</a>
                                    </li>
                                    <li class="disabled"><a href="javascript:void(0);"><i class="fa fa-eye"></i><br>Order Review</a>
                                    </li>
                                </ul>
                                <div class="content">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="box payment-method">

                                                <h4>Bikash Or Rocket</h4>

                                                <p>(commission paid for by customer)</p>

                                                <div class="box-footer text-center">

                                                    <input type="radio" name="payment" value="bikash" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="box payment-method">

                                                <h4>Bank Transfer</h4>

                                                <p>(commission paid for by customer)</p>
                                                <div class="box-footer text-center">

                                                    <input type="radio" name="payment" value="Bank Transfer" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="box payment-method">

                                                <h4>Money Delivered Personal</h4>

                                                <p>(commission paid for by customer)</p>
                                                <div class="box-footer text-center">

                                                    <input type="radio" name="payment" value="Money Delivered Personal" required>
                                                </div>
                                            </div>
                                        </div >
                                        <div class="col-sm-6">
                                            <div class="box payment-method">

                                                <h4>Other</h4>
                                                <p>
                                                <input type="text" name="other_method" class="form-control" placeholder="Enter your prefered payment method">
                                                </p>
                                                <div class="box-footer text-center">

                                                    <input type="radio" name="payment" value="Other" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    {{--<div class="pull-left">--}}
                                        {{--<a href="shop-basket.html" class="btn btn-default"><i class="fa fa-chevron-left"></i>Back to Shipping method</a>--}}
                                    {{--</div>--}}
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-template-main">Continue to Order review<i class="fa fa-chevron-right"></i>
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
    </div>
@endsection

@section('scripts')
    <script>
        $('input[name=payment]').change(function () {
            if($('input[name=payment]:checked').val()=="Other"){
                $('input[name=other_method]').attr('required',true);
            }
            else{
                $('input[name=other_method]').attr('required',false);
            }
        });
        $(document).ready(function () {
            var voucher = JSON.parse(localStorage.getItem('productId'));
            var subTotal = 0;
            var total = 0;
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
        });

        function callAjax() {
            var paymentMethode =$('input[name=payment]:checked').val();
            if(paymentMethode == 'Other'){
                var definendMethode = $('input[name=other_method]').val();
                localStorage.setItem('payment_methode', paymentMethode);
                localStorage.setItem('defined_methode', definendMethode);
            }
            else{
                var definendMethode = $('input[name=other_method]').val();
                localStorage.setItem('payment_methode', paymentMethode);
            }
            window.location.replace('/orderPlacementInfo/checkOut');
        }
    </script>
@endsection