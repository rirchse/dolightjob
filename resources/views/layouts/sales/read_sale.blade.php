@extends('dashboard')
@section('title', 'Sale Details')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>Sale Details</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Sales</a></li>
    <li class="active">Details</li>
  </ol>    
</section>

<!-- Main content -->
<section class="content">
  <div class="row"><!-- left column -->
    <div class="col-md-9"><!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
        </div>
        <div class="col-md-12 text-right toolbar-icon">
          <a href="{{route('sale.index')}}" title="View {{Session::get('_types')}} sales" class="label label-success"><i class="fa fa-list"></i></a>
          {{-- <a href="{{route('sale.edit',$sale->id)}}" class="label label-warning" title="Edit this sale"><i class="fa fa-edit"></i></a> --}}
          {{-- <a href="{{route('index.payment',$sale->id)}}" title="Print" class="label label-success"><i class="fa fa-money"></i></a> --}}
          <a href="/sale/{{$sale->id}}/print" title="Print" class="label label-info"><i class="fa fa-print"></i></a>
          
          {{-- <a href="{{route('sale.delete',$sale->id)}}" class="label label-danger" onclick="return confirm('Are you sure want to delete this account!');" title="Delete this account"><i class="fa fa-close"></i></a> --}}
        </div>
        <div class="col-md-12">
          <table class="table">
            <tbody>
              <?php 
              if($sale->customer_id){
                $customer = App\Customer::find($sale->customer_id);
              }
              ?>
              <tr>
                <th>Customer Name:</th>
                <td>{{$customer->full_name?$customer->full_name:''}}</td>
              </tr>
              <tr>
                <th>Customer Mobile:</th>
                <td>{{$customer->contact?$customer->contact:''}}</td>
              </tr>
              <tr>
                <th>Sales Date:</th>
                <td>{{$sale->sales_date?date('d M Y h:i:s A',strtotime($sale->sales_date) ):''}} </td>
              </tr>
              <tr>
                <th>Sales Type:</th>
                <td>{{$sale->sales_type}}</td>
              </tr>
              <tr>
                <th>Referral Name:</th>
                <td>{{$sale->referral_name}}</td>
              </tr>
              <tr>
                <th>Referral Contact:</th>
                <td>{{$sale->referral_contact}}</td>
              </tr>
              <tr>
                <th>Referral Address:</th>
                <td>{{$sale->referral_address}}</td>
              </tr>                 
              <tr>
                <th>Deteils:</th>
                <td>{{$sale->details}}</td>
              </tr>
              <tr>
                <th>Status:</th>
                <td>
                  @if($sale->status == 0)
                  <span class="label label-warning">Unactive</span>
                  @elseif($sale->status == 1)
                  <span class="label label-success">Active</span>
                  @elseif($sale->status == 2)
                  <span class="label label-danger">Disabled</span>
                  @endif
                </td>
              </tr>
              <tr>
                <th>Record Created On:</th>
                <td>{{date('d M Y h:i:s A',strtotime($sale->created_at) )}} </td>
              </tr>                 
            </tbody>
          </table>
          <table class="table">
            <h4 class="text-center">Ordered Items</h4>
            <tr>
              <th>#</th>
              <th>Product Name</th>
              <th>Price</th>
              <th>Qty</th>
              <th>Total Price</th>
            </tr>
            @foreach(App\OrderItem::where('sales_id', $sale->id)->get() as $key => $item)
            <tr>
              <td>{{$key+1}}</td>
              <td>{{$item->name}}</td>
              <td>{{$item->price}}</td>
              <td>{{$item->qty}}</td>
              <td>{{$item->total}}</td>
            </tr>
            @endforeach
            <tr>
              <th colspan=4></th><th>Paid = {{$sale->paid}}</th>
            </tr>
            <tr>
              <th colspan=4></th><th>Due = {{$sale->due}}</th>
            </tr>
            <tr>
              <th colspan=4></th><th>Total = {{$sale->total}}</th>
            </tr>
          </table>
        </div>
        <div class="clearfix"></div>
        <p><a href="{{route('sale.delete',$sale->id)}}" onclick="return confirm('Are sure you want to permanently delete this Sale?')" class="text-danger" style="padding:15px">Permanently Remove?</a></p>
      </div>
    </div><!-- /.box -->
  </div><!--/.col (left) -->
</section><!-- /.content -->

@endsection
