@extends('layouts.user.layout')
@section('title')
<title>Account Settings</title>
@endsection

@section('content')
    <div id="content" style="margin-top: 10px;">

        <div class="container">

            <div class="row">

                <div class="col-md-8">
                    <!-- *** CUSTOMER MENU ***
_________________________________________________________ -->
                    <div class="panel panel-default sidebar-menu">
                        <div class="panel-body">
                            <strong>Hello {{$User->name}}</strong><br>
                            <p>Having great time with us? Here you can see your personal information and change those information.</p>

                            <ul class="nav nav-pills nav-stacked">
                                <li>
                                    <a href="{{route('user.order')}}"><i class="fa fa-list"></i>My Orders</a>
                                </li>
                                <li>
                                    <a class="normal-links" href="javascript:void(0);" data-toggle="modal" data-target="#myModal_requested_item"><i class="fa fa-inbox"></i>My Requested Items</a>
                                </li>
                                <li>
                                    <a class="normal-links" href="javascript:void(0);" data-toggle="modal" data-target="#myModal_change_setting"><i class="fa fa-lock"></i> Change Personal Information</a>
                                </li>
                                <li>
                                    <a class="normal-links" href="javascript:void(0);" data-toggle="modal" data-target="#myModal_change_password"><i class="fa fa-lock"></i> Reset Password</a>
                                </li>
                            </ul>
                        </div>

                    </div>
                    <!-- /.col-md-3 -->

                    <!-- *** CUSTOMER MENU END *** -->
                </div>

                <div class="col-md-4 clearfix">
                    <div class="col-md-12">
                        <div class="box-simple">
                            <div class="icon">
                                <i class="fa fa-user fa-2x"></i>
                            </div><br>
                            <p>{{$User->name}}</p>
                            <p>{{$User->email}}</p>
                            <p>{{$User->mobile}}</p>
                            <p>{{$User->district}}</p>
                            </div>
                    </div>

                </div>

            </div>
            <!-- /.row -->

        </div>
        <!-- /.container -->
    </div>
    <div class="modal fade" id="myModal_change_setting" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Change Your Information</h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="/update/personalinfo/{{encrypt($User->id)}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <input name="name" class="form-control" placeholder="Your Name" type="text" value="{{$User->name}}" required>
                        </div>
                        <div class="form-group">
                            <input name="email" class="form-control" placeholder="Your email" type="email" value="{{$User->email}}" required>
                        </div>
                        <div class="form-group">
                            <input name="mobile" class="form-control" placeholder="Your Phone Number" type="text" value="{{$User->mobile}}" required>
                        </div>
                        <div class="form-group">
                            <select id="dis" name="district" class="form-control" autocomplete="on">
                                @foreach($Districts as $item)
                                    <option value="{{$item}}">{{$item}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="address" required>{{$User->address}}</textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-template-main" value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal_change_password" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Reset Password</h4>
                </div>
                <div class="modal-body">
                    <form id="register-form" method="post" action="/update/password/{{encrypt($User->id)}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <input id="password" name="password" class="form-control" placeholder="New Password" type="password" required>
                        </div>
                        <div class="form-group">
                            <input name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Re Type Password" type="password" required>
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-template-main" value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal_requested_item" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Requested Items</h4>
                </div>
                <div class="modal-body">
                   <table class="table table-responsive table-bordered">
                       <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Request ID</th>
                            <th>Requested Date</th>
                            <th>Requested Item</th>
                            <th>Price</th>
                        </tr>
                       </thead>
                       <tbody>
                       <?php $i = 1; ?>
                            @foreach($requested_item as $item)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>REQ_{{$item->id}}</td>
                                    <td><?php $date = date("jS F, Y",strtotime($item->created_at)); echo $date;?></td>
                                    <td>
                                        <p>Item Name: {{$item->name}}</p>
                                        <p>Item Quantity:{{$item->quantity}}</p>
                                        <p><a href="{{$item->url}}">Item Link </a></p>
                                            @if($item->size)
                                            <p>
                                            Size:
                                                {{$item->size}}
                                            </p>
                                            @endif
                                        @if($item->color)
                                            <p>
                                            Color:
                                                {{$item->color}}
                                            </p>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->price)
                                            {{$item->price}}
                                            @else
                                            Not Evaluated Yet
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
    <script type="text/javascript" src="/js/user/validators/passwordMatch.validator.js">
    </script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.js"></script>
    <script>
        $(document).ready(function(){
            var pre_dis = '{{$User->district}}';
            $('#dis option[value='+pre_dis+']').attr('selected','selected');
            console.log(pre_dis);
        });
    </script>
@endsection