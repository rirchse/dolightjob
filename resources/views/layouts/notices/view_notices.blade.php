@extends('dashboard')
@section('title', 'View Notices')
@section('content')
    

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>View Notices</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Notice</a></li>
        <li class="active">Notice</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Notice</h3>
              <div class="box-tools">
                <a href="/notice/create" class="btn btn-info">Create</a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="example1" class="table table-bordered table-hover">
                <tr>
                  <th>ID</th>
                  <th>Title</th>
                  <th>Details</th>
                  <th>Position</th>
                  <th>Status</th>
                  <th>Created On</th>
                  <th width="110">Action</th>
                </tr>
                @foreach($notices as $notice)
                <tr>
                  <td>{{$notice->id}}</td>
                  <td>{{$notice->title}}</td>
                  <td>{!!$notice->details!!}</td>
                  <td>{{$notice->postion}}</td>
                  <td>
                    @if($notice->status == 1)
                    <span class="label label-success">Active</span>
                    @elseif($notice->status == 0)
                    <span class="label label-warning">Inactive</span>
                    @elseif($notice->status == 3)
                    <span class="label label-danger">Disabled</span>
                    @endif
                  </td>
                  <td>{{ date('d M Y', strtotime($notice->created_at))}}</td>
                  <td>
                    <a href="/notice/{{$notice->id}}" class="label label-info" title="ad Details"><i class="fa fa-file-text"></i></a>
                    <a href="/notice/{{$notice->id}}/edit" class="label label-warning" title="Edit this ad"><i class="fa fa-edit"></i></a>
                    {!!Form::model($notice, ['route' => ['notice.destroy', $notice->id], 'method' => 'DELETE'])!!}
                    {{-- <input type="submit" value="Del"> --}}
                    <button type="submit" class="btn btn-danger" onclick="return conofirm('Are you sure you want to delete this?');"><i class="fa fa-trash"></i></button>
                    {!!Form::close()!!}                    
                  </td>
                </tr>

                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                {{$notices->links()}}
              </div>
            </div>
          </div> <!-- /.box -->
        </div>
      </div>
    </section> <!-- /.content -->
@endsection