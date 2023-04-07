@extends('dashboard')
@section('title', 'Edit MyJob')
@section('content')
<section class="content-header">
  {{-- <h1>MyJob</h1> --}}
<ol class="breadcrumb">
  <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">Edit MyJob</li>
</ol>
</section>
<!-- Main content -->
<section class="content">
  <div class="row"> <!-- left column -->
    <div class="col-sm-6 col-md-offset-2"> <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Edit MyJob</h3>
        </div>
        <div class="col-md-12 text-right toolbar-icon">
            {{-- <a href="{{route('myjob.show',$job->id)}}" class="label label-info" title="Job Details"><i class="fa fa-file-text"></i></a> --}}
            {{-- <a href="{{route('myjob.index')}}" title="View My Jobs" class="label label-success"><i class="fa fa-list"></i></a> --}}
        </div>
      <!-- /.box-header -->
      <!-- form start -->
      {!! Form::model($job, ['route' => ['update_job.user', $job->id], 'method' => 'PUT', 'files' => true]) !!}
      <div class="box-body">
            <div class="col-md-12">
                <h4 style="color:blue">Each Worker Earn: <b>$<span id="worker_earn">{{$job->worker_earn}}</span></b></h4><br>
               <div class="form-group">
                {!! Form::label('worker', 'Worker Need: *', ['class' => 'control-label']) !!}
                {{ Form::number('worker', 1, ['class' => 'form-control', 'min' => 1])}}
                </div>
              <div class="form-group">
                  {{ Form::label('estimated_day', 'Increase Duration Day: *', ['class' => 'control-label']) }}
                  {{ Form::number('estimated_day', 1, ['class' => 'form-control', 'required' => '', 'min' => 1, 'max' => 7]) }}
              </div><br>
            <h4 style="color:green;">Cost Amount = <b>$<span id="total_cost">00.000</span></b></h4>
            </div>
            <div class="clearfix"></div>
        </div> <!-- /.box-body -->
        <div class="clearfix"></div>
        <div class="box-footer">
          <button id="submit" type="submit" class="btn btn-success btn-md "><i class="fa fa-refresh"></i> Confirm</button>
        </div>
        <input type="hidden" id="db_sub_cat_id" value="<?php echo $job->sub_cat_id; ?>">
    {!! Form::close() !!}
</div> <!-- /.box-primary -->

</div> <!--/.col-md-10 -->
</div> <!-- /.row -->
</section> <!-- /.content -->
@endsection

@section('scripts')
<script type="text/javascript">

    //codes for text editor

  /* set minimum earning for a single worker */
    // function setMinEarning(elm)
    // {
    //   var sub_cat = elm.options[elm.options.selectedIndex];
    //   var worker_earn = document.getElementById('worker_earn');

    //   if(sub_cat.getAttribute('budget') > 0){
    //     worker_earn.value = sub_cat.getAttribute('budget');
    //     worker_earn.setAttribute('min', sub_cat.getAttribute('budget'));
    //     total_cost_calc();
    //     // console.log(sub_cat.getAttribute('budget'));
    //   }else{
    //     worker_earn.value = 0.014;
    //     worker_earn.setAttribute('min', 0.014);
    //     total_cost_calc();
    //     // console.log(0.014);
    //   }
    // }


    /* project cost calculation */
    var worker = document.getElementById('worker');
    var worker_earn = document.getElementById('worker_earn');
    var total_cost = document.getElementById('total_cost');

    worker.addEventListener('change', total_cost_calc);
    worker_earn.addEventListener('change', total_cost_calc);

    function total_cost_calc ()
    {
      total = worker.value * worker_earn.innerHTML;
      charge = Number(total * 20 / 100);
      total_cost.innerHTML = Number(Number(total) + Number(charge)).toFixed(3);

      submitEnable();
    }

    total_cost_calc();

    /* submit button enable */
    // function submitEnable()
    // {
    //   var submit = document.getElementById('submit');
    //   if(total_cost.value >= 0.90)
    //   {
    //     submit.removeAttribute('disabled');
    //   }
    //   else
    //   {
    //     submit.setAttribute('disabled', 'disabled');
    //   }
    // }


  //document on reload sub-category selection
  document.onload(getSubcats(document.getElementById('category')));

</script>
@endsection