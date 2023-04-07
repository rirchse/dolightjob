@extends('dashboard')
@section('title', 'View Referrals')
@section('content')
    

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Referrals</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Referrals</a></li>
        {{-- <li><a href="#">Tables</a></li> --}}
        <li class="active">Referrals</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">


    <div class="box text-center">
      <h3>Your Referral ID: <br><a href="#">{{url('/')}}/{{Auth::id()}}/aff</a></h3><br>
    </div>

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Referrals</h3>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="example1" class="table table-bordered table-hover">
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Bonus ($)</th>
                  <th>Status</th>
                  <th>Join Date</th>
                  <th width="110">Action</th>
                </tr>

                @foreach($referrals as $refer)

                <tr>
                  <td>{{$refer->id}}</td>
                  <td>{{$refer->name}}</td>
                  <td>{{$refer->aff_bonus}}</td>
                  <td>
                    @if($refer->aff_bonus)
                    <span class="label label-success">Active</span>
                    @else
                    <span class="label label-warning">Pending</span>
                    @endif
                  </td>
                  <td>{{ date('d M Y', strtotime($refer->created_at))}}</td>
                  <td>
                    {{-- <a href="{{route('category.show',$refer->id)}}" class="label label-info" title="category Details"><i class="fa fa-file-text"></i></a>
                    <a href="{{route('category.edit',$refer->id)}}" class="label label-warning" title="Edit this category"><i class="fa fa-edit"></i></a> --}}
                    
                  </td>
                </tr>

                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
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