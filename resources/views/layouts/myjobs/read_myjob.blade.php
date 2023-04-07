@extends('dashboard')
@section('title', 'My Jo Details')
@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>My Job Details</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> My Jobs</a></li>
        <li class="active">Details</li>
      </ol>    
    </section>

    <!-- Main content -->
    <style type="text/css">.info-box-content{margin-left: 0px;text-align: center;}</style>
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-8 no-padding">
        <div class="col-md-4">
          <div class="info-box">
            <div class="info-box-content">
              <span class="info-box-text">Job ID</span>
              <span class="info-box-number">#{{$myjob->id}}</span>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="info-box">
            <div class="info-box-content">
              <span class="info-box-text">Progress</span>
              <span class="info-box-number">{{count(App\Task::where('job_id', $myjob->id)->whereNotIn('status', [3])->get())}} of {{$myjob->worker}}</span>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="info-box">
            <div class="info-box-content">
              <span class="info-box-text">Each Earn</span>
              <span class="info-box-number">${{$myjob->worker_earn}}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-8"><!-- general form elements -->
        <div class="info-box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">{{$myjob->job_title}}</h3>
          </div>
          <div class="box-body">
          <div class="col-md-12 text-right toolbar-icon">
            <a href="/myjob/create" title="Add New Job" class="label label-info"><i class="fa fa-plus"></i></a>
            <a href="/myjob" title="View MyJobs" class="label label-success"><i class="fa fa-list"></i></a>
            @if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin']))
            <a href="/myjob/{{$myjob->id}}/edit" class="label label-warning" title="Edit this myjob"><i class="fa fa-edit"></i></a>
            @endif
            
            {{-- <a href="{{route('myjob.delete',$myjob->id)}}" class="label label-danger" onclick="return confirm('Are you sure want to delete this account!');" title="Delete this account"><i class="fa fa-close"></i></a> --}}
            
          </div>
          <style type="text/css">
          .table tbody tr td{line-height: 2.5}
          </style>
          <div class="col-md-12">
            <table class="table">
                <tbody>
                  <tr>
                    <td colspan=2>
                      <a target="_blank" href="{{$myjob->image}}"><img class="img-responsive" src="{{$myjob->image}}"></a>
                    </td>
                  </tr>
                  <tr>
                    <td>Category: <b>{{$myjob->cat_id?DB::table('categories')->find($myjob->cat_id)->name:''}}</b><br>Sub Category: <b>{{$myjob->sub_cat_id?DB::table('subcategories')->find($myjob->sub_cat_id)->name:''}}</b><br>
                      Time: <b>{{$myjob->estimated_day}}</b> Day<br>
                      Screenshot Required: <b>{{$myjob->screenshot}}</b></td>
                    <td>Job Posted: <b>{{date('d M Y h:i:s A',strtotime($myjob->created_at) )}}</b><br>
                      Last Update: <b>{{date('d M Y h:i:s A',strtotime($myjob->updated_at) )}}</b><br>
                      Status: 
                      @if($myjob->status == 0)
                      <span class="label label-warning">Pending</span>
                      @elseif($myjob->status == 1)
                      <span class="label label-success">Active</span>
                      @elseif($myjob->status == 2)
                      <span class="label label-danger">Cancelled</span>
                      @elseif($myjob->status == 3)
                      <span class="label label-info">Completed</span>
                      @elseif($myjob->status == 4)
                      <span class="label label-primary">Pause</span>
                      @elseif($myjob->status == 5)
                      <span class="label label-default">Auto Pause</span>
                      @endif
                      <p style="color:green">Job Posted  By: <b>{{App\User::find($myjob->created_by)?App\User::find($myjob->created_by)->name:''}}</b></p>
                    </td>
                  </tr>
                  @if($myjob->created_by == Auth::id() || Auth::user()->authorizeRoles(['SuperAdmin', 'Admin']))
                    <tr>
                      <td>
                        Auto Pause Status: <b>{{$myjob->auto_pause == 1?'Enabled':'Disabled'}}</b><br>
                        Apply Limit: <b>{{$myjob->apply_limit}}</b><br>
                      </td>
                      <td>
                        Apply Counter: <b>{{$myjob->apply_counter}}</b><br>
                        Paused Time: <b>{{$myjob->paused_time?date('d M Y h:i:s a', strtotime($myjob->paused_time)):''}}</b><br>
                      </td>
                    </tr>
                  @endif
              </tbody>
            </table>
          </div>
        </div>
        {{-- <div class="box-footer">
          
        </div> --}}
      </div><!-- /.box -->
      <div class="info-box">
        <div class="panel">
          <div class="box-header with-border"><h4>Job Description:</h4></div>
          <div class="panel-body">{!!$myjob->description!!}</div>
        </div>
      </div>

      <div class="info-box">
        <div class="panel">
          <div class="box-header with-border">
            <h4>Required Proof:</h4>
          </div>
          <div class="panel-body">
            {!!$myjob->note!!}
          </div>
        </div>
      </div>
      <div class="box-footer">
        <a href="/edit_my_job/{{$myjob->id}}" class="btn btn-primary"> <i class="fa fa-refresh"></i> Update Job</a>
        @if($myjob->status == 1)
        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#auto_pause">Pause/Auto Pause</button>
        @elseif($myjob->status == 4 || $myjob->status == 5)
        <a href="/myjob-pause/{{$myjob->id}}" class="btn btn-info"> <i class="fa fa-check"></i> Resume</a>
        @endif
        @if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin']))
          @if($myjob->status == 0)
          <a href="/myjob/{{$myjob->id}}/approve" class="btn btn-success"> <i class="fa fa-check"></i> Approve</a>
          @endif
          @if($myjob->status == 0 || $myjob->status == 4)
          <a href="{{route('myjob.delete',$myjob->id)}}" onclick="return confirm('Are sure you want to permanently delete this myjob?')" class="btn btn-danger"> <i class="fa fa-trash"></i> Delete</a>
          @endif
        @endif
        @if($myjob->status != 0)
        <a href="/myjob/{{$myjob->id}}/prove" class="btn btn-info pull-right" title="Proves"><i class="fa fa-users"></i> Proves</a>
        @endif
      <div class="clearfix"></div>
      </div>
    </div><!--/.col (left) -->
    <div class="col-md-4">
      <div class="info-box">
        <div class="box-header">Reports</div>
        <div class="box-body">
          <table class="table">
            <tr>
              <th>Created By</th>
              <th>Note</th>
              <th>Action</th>
            </tr>
            @foreach(App\Report::where('status', 0)->where('job_id', $myjob->id)->get() as $report)
            <tr>
              <td>
                <?php $created_by = App\User::find($report->created_by); ?>
                @if($created_by)
                <a href="/user_review/{{$created_by->id}}">{{$created_by->name}}</a>
                @endif
              </td>
              <td>{{$report->note}}</td>
              <td><a onclick="return confirm('Are you sure you want to delete this report?')" href="/report/{{$report->id}}/delete" class="text-danger">Del</a></td>
            </tr>
            @endforeach
          </table>
        </div>
      </div>
    </div>
  </section><!-- /.content -->

  <!-- worker prove panel -->
    <div class="modal fade" id="auto_pause">
      <div class="modal-dialog">
        <div class="modal-content" style="overflow-y:auto">
          {!! Form::model($myjob,['route' => ['myjob.auto_pause', $myjob->id], 'method' => 'PUT', 'files' => true]) !!}
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Pause / Auto Pause</h4>
            </div>
          <div class="modal-body">
            <label>Auto Pause: </label><br>
            <label><input type="radio" name="auto_pause" value="1" class="auto" onclick="check(this)" {{$myjob->auto_pause == 1?'checked':''}}> Enable </label> <label> <input type="radio" name="auto_pause" value="0"  class="auto" onclick="check(this)" {{$myjob->auto_pause == 0?'checked':''}}> Disable </label>
                {{ Form::number('apply_limit', null, ['class' => 'form-control', 'required' => '', 'id' => 'apply_limit', 'placeholder' => 'Job will auto pause when cross the limit.'])}}            
          </div>
          <div class="modal-footer">
            <a href="/myjob-pause/{{$myjob->id}}" class="btn btn-warning"> <i class="fa fa-circle-o"></i> Pause</a>
            <button type="submit"  name="submit-btn" id="submit-btn" class="btn btn-success pull-left">Submit</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>

    <script type="text/javascript">
    function check(e){
      var apply_limit = document.getElementById('apply_limit');
      if(e.value == 1){
        apply_limit.setAttribute('required', 'required');
      }else{
        apply_limit.removeAttribute('required');
      }
    }

    </script>
   
@endsection