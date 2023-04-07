@extends('dashboard')
@section('title', 'Edit MyJob')
@section('content')
<section class="content-header">
  <h1>MyJob</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Edit MyJob</li>
</ol>
</section>
<!-- Main content -->
<section class="content">
  <div class="row"> <!-- left column -->
    <div class="col-md-10"> <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Edit MyJob</h3>
        </div>
        <div class="col-md-12 text-right toolbar-icon">
            <a href="{{route('myjob.show',$myjob->id)}}" class="label label-info" title="Job Details"><i class="fa fa-file-text"></i></a>
            <a href="{{route('myjob.index')}}" title="View My Jobs" class="label label-success"><i class="fa fa-list"></i></a>
            {{-- <a href="{{route('myjob.delete',$myjob->id)}}" class="label label-danger" title="Delete this account"><i class="fa fa-trash"></i></a> --}}
        </div>
      <!-- /.box-header -->
      <!-- form start -->
      {!! Form::model($myjob, ['route' => ['myjob.update', $myjob->id], 'method' => 'PUT', 'files' => true]) !!}
      <div class="box-body">
        {{-- <div class="col-md-6">
            <div class="form-group">
              {{ Form::label('category', 'Category: *', ['class' => 'control-label']) }}
              <select id="category" name="category" class="form-control" onChange="getSubcats(this);">
                  <option value="">Select Category</option>
                  @foreach($categories as $category)
                  <option value="{{$category->id}}"{{ $myjob->cat_id == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                  @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('sub_category', 'Sub-Category: *', ['class' => 'control-label']) }}
                <select id="sub_cat" name="sub_category" class="form-control" onchange="setMinEarning(this);" >
                    <option value="">Select Sub-Category</option>
                </select>
            </div>
          </div> --}}
          <div class="col-md-12">
              <div class="form-group">
                {!! Form::label('job_title', 'Job Title: *', ['class' => 'control-label']) !!}
                {{ Form::text('job_title', $myjob->job_title, ['class' => 'form-control'])}}
              </div>
              <div class="form-group">
                  {{ Form::label('description', 'What specific tasks need to be complete?(Job Description): *', ['class' => 'control-label']) }}
                  {{ Form::textarea('description', $myjob->description, ['class' => 'form-control textarea', 'rows' => 5]) }}
              </div>
              <div class="form-group">
                  {{ Form::label('note', 'Required proof the job was completed:', ['class' => 'control-label']) }}
                  {{ Form::textarea('note', $myjob->required_proof, ['class' => 'form-control textarea','rows' => 5]) }}
              </div>
          </div>
            {{-- <div class="col-md-12">
                <h4 style="border-bottom:1px solid #ddd;text-align:center;margin-top:50px;margin-bottom:30px"><span style="background:#fff;padding:15px;"> Budget and Settings</span></h4>
            </div> --}}
            {{-- <div class="col-md-6" style="padding-left:0">
               <div class="form-group">
                {!! Form::label('worker', 'Worker Needed: *', ['class' => 'control-label']) !!}
                {{ Form::number('worker', $myjob->worker_needed, ['class' => 'form-control'])}}
                </div>--}}
            </div>
            <div class="col-md-6" style="padding-right:0">
              <div class="form-group">
                {{ Form::label('screenshot', 'Required Screenshots: *', ['class' => 'control-label']) }}
                {{ Form::number('screenshot', $myjob->screenshot, ['class' => 'form-control']) }}
              </div>
              {{-- <div class="form-group">
                  {{ Form::label('worker_earn', 'Each Worker Earn ($): *', ['class' => 'control-label']) }}
                  {{ Form::number('worker_earn', $myjob->worker_earn, ['class' => 'form-control', 'step' => 0.001]) }}
              </div> --}}
              <div class="form-group">
                  {{ Form::label('estimated_day', 'Estimated Day: *', ['class' => 'control-label']) }}
                  {{ Form::number('estimated_day', $myjob->estimated_day, ['class' => 'form-control', 'required' => '']) }}
              </div>
            </div>
            <div class="col-md-6">
            {{-- <div class="form-group">
                {{ Form::label('total_cost', 'Total Cost ($): *', ['class' => 'control-label']) }}
                <div class="input-group">
                  <div class="input-group-addon">
                    <span style="color:red">Min. $0.90</span>
                  </div>
                {{ Form::number('total_cost', $myjob->total_cost, ['class' => 'form-control', 'step' => 0.001, 'readonly' => '']) }}
              </div>
            </div> --}}
              <div class="form-group">
                {{ Form::label('image', 'Add Attachement:', ['class' => 'control-label']) }}
                {{ Form::file('image', ['class' => 'form-control', 'id' => 'image']) }}
                @if($myjob->image)
                <a target="_blank" href="{{$myjob->image}}">View Attachement</a>
                @endif                
                <br><img id="preview" src="{{$myjob->image?$myjob->image:''}}" width=250 alt="">
              </div>
            </div>
            <div class="col-md-6 col-md-offset-3">
              <br>
              {{-- <div class="form-group">
                  <b>Choose Job Status: </b>
                  {!! Form::radio('status', '1'); !!}
                  {{ Form::label('status1', ' Publish:', ['class' => 'control-label']) }}
                  {!! Form::radio('status', '6'); !!}
                  {{ Form::label('status2', ' UnPublish:', ['class' => 'control-label']) }}
              </div> --}}
            </div>
            <div class="clearfix"></div>
        <div class="box-footer">
          <button id="submit" type="submit" class="btn btn-success pull-right"><i class="fa fa-refresh"></i> Update</button>
        </div>
        </div> <!-- /.box-body -->
        <input type="hidden" id="db_sub_cat_id" value="<?php echo $myjob->sub_cat_id; ?>">
    {!! Form::close() !!}
    </div> <!-- /.box-primary -->

    </div> <!--/.col-md-10 -->
  </div> <!-- /.row -->
</section> <!-- /.content -->
@endsection

@section('scripts')
<script type="text/javascript">

    //codes for text editor
    // $(function(){$('.textarea').wysihtml5()});
    
    //ajax call get sub-categories
  function getSubcats(elm)
  {
    var catid = elm.options[elm.options.selectedIndex].value;
    var db_sub_cat_id = document.getElementById('db_sub_cat_id').value;
    
    // $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content');}});

    $.ajax({
      type: 'GET', //THIS NEEDS TO BE GET
      url: '/get_sub_cats/'+catid,
      success: function (data) {

        var obj = JSON.parse(JSON.stringify(data));
        var sub_cat_html = "";

        $.each(obj['subcats'], function (key, val) {
          if(db_sub_cat_id == val.id){
           sub_cat_html += "<option value="+val.id+" selected='selected'>"+val.name+"</option>";
         }else{
          sub_cat_html += "<option value="+val.id+">"+val.name+"</option>";
        }
        });

        if(sub_cat_html != ""){
            $("#sub_cat").html('<option value="">Select Sub-Category</option>'+sub_cat_html);
        }else{
            $("#sub_cat").html('<option value="">No Sub-Category</option>');
        }

        // console.log(obj['subcats'].count());

        // $("#sub_cat").append(you_html); //// For Append
           //// For replace with previous one
      },
      error: function(data) { 
           // console.log('data error');
      }
    });
  }

  /* set minimum earning for a single worker */
    function setMinEarning(elm)
    {
      var sub_cat = elm.options[elm.options.selectedIndex];
      var worker_earn = document.getElementById('worker_earn');

      if(sub_cat.getAttribute('budget') > 0){
        worker_earn.value = sub_cat.getAttribute('budget');
        worker_earn.setAttribute('min', sub_cat.getAttribute('budget'));
        total_cost_calc();
        // console.log(sub_cat.getAttribute('budget'));
      }else{
        worker_earn.value = 0.014;
        worker_earn.setAttribute('min', 0.014);
        total_cost_calc();
        // console.log(0.014);
      }
    }


    /* project cost calculation */
    var worker = document.getElementById('worker');
    var worker_earn = document.getElementById('worker_earn');
    var total_cost = document.getElementById('total_cost');

    worker.addEventListener('change', total_cost_calc);
    worker_earn.addEventListener('change', total_cost_calc);

    function total_cost_calc ()
    {
      total = worker.value * worker_earn.value;
      charge = Number(total * 10 / 100);
      total_cost.value = Number(Number(total) + Number(charge)).toFixed(3);

      submitEnable();
    }

    total_cost_calc();

    /* submit button enable */
    function submitEnable()
    {
      var submit = document.getElementById('submit');
      if(total_cost.value >= 0.90)
      {
        submit.removeAttribute('disabled');
      }
      else
      {
        submit.setAttribute('disabled', 'disabled');
      }
    }


  //document on reload sub-category selection
  document.onload(getSubcats(document.getElementById('category')));

</script>
@endsection