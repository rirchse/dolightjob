@extends('dashboard')
@section('title', 'Customer Details')
@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Customer Details</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Customers</a></li>
        <li class="active">Details</li>
      </ol>
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-7"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Customer Information</h4>
          </div>
          <div class="col-md-12 text-right toolbar-icon">
            <a href="{{route('customer.index')}}" title="View {{Session::get('_types')}} customers" class="label label-success"><i class="fa fa-list"></i></a>
            <a href="{{route('customer.edit',$customer->id)}}" class="label label-warning" title="Edit this customer"><i class="fa fa-edit"></i></a>
            {{-- <a href="#" title="Print" class="label label-info"><i class="fa fa-print"></i></a> --}}
            
            {{-- <a href="{{route('customer.delete',$customer->id)}}" class="label label-danger" onclick="return confirm('Are you sure want to delete this account!');" title="Delete this account"><i class="fa fa-close"></i></a> --}}
            
          </div>
          <div class="col-md-12">
            <table class="table">
              <tbody>
                <tr>
                  <th width=150>Full Name:</th>
                  <td>{{$customer->full_name}}</td>
                </tr>
                <tr>
                  <th>Email:</th>
                  <td>{{$customer->email}}</td>
                </tr>
                <tr>
                  <th>Contact:</th>
                  <td>{{$customer->contact}}</td>
                </tr>
                <tr>
                  <th>Care Of:</th>
                  <td>{{$customer->care_of}}</td>
                </tr>
                <tr>
                  <th>Phone:</th>
                  <td>{{$customer->phone}}</td>
                </tr>
                <tr>
                  <th>Date Of Barth:</th>
                  <td>{{$customer->dob}}</td>
                </tr>
                <tr>
                  <th>Gender:</th>
                  <td>{{$customer->gender}}</td>
                </tr>
                <tr>
                  <th>Profession:</th>
                  <td>{{$customer->job}}</td>
                </tr>
                <tr>
                  <th>Organization:</th>
                  <td>{{$customer->organization}}</td>
                </tr>
                <tr>
                  <th>Present Address:</th>
                  <td>{{$customer->present_address}}</td>
                </tr>
                <tr>
                  <th>Permanent Address:</th>
                  <td>{{$customer->permanent_address}}</td>
                </tr>
                <tr>
                  <th>Referral:</th>
                  <td>{{$customer->referral}}</td>
                </tr>
                <tr>
                  <th>Referral Contact:</th>
                  <td>{{$customer->referral_contact}}</td>
                </tr>
                <tr>
                  <th>Referral Address:</th>
                  <td>{{$customer->referral_address}}</td>
                </tr>
                <tr>
                  <th>Details:</th>
                  <td>{{$customer->details}}</td>
                </tr>
                <tr>
                  <th>Status:</th>
                  <td>
                    @if($customer->status == 0)
                    <span class="label label-warning">Unverified</span>
                    @elseif($customer->status == 1)
                    <span class="label label-success">Active</span>
                    @elseif($customer->status == 2)
                    <span class="label label-danger">Disabled</span>
                    @endif
                  </td>
                </tr>
                <tr>
                  <th>Created On:</th>
                  <td>{{date('d M Y h:i:s A',strtotime($customer->created_at) )}} </td>
                </tr>
                <tr>
                  <th>Updated On:</th>
                  <td>{{date('d M Y h:i:s A',strtotime($customer->updated_at) )}} </td>
                </tr>
                <tr>
                  <th>Created By:</th>
                  <td>{{App\User::find($customer->created_by)?App\User::find($customer->created_by)->name:'Unknown'}}</td>
                </tr>
                <tr>
                  <th>Updated By:</th>
                  <td>{{App\User::find($customer->updated_by)?App\User::find($customer->updated_by)->name:'Unknown'}}</td>
                </tr>
                <tr>
                  <th>Photo: </th>
                  <td><a href="/img/customer/{{$customer->image}}" target="_blank"><img src="/img/customer/{{$customer->image}}" width=60><br>View Large Photo</a></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="clearfix"></div>

          <p><a href="{{route('customer.delete',$customer->id)}}" onclick="return confirm('Are sure you want to permanently delete this customer?')" class="text-danger" style="padding:15px">x</a></p>
        </div>
      </div><!-- /.box -->
    </div><!--/.col (left) -->
  </section><!-- /.content -->
   
@endsection
