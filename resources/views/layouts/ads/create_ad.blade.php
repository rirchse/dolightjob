@extends('dashboard')
@section('title', 'Post a Ad')
@section('content')
 <section class="content-header">
      <h1>Post a Ad</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Advertiesments</a></li>
        <li class="active">Post a Ad</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 style="color: #800" class="box-title">Ad Information</h3>
            </div>
            {!! Form::open(['route' => 'ad.store', 'method' => 'POST', 'files' => true]) !!}
                <div class="box-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ Form::label('title', 'Ad Title:', ['class' => 'control-label']) }}
                            {{ Form::text('title', null, ['class' => 'form-control'])}}
                        </div>
                        <div class="form-group">
                            {{ Form::label('position', 'Position:', ['class' => 'control-label']) }}
                            {{ Form::select('position', ['header' => 'Header', 'footer' => 'Footer',], null, ['class' => 'form-control'])}}
                        </div>
                        <div class="form-group">
                            {{ Form::label('size', 'Size:', ['class' => 'control-label']) }}
                            {{ Form::select('size', ['25' => '25%', '33' => '33%', '50' => '50%', '100' => '100%'], null, ['class' => 'form-control'])}}
                        </div>
                        <div class="form-group">
                            {{ Form::label('details', 'Ad Description:', ['class' => 'control-label']) }}
                            {!! Form::textarea('details', null, ['class'=>'form-control', 'rows' => 7]) !!}
                        </div>
                        <div class="form-group">
                            {{ Form::label('url', 'Ad URL:', ['class' => 'control-label']) }}
                            {{ Form::text('url', null, ['class' => 'form-control', 'placeholder' => 'http://'])}}
                        </div>
                        <div class="form-group">
                            {{ Form::label('image', 'Ad Image:', ['class' => 'control-label']) }}
                            {{ Form::file('image', null, ['class' => 'form-control']) }}
                        </div>
                    <div class="form-group">
                        <b>Status:</b> <br>
                        {{ Form::label('status', 'Publish:', ['class' => 'control-label']) }}
                        {!! Form::checkbox('status', '1', 'checked'); !!}
                    </div>
                    <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Submit</button>
                </div>
                    <div class="clearfix"></div>
            {!! Form::close() !!}
          </div> <!-- /.box -->
        </div> <!--/.col (left) -->
      </div> <!-- /.row -->
    </section> <!-- /.content -->
@endsection