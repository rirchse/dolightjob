@extends('dashboard')
@section('title', 'ad Details')
@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>ad Details</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> ads</a></li>
        <li class="active">Details</li>
      </ol>
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-6"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">ad Information</h4>
          </div>
          <div class="col-md-12 text-right toolbar-icon">
            <a href="{{route('ad.index')}}" title="View {{Session::get('_types')}} ads" class="label label-success"><i class="fa fa-list"></i></a>
            <a href="{{route('ad.edit',$ad->id)}}" class="label label-warning" title="Edit this ad"><i class="fa fa-edit"></i></a>
            
          </div>
          <div class="col-md-12">
            <table class="table">
                <tbody>
                  <tr>
                    <th width="150">Title:</th>
                    <td>{{$ad->title}}</td>
                  </tr>
                  <tr>
                    <th>Position:</th>
                    <td>{{$ad->position}}</td>
                  </tr>
                  <tr>
                    <th>URL:</th>
                    <td>{{$ad->url}}</td>
                  </tr>
                  <tr>
                    <th>Image:</th>
                    <td>{{$ad->image}}</td>
                  </tr>
                  <tr>
                    <th>Details:</th>
                    <td>{{$ad->details}}</td>
                  </tr>              
                
                   <tr>
                    <th>Status:</th>
                    <td>
                      @if($ad->status == 0)
                      <span class="label label-warning">Inactive</span>
                      @elseif($ad->status == 1)
                      <span class="label label-success">Active</span>
                      @elseif($ad->status == 2)
                      <span class="label label-danger">Disabled</span>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th>Record Created On:</th>
                    <td>{{date('d M Y h:i:s A',strtotime($ad->created_at) )}} </td>
                  </tr>
                  <tr>
                    <th>Record Updated On:</th>
                    <td>{{date('d M Y h:i:s A',strtotime($ad->updated_at) )}} </td>
                  </tr>
              </tbody>
            </table>
          </div>
          <div class="clearfix"></div>

          <p><a href="{{route('ad.destroy',$ad->id)}}" onclick="return confirm('Are sure you want to permanently delete this ad?')" class="text-danger" style="padding:15px">Permanently Remove?</a></p>
        </div>
      </div><!-- /.box -->
    </div><!--/.col (left) -->
  </section><!-- /.content -->
   
@endsection
