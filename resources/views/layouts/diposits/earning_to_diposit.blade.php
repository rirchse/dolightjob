@extends('dashboard')
@section('title', 'Earning to Deposit')
@section('content')

<section class="content-header">
  <h1>Earning to Deposit</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Deposits</a></li>
    <li class="active">Earning to Deposit</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row"> <!-- left column -->
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 style="color: #800" class="box-title">Deposit Information</h3>
        </div>
        {!! Form::open(['route' => 'diposit.store', 'method' => 'POST', 'files' => true]) !!}

        <div class="box-body">
          <h4 style="color:green">Your Earning Balance: <b>$<span id="earning_bal">{{App\EarningBalance::where('user_id', Auth::id())->first()->amount}}</span></b></h4>
        </div>

        <div class="box-body">
          <div class="form-group">
            {{ Form::label('usd', 'Deposit Amount ($):', ['class' => 'control-label']) }}
            <div class="input-group">
              <div class="input-group-addon"><i class="fa fa-usd"></i></div>
            {{ Form::number('usd', null, ['class' => 'form-control', 'required' => '', 'step' => '.001', 'min' => '0.20', 'max' => '117.647'])}}
            </div>
            <input type="hidden" name="account_type" value="Earning-Deposit">
            <input type="hidden" name="bdt" id="bdt" value="">
          </div>
          <div class="form-group">
            {{ Form::hidden('account_no', '01700000000', ['class' => 'form-control', 'required' => '', 'minlength' => 11, 'maxlength' => 11, 'id' => 'account_no'])}}
          </div>
          <div class="form-group">
            {{ Form::hidden('transaction_id', 'EarDepo', ['class' => 'form-control', 'required' => '', 'minlength' => 4, 'id' => 'trxid'])}}
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
  var earning_bal = document.getElementById('earning_bal');
  var view = document.getElementById('view');
  var earnings = document.getElementById('earnings');

  usd.addEventListener('change', calc_usd);
  function calc_usd(){
    // var calc_value = Number(usd.value * 85);
    bdt.value = Number(usd.value * 85);
  }

  //onload set max earning value
  usd.setAttribute('max', earning_bal.innerHTML);

  </script>
  @endsection