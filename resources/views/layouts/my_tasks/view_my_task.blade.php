@extends('dashboard')
@section('title', 'View All MyTask')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>View MyTask</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    {{-- <li><a href="#">Tables</a></li> --}}
    <li class="active">View MyTask</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">List of MyTask</h3>
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
                  <th>Cause of Uns:</th>
                  <th>Status</th>
                  <th width="110">Action</th>
                </tr>
                <?php $x = 0; ?>
                @foreach($tasks as $task)
                <?php $x++; ?>
                <tr onclick="window.location='/jobs/{{$task->job_id}}'" style="cursor:pointer">
                  <td>{{$x}}</td>
                  <td>{{$task->job_title}}</td>
                  <td>{{$task->cat_id?DB::table('categories')->find($task->cat_id)->name:''}}</td>
                  <td>{{$task->sub_cat_id?DB::table('subcategories')->find($task->sub_cat_id)->name:''}}</td>
                  <td>{{$task->worker_earn}}</td>
                  <td>{{ $task->estimated_day }}</td>
                  <td>{{ $task->comment }}</td>
                  <td>
                    @if($task->status == 0)
                    <span class="label label-warning">Working</span>
                    @elseif($task->status == 1)
                    <span class="label label-warning">Pending</span>
                    @elseif($task->status == 2)
                    <span class="label label-success">Satisfied</span>
                    @elseif($task->status == 3)
                    <span class="label label-danger">Un-Satisfied</span>
                    @endif
                  </td>
                  <td>
                    {{-- <a href="#" class="btn btn-danger btn-sm" title="Report">Report</a> --}}
                    @if($task->status == 0)
                    <a class="btn btn-success" href="/jobs/{{$task->job_id}}">Go to Submit</a>
                    @endif
                  </td>
                </tr>
                @endforeach
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