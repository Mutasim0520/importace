@extends('layouts.user.layout')
@section('title')
<title>LogIn</title>
@endsection
@section('content')
    <div id="content" style="margin-top: 5px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="box">
                        <h2 class="text-uppercase">Login</h2>

                        <p class="lead">Already our customer?</p>
                        <form method="POST" action="{{ url('/login') }}">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <input class="form-control" id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="Email Address"/>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <input class="form-control" id="password" type="password" name="password" required placeholder="Password"/>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" style=""  name="remember" {{ old('remember') ? 'checked' : ''}}> Remember Me
                                    </label>
                                </div>
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#forgot_password">Forgot Password</a>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-template-main"><i class="fa fa-sign-in"></i>Login</button>
                                <a style="background-color: #38a7bb; color:white;" href="/login/facebook" class="btn btn-template-main"><i class="fa fa-facebook-square"></i> Log in with facebook
                                </a>
                            </div>
                        </form>
                    </div>
    </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="forgot_password" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
        <div class="modal-dialog modal-md">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="Login">Change Password</h4>
                </div>
                <div class="modal-body">
                    <p>Please provide the email you registered with. we will sent an password reset link to that email.</p>
                    <form action="{{Route('send.password.reset.link')}}" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <input class="form-control" name="email" type="email" placeholder="Enter email" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-template-main" value="Send Link">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
