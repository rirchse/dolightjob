@extends('dashboard')
@section('title', 'Edit Sale')
@section('content')

    <section class="content-header">
      <h1>
        Edit Sale
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit Sale</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-11">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Sale</h3>
            </div>
            <div class="col-md-12 text-right toolbar-icon">
              <a href="{{route('sale.show',$sale->id)}}" class="label label-info" title="sale Details"><i class="fa fa-file-text"></i></a>
              <a href="{{route('sale.index')}}" title="View {{Session::get('_types')}} sale" class="label label-success"><i class="fa fa-list"></i></a>
              {{-- <a href="{{route('sale.delete',$sale->id)}}" class="label label-danger" title="Delete this account"><i class="fa fa-trash"></i></a> --}}
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::model($sale, ['route' => ['sale.update', $sale->id], 'method' => 'PUT', 'files' => true]) !!}
              <div class="box-body">
                <div class="col-md-6">  
                        <div class="form-group label-floating">
                            {{ Form::label('customer_id', 'Select Customer:', ['class' => 'control-label']) }}
                            <select name="customer_id" class="form-control" required>
                                <option value="">Select Customer</option>
                                @foreach($customers as $customer)
                                <option value="{{$customer->id}}" {{ $sale->customer_id == $customer->id ? 'selected' : ''}}>{{$customer->first_name.' '.$customer->last_name.' '.' ['.$customer->contact.']'}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group label-floating">
                            {{ Form::label('product_id', 'Select Porduct:', ['class' => 'control-label']) }}
                            <select name="product_id" class="form-control" required>
                                <option value="">Select Porduct</option>
                                @foreach($products as $product)
                                <option value="{{$product->id}}"  {{ $sale->product_id == $product->id ? 'selected' : ''}}>{{$product->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group label-floating">
                            {{ Form::label('sold_by', 'Select Solder:', ['class' => 'control-label']) }}
                            <select name="sold_by" class="form-control" required>
                                <option value="">Select Solder</option>
                                @foreach($users as $user)
                                <option value="{{$user->id}}" {{ $sale->sold_by == $user->id ? 'selected' : ''}}>{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div> 
                        <div class="form-group label-floating">
                            {{ Form::label('sold_amount', 'Sold Amount:', ['class' => 'control-label']) }}
                            {{ Form::text('sold_amount', null, ['class' => 'form-control', 'required' => '','placeholder'=>'Sold Amount'])}}
                        </div> 
                        <div class="form-group label-floating">
                            {{ Form::label('sales_date', 'Sale Date:', ['class' => 'control-label']) }}
                            {{ Form::date('sales_date', $sale->sales_date, ['class' => 'form-control', 'required' => ''])}}
                        </div>
                        <div class="form-group label-floating">
                            {{ Form::label('sales_type', 'Select Sales Type:', ['class' => 'control-label']) }}
                            <select name="sales_type" class="form-control" required>
                                <option value="">Select Sales Type</option>
                                <option value="Installment"  {{ $sale->sales_type == 'Installment' ? 'selected' : ''}}>Installment</option>
                                <option value="Full_payment" {{ $sale->sales_type == 'Full_payment' ? 'selected' : ''}}>Full payment</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">                        
                        <div class="form-group label-floating">
                            {{ Form::label('referral_name', 'Referral Name', ['class' => 'control-label']) }}
                            {{ Form::text('referral_name', null, ['class' => 'form-control', 'required' => '','placeholder'=>'Referral Name'])}}
                        </div>
                        <div class="form-group label-floating">
                            {{ Form::label('referral_contact', 'Referral Contact', ['class' => 'control-label']) }}
                            {{ Form::text('referral_contact', null, ['class' => 'form-control', 'required' => '','placeholder'=>'Referral Contact'])}}
                        </div> 
                        <div class="form-group label-floating">
                            {{ Form::label('referral_address', 'Referral Address', ['class' => 'control-label']) }}
                            {{ Form::text('referral_address', null, ['class' => 'form-control', 'required' => '','placeholder'=>'Referral Address'])}}
                        </div>
                        <div class="form-group label-floating">
                            {{ Form::label('pay_amount', 'Pay Amount:', ['class' => 'control-label']) }}
                            {{ Form::text('pay_amount', null, ['class' => 'form-control', 'required' => ''])}}
                        </div>         
                                 
                        <div class="form-group label-floating">
                            {{ Form::label('details', 'Details', ['class' => 'control-label']) }}
                            {!! Form::textarea('details',null,['class'=>'form-control', 'rows' => 4, 'cols' => 45]) !!}
                        </div>
                        <div class="form-group label-floating">
                            {{ Form::label('status', 'Status', ['class' => 'control-label']) }}
                            {!! Form::checkbox('status', '1'); !!}
                        </div>                  
                     <div class="col-md-6">
                        <div class="fileinput fileinput-new text-center" data-provides="fileinput" style="width:250px;">                    
                            <div>
                                <span class="btn-round btn-rose btn-file btn-small">
                                    <span class="fileinput-new">Add Photo</span>
                                    <input type="file" name="image">
                                </span>
                                <br />
                            </div>
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