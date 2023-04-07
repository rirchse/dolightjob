@extends('dashboard')
@section('title', 'Create Recharge')
@section('content')

<section class="content-header">
  <h1>Create Recharge Request</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Recharges</a></li>
    <li class="active">Create Recharge</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row"> <!-- left column -->
    <div class="col-md-6"> <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 style="color: #800" class="box-title">Provide Mobile Recharge Information</h3>
        </div>
        {!! Form::open(['route' => 'recharge.store', 'method' => 'POST', 'files' => true]) !!}
        <div class="box-body">
          <div class="form-group">
            {{ Form::label('account_type', 'Select Operator:', ['class' => 'control-label']) }}
            <select name="account_type" class="form-control" required>
              <option value="">Select Operator</option>
              <option value="GrameenPhone+88017">GrameenPhone+88017</option>
              <option value="Robi+88018">Robi+88018</option>
              <option value="Airtel+88016">Airtel+88016</option>
              <option value="Banglalink+88019">Banglalink+88019</option>
              <option value="Teletalk+88015">Teletalk+88015</option>
            </select>
          </div>
          <div class="form-group">
            {{ Form::label('account_no', 'Mobile Number:', ['class' => 'control-label']) }}
            {{ Form::text('account_no', null, ['class' => 'form-control', 'required' => '', 'placeholder' => '01xxxxxxxxx', 'minlength' => 11, 'maxlength' => 11])}}
            <small style="color:#f00">Please double check your mobile number.</small style="color:#f00">
          </div>
          <div class="form-group">
            {{ Form::label('amount', 'Recharge Amount (BDT):', ['class' => 'control-label']) }}
            <div class="input-group">
              <div class="input-group-addon">
                <span style="color:#f00">Min. 20Taka </span>
              </div>
            {{ Form::number('amount', null, ['class' => 'form-control', 'required' => '', 'min' => 20, 'step' => 0.001])}}
            </div>
            <span style="color:#f00;text-align:right" >{{-- $1 = 85 BDT, Charge: <strong>20%</strong> --}} Total Cost: $<b id="usd">0.000</b></span>
            {{-- <span style="font-weight:bold;font-size:16px">00.00</span> --}}
          </div>

          <div class="form-group">
            {{ Form::label('note', 'Note:', ['class' => 'control-label']) }}
            {!! Form::textarea('note', null, ['class'=>'form-control', 'rows' => 3]) !!}
          </div>

          <button type="submit" class="btn btn-success pull-right btn-lg"><i class="fa fa-save"></i> Submit </button>
          <div class="clearfix"></div>
          {!! Form::close() !!}

        </div><!-- /.box -->
      </div><!--/.col (left) -->
    </div><!-- /.row -->
  </section><!-- /.content -->
  @endsection

  @section('scripts')
  <script type="text/javascript">
  var amount = document.getElementById('amount');
  var bdt = document.getElementById('bdt');
  var usd = document.getElementById('usd');
  amount.addEventListener('change', function(){
    var calc_value = Number(amount.value).toFixed(3);
    var usd_value = calc_value/85;
    var percent = usd_value * 20 / 100;
    var total_cost = usd_value + percent;
    usd.innerHTML = Number(total_cost).toFixed(3);
    // amount.value = Number(calc_value) - Number(percent);
    // console.log(amount);
  });
  </script>
  @endsection