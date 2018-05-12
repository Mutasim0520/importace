@extends('layouts.user.layout')
<title>Cart</title>
@section('content')
    <div id="heading-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1>Checkout-order review</h1>
                </div>
            </div>
        </div>
    </div>
    <div id="content">
        <div class="container">
            <div class="row">
                <div id="wait" class="col-sm-12" style="display: none;">
                    <p><center>Please wait. Your order is under processing.</center></p>
                    <center><div class="loader"></div></center>
                </div>
                <div id="detail-container">
                    <div class="col-md-9 clearfix" id="basket">

                        <div class="box">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Detail</th>
                                        <th>Quantity</th>
                                        <th>Unit price</th>
                                        <th>Discount</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody id="item-carts" >
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th colspan="5">Total</th>
                                        <th id="pp" colspan="2"></th>
                                    </tr>
                                    </tfoot>
                                </table>

                            </div>
                            <!-- /.table-responsive -->

                            <div class="box-footer">
                                <form action="javascript:callAjax();">
                                    {{csrf_field()}}
                                    <div class="pull-left">
                                        <input style="margin-left: 10px;" type="checkbox" required><label> I accept all terms and conditions.<a href="javascript:void(0);" data-toggle="modal" data-target="#model_tandc">See Terms & Conditions</a></label>
                                    </div>
                                    <div class="pull-right">
                                        <button type="submit"  class="btn btn-template-main">Place Order <i class="fa fa-chevron-right"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>

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
                </div>
                <!-- /.col-md-3 -->

            </div>

        </div>
        <!-- /.container -->
    </div>
    <div class="modal fade success-popup" id="product_out_of_stock" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <p class="lead product_unavailable"></p>
                </div>
                <div class="modal-footer text-center">
                    <a class="btn btn-template-main" href="/cart">Go To Cart</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade success-popup" id="model_tandc" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h3>Terms & Conditions</h3>
                </div>
                <div class="modal-body text-center">
                    <p class="lead product_unavailable">
                        T&C
                    </p>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-template-main" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            function itemAdder() {
                var products = JSON.parse(localStorage.getItem('productId'));
                //console.log(products);
                if(products.length >0){
                    $('#cart_container').show();
                    $('#mes').hide();
                }
                console.log(products);
                var final_total = 0;
                for(var i = 0; i < products.length; i++) {
                    $('#item-carts').append('<tr>'+'<td><img style="height: 50px;width: 56px;" src="'+products[i].photo+'" alt="Image not found"></td><td><h5>'+ products[i].title +'</h5> <small>Size:'+ products[i].sizes +'</small> ,<small>Size:'+ products[i].colors +'</small><br><small>Product Code:'+ products[i].code +'</small></td>'+'<td id="quantity_'+ i +'">'+products[i].quantity+'</td>'+
                        '<td>'+'<p>'+ products[i].price +' tk</p>'+'</td>'+'<td>'+'<p id="total_discount_'+i+'"></p>'+'</td>'+
                        '<td> <p id="total_'+ i +'"></p></td>'+'</tr>');
                    var q = (parseInt($('#quantity_'+ i +'').text()));
                    console.log(q);
                    var discount = parseFloat(products[i].discount);
                    var productDiscount = Math.ceil((discount/100)*(parseFloat(products[i].price)-parseFloat(products[i].weight)));
                    var total = Math.ceil(q*(parseFloat(products[i].price)-productDiscount));
                    var totalDiscount = Math.ceil((q*(parseFloat(products[i].price)))-total);
                    console.log(totalDiscount);

                    $('#total_'+ i+'').text(total+' tk');
                    $('#total_discount_'+ i+'').text(totalDiscount+' tk');

                    final_total = final_total+parseFloat((($('#total_'+ i+'').text()).replace(/[^0-9\.]+/g,'')));
                }
                var shippingCost = parseFloat({{$GBP->shipping_cost}});
                var totalwithshipping =(Math.ceil((final_total+shippingCost)/5))*5;
                $('#final-total').text(final_total+' tk');
                $('#pp').text(final_total+' tk');
                $('#totalWithShipping').text(totalwithshipping+' tk')
            }
            itemAdder();
        });

        function callAjax() {
            var paymentMethode =localStorage.getItem('payment_methode');
            var definedMethode = localStorage.getItem('defined_methode');
            var address = JSON.parse(localStorage.getItem('voucher'));
            var pointUsage;
            if(localStorage.getItem('pointUsage')){
                pointUsage = localStorage.getItem('pointUsage');
            }
            else pointUsage = 0;
            {{--console.log(address);--}}
            ///check availability
            $.ajax({
                type: 'POST',
                url:'/check/product/checkOut',
                data:{_token: "{{ csrf_token() }}", voucher:address,
                },
                success: function( msg ) {
                    console.log(msg);
                    msg = JSON.constructor(msg);
                    var item =  JSON.parse(localStorage.getItem('productId'));
                    var avilability = 1;
                    for(var i = 0;i<msg.length; i++){
                        if(msg[i] == 0){
                            $('.product_unavailable').append('<img src="'+item[i].photo+'") style="height: 100px;width: 100px"><br>'+item[i].title+' has just gone out of stock. Please remove this product from cart and try again.');
                            $('#product_out_of_stock').modal('show');
                            avilability = 0;
                        }
                    }
                    if(avilability == 1){
                        $('#detail-container').hide();
                        $('#wait').show();
                        $.ajax({
                        type: 'POST',
                        url:'/checkOut',
                        data:{_token: "{{ csrf_token() }}", voucher:address, paymentMethode:paymentMethode, pointUsage:pointUsage,definedMethod:definedMethode,
                        },
                        success: function( msg ) {
                        console.log(msg);
                            localStorage.clear();
                        window.location.replace('/userOrderDetail');

                        }
                        });

                    }
                }
            });

        }

    </script>
@endsection