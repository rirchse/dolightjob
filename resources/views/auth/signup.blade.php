@extends('login')
@section('title', 'Signup')
@section('content')
<script src='https://www.google.com/recaptcha/api.js' async defer></script>
<style>
    .checkbox{padding-left: 25px}
</style>

<div class="main-wrapper" stlye="width:100%;">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="sign-up-form">
        <div class="login-box" style="margin-top:10px">
        <div class="login-logo">
          <h2>Sign up {{Session::get('_aff')}}</h2>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
          <p class="login-box-msg">Signup with your information.</p>

          {!! Form::open(['route' => 'signup', 'method' => 'POST', 'role' => 'form' ]) !!}
            <div class="form-group has-feedback has-float-label">
              <label for="email">Your Name</label>
              {{ Form::text('name', null, ['class' => 'form-control', 'required' =>'', 'placeholder' => ' ', 'id' => 'name'])}}
              <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback has-float-label">
              <label for="email">Email Address</label>
              {{ Form::email('email', null, ['class' => 'form-control', 'required' =>'', 'placeholder' => ' ', 'id' => 'email'])}}
              <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback has-float-label">
              <label for="contact">Contact Number</label>
              {{ Form::text('contact', null, ['class' => 'form-control', 'required' =>'', 'placeholder' => ' ', 'id' => 'contact', 'minlength' => 11, 'maxlength' => 11])}}
              <span class="glyphicon glyphicon-phone form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback has-float-label">
              <label for="password">Password</label>
              {{ Form::password('password', ['class' => 'form-control', 'required' =>'', 'placeholder' => ' ', 'id' => 'password'])}}
              <span class="glyphicon glyphicon-eye-close form-control-feedback" onclick="showPass(this)" style="pointer-events:visible"></span>
            </div>
            <div class="form-group has-feedback has-float-label">
              <label for="password_confirmation">Confirm Password</label>
              {{ Form::password('password_confirmation', ['class' => 'form-control', 'required' =>'', 'placeholder' => ' ', 'id' => 'password_confirmation'])}}
              <span class="glyphicon glyphicon-eye-close form-control-feedback" onclick="showPass(this)" style="pointer-events:visible"></span>
            </div>
            <div class="row">
              <div class="col-xs-12">
                {{-- @include('/partials.google_recaptcha') --}}
              </div>
              <div class="col-xs-12">
                <div class="checkbox icheck">
                  <label class="">
                    <input type="checkbox" class="checkbox" required > I have double check all of information and agree with the Terms & Condition.
                  </label>
                  <div class="clearfix"></div>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-submit">Submit</button>
              </div>
              <!-- /.col -->
            </div>
          {!! Form::close() !!}

          <!-- <div class="social-auth-links text-center">
            <p>- OR -</p>
            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Login using
              Facebook</a>
            <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Login using
              Google+</a>
          </div> -->
          <!-- /.social-auth-links -->
          <br>

          <a href="/login" class="text-primary">Are you already sign up?</a>
        </div><!-- /.login-box-body -->
      </div><!-- /.login-box -->
      </div>
      
    </div>
  </div>
</div>
@endsection