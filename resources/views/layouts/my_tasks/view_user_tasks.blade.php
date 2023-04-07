@extends('dashboard')
@section('title', 'View All Task')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>View Tasks</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    {{-- <li><a href="#">Tables</a></li> --}}
    <li class="active">View Tasks</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-sm-9">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">List of Tasks</h3>
              <div class="box-tools">
                {{-- <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">
                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div> --}}
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="example1" class="table table-bordered table-hover">
                <tr>
                  <th>#</th>
                  <th>Job Title</th>
                  <th>Category</th>
                  <th>Sub-Category</th>
                  <th>Earning ($)</th>
                  <th>Estimated Day</th>
                  <th>Status</th>
                  <th width="110">Action</th>
                </tr>
                <?php $x = 0; $earning = 0; ?>
                @foreach($tasks as $task)
                <?php $x++; ?>
                <tr>
                  <td>{{$x}}</td>
                  <td>{{$task->job_title}}</td>
                  <td>{{$task->cat_id?DB::table('categories')->find($task->cat_id)->name:''}}</td>
                  <td>{{$task->sub_cat_id?DB::table('subcategories')->find($task->sub_cat_id)->name:''}}</td>
                  <td>{{$task->worker_earn}}</td>
                  <td>{{ $task->estimated_day }}</td>
                  <td>
                    @if($task->status == 1)
                    <span class="label label-warning">Pending</span>
                    @elseif($task->status == 0)
                    <span class="label label-primary">Working</span>
                    @elseif($task->status == 2)
                    <span class="label label-success">Completed</span>
                    @endif
                  </td>
                  <td>
                    {{-- <a href="#" class="label label-info" title="myjob Details"><i class="fa fa-file-text"></i></a> --}}
                    @if($task->status == 0)
                    <a href="/myjob/cancel/{{$task->id}}" class="label label-danger" title="Cancel This Job"><i class="fa fa-close"></i></a>
                    @endif
                    <a href="/jobs/{{$task->job_id}}" class="label label-success" title="Submit This Job"><i class="fa fa-refresh"></i> </a>
                  </td>
                </tr>
                <?php 
                if($task->status == 2){
                  $earning += $task->earning;
                  } ?>
                @endforeach
                {{-- <tr>
                  <th colspan=3></td>
                    <td><span class="label label-success">${{$earning}}</span></th>
                </tr> --}}
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                {{$tasks->links()}}
              </div>
            </div>
          </div>
          <!-- /.box -->
        </div>
        <div class="col-sm-3">
          <div class="box">
            <div class="box-header">
              <img class="img-responsive" src="{{$user->image}}" style="border-radius:50%; max-width:150px; margin:auto">
            </div>
            <div class="box-body" style="text-align:center;border-top:1px solid #eee">
              <h4>{{$user->name}}</h4>
              <p>{{$user->contact}}<br>{{$user->email}}</p>
              <p> <a href="/user/{{$user->id}}" class="btn btn-info">Read More...</a> </p>
            </div>
          </div>
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