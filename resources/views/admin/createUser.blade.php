@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading dark-overlay">Admin List</div>
                <div class="panel-body">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>email</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($Admins as $item)
                                <tr>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->email}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading dark-overlay">Create Admin</div>
                <div class="panel-body">
                    <form id="create-admin" action="{{Route('create.admin')}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input id="password" type="password" name="password" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Retype password</label>
                            <input type="password" name="password_confirmation" required class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Create" class="btn btn-flat btn-success">
                        </div>

                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/admin/validations/adminValidator.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.js"></script>
@endsection