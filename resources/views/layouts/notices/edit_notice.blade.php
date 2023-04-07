@extends('dashboard')
@section('title', 'Edit Notice')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Notice</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit Notice</li>
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
              <h3 class="box-title">Edit Notice</h3>
            </div>
            <div class="col-md-12 text-right toolbar-icon">
              <a href="{{route('notice.show',$notice->id)}}" class="label label-info" title="notice Details"><i class="fa fa-file-text"></i></a>
              <a href="{{route('notice.index')}}" title="View {{Session::get('_types')}} notices" class="label label-success"><i class="fa fa-list"></i></a>
              {{-- <a href="{{route('notice.delete',$notice->id)}}" class="label label-danger" title="Delete this account"><i class="fa fa-trash"></i></a> --}}
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::model($notice, ['route' => ['notice.update', $notice->id], 'method' => 'PUT', 'files' => true]) !!}
              <div class="box-body">
                    <div class="col-md-12">
                        <div class="form-group label-floating">
                            {{Form::label('title', 'Title: ', ['class' => 'control-label']) }}
                            {{ Form::text('title', null, ['class' => 'form-control'])}}
                        </div>
                        <div class="form-group label-floating">
                            {{Form::label('position', 'Position: ', ['class' => 'control-label']) }}
                            {{ Form::text('position', null, ['class' => 'form-control'])}}
                        </div>
                        <div class="form-group label-floating">
                            {{ Form::label('details', 'Details:', ['class' => 'control-label']) }}
                            {!! Form::textarea('details',null,['class'=>'form-control', 'rows' => 5]) !!}
                        </div>
                    <div class="form-group label-floating">
                        <b>Status:</b> <br>
                        {{ Form::label('status', 'Active:', ['class' => 'control-label']) }}
                        {!! Form::checkbox('status', '1','checked'); !!}
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