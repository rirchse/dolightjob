@extends('dashboard')
@section('title', 'View All Available Jobs')
@section('content')
<?php
if(!empty($jobs)) {
  $myjobs = $jobs;
}
?>

<?php $ads = App\Ad::where('status', 1)->where('position', 'header')->get();?>
@if($ads)
<section class="content" style="min-height:0">
  <div class="row">
    <div class="col-xs-12">
      @foreach($ads as $ad)
      <div class="info-box" style="width:{{$ad->size}}%; display:inline-block;margin-right:15px">
      <img src="{{$ad->image}}" class="img-responsive">
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-info">
        <div class="box-header" style="border-bottom:1px solid #eee; padding-top:20px">
          <div class="col-sm-3">
          <h3 class="box-title" style="padding-top:5px;padding-bottom:15px">Find Jobs</h3>
          </div>
          <div class="col-sm-9 no-padding">
          {!! Form::open(['route' => 'findjob', 'method' => 'POST', 'files' => true]) !!}
          <div class="col-md-4">
            <div class="form-group">
                <select name="category" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
          </div>
          <div class="col-md-8">
            <div class="input-group input-group-sm">
              <input type="text" name="job_title" class="form-control" placeholder="Search by keywords" required>
              <span class="input-group-btn">
                <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </div>
          {!! Form::close() !!}
        </di box-infov>
      </div>
    </div>
    <div class="box-tools">
    </div>
            </div>
            <!-- /.box-header -->
            <style type="text/css">
            .tbl-row{width: 100%;background: #fff}
            .tbl-row{margin-top: 5px;border-bottom: 1px solid #eee}
            .tbl-row .tbl-cell{padding:10px;}
            .tbl-row .tbl-cell:last-child{width:100%;max-width: 20%;text-align: center;}
            @media(max-width: 600px){
            .tbl-cell-middle, .tbl-row .tbl-cell:last-child{float: left;}
            .tbl-cell-middle{width:100%;max-width:80%;}
            .tbl-row .tbl-cell:last-child{width:100%;max-width:20%;}
            .tbl-row .tbl-cell:first-child{width:100%;clear: bottom;display: inline-block;}
            }
            @media(min-width: 601px){
            .tbl-row .tbl-cell:first-child{width:100%;max-width: 60%}
            .tbl-row{display: table;}
            .tbl-row .tbl-cell{display: table-cell;padding:15px;}
            }
            </style>
        
            <div class="">
                <?php $x = 0; ?>
                @foreach($myjobs as $myjob)
                <?php $x++; 
                //task status: 0 = apply, 1 = submit, 2 = approve, 3 = cancel
                ?>
                @if(!App\Task::where('job_id', $myjob->id)->where('created_by', Auth::id())->first())
                <div class="tbl-row" onclick="GO(this)" link="/jobs/{{$myjob->id}}" style="cursor:pointer">
                  <div class="tbl-cell">
                    <b>{{$myjob->job_title}}</b><br>
                    {{App\User::find($myjob->created_by)?App\User::find($myjob->created_by)->name:''}}
                  </div>
                  <div class="tbl-cell tbl-cell-middle">
                    <?php
                    $task_count = DB::table('tasks')->where('job_id', $myjob->id)->whereNotIn('status', [3])->get();
                    ?>
                    {{$myjob->id?count($task_count):0}} Of {{$myjob->worker}}
                    <br>
                    <progress value="{{count($task_count)}}" max="{{$myjob->worker}}"></progress>
                  </div>
                  <div class="tbl-cell">${{$myjob->worker_earn}}</div>
                  <div class="clearfix"></div>
                </div>
                @endif
                @endforeach
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                {{$myjobs->links()}}
              </div>
            @if(count($myjobs) <= 0)
            <a href="/find_jobs">Result not found, view available job.</a>
            @endif
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->
    @endsection
@section('scripts')
  <script>
    // $(function () {
    //   $('#example1').DataTable()
    //   $('#example2').DataTable({
    //     'paging'      : true,
    //     'lengthChange': false,
    //     'searching'   : false,
    //     'ordering'    : true,
    //     'info'        : true,
    //     'autoWidth'   : false
    //   })
    // })
/* onclick got to the link */
function GO(elm)
{
  window.location = elm.getAttribute('link');
}
  </script>
@endsection