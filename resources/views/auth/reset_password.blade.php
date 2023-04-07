@extends('login')
@section('title', 'Forgot Password')
@section('content')
<script src='https://www.google.com/recaptcha/api.js' async defer></script>
<style>
    .checkbox{padding-left: 25px}
</style>

<div class="main-wrapper" stlye="width:100%;">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="sign-up-form">
        <div class="login-box" style="margin-top:100px">
        <div class="login-logo">
          <h2>Reset Password</h2>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
          <p class="login-box-msg">Please double check your password.</p>

          {!! Form::model($user, ['route' => ['password.update', $user->id], 'method' => 'PUT', 'role' => 'form' ]) !!}            
            <div class="form-group has-feedback has-float-label">
              <label for="password">New Password</label>
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
                <br>
              </div>
              {{-- <div class="col-xs-8">
                <div class="checkbox icheck">
                  <label class="">
                    <input type="checkbox" class="checkbox"> Remember Me
                  </label>
                  <div class="clearfix"></div>
                </div>
              </div> --}}
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

          {{-- <a href="/forgot_password" class="text-primary">I forgot my password</a> --}}
        </div><!-- /.login-box-body -->
      </div><!-- /.login-box -->
      </div>
      
    </div>
  </div>
</div>
@endsection