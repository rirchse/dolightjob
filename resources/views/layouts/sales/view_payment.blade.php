@extends('dashboard')
@section('title', 'View All Payment')
@section('content')
    {{-- {{dd($sale)}} --}}

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>All Payment</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        {{-- <li><a href="#">Tables</a></li> --}}
        <li class="active">All Payment</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Payment</h3>
              
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table id="example1" class="table table-bordered table-hover">
                <tr>
                  <th>Id</th>
                  <th>Product Name</th>
                  <th>Customer Name</th>
                  <th>Paid Amount</th>                  
                  <th>Payment Date</th>                  
                  <th>Status</th>
                  <th>Created On</th>
                  <th width="110">Action</th>
                </tr>

                @foreach($payments as $payment)
                @if($sale->id == $payment->sales_id)

                <tr>
                  <td>{{$payment->id}}</td>
                  <td>{{$payment->sales_id=$sale->name}}</td>
                  <td>{{$payment->sales_id=$sale->first_name.' '.$sale->last_name}}</td>
                  <td>{{$payment->paid_amount}}</td>
                  <td>{{$payment->payment_date}}</td>
                  <td>
                    @if($payment->status == 1)
                    <span class="label label-success">Active</span>
                    @elseif($payment->status == 0)
                    <span class="label label-warning">Unactive</span>
                    @elseif($payment->status == 3)
                    <span class="label label-danger">Deleted</span>
                    @endif
                  </td>
                  <td>{{ date('d M Y', strtotime($payment->created_at))}}</td>
                  <td>
                    <a href="{{route('show.payment',$payment->id)}}" class="label label-info" title="payment Details"><i class="fa fa-file-text"></i></a>
                    <a href="{{route('payment.edit',$payment->id)}}" class="label label-warning" title="Edit this payment"><i class="fa fa-edit"></i></a>
                    
                  </td>
                </tr>
                
                @endif

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
