@extends('dashboard')
@section('title', 'Create Deposit')
@section('content')

<section class="content-header">
  <h1>Create Deposit</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Deposits</a></li>
    <li class="active">Create Deposit</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row"> <!-- left column -->
    <div class="col-md-6"> <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 style="color: #800" class="box-title">Deposit Indication:</h3>
        </div>
        <div class="box-body">
          <h4 style="color:green">Your current deposit balance: <b>${{App\DepositBalance::where('user_id', Auth::id())->first()->amount}}</b></h4>
          <div class="payment_indication" id="payment_instruction">
            Select Payment Option <i class="fa fa-arrow-right"></i>
          </div>
          
        </div>
      </div>{{-- box box-primary --}}
    </div>
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 style="color: #800" class="box-title">Deposit Information</h3>
        </div>
        {!! Form::open(['route' => 'diposit.store', 'method' => 'POST', 'files' => true]) !!}
        <div class="box-body">
          <div class="form-group">
            {{ Form::label('account_type', 'Payment Method:', ['class' => 'control-label']) }}
            <select name="account_type" class="form-control" required onchange="payment_ins(this);">
              <option value="">Select Deposit Option</option>
              <option value="bKash">bKash</option>
              <option value="Rocket">Rocket</option>
              <option value="Nagad">Nagad</option>
              {{-- <option value="Earning-Deposit">Earning to Deposit</option> --}}
            </select>
          </div>

          <div class="form-group">
          <div class="col-md-6" style="padding-left:0">
            {{ Form::label('usd', 'Deposit Amount ($):', ['class' => 'control-label']) }}
            <div class="input-group">
              <div class="input-group-addon"><i class="fa fa-usd"></i></div>
            {{ Form::number('usd', null, ['class' => 'form-control', 'required' => '', 'step' => '.001', 'min' => '1', 'max' => '117.647'])}}
            </div>
          </div>
          <div class="col-md-6" style="padding-right:0">
            {{ Form::label('bdt', 'Deposit Amount (BDT):', ['class' => 'control-label']) }}
            <div class="input-group">
              <div class="input-group-addon"><i class="fa fa-money"></i></div>
            {{ Form::number('bdt', null, ['class' => 'form-control', 'required' => '', 'min' => 85, 'step' => '0.001'])}}
            </div>
          </div>
            <span>$1 = 85 BDT,</span>
            <span style="color:red">Minimum deposit amount: (BDT.85Tk.) (USD $1)</span>
          </div>
          <div class="form-group">
            {{ Form::label('account_no', 'Sender Account Number:', ['class' => 'control-label']) }}
            {{ Form::text('account_no', null, ['class' => 'form-control', 'required' => '', 'minlength' => 11, 'maxlength' => 11, 'id' => 'account_no'])}}
          </div>
          <div class="form-group">
            {{ Form::label('transaction_id', 'Transaction ID (TrxID):', ['class' => 'control-label']) }}
            {{ Form::text('transaction_id', null, ['class' => 'form-control', 'required' => '', 'minlength' => 4, 'id' => 'trxid'])}}
          </div>
          <div class="form-group">
            {{ Form::label('note', 'Note:', ['class' => 'control-label']) }}
            {!! Form::textarea('note', null, ['class'=>'form-control', 'rows' => 3]) !!}
          </div>

          <button type="submit" class="btn btn-success pull-right btn-lg"><i class="fa fa-save"></i> Submit</button>
          <div class="clearfix"></div>
          {!! Form::close() !!}

        </div> <!-- /.box -->
      </div> <!--/.col (left) -->
    </div> <!-- /.row -->
  </section> <!-- /.content -->
  @endsection

  @section('scripts')
  <script type="text/javascript">
  var usd = document.getElementById('usd');
  var bdt = document.getElementById('bdt');
  var account_no = document.getElementById('account_no');
  var trxid = document.getElementById('trxid');
  var view = document.getElementById('view');
  var earnings = document.getElementById('earnings');

  usd.addEventListener('change', calc_usd);
  bdt.addEventListener('change', calc_bdt);
  function calc_usd(){
    var calc_value = Number(usd.value * 85).toFixed(2);
    bdt.value = calc_value;
  }
function calc_bdt(){
    var calc_value = Number(bdt.value / 85).toFixed(3);
    usd.value = calc_value;
  }

  //payment options
  function payment_ins (elm) {
    var payment_instruction = document.getElementById('payment_instruction');
    // console.log(elm.options[elm.options.selectedIndex].value);
    var pay_type = elm.options[elm.options.selectedIndex];
    if(pay_type.value == 'bKash')
    {
      payment_instruction.innerHTML = '<h4>Send money to this number: <strong id="copy">01784888730</strong> <button onclick="Copy()">Copy</button> <button onclick="Copy()">Copy</button></h4><a target="_blank" href="/img/payment_option/bkash.jpg"><img class="img-responsive" src="/img/payment_option/bkash.jpg"></a>';
      empty_depo_field();
    }
    else if(pay_type.value == 'Rocket')
    {
      payment_instruction.innerHTML = '<h4>Send money to this number: <strong id="copy">01784888730</strong> <button onclick="Copy()">Copy</button></h4><a target="_blank" href="/img/payment_option/rocket.jpg"><img class="img-responsive" src="/img/payment_option/rocket.jpg"></a>';
      empty_depo_field();
    }
    else if(pay_type.value == 'Nagad'){
      payment_instruction.innerHTML = '<h4>Send money to this number: <strong id="copy">01784888730</strong> <button onclick="Copy()">Copy</button></h4><a target="_blank" href="/img/payment_option/nagad.jpg"><img class="img-responsive" src="/img/payment_option/nagad.jpg"></a>';
      empty_depo_field();
    }
    else if(pay_type.value == 'Earning-Deposit')
    {
      account_no.value = '01700000000';
      trxid.value = 'EarDepo';
      account_no.parentNode.style.display = 'none';
      trxid.parentNode.style.display = 'none';
      usd.setAttribute('max', earnings.innerHTML);
      payment_instruction.innerHTML = '<h3 style="color:#f00">Your current earning balance: <strong>$'+earnings.innerHTML+'</strong><br> Minimum deposit amount <strong>$1</strong></h3></a>';
    }
    else
    {
      payment_instruction.innerHTML = '<h3>Select Payment Option <i class="fa fa-arrow-right"></i></h3>';
      empty_depo_field();
    }

    function empty_depo_field()
    {      
      account_no.value = '';
      trxid.value = '';
      account_no.parentNode.style.display = 'block';
      trxid.parentNode.style.display = 'block';
      usd.setAttribute('max', 117.647);
    }
    
  }

  </script>
  @endsection