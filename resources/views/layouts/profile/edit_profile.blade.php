@extends('dashboard')
@section('title', 'Update Profile')
@section('content')
<?php $user = Auth::user(); ?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>My Profile</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Settings</a></li>
        <li class="active">Profile</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-8">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Update Profile Information</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::model($profile, ['route' => ['profile.update'], 'method' => 'PUT', 'files' => true]) !!}
              <div class="box-body">
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('name', 'Name:', ['class' => 'control-label']) }}
                    {{ Form::text('name', $profile->name, ['class' => 'form-control'])}}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('email', 'Email Address:', ['class' => 'control-label']) }}
                    {{ Form::email('email', $profile->email, ['class' => 'form-control', 'disabled' => ''])}}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('contact', 'Contact Number:', ['class' => 'control-label']) }}
                    {{ Form::text('contact', $profile->contact, ['class' => 'form-control'])}}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('skill', 'Skill:', ['class' => 'control-label']) }}
                    {{ Form::text('skill', $profile->skill, ['class' => 'form-control'])}}
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    {{ Form::label('facebook', 'Facebook Profile URL:', ['class' => 'control-label']) }}
                    {{ Form::text('facebook', $profile->facebook, ['class' => 'form-control', 'placeholder' => 'https://www.facebook.com/example'])}}
                  </div>
                  <div class="form-group">
                    {{ Form::label('address', 'Address:', ['class' => 'control-label']) }}
                    {{ Form::textarea('address', $profile->address, ['class' => 'form-control', 'rows' => 2])}}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('city', 'City:', ['class' => 'control-label']) }}
                    {{ Form::text('city', $profile->city, ['class' => 'form-control'])}}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('state', 'State:', ['class' => 'control-label']) }}
                    {{ Form::text('state', $profile->state, ['class' => 'form-control'])}}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('zip_code', 'ZIP Code:', ['class' => 'control-label']) }}
                    {{ Form::text('zip_code', $profile->zip_code, ['class' => 'form-control'])}}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('country', 'Country:', ['class' => 'control-label']) }}
                    {{ Form::text('country', $profile->country, ['class' => 'form-control'])}}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('image', 'Profile Image:', ['class' => 'control-label']) }}
                    {{ Form::file('image', ['class' => 'form-control'])}}
                    @if($profile->image)<span><a target="_blank" href="{{$profile->image}}">View Image</a></span>@endif
                  </div>
                </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Update</button>
              </div>
            {!! Form::close() !!}
          </div>
          <!-- /.box -->

        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection