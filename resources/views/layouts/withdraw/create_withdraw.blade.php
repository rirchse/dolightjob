@extends('dashboard')
@section('title', 'Create Withdraw')
@section('content')

<section class="content-header">
  <h1>Create Withdraw Request</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Withdraws</a></li>
    <li class="active">Create Withdraw</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row"> <!-- left column -->
    <div class="col-md-6"> <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 style="color: #800" class="box-title">Provide Your Personal Account Information</h3>
        </div>
        {!! Form::open(['route' => 'withdraw.store', 'method' => 'POST', 'files' => true]) !!}
        <div class="box-body">
          <div class="form-group">
            {{ Form::label('account_type', 'Bank Account:', ['class' => 'control-label']) }}<br>
            <style type="text/css">
            .operator{border:1px solid #ddd;width:100%; display:table; max-width:32.35%; padding:0 10px;display:inline-block;}
            .operator img{width: 100px;display: inline-block;}
            </style>
            <div class="operator">
            <label><input type="radio" name="account_type" value="bKash"> <img src="/img/operators/bkash.png"></label>
            </div>
            <div class="operator">
            <label><input type="radio" name="account_type" value="Rocket"> <img src="/img/operators/rocket.png"></label>
            </div>
            <div class="operator">
            <label><input type="radio" name="account_type" value="Nagad"> <img src="/img/operators/nagad.png"></label>
            </div>
          </div>
          <div class="form-group">
            {{ Form::label('account_no', 'Account Number:', ['class' => 'control-label']) }}
            {{ Form::text('account_no', null, ['class' => 'form-control', 'required' => '', 'minlength' => 11, 'maxlength' => 11])}}
            <span style="color:#f00">Please double check your account number.</span>
          </div>
          <div class="form-group">
            {{ Form::label('amount', 'Withdraw Amount (USD):', ['class' => 'control-label']) }}
            <div class="input-group">
              <div class="input-group-addon">
                <span style="color:#f00">Min. $0.736 </span>
              </div>
            {{ Form::number('amount', null, ['class' => 'form-control', 'required' => '', 'min' => 0.736, 'step' => 0.001, 'id' => 'usd'])}}
            </div>
            <span>$1 = 85 BDT,  <strong>20%</strong> Charge applicable. <span style="color:#f00">Minimum amount <b>$0.736 = 50BDT </b></span></span>
            You will receive: <span id="view" style="font-size:18px;color:#f00"> 50</span>Taka.
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
  var view = document.getElementById('view');
  var usd = document.getElementById('usd');
  usd.addEventListener('keyup', function(){
    var calc_value = Number(usd.value*85).toFixed(3);
    var percent = calc_value*20/100;
    view.innerHTML = Number(calc_value) - Number(percent);
    amount.value = Number(calc_value) - Number(percent);
  });
  </script>
  @endsection