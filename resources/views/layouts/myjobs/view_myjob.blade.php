@extends('dashboard')
@section('title', 'View MyJob')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>View MyJob</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    {{-- <li><a href="#">Tables</a></li> --}}
    <li class="active">View MyJob</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">List of MyJob</h3>
              <div class="box-tools">
                {!! Form::open(['route'=> 'myjob.search', 'method' => 'POST']) !!}
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="myjob_name" class="form-control pull-right" placeholder="My Job ID, Job Title" required>

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
                {!!Form::close()!!}
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="example1" class="table table-bordered table-hover">
                <tr>
                  <th>Job ID</th>
                  @if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin']))
                  <th>Posted By</th>
                  @endif
                  <th>Job Title</th>
                  <th>Category</th>
                  <th>Progress</th>
                  <th>Each Earn ($)</th>
                  <th>Total Cost ($)</th>
                  <th>Estimated Day</th>
                  <th>Status</th>
                  <th width="100">Action</th>
                </tr>
                <?php $x = 0; ?>
                @foreach($myjobs as $job)
                <?php $x++; ?>
                <tr onclick="window.location.href='/myjob/{{$job->id}}'" style="cursor:pointer">
                  <td>{{$job->id}}</td>
                  @if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin']))
                  <td><?php $user = App\User::find($job->created_by); ?>
                    {{$user?$user->name:''}}</td>
                  @endif
                  <td>{{$job->job_title}}</td>
                  <td>
                    <?php
                    $category = App\Category::find($job->cat_id);
                    ?>
                    {{$category?$category->name:''}}
                  </td>
                  <td>{{count(App\Task::where('job_id', $job->id)->whereIn('status', [0,1,2])->get())}} of {{$job->worker}}</td>
                  <td>${{$job->worker_earn}}</td>
                  <td>${{$job->total_cost}}</td>
                  <td>{{ $job->estimated_day}}</td>
                  <td>
                    @if($job->status == 0)
                    <span class="label label-warning">Pending</span>
                    @elseif($job->status == 1)
                    <span class="label label-success">Active</span>
                    @elseif($job->status == 2)
                    <span class="label label-danger">Disapproved</span>
                    @elseif($job->status == 3)
                    <span class="label label-info">Completed</span>
                    @elseif($job->status == 4)
                    <span class="label label-primary">Pause</span>
                    @elseif($job->status == 5)
                    <span class="label label-primary">Auto Pause</span>
                    @endif
                  </td>
                  <td>
                    <a href="{{route('myjob.show',$job->id)}}" class="btn btn-info" title="myjob Details">Details</a>
                    @if($job->status != 3)
                    {{-- <a href="{{route('myjob.edit',$job->id)}}" class="label label-warning" title="Edit this job"><i class="fa fa-edit"></i></a> --}}
                    @endif
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                {{$myjobs->links()}}
              </div>
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->
    @endsection
{{-- @section('scripts')
  <script>
    $(function () {
      $('#example1').DataTable()
      $('#example2').DataTable({
        'paging'      : true,
        'lengthChange': false,
        'searching'   : false,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false
      })
    })
  </script>
@endsection --}}