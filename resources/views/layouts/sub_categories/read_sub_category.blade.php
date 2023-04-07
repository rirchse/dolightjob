@extends('dashboard')
@section('title', 'User Details')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>Sub-Category Details</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Sub-Categories</a></li>
    <li class="active">Details</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row"><!-- left column -->
    <div class="col-md-6"><!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h4 class="box-title">Sub-Category Information</h4>
        </div>
        <div class="col-sm-12 text-right toolbar-icon">
          <a href="{{route('sub_category.create')}}" class="label label-info"><i class="fa fa-plus"></i></a>
          <a href="{{route('sub_category.index')}}" title="View {{Session::get('_types')}} sub_categorys" class="label label-success"><i class="fa fa-list"></i></a>
          <a href="{{route('sub_category.edit',$sub_category->id)}}" class="label label-warning" title="Edit this sub_category"><i class="fa fa-edit"></i></a>
          {{-- <a href="{{route('sub_category.delete',$sub_category->id)}}" class="label label-danger" onclick="return confirm('Are you sure want to delete this account!');" title="Delete this account"><i class="fa fa-close"></i></a>             --}}
        </div>
        <div class="col-md-12">
          <table class="table">
            <tbody>
              <tr>
                <th>Name:</th>
                <td>{{$sub_category->name}}</td>
              </tr>
              <tr>
                <th>Min. Budget ($):</th>
                <td>{{$sub_category->budget}}</td>
              </tr>
              <tr>
                <th>Parent Name:</th>
                <td>{{$sub_category->parent_id?App\Category::find($sub_category->parent_id)->name:''}}</td>
                  </td>
              </tr>
              <tr>
                <th>Details:</th>
                <td>{{$sub_category->details}}</td>
              </tr>
              <tr>
                <th>Status:</th>
                <td>
                  @if($sub_category->status == 0)
                  <span class="label label-warning">Inactive</span>
                  @elseif($sub_category->status == 1)
                  <span class="label label-success">Active</span>
                  @elseif($sub_category->status == 2)
                  <span class="label label-danger">Disabled</span>
                  @endif
                </td>
              </tr>
              <tr>
                <th>Record Created On:</th>
                <td>{{date('d M Y h:i:s A',strtotime($sub_category->created_at) )}} </td>
              </tr>
              <tr>
                <th>Record Updated On:</th>
                <td>{{date('d M Y h:i:s A',strtotime($sub_category->updated_at) )}} </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="clearfix"></div>
        @if(Auth::user()->authorizeRoles(['SuperAdmin']))
        <p><a href="{{route('sub_category.delete',$sub_category->id)}}" onclick="return confirm('Are sure you want to permanently delete this category?')" class="text-danger" style="padding:15px">Permanently Remove?</a></p>
        @endif
      </div>
    </div><!-- /.box -->
  </div><!--/.col (left) -->
</section><!-- /.content -->

@endsection
