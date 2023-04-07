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
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="example1" class="table table-bordered table-hover">
                <tr>
                  <th>#ID</th>
                  <th>Job Title</th>
                  <th>Category</th>
                  <th>Sub-Category</th>
                  <th>Worker Needed</th>
                  <th>Each Worker Earn ($)</th>
                  <th>Total Cost ($)</th>
                  <th>Estimated Day</th>
                  <th>Status</th>
                  <th width="150">Action</th>
                </tr>
                <?php $x = 0; ?>
                @foreach($myjobs as $myjob)
                <?php $x++; ?>
                <tr>
                  <td>{{$myjob->id}}</td>
                  <td>{{$myjob->job_title}}</td>
                  <td>
                    <?php
                    $category = DB::table('categories')->find($myjob->cat_id);
                    ?>
                    {{$category?$category->name:''}}
                  </td>
                  <td>
                    <?php
                    $subcat = DB::table('subcategories')->find($myjob->sub_cat_id);
                    ?>
                    {{$subcat?$subcat->name:''}}
                  </td>
                  <td>{{$myjob->worker}}</td>
                  <td>{{$myjob->worker_earn}}</td>
                  <td>{{$myjob->total_cost}}</td>
                  <td>{{ $myjob->estimated_day}}</td>
                  <td>
                    @if($myjob->status == 0)
                    <span class="label label-warning">Pending</span>
                    @elseif($myjob->status == 1)
                    <span class="label label-success">Active</span>
                    @elseif($myjob->status == 2)
                    <span class="label label-danger">Disapproved</span>
                    @elseif($myjob->status == 3)
                    <span class="label label-info">Completed</span>
                    @elseif($myjob->status == 4)
                    <span class="label label-primary">Pause</span>
                    @elseif($myjob->status == 5)
                    <span class="label label-primary">Auto Pause</span>
                    @endif
                  </td>
                  <td>
                    <a href="{{route('myjob.show',$myjob->id)}}" class="label label-info" title="myjob Details"><i class="fa fa-file-text"></i></a>
                    @if($myjob->status != 3)
                    <a href="{{route('myjob.edit',$myjob->id)}}" class="label label-warning" title="Edit this product"><i class="fa fa-edit"></i></a>
                    @endif
                    <a href="/myjob/{{$myjob->id}}/prove" class="label label-success" title="Proves"><i class="fa fa-go"></i> Proves</a>
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