@extends('layouts.user.layout')
<title>Cart</title>
@section('content')
    <div id="heading-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1>Shopping cart</h1>
                </div>
            </div>
        </div>
    </div>
    <div id="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="text-muted lead" style="text-align: center"></p>
                </div>
                <div id="tab-con" style="display: none;">

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
                                        <th id="ppk" colspan="2"></th>
                                    </tr>
                                    </tfoot>
                                </table>

                            </div>
                            <!-- /.table-responsive -->

                            <div class="box-footer">
                                <div class="pull-left">
                                    <a href="/" class="btn btn-default"><i class="fa fa-chevron-left"></i> Continue shopping</a>
                                </div>
                                <div class="pull-right">
                                    <a href="/orderPlacementInfo/address" class="btn btn-template-main">Proceed to checkout <i class="fa fa-chevron-right"></i>
                                    </a>
                                </div>
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
                                        <td>Shipping and handling</td>
                                        <th>{{$GBP[0]->shipping_cost}} tk</th>
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
            </div>
        </div>
        <!-- /.container -->
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            if(localStorage.getItem('productId')){
                if(JSON.parse(localStorage.getItem('productId')).length>0){
                    $('#tab-con').show();
                    $('.lead').append("You have "+JSON.parse(localStorage.getItem('productId')).length+" items in your bag.");
                }
                else $('.lead').append('Your bag is currently empty.');
            }
            else{
                $('.lead').append('Your bag is currently empty.');
            }

            function itemAdder() {
                var products = JSON.parse(localStorage.getItem('productId'));
                if(products.length >0){
                    $('#cart_container').show();
                    $('#mes').hide();
                }
                console.log(products);
                var final_total = 0;
                for(var i = 0; i < products.length; i++) {
                    $('#item-carts').append('<tr>'+'<td><img style="height: 50px;width: 56px;" src="'+products[i].photo+'" alt="Image not found"></td><td><h5>'+ products[i].title +'</h5> <small id="size_'+i+'" style="display:none">Size:'+ products[i].sizes +'</small> ,<small id="color_'+i+'" style="display:none">Color: <small style="background-color: '+products[i].colors+';color: '+products[i].colors+'; height: 5px; width: 5px;">M</small></small><br><small>Product Code:'+ products[i].code +'</small></td>'+'<td><label id="L"><form><input id="quantity_'+ i +'" class="form-control" type="number" name="quantity" value="'+products[i].quantity+'" min="1" max="'+products[i].maxQuantity+'" onchange="totalPriceCounter('+products[i].price +','+i+','+products[i].id+','+ products[i].discount +','+ products[i].weight +')"></form></label> </td>'+
                        '<td>'+'<p>'+ products[i].price +' tk</p>'+'</td>'+'<td>'+'<p id="total_discount_'+i+'"></p>'+'</td>'+
                        '<td> <p id="total_'+ i +'"></p></td>'+'<td><a href="javascript:itemRemover('+products[i].id+');"><i class="fa fa-trash-o"></i></a></td>'+'</tr>');
                    var q =(parseInt($('#quantity_'+ i +'').val()));
                    var discount = parseFloat(products[i].discount);
                    var productDiscount =Math.ceil((discount/100)*(parseFloat(products[i].price)-parseFloat(products[i].weight)));
                    console.log(productDiscount);
                    var total = Math.ceil(q*(parseFloat(products[i].price)-productDiscount));
                    var totalDiscount = Math.ceil((q*(parseFloat(products[i].price)))-total);

                    $('#total_'+ i+'').text(total+' tk');
                    $('#total_discount_'+ i+'').text(totalDiscount+' tk');

                    final_total = final_total+parseFloat((($('#total_'+ i+'').text()).replace(/[^0-9\.]+/g,'')));
                    if(products[i].color){
                        $('#color_'+i+'').show;
                    }
                    if(products[i].size){
                        $('#size_'+i+'').show;
                    }
                }
                var shippingCost = parseInt({{$GBP[0]->shipping_cost}});
                var totalwithshipping = (Math.ceil((final_total+shippingCost)/5))*5;
                $('#final-total').text(final_total+' tk');
                $('#totalWithShipping').text(totalwithshipping+' tk')
                $('#ppk').text(final_total+' tk');
            }
            itemAdder();
        });
        function totalPriceCounter(price,id,pid,discount,weight) {
            var products = JSON.parse(localStorage.getItem('productId'));
            var unitPrice = parseFloat(price);
            var discount = parseFloat(discount);
            var productDiscount = Math.ceil((discount/100)*(unitPrice-parseFloat(weight)));
            var counter = parseFloat($('#quantity_'+ parseInt(id) +'').val());
            var total = Math.ceil(counter*(unitPrice-productDiscount));
            var totalPrice = unitPrice*counter;
            var totalDiscount = Math.ceil((counter*unitPrice)-total);

            $('#total_discount_'+ id+'').text(totalDiscount+' tk');
            $('#total_'+ parseInt(id) +'').text(total+' tk');

            var finalTotal = 0;

            for (var i =0; i<products.length;i++){
                var itemTotal = $('#total_'+ i +'').text();
                itemTotal = itemTotal.replace(/[^0-9\.]+/g,'');
                finalTotal = parseInt(itemTotal)+finalTotal;
            }

            var shippingCost = parseInt({{$GBP[0]->shipping_cost}});
            var totalwithshipping = (Math.ceil((finalTotal+shippingCost)/5))*5;

            $('#final-total').text(finalTotal+' tk');
            $('#totalWithShipping').text(totalwithshipping+' tk');
            $('#ppk').text(finalTotal+' tk');


            for(var i = 0; i < products.length; i++) {
                if(parseInt(products[i].id) == parseInt(pid)){
                    console.log('dukse');
                    var pid = products[i].id;
                    var title = products[i].title;
                    var price = products[i].price;
                    var colors = products[i].colors;
                    var sizes = products[i].sizes;
                    var photo = products[i].photo;
                    var code = products[i].code;
                    var weight = products[i].weight;
                    var discount = products[i].discount;
                    var quantity = $('#quantity_'+ parseInt(id) +'').val();
                    products.splice(i,1);
                    products.push({
                        id : pid,
                        code:code,
                        title : title,
                        price: price,
                        shippingCost: shippingCost,
                        discount:discount,
                        colors:colors,
                        sizes:sizes,
                        photo:photo,
                        quantity:quantity,
                        weight:weight,
                    });
                    localStorage.setItem('productId', JSON.stringify(products));
                    console.log(localStorage.getItem('productId'));

                }
            }

        }
        function itemRemover(id) {
            var products = JSON.parse(localStorage.getItem('productId'));
            console.log(products);
            for(var i = 0; i < products.length; i++) {
                if(parseInt(products[i].id) == parseInt(id)){
                    products.splice(i,1);
                    localStorage.setItem('productId',JSON.stringify(products));
                    break;
                }
            }
            location.reload();
        }

    </script>
@endsection