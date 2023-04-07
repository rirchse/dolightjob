@extends('dashboard')
@section('title', 'Prove Details')
@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Prove Details</h1>
      <ol class="breadcrumb">
        <li>
          <a href="#"><i class="fa fa-dashboard"></i>My Job </a>
        </li>
        <li class="active">Details</li>
      </ol>    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-8"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Prove Information</h4>
            <div class="box-tools">
              <a href="/myjob" title="" class="label label-info" title="Back to MyJob"><i class="fa fa-list"></i> My Job</a>
              <a href="/myjob/{{$task->job_id}}/prove" title="" class="label label-success"><i class="fa fa-list"></i></a>
              <a href="/myjob/{{$task->job_id}}/prove" class="label label-success" title="Proves"><i class="fa fa-go"></i> Proves</a>
            </div>
          </div>
          {{-- <div class="col-md-12 text-right toolbar-icon"></div> --}}
          <div class="col-md-12">
            <table class="table">
                <tbody>
                  <tr>
                    <th>Job Title</th>
                    <th>{{$task->job_title}}</th>
                  </tr>
                  <tr>
                    <th>Required Proof</th>
                    <td>{!!$task->required!!}</td>
                  </tr>
                  <tr>
                    <th>Submitted Proof</th>
                    <td>{!!$task->note!!}</td>
                  </tr>
                  <tr>
                    <th>#1 Screenshot </th>
                    <td>
                      <a target="_blank" href="{{$task->screenshot}}"><img class="img-responsive" src="{{$task->screenshot}}" alt=""></a></td>
                  </tr>
                  @if($task->screenshot_2)                  
                  <tr>
                    <th>#2 Screenshot </th>
                    <td>
                      <a target="_blank" href="{{$task->screenshot}}"><img class="img-responsive" src="{{$task->screenshot_2}}" alt=""></a></td>
                  </tr>
                  @endif
              </tbody>
            </table>
          </div>
        <div class="clearfix"></div>
        </div>
        {!! Form::model($task, ['route' => ['task.approve', $task->id], 'method' => 'PUT', 'files' => true]) !!}
        <div class="panel panel-primary">
          <div class="panel-heading"><h4>Approve The Job</h4></div>
          <div class="panel-body">
            <div class="radio">
              <label>
                <input type="radio" class="radio" name="approval" value="Satisfy" onclick="Approve(this);" {{$task->approval == 'Satisfy'?'checked':''}}> Satisfy
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" class="radio" name="approval" value="Unsatisfy" onclick="Approve(this);" id="unsatisfy" {{$task->approval == 'Unsatisfy'?'checked':''}}> Unsatisfy
              </label>
            </div>
          <div class="form-group">
            <textarea name="comment" id="comment" rows="3" class="form-control" placeholder="Reason of unsatisfied" style="display:none">{{$task->comment}}</textarea>
          </div>
          </div>
          <div class="panel-footer">
            <input type="submit" class="btn btn-success btn-lg" value="Submit">
          </div>
        </div>
        {!! Form::close() !!}
      </div><!-- /.box -->
    </div><!--/.col (left) -->
  </section><!-- /.content -->
   
@endsection
@section('scripts')
<script type="text/javascript">
  var unsatisfy = document.getElementById('unsatisfy');
  function Approve(elm)
  {
    var appr = document.getElementById('comment');
    if(elm.value == 'Unsatisfy')
    {
      appr.style.display = 'block';
      appr.setAttribute('required', 'required');
    }
    else
    {
      appr.style.display = 'none';
      appr.removeAttribute('required');
    }    
  }
  if(unsatisfy.getAttribute('checked') == ''){
    Approve(unsatisfy);
  }

</script>

  

@endsection