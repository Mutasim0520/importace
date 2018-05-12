@extends('layouts.user.layout')
@section('title')
    <title>Order List</title>
@endsection
@section('content')
    <div id="content">
        <div id="heading-breadcrumbs">
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <h1>My Orders</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 clearfix" id="customer-order">
                    <p class="text-muted lead">If you have any questions, please feel free to <a href="contact.html">contact us</a>, our customer service center is working for you 24/7.</p>
                    <div class="box">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Order Number</th>
                                    <th>Date</th>
                                    <th>Total Amount</th>
                                    <th>Track Order</th>
                                    <th>Details</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $n = 1; ?>
                                @foreach($order as $item)
                                    <tr>
                                        <td class="">
                                            {{$n}}
                                        </td>
                                        <td class="">
                                            {{$item['order_number']}}
                                        </td>
                                        <td class="">
                                            {{ substr($item['created_at'], 0, strpos($item['created_at'], ' '))}}
                                        </td>

                                        <td class="cart_price">
                                            <p>{{floor($item->order_value)}} tk</p>
                                        </td>
                                        <td>
                                            <a class="normal-links" href="/indivisualOrderTrack/{{encrypt($item->order_id)}}"><i class="fa fa-eye" style="margin-right: 2px;"></i>Track Order
                                            </a>
                                        </td>
                                        <td>
                                            <a class="normal-links" href="/indivisualOrderDetail/{{encrypt($item->order_id)}}">
                                                <i class="fa fa-info" style="margin-right: 2px;"></i>Detail
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $n++;?>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function showDetail(id) {
            $('#detail_'+id+'').toggle(function () {
                $(this).css("background-color","#F8F8F8");
                $(this).css("background-color","#F8F8F8");
            });
        }
    </script>
@endsection