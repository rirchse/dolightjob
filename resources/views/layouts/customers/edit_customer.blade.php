@extends('dashboard')
@section('title', 'Edit Customer Account')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>Customer Account</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Edit Customer Account</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <div class="row"><!-- left column -->
    <div class="col-md-10"><!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Edit Customer Account</h3>
        </div>
        <div class="col-md-12 text-right toolbar-icon">
          <a href="{{route('customer.show',$customer->id)}}" class="label label-info" title="customer Details"><i class="fa fa-file-text"></i></a>
          <a href="{{route('customer.index')}}" title="View {{Session::get('_types')}} customers" class="label label-success"><i class="fa fa-list"></i></a>
          {{-- <a href="{{route('customer.delete',$customer->id)}}" class="label label-danger" title="Delete this account"><i class="fa fa-trash"></i></a> --}}
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        {!! Form::model($customer, ['route' => ['customer.update', $customer->id], 'method' => 'PUT', 'files' => true]) !!}
        <div class="box-body">
        <div class="col-md-6">
            <h4>Personal Information:</h4>
            <div class="form-group label-floating">
                {{ Form::label('full_name', 'Full Name of Customer: *', ['class' => 'control-label']) }}
                {{ Form::text('full_name', $customer->full_name, ['class' => 'form-control', 'placeholder'=>'Customer Full Name'])}}
            </div>
            <div class="form-group label-floating">
                {{ Form::label('contact', 'Contact Number: *', ['class' => 'control-label']) }}
                {{ Form::text('contact', $customer->contact, ['class' => 'form-control', 'placeholder'=>'Mobile Number'])}}
            </div>
            <div class="form-group label-floating">
                {{ Form::label('email', 'Email(Optional):', ['class' => 'control-label']) }}
                {{ Form::email('email', $customer->email, ['class' => 'form-control','placeholder'=>'Email Address'])}}
            </div>
            <div class="form-group label-floating">
                {{ Form::label('gender', 'Gender:', ['class' => 'control-label']) }}<br>
                <input type="radio" name="gender" value="Male" {{$customer->gender == 'Male'?'checked':''}}> Male &nbsp;  &nbsp; 
                <input type="radio" name="gender" value="Female" {{$customer->gender == 'Female'?'checked':''}}> Female
            </div>
            <div class="form-group label-floating">
                {{ Form::label('care_of', 'Father\'s/Husband Name:', ['class' => 'control-label']) }}
                {{ Form::text('care_of', $customer->care_of, ['class' => 'form-control'])}}
            </div>
            <div class="form-group label-floating">
                {{ Form::label('phone', 'Home Phone:', ['class' => 'control-label']) }}
                {{ Form::text('phone', $customer->phone, ['class' => 'form-control', 'placeholder'=>'Home Phone'])}}
            </div>
            <div class="form-group label-floating">
                {{ Form::label('date_of_birth', 'Date Of Barth:', ['class' => 'control-label']) }}
                {{ Form::date('date_of_birth', $customer->dob, ['class' => 'form-control']) }}
            </div>
            <div class="form-group label-floating">
                {{ Form::label('present_address', 'Present Address:', ['class' => 'control-label']) }}
                {{ Form::textarea('present_address', $customer->present_address, ['class' => 'form-control', 'placeholder'=>'Present Address', 'rows' => 2])}}
            </div>
            <div class="form-group label-floating">
                {{ Form::label('permanent_address', 'Permanent Address: *', ['class' => 'control-label']) }}
                {{ Form::textarea('permanent_address', $customer->permanent_address, ['class' => 'form-control', 'placeholder'=>'Permanent Address', 'rows' => 2])}}
            </div>
        </div>
        <div class="col-md-6">
            <h4>Profession Information:</h4>
            <div class="form-group label-floating">
                {{ Form::label('profession', 'Profession:', ['class' => 'control-label']) }}
                {{ Form::text('profession', $customer->job, ['class' => 'form-control', 'placeholder'=>'Job Title'])}}
            </div>
            <div class="form-group label-floating">
                {{ Form::label('organization', 'Organization:', ['class' => 'control-label']) }}
                {{ Form::text('organization', $customer->organization, ['class' => 'form-control', 'placeholder'=>'Organization'])}}
            </div>
        </div>
        <div class="col-md-6">
            <h4>Referral Information:</h4>
            <div class="form-group label-floating">
                {{ Form::label('referral', 'Referral Name: *', ['class' => 'control-label']) }}
                {{ Form::text('referral', $customer->referral, ['class' => 'form-control', 'placeholder'=>'Referral Name']) }}
            </div>
            <div class="form-group label-floating">
                {{ Form::label('referral_contact', 'Referral Contact:', ['class' => 'control-label']) }}
                {{ Form::text('referral_contact', $customer->referral_contact, ['class' => 'form-control','placeholder'=>'Referral Contact']) }}
            </div>
            <div class="form-group label-floating">
                {{ Form::label('referral_address', 'Referral Address:', ['class' => 'control-label']) }}
                {{ Form::textarea('referral_address', $customer->referral_address, ['class' => 'form-control', 'placeholder'=>'Referral Address', 'rows' => 2]) }}
            </div>
            <div class="form-group label-floating">
                {{ Form::label('status', 'Status:', ['class' => 'control-label']) }}<br>
                Active: {!! Form::checkbox('status', 1); !!}
            </div>
            <div class="form-group label-floating">
                {{ Form::label('image', 'Photo:', ['class' => 'control-label']) }}
                {{ Form::file('image', ['class' => 'form-control']) }}
            </div>
            <div class="form-group label-floating">
                {{ Form::label('details', 'Details', ['class' => 'control-label']) }}
                {!! Form::textarea('details', $customer->details, ['class'=>'form-control', 'rows' => 4, 'placeholder' => 'Details about this customer']) !!}
            </div>
        </div>
        <div class="clearfix"></div>
      </div>

        <div class="box-footer">
            <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Save</button>
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