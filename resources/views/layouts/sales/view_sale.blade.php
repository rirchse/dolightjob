@extends('dashboard')
@section('title', 'View All Sale')
@section('content')
    <section class="content-header">
      <h1>View All Sales</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">All Sale</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Sale</h3>
              {{-- <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div> --}}
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="example1" class="table table-bordered table-hover">
                <tr>
                  <th>Id</th>
                  <th>Customer Name</th>                  
                  <th>Total</th>                  
                  <th>Sales Date</th>                  
                  <th>Sales Type</th>                  
                  <th>RN</th>                  
                  <th>RC</th>                  
                  <th>Sold By</th>                  
                  <th>Status</th>
                  <th>Created By</th>
                  <th>Created On</th>
                  <th width="110">Action</th>
                </tr>

                @foreach($sales as $sale)

                <tr>
                  <td>{{$sale->id}}</td>
                  <td>{{$sale->customer_id?App\Customer::find($sale->customer_id)->full_name:''}}</td>
                  <td>{{$sale->total}}</td>
                  <td>{{$sale->sales_date}}</td>
                  <td>{{$sale->sales_type}}</td>
                  <td>{{$sale->referral_name}}</td>
                  <td>{{$sale->referral_contact}}</td>
                  <td>{{$sale->sold_by}}</td>
                  <td>
                    @if($sale->status == 1)
                    <span class="label label-success">Active</span>
                    @elseif($sale->status == 0)
                    <span class="label label-warning">Unactive</span>
                    @elseif($sale->status == 3)
                    <span class="label label-danger">Deleted</span>
                    @endif
                  </td>
                  <td>{{$sale->created_by?App\User::find($sale->created_by)->name:''}}</td>

                  <td>{{ date('d M Y', strtotime($sale->created_at))}}</td>
                  <td>
                    <a href="{{route('sale.show',$sale->id)}}" class="label label-info" title="sale Details"><i class="fa fa-file-text"></i></a>
                    {{-- <a href="{{route('sale.edit',$sale->id)}}" class="label label-warning" title="Edit this sale"><i class="fa fa-edit"></i></a> --}}
                    {{-- <a href="{{route('get.payment',$sale->id)}}" class="label label-success" title="Payment this sale"><i class="fa fa-money"></i></a> --}}
                    {{-- @if($sale->status == 1)
                    <a href="/admin/sale_login/{{$sale->email}}" class="label label-success" title="Login to this account" target="_blank"><i class="fa fa-search-plus"></i></a>
                    @endif
                    @if($sale->status == 0)
                    <a href="/admin/resend_email_verification/{{$sale->id}}" class="label label-primary" onclick="return confirm('Are you sure you want to resend email verification to this sale?')" title="Resend verification email."><i class="fa fa-envelope-o"></i></a>
                    @endif
                    @if($sale->status == 3)
                    <a href="/admin/sale/{{$sale->id}}/restore" class="label label-success" title="Restore the account" onclick="return confirm('Are you sure you want to restore the account?')"><i class="fa fa-undo"></i></a>
                    @endif --}}
                  </td>
                </tr>

                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                {{-- {{$sales->links()}} --}}
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