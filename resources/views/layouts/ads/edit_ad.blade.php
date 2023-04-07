@extends('dashboard')
@section('title', 'Edit Ad')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Ad</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit Ad</li>
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
              <h3 class="box-title">Edit Ad</h3>
            </div>
            <div class="col-md-12 text-right toolbar-icon">
              <a href="{{route('ad.show', $ad->id)}}" class="label label-info" title="ad Details"><i class="fa fa-file-text"></i></a>
              <a href="{{route('ad.index')}}" title="View {{Session::get('_types')}} ads" class="label label-success"><i class="fa fa-list"></i></a>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::model($ad, ['route' => ['ad.update', $ad->id], 'method' => 'PUT', 'files' => true]) !!}
              <div class="box-body">
                    <div class="col-md-12">                        
                        <div class="form-group">
                            {{ Form::label('title', 'Ad Title:', ['class' => 'control-label']) }}
                            {{ Form::text('title', $ad->title, ['class' => 'form-control'])}}
                        </div>
                        <div class="form-group">
                            {{ Form::label('position', 'Position:', ['class' => 'control-label']) }}
                            {{ Form::select('position', ['header' => 'Header', 'footer' => 'Footer',], $ad->position, ['class' => 'form-control'])}}
                        </div>
                        <div class="form-group">
                            {{ Form::label('size', 'Size:', ['class' => 'control-label']) }}
                            {{ Form::select('size', ['25' => '25%', '33' => '33%', '50' => '50%', '100' => '100%'], $ad->size, ['class' => 'form-control'])}}
                        </div>
                        <div class="form-group">
                            {{ Form::label('details', 'Ad Description:', ['class' => 'control-label']) }}
                            {!! Form::textarea('details', $ad->details, ['class'=>'form-control', 'rows' => 7]) !!}
                        </div>
                        <div class="form-group">
                            {{ Form::label('url', 'Ad URL:', ['class' => 'control-label']) }}
                            {{ Form::text('url', $ad->url, ['class' => 'form-control', 'placeholder' => 'http://'])}}
                        </div>
                    <div class="form-group label-floating">
                        {{ Form::label('image', 'Image:', ['class' => 'control-label']) }}
                        {{ Form::file('image') }}
                        @if($ad->image)
                        <a href="{{$ad->image}}" target="_blank">View</a>
                        @endif
                    </div>
                    <div class="form-group">
                        <b>Status:</b> <br>
                        {{ Form::label('status', 'Publish:', ['class' => 'control-label']) }}
                        {!! Form::checkbox('status', '1', 'checked'); !!}
                    </div>
                <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Submit</button>
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