@extends('dashboard')
@section('title', 'Post New Job')
@section('content')
<section class="content-header">
  <h1>Post a New Job</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> My Jobs</a></li>
    <li class="active">Post a Job</li>
</ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row"> <!-- left column -->
    <div class="col-md-10"> <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
            <h3 style="color: #800" class="box-title">Job Information</h3>
        </div>
        <form action="/myjob" method="post" id="ajax_form" enctype="multipart/form-data">
            {{csrf_field()}}
        <div class="box-body">
            {{-- <h4 style="border-bottom:1px solid #ddd;text-align:center;"><span style="background:#fff;padding:15px;"> Select Job Category</span></h4> --}}
            <div class="col-md-6">
                <div class="form-group">
                    <label>Select a Job Category: *</label>
                    <select name="category" id="category" class="form-control" onchange="getsubcats(this)" required="">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Select a Sub-Category: *</label>
                    <select id="sub_category" name="sub_category" class="form-control" onchange="setMinEarning(this)" required="">
                        <option value="">Select Sub-Category</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('job_title', 'Job Title: *', ['class' => 'control-label']) !!}
                    {{ Form::text('job_title', null, ['class' => 'form-control', 'required' => '', 'id' => 'job_title'])}}
                </div>
                <div class="form-group">
                    {{ Form::label('description', 'What specific tasks need to be complete? (Job Description):', ['class' => 'control-label']) }}
                    {{ Form::textarea('description', null, ['class' => 'form-control textarea', 'rows' => 8, 'id' => 'description', 'required' => '']) }}
                </div>
                <div class="form-group">
                    {{ Form::label('note', 'Required proof the job was completed:', ['class' => 'control-label']) }}
                    {{ Form::textarea('note', null, ['class' => 'form-control textarea', 'rows' => 5, 'required' => '', 'id' => 'note']) }}
                </div>
            </div>
            <div class="col-md-12">
                <h4 style="border-bottom:1px solid #ddd;text-align:center;margin-top:50px;margin-bottom:30px"><span style="background:#fff;padding:15px;"> Budget and Settings</span></h4>
            </div>

            <div class="col-md-6">
            <div class="col-md-6" style="padding-left:0">
               <div class="form-group">
                {!! Form::label('worker', 'Worker Needed: *', ['class' => 'control-label']) !!}
                {{ Form::number('worker', 1, ['class' => 'form-control', 'required' => '', 'min' => 1, 'id' => 'worker'])}}
                </div>
            <div class="form-group">
                {{ Form::label('screenshot', 'Required Screenshots: *', ['class' => 'control-label']) }}
                {{ Form::number('screenshot', 0, ['class' => 'form-control', 'min' => 0, 'max' => 2, 'id' => 'screenshot']) }}
            </div>
            </div>
            <div class="col-md-6" style="padding-right:0">
            <div class="form-group">
                {{ Form::label('worker_earn', 'Each Worker Earn: *', ['class' => 'control-label']) }}
                {{ Form::number('worker_earn', 0.014, ['class' => 'form-control', 'step' => 0.001, 'required' => '', 'min' => 0.010, 'id' => 'worker_earn']) }}
            </div>
            <div class="form-group">
                {{ Form::label('estimated_day', 'Estimated Day: *', ['class' => 'control-label']) }}
                {{ Form::number('estimated_day', 1, ['class' => 'form-control', 'required' => '', 'min' => 1, 'max' => 7, 'id' => 'estimated_day']) }}
            </div>

            </div>
            </div>

            <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('total_cost', 'Total Cost: *', ['class' => 'control-label']) }}
                <div class="input-group">
                  <div class="input-group-addon">
                    <span style="color:red">Min. $0.90</span>
                  </div>
                  {{ Form::number('total_cost', 0, ['class' => 'form-control', 'step' => 0.001, 'required' => '', 'min' => 0.90, 'id' => 'total_cost']) }}
                </div>
            </div>
            </div>
            <div class="col-md-6">              
            <div class="form-group">
                {{ Form::label('image', 'Add Attachment:', ['class' => 'control-label']) }}
                <div class="input-group">
                  {{ Form::file('image', ['class' => 'form-control', 'id' => 'image']) }}
                  <div for="image" class="input-group-addon"><i class="fa fa-file-text"></i></div>
                </div><br>
                <img id="preview" width=250>
            </div>
            </div>
            <div class="col-md-6">
                <label>Enable Auto Pause: <input type="checkbox" name="auto_pause" value="1"></label>
                {{ Form::number('apply_limit', null, ['class' => 'form-control', 'required' => '', 'id' => 'apply_limit', 'placeholder' => 'Job will auto pause when cross the limit.'])}}
            </div>
            <div class="clearfix"></div>
        </div> <!-- /.box -->
        <div class="box-footer">
            <p class="text-danger text-center" id="msg"></p>
            <button id="submit" disabled type="submit" class="btn btn-success btn-lg pull-right"><i class="fa fa-save"></i> Submit</button>
        </div>
    {!! Form::close() !!}
</div> <!--/.col (left) -->
</div> <!-- /.row -->
</section> <!-- /.content -->
@endsection

@section('scripts')
<script type="text/javascript">

    function getsubcats(elm){
        var catid = elm.options[elm.options.selectedIndex].value;
        $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: '/get_sub_cats/'+catid,
            success: function (data) {

                var obj = JSON.parse(JSON.stringify(data));
                var sub_cat_html = "";

                $.each(obj['subcats'], function (key, val) {
                   sub_cat_html += "<option budget="+val.budget+" value="+val.id+">"+val.name+"</option>";
                });

                if(sub_cat_html != ""){
                    $("#sub_category").html('<option value="">Select Sub-Category</option>'+sub_cat_html)
                }else{
                    $("#sub_category").html('<option value="">No Sub-Category</option>')
                }
            },
            error: function(data) { 
                 // console.log('data error');
            }
        });
    }

  //document on reload sub-category selection
  // document.onload(getsubcats(document.getElementById('category')));

    //set minimum earning for a single worker
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

    // getsubcats(elm);

    //project cost calculation
    var worker = document.getElementById('worker');
    var worker_earn = document.getElementById('worker_earn');
    var total_cost = document.getElementById('total_cost');

    worker.addEventListener('change', total_cost_calc);
    worker_earn.addEventListener('change', total_cost_calc);

    function total_cost_calc()
    {
        total = worker.value * worker_earn.value;
        charge = Number(total * 20 / 100);
        total_cost.value = Number(Number(total) + Number(charge)).toFixed(3);
        submitEnable();
    }

    total_cost_calc();

    /* submit button enable */
    function submitEnable(){
      var submit = document.getElementById('submit');
      if(total_cost.value >= 0.90)
      {
        submit.removeAttribute('disabled');
      }else{
        submit.setAttribute('disabled', 'disabled');
      }
    }

    //codes for text editor
    // $(function(){
    //     CKEDITOR.replace('editor1')
    //     // $('.textarea').wysihtml5()
    // });

</script>

<script type="text/javascript">

    //submit prove from by ajax
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $(document).ready(function(){
      $('#ajax_form').submit(function (e) {
        //disable the submit button when form submitted.
        document.getElementById('submit').setAttribute('disabled', 'disabled');
         //to prevent normal form submission and page reload
        e.preventDefault();
        //to create object form data
        var postData = new FormData(this); 
        $.ajax({
          type : 'POST',
          url : "{{route('myjob.store')}}",
          data : postData,
          processData: false,
          contentType: false,
          success: function(result){
            if(result.status == 'ok'){
                alert(result.msg);
                window.location.href = '/myjob/'+result.id;
            }
          },
          error: function (xhr, ajaxOptions, thrownError) {
            document.getElementById('submit').removeAttribute('disabled');
            // console.log(job_title);
            alert(xhr.status);
            alert(thrownError);
          }
        });
      });
    });
  </script>
@endsection