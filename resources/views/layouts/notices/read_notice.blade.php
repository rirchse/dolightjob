@extends('dashboard')
@section('title', 'Notice Details')
@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Notice Details</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Notices</a></li>
        <li class="active">Details</li>
      </ol>
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-6"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Notice Information</h4>
          </div>
          <div class="col-md-12 text-right toolbar-icon">
            <a href="{{route('notice.index')}}" title="View {{Session::get('_types')}} notices" class="label label-success"><i class="fa fa-list"></i></a>
            <a href="{{route('notice.edit',$notice->id)}}" class="label label-warning" title="Edit this notice"><i class="fa fa-edit"></i></a>
            {{-- <a href="#" title="Print" class="label label-info"><i class="fa fa-print"></i></a> --}}
            
            {{-- <a href="{{route('notice.delete',$notice->id)}}" class="label label-danger" onclick="return confirm('Are you sure want to delete this account!');" title="Delete this account"><i class="fa fa-close"></i></a> --}}
            
          </div>
          <div class="col-md-12">
            <table class="table">
                <tbody>
                  <tr>
                    <th width="150">Title:</th>
                    <td>{{$notice->title}}</td>
                  </tr>
                  <tr>
                    <th>Postion:</th>
                    <td>{{$notice->position}}</td>
                  </tr>
                  <tr>
                    <th>Details:</th>
                    <td>{{$notice->details}}</td>
                  </tr>
                   <tr>
                    <th>Status:</th>
                    <td>
                      @if($notice->status == 0)
                      <span class="label label-warning">Inactive</span>
                      @elseif($notice->status == 1)
                      <span class="label label-success">Active</span>
                      @elseif($notice->status == 2)
                      <span class="label label-danger">Disabled</span>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th>Record Created On:</th>
                    <td>{{date('d M Y h:i:s A',strtotime($notice->created_at) )}} </td>
                  </tr>
                  <tr>
                    <th>Record Updated On:</th>
                    <td>{{date('d M Y h:i:s A',strtotime($notice->updated_at) )}} </td>
                  </tr>
              </tbody>
            </table>
          </div>
          <div class="clearfix"></div>

          <p><a href="{{route('notice.destroy', $notice->id)}}" onclick="return confirm('Are sure you want to permanently delete this notice?')" class="text-danger" style="padding:15px">Permanently Remove?</a></p>
        </div>
      </div><!-- /.box -->
    </div><!--/.col (left) -->
  </section><!-- /.content -->
   
@endsection
