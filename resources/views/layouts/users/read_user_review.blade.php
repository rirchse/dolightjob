@extends('dashboard')
@section('title', 'User Review')
@section('content')
 <section class="content-header">
      <h1>User Review</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Users</a></li>
        <li class="active">User Review</li>
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
              <h3 style="color: #800" class="box-title">User Information:</h3>
            </div>
        <div class="box-body">
        <div class="info-box" id="job-owner">
            <div class="col-md-6">
                <div class="box-header">
                  <img class="img-responsive" src="{{$user->image}}" style="max-width:150px; margin:auto">
                </div>
            </div>
            <div class="col-md-6">
                <div class="box-body" style="text-align:center;border-top:1px solid #eee">
                  <h4> <i class="fa fa-circle text-aqua"></i> {{$user->name}}</h4>
                  <p>User ID: #{{$user->id}}</p>
                  <p>Skill: {{$user->skill}}</p>
                  <p class="text-orange">
                    Reviews 
                    @for($x = 0; $x < 5; $x++)
                    <i class="fa fa-star"></i>
                    @endfor
                  </p>
                  <p>Since {{date('d M Y', strtotime($user->created_at))}}</p>
                </div>
            </div>
            <div class="clearfix"></div>
      </div>
          </div> <!-- /.box -->
        </div> <!--/.col (left) -->
      </div> <!-- /.row -->
    </section> <!-- /.content -->
@endsection