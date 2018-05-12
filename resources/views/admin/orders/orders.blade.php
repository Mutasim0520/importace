@extends('layouts.layout')

@section('styles')
    <link href="/css/admin/dataTables.bootstrap.css" rel="stylesheet">
@endsection
@section('header')
    All Orders
@endsection

@section('content')
    <div class="row">
        <div class="box">
            <div class="box-body">
        <div class="col-lg-12">
            <div class="form-group" id="rate_container">
                <label>GBP rate for profit calculation</label>
                <input type="number"  step="0.0001" id="rate" class="form-control">
            </div>
                        <table class="table table-striped table-hover table-responsive " cellspacing="0" id="myTable">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Number</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Address</th>
                                <th>Current Status</th>
                                <th>Advance(BDT)</th>
                                <th>Order Value(BDT)</th>
                                <th>Value (GBP)</th>
                                <th>Description</th>
                                <th>Product URL</th>
                                <th>DUE(in BDT)</th>
                                <th>Profit(GBP)</th>
                                <th>LOG</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>S/N</th>
                                <th>Number</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Address</th>
                                <th>Current Status</th>
                                <th>Advance(BDT)</th>
                                <th>Order Value(BDT)</th>
                                <th>Value (GBP)</th>
                                <th>Description</th>
                                <th>Product URL</th>
                                <th>DUE(in BDT)</th>
                                <th>Profit(GBP)</th>
                                <th>LOG</th>

                            </tr>
                            </tfoot>
                            <tbody id="fbody">
                            <?php $i = 1;?>
                            @foreach($Orders as $item)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td><a href="/admin/indivisualOrderDetail/{{encrypt($item['order_id'])}}">{{$item['order_number']}}</a></td>
                                    <td>{{ substr($item['created_at'], 0, strpos($item['created_at'], ' '))}}</td>
                                    <td>{{$item['user']->name}}</td>
                                    <td>{{$item['user']->address}}</td>
                                    <td style="font-weight: bold;">
                                       <select id="order_status_{{$i}}" name="order_status_{{$i}}" class="form-control" onchange="javascript:changeStatus('{{$i}}','{{$item->order_id}}')">
                                           <option value="Cancelled">Cancelled</option>
                                           <option value="Received">Received</option>
                                           <option value="Confirmed">Confirmed</option>
                                           <option value="Processing">Processing</option>
                                           <option value="Shipping">Shipping</option>
                                           <option value="Delivered">Delivered</option>
                                       </select>
                                        <script type="text/javascript">
                                            setStatus('{{$i}}','{{$item->status}}');
                                            function setStatus(index,status) {
                                                console.log('got');
                                                $('#order_status_'+index+' option[value='+status+']').attr('selected','selected');
                                            }
                                        </script>
                                    </td>
                                    <td><input value="{{$item->advance}}" onchange="javascript:setAdvance('{{$item->order_id}}');" id="advance_{{$item->order_id}}" type="text" class="form-control" style="width:100%"></td>
                                    <td>
                                        {{$item['order_value']}}
                                        tk
                                    </td>
                                    <td><input value="{{$item->value_gbp}}" onchange="javascript:setValueInGbp('{{$item->order_id}}');" id="value_gbp_{{$item->order_id}}" type="text" class="form-control" style="width:100%"></td>
                                    <td>
                                        <ol>
                                        @foreach($item->order_product as $item2)
                                                <li>
                                                    <ul>
                                                        <li>Name:<a href="/indivisualProduct/{{encrypt($item2->product_id)}}">{{$item2->title}}</a></li>
                                                        <li>Quantity:{{$item2->quantity}}</li>
                                                        @if($item2->color)<li>Color:{{$item2->color}}</li>@endif
                                                        @if($item2->size)<li>Size:{{$item2->size}}</li>@endif
                                                    </ul>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </td>
                                    <td>
                                        <ol>
                                        @foreach( $item->product as $item2)
                                                <li><a target="_blank" href="{{$item2->url}}">Link</a></li>
                                            @endforeach
                                        </ol>
                                    </td>
                                    <td>
                                        @if($item->advance)
                                            <?php
                                                echo floatval($item->order_value)-floatval($item->advance);
                                            ?>
                                            @else
                                            {{$item->order_value}}
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->profit)
                                            {{$item->profit}}
                                        @else
                                            Not Set Yet
                                        @endif
                                    </td>
                                    <td><a target="_blank" href="/showLog/{{encrypt($item['order_id'])}}">Log</a></td>
                                </tr>

                                <?php $i = $i+1;?>
                            @endforeach
                            </tbody>
                        </table>
        </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script src="/js/admin/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="/js/admin/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/3.2.1/js/dataTables.fixedColumns.min.js"></script>
    <script>
        $(document).ready(function () {
            var rate = localStorage.getItem('gbp_rate');
            $('#rate').val(rate);
            $('#myTable').DataTable({
                scrollY:        "400px",
                scrollX:        true,
                scrollCollapse: true,
                paging:         false,
                fixedColumns:   {
                    leftColumns: 2,
                }
            });

        });
        $('#rate').change(function () {
            var rate = $('#rate').val();
            if(rate){
                localStorage.setItem('gbp_rate',$('#rate').val());
            }
        });
        function changeStatus (index,id) {
            var status = $('#order_status_'+index+'').val();
            $.ajax({
                type:'POST',
                url:'/admin/changeOrderStatus',
                data:{_token: "{{ csrf_token() }}", id:id, status:status
                },
                success: function( msg ) {
                    location.reload();
                    console.log(msg);
                }
            });
        }

        function setAdvance(id) {
            var rate = $('#rate').val();
            if(rate){
                $('#rate_container').removeClass('alert alert-danger');
                $('#warning').remove();
                var total = $('#value_gbp_'+id+'').val();
                if(total){
                    var profit = ((parseFloat($('#advance_'+id+'').val()))/parseFloat(rate))- parseFloat(total);
                }
                else{
                    var profit = ((parseFloat($('#advance_'+id+'').val()))/parseFloat(rate));
                }

                console.log(profit);
                $.ajax({
                    type:'POST',
                    url:'/admin/changeOrderAdvance',
                    data:{_token: "{{ csrf_token() }}", id:id, advance:$('#advance_'+id+'').val(),profit:profit.toFixed(2)
                    },
                    success: function( msg ) {
                        location.reload();
                        console.log(msg);
                    }
                });
            }
            else {
                $('#rate_container').addClass('alert alert-danger');
                $('#rate_container').append('<strong id="warning">First Add the rate</strong>');
            }
        }
        function setValueInGbp(id) {
            var rate = $('#rate').val();
            if(rate){
                $('#rate_container').removeClass('alert alert-danger');
                $('#warning').remove();
                var total = $('#value_gbp_'+id+'').val();
                if(total){
                    var profit = ((parseFloat($('#advance_'+id+'').val()))/parseFloat(rate))- parseFloat(total);
                }
                else{
                    var profit = ((parseFloat($('#advance_'+id+'').val()))/parseFloat(rate));
                }

                console.log(profit);
                $.ajax({
                    type:'POST',
                    url:'/admin/changeOrderValueGbp',
                    data:{_token: "{{ csrf_token() }}", id:id, value:$('#value_gbp_'+id+'').val(),profit:profit.toFixed(2)
                    },
                    success: function( msg ) {
                        location.reload();
                        console.log(msg);
                    }
                });
            }
            else {
                $('#rate_container').addClass('alert alert-danger');
                $('#rate_container').append('<strong id="warning">First Add the rate</strong>');
            }
        }

    </script>
@endsection