@extends('dashboard')
@section('title', 'View All Advertiesment')
@section('content')
    

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>View Advertiesments</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Advertiesment</a></li>
        <li class="active">Advertiesment</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Advertiesment</h3>
              <div class="box-tools">
                <a href="/ad/create" class="btn btn-info">Create</a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="example1" class="table table-bordered table-hover">
                <tr>
                  <th>ID</th>
                  <th>Title</th>
                  <th>Position</th>
                  <th>Size</th>
                  <th>URL</th>
                  <th>Status</th>
                  <th>Deteils</th>
                  <th>Created On</th>
                  <th width="110">Action</th>
                </tr>
                @foreach($ads as $ad)
                <tr>
                  <td>{{$ad->id}}</td>
                  <td>{{$ad->title}}</td>
                  <td>{{$ad->position}}</td>
                  <td>{{$ad->size}}</td>
                  <td>{{$ad->url}}</td>
                  <td>
                    @if($ad->status == 1)
                    <span class="label label-success">Active</span>
                    @elseif($ad->status == 0)
                    <span class="label label-warning">Inactive</span>
                    @elseif($ad->status == 3)
                    <span class="label label-danger">Disabled</span>
                    @endif
                  </td>
                  <td>{{$ad->details}}</td>

                  <td>{{ date('d M Y', strtotime($ad->created_at))}}</td>
                  <td>
                    <a href="{{route('ad.show',$ad->id)}}" class="label label-info" title="ad Details"><i class="fa fa-file-text"></i></a>
                    <a href="{{route('ad.edit', $ad->id)}}" class="label label-warning" title="Edit this ad"><i class="fa fa-edit"></i></a>
                  </td>
                </tr>

                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                {{-- {{$ads->links()}} --}}
              </div>
            </div>
          </div> <!-- /.box -->
        </div>
      </div>
    </section> <!-- /.content -->
@endsection