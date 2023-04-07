@extends('dashboard')
@section('title', 'Job Details')
@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
      {{-- <h1>Job Details</h1> --}}
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Jobs</a></li>
        <li class="active">Details</li>
      </ol>    
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-7 no-padding">
        <div class="col-sm-6">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion ion-ios-people-outline"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Working</span>
              <span class="info-box-number">{{count(DB::table('tasks')->where('job_id', $job->id)->whereNotIn('status', [3])->get())}} <small> of</small> {{$job->worker}}</span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </div>
        <div class="col-sm-6">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-money"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">You Can Earn</span>
              <span class="info-box-number">${{$job->worker_earn}}</span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </div>
      </div>
      <div class="col-md-7"><!-- general form elements -->
        <div class="info-box">
          <div class="box-header with-border">
            <h4 class="box-title">{{$job->job_title}}</h4>
            <div class="box-tools">
            {{-- <a href="/find_jobs" title="View available jobs" class="label label-success"><i class="fa fa-list"></i></a> --}}
            </div>
          </div>
          <div class="col-md-12 text-right toolbar-icon">
          </div>
          <div class="col-md-12">
            <table class="" style="width:100%; font-size:16px;line-height:2">
              <tbody>
                <tr>
                  <td colspan=2><br>
                    <a target="_blank" href="{{$job->image}}">
                      <img class="img-responsive" src="{{$job->image}}" alt="No Attachement" style="border:1px solid #ddd">
                    </a>
                    <br>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="clearfix"></div>
        </div><!-- /.box -->
        <div class="info-box">
          <div class="box-header with-border"><b>What is expected from worker?</b></div>
          <div class="panel-body">{!!$job->description!!}</div>
        </div>
        <div class="info-box">
          <div class="box-header with-border"><b>Required Proof that task was finish.</b></div>
          <div class="panel-body">{!!$job->note!!}</div>
        </div>
          <button class="btn btn-danger" data-target="#report" data-toggle="modal">Report</button>
          <br><br>

        <div class="info-box" style="border:1px solid #ddd;min-height:50px">
          <div class="box-header text-center">
            @if(!$task && $job->created_by != Auth::id())
            <a href="/job_apply/{{$job->id}}" title="Apply to the job" class="btn btn-success btn-lg"><i class="fa fa-check"> </i> Apply</a>
            @elseif($job->created_by == Auth::id())
            <h3><a class="btn btn-info" href="#job-owner">This is your job</a></h3>
            @elseif($task->status == 0)
            <h3 class="text-success">You already applied to this job<br>Please Submit Prove OR, <a href="/myjob/cancel/{{$task?$task->id:''}}" class="btn-danger btn-sm">Cancel</a></h3>
            @elseif($task->status == 1)
            <h3 class="text-success">The Job is Under Reviewing</h3>
            @elseif($task->status == 2)
            <h3 class="text-success">The Job is Satisfied</h3>
            @elseif($task->status == 3)
            <h3 class="text-danger">The Job is Unsatisfied</h3>
            @endif
          </div>          
        </div>

      @if($task && $task->status == 0)

      {{-- <div class="col-md-12"> --}}
        {!! Form::model($task, ['route' => ['task.submit', $task?$task->id:''], 'method' => 'PUT', 'files' => true]) !!}
        {{Form::hidden('job_id', $job->id)}}

        <div class="box">
          <div class="row">
          <div class="col-sm-12">
          <div class="panel panel-default">
            <div class="panel-heading"><b>Submit Required Work Proof.</b></div>
            <div class="panel-body">
              {{-- <b>Required Proof that task was finish:</b><br> --}}
              {!!$job->note!!}
            </div>
            <div class="panel-body">
              <div class="form-group">
                <textarea name="required_proof" id="" rows="5" class="form-control textarea" required placeholder="Answer client required information"></textarea>
              </div>
              <div class="form-group">
                <label for="" class="form-label">#1 Upload Screenshot Prove.</label>
                <input type="file" class="form-control" name="screenshot" required id="image"><br>
                <img id="preview" width=250>
              </div>
              @if($job->screenshot == 2)
              <div class="form-group">
                <label for="" class="form-label">#2 Upload Screenshot Prove.</label>
                <input type="file" class="form-control" name="screenshot_2" required id="screenshot_2"><br>
                <img id="preview_2" width=250>
              </div>
              @endif
            </div>
          </div>
          </div>
          </div>
          <div class="box-footer">
            <button type="submt" class="btn btn-success btn-md pull-right">Submit Prove</button>
          </div>
        </div>
        {!! Form::close() !!}
      @endif

      <div class="info-box">
        <table class="table">
          <tr>
            <td colspan=2 style="color:green">Job ID: <b>#{{$job->id}}</b></td>
          </tr>
          <tr>
            <td>
              <i class="fa fa-pie-chart"></i> Category: <b>{{App\Category::find($job->cat_id)?App\Category::find($job->cat_id)->name:''}}</b><br>
              <i class="fa fa-pie-chart"></i> Sub Category: <b>{{$job->sub_cat_id?DB::table('subcategories')->find($job->sub_cat_id)->name:''}}</b><br>
            </td>
            <td>
              <i class="fa fa-clock-o"></i> Time: <b>{{6}}</b> Days<br>
              <i class="fa fa-redo"></i> Last Updated: <b>{{$job->updated_at}}</b><br>
            </td>
          </tr>               
           <tr>
            <td>
              Job Status: 
              @if($job->status == 0)
              <span class="label label-warning">Pending</span>
              @elseif($job->status == 1)
              <span class="label label-success">Active</span>
              @elseif($job->status == 2)
              <span class="label label-primary">Completed</span>
              @elseif($job->status == 5)
              <span class="label label-primary">Paused</span>
              @endif
            </td>
            <td>
              <p style="color:green">Job Posted  By: <b>{{App\User::find($job->created_by)?App\User::find($job->created_by)->name:''}}</b></p>
            </td>
          </tr>
        </table>
      </div>

      </div><!--/.col (left) -->
      <?php $user = App\User::find($job->created_by); ?>
      <div class="col-sm-4">
        <div class="info-box" id="job-owner">
            <div class="box-header">
              <img class="img-responsive" src="{{$user->image}}" style="max-width:150px; margin:auto">
            </div>
            <div class="box-body" style="text-align:center;border-top:1px solid #eee">
              <h4> <a href="/user_review/{{$user->id}}"><i class="fa fa-circle text-aqua"></i> {{$user->name}}</a></h4>
              <p>User ID: #{{$user->id}}</p>
              <p>Skill: {{$user->skill}}</p>
              <p class="text-orange">
                Reviews 
                @for($x = 0; $x < 5; $x++)
                <i class="fa fa-star"></i>
                @endfor
              </p>
              <p>Since {{date('d M Y', strtotime($user->created_at))}}</p>
            </div>
        </div>
      </div>

    </div> <!--/.row -->
  </section><!-- /.content -->

  {!! Form::open(['route' => 'report.store', 'method' => 'POST']) !!}
  <div class="modal fade" id="report">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
          <h4>Report</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <textarea name="report" id="" rows="3" class="form-control" placeholder="Type here: What you want to report?" required></textarea>
            <input type="hidden" name="job_id" value="{{$job->id}}">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Submit</button>
        </div>
      </div>
    </div>
  </div>
  {!! Form::close() !!}
@endsection
@section('scripts')
   <script type="text/javascript">
   //codes for text editor
    // $(function(){$('.textarea').wysihtml5()});
   </script>

   <script type="text/javascript">
  //onupload image preview
  screenshot_2.onchange = evt => {
    const [file] = screenshot_2.files
    if (file) {
      preview_2.src = URL.createObjectURL(file)
    }
  }
  </script>
@endsection
