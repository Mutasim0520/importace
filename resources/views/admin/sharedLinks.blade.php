@extends('layouts.layout')

@section('styles')
    <link href="/css/admin/dataTables.bootstrap.css" rel="stylesheet">
@endsection
@section('header')
    All Shared Links
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
                <div class="box">
                    <div class="box-body">
                        <table class="table table-striped table-hover" width="100%" cellspacing="0" id="myTable">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Date</th>
                                <th>Response</th>
                                <th>Website URL</th>
                                <th>Product</th>
                                <th>Customer</th>
                                <th>Price</th>

                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>S/N</th>
                                <th>Date</th>
                                <th>Response</th>
                                <th>Website URL</th>
                                <th>Product</th>
                                <th>Customer</th>
                                <th>Price</th>
                                {{--<th>Log</th>--}}
                            </tr>
                            </tfoot>
                            <tbody id="fbody">
                            <?php $i = 1;?>
                            @foreach($Links as $item)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{substr($item['created_at'], 0, strpos($item['created_at'], ' '))}}</td>
                                    <td>
                                        @if($item['is_responded'])
                                            <strong style="color:Green">Responded By: {{$item['admin']->name}}</strong><br>
                                            <strong style="color:Green">Responded At: {{$item->updated_at}}</strong>
                                            @else
                                            <label><input type="checkbox" onchange="javascript:requestStatusChanger({{$item->id}});">Mark as responded</label>
                                        @endif
                                    </td>
                                    <td><a target="_blank" href="{{$item->url}}">LINK</a></td>
                                    <td>
                                        <p><strong>Product Name:</strong>{{$item->name}}</p>
                                        <p><strong>Product Size:</strong>
                                            @if($item->size)
                                                {{$item->size}}
                                                @else
                                                Not Applicable
                                            @endif
                                        </p>
                                        <p><strong>Product Color:</strong>
                                            @if($item->color)
                                                {{$item->color}}
                                            @else
                                                Not Applicable
                                            @endif
                                        </p>
                                        <p><strong>Product Quantity:</strong>
                                                {{$item->quantity}}
                                        </p>
                                    </td>
                                    <td>
                                        <p><strong>Customer Name:</strong>
                                            {{$item->user_name}}
                                        </p>
                                        <p><strong>Phone Number:</strong>
                                                {{$item->phone}}
                                        </p>
                                        <p><strong>Email:</strong>
                                            @if($item->email)
                                                {{$item->email}}
                                            @else
                                                Not Applicable
                                            @endif
                                        </p>
                                    </td>
                                    <td>
                                        @if($item->price)
                                            {{$item->price}}
                                            @else
                                                <label>Set Price</label>
                                                <input type="text" class="form-control" name="price" onchange="javascript:setPrice('{{$item->id}}');">
                                        @endif
                                    </td>
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
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });

        });
        function requestStatusChanger(id) {
            console.log(id);
            var admin = '{{Auth::id()}}';
            $.ajax({
                type:'POST',
                url:'/admin/changeRequestStatus',
                data:{_token: "{{ csrf_token() }}", id:id,admin:admin,
                },
                success: function( msg ) {
                    location.reload();
                    console.log(msg);
                }
            });
        }

        function setPrice(id) {
            $.ajax({
                type:'POST',
                url:'/admin/setRequestPrice',
                data:{_token: "{{ csrf_token() }}", id:id,price:$('input[name=price]').val(),
                },
                success: function( msg ) {
                    location.reload();
                    console.log(msg);
                }
            });
        }

    </script>
@endsection