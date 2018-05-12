@if(Auth::guest())
    @extends('layouts.user.layout')
@endif
@section('title')
    <title>Sign Up</title>
@endsection
@section('content')
    <div id="content" style="margin-top: 5px;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="box">
                        <h2 class="text-uppercase">Sign Up</h2>

                        <p class="lead">Not Registered Customer yet?</p>
                        <p><a style="background-color: #38a7bb; color:white;" href="/login/facebook" class="btn btn-template-main"><i class="fa fa-facebook-square"></i> Register with facebook
                                </a> Or register here</p>
                        <form role="form" method="POST" id="register-form" action="/register">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <input id="name" type="text" class="form-control" name="name" required placeholder="Enter Your Name">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <input id="email" type="email" class="form-control" name="email" required placeholder="Enter Your Email">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                    @elseif ($errors->has('invalid_email'))
                                        <span class="help-block">
                                                    <strong>{{ $errors->first('invalid_email') }}</strong>
                                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <input id="password" type="password" class="form-control" name="password" required placeholder="Enter Your Password">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="password" placeholder="Confirm Password" name="password_confirmation" required>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <input id="name" type="text" class="form-control" id="mobile" name="mobile" required placeholder="Enter Your Contact Number" autofocus>
                            </div>
                            <div class="form-group"><select id="district" type="text" class="form-control" name="district" required autocomplete="on">
                                    <option value="">Select District</option>
                                    <option value="BARGUNA">BARGUNA</option>
                                    <option value="BARISAL">BARISAL</option>
                                    <option value="BHOLA">BHOLA</option>
                                    <option value="JHALOKATI">JHALOKATI</option>
                                    <option value="PATUAKHALI">PATUAKHALI</option>
                                    <option value="PIROJPUR">PIROJPUR</option>
                                    <option value="BANDARBAN">BANDARBAN</option>
                                    <option value="BRAHMANBARIA">BRAHMANBARIA</option>
                                    <option value="CHANDPUR">CHANDPUR</option>
                                    <option value="CHITTAGONG">CHITTAGONG</option>
                                    <option value="COMILLA">COMILLA</option>
                                    <option value="COX&#039;S BAZAR">COX&#039;S BAZAR</option>
                                    <option value="FENI">FENI</option>
                                    <option value="KHAGRACHHARI">KHAGRACHHARI</option>
                                    <option value="LAKSHMIPUR">LAKSHMIPUR</option>
                                    <option value="NOAKHALI">NOAKHALI</option>
                                    <option value="RANGAMATI">RANGAMATI</option>
                                    <option value="DHAKA">DHAKA</option>
                                    <option value="FARIDPUR">FARIDPUR</option>
                                    <option value="GAZIPUR">GAZIPUR</option>
                                    <option value="GOPALGANJ">GOPALGANJ</option>
                                    <option value="JAMALPUR">JAMALPUR</option>
                                    <option value="KISHOREGONJ">KISHOREGONJ</option>
                                    <option value="MADARIPUR">MADARIPUR</option>
                                    <option value="MANIKGANJ">MANIKGANJ</option>
                                    <option value="MUNSHIGANJ">MUNSHIGANJ</option>
                                    <option value="MYMENSINGH">MYMENSINGH</option>
                                    <option value="NARAYANGANJ">NARAYANGANJ</option>
                                    <option value="NARSINGDI">NARSINGDI</option>
                                    <option value="NETRAKONA">NETRAKONA</option>
                                    <option value="RAJBARI">RAJBARI</option>
                                    <option value="SHARIATPUR">SHARIATPUR</option>
                                    <option value="SHERPUR">SHERPUR</option>
                                    <option value="TANGAIL">TANGAIL</option>
                                    <option value="BAGERHAT">BAGERHAT</option>
                                    <option value="CHUADANGA">CHUADANGA</option>
                                    <option value="JESSORE">JESSORE</option>
                                    <option value="JHENAIDAH">JHENAIDAH</option>
                                    <option value="KHULNA">KHULNA</option>
                                    <option value="KUSHTIA">KUSHTIA</option>
                                    <option value="MAGURA">MAGURA</option>
                                    <option value="MEHERPUR">MEHERPUR</option>
                                    <option value="NARAIL">NARAIL</option>
                                    <option value="SATKHIRA">SATKHIRA</option>
                                    <option value="BOGRA">BOGRA</option>
                                    <option value="CHAPAINABABGANJ">CHAPAINABABGANJ</option>
                                    <option value="JOYPURHAT">JOYPURHAT</option>
                                    <option value="PABNA">PABNA</option>
                                    <option value="NAOGAON">NAOGAON</option>
                                    <option value="NATORE">NATORE</option>
                                    <option value="RAJSHAHI">RAJSHAHI</option>
                                    <option value="SIRAJGANJ">SIRAJGANJ</option>
                                    <option value="DINAJPUR">DINAJPUR</option>
                                    <option value="GAIBANDHA">GAIBANDHA</option>
                                    <option value="KURIGRAM">KURIGRAM</option>
                                    <option value="LALMONIRHAT">LALMONIRHAT</option>
                                    <option value="NILPHAMARI">NILPHAMARI</option>
                                    <option value="PANCHAGARH">PANCHAGARH</option>
                                    <option value="RANGPUR">RANGPUR</option>
                                    <option value="THAKURGAON">THAKURGAON</option>
                                    <option value="HABIGANJ">HABIGANJ</option>
                                    <option value="MAULVIBAZAR">MAULVIBAZAR</option>
                                    <option value="SUNAMGANJ">SUNAMGANJ</option>
                                    <option value="SYLHET">SYLHET</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="address" rows="4" required placeholder="Your Address"></textarea>
                            </div>
                            <div class="form-group">
                                <div style="margin-top: 15px; margin-bottom: 10px;">
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" id="optionsRadios1" value="Male"> <span> Male</span>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" id="optionsRadios1" value="Female"> <span>Female</span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-template-main"><i class="fa fa-user"></i>Register</button>
                                
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="/js/user/validators/passwordMatch.validator.js">
    </script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.js"></script>
@endsection
