@extends('dashboard')
@section('title', 'Create Notice')
@section('content')
 <section class="content-header">
      <h1>Create Notice</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Notice</a></li>
        <li class="active">Create Notice</li>
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
              <h3 style="color: #800" class="box-title">Notice Information</h3>
            </div>
            {!! Form::open(['route' => 'notice.store', 'method' => 'POST', 'files' => true]) !!}
                <div class="box-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ Form::label('title', 'Title:', ['class' => 'control-label']) }}
                            {{ Form::text('title', null, ['class' => 'form-control'])}}
                        </div>
                        <div class="form-group">
                            {{ Form::label('position', 'Position:', ['class' => 'control-label']) }}
                            {{ Form::select('position', ['header' => 'Header', 'footer' => 'Footer',], null, ['class' => 'form-control'])}}
                        </div>
                        <div class="form-group">
                            {{ Form::label('details', 'Description:', ['class' => 'control-label']) }}
                            {!! Form::textarea('details', null, ['class'=>'form-control', 'rows' => 7]) !!}
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