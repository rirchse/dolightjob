@extends('print')
@section('title', 'sale print')
@section('content')

  <?php 
  if($sale->customer_id){
    $customer = App\Customer::find($sale->customer_id);
  }
  ?>

<div class="col-md-12 text-right toolbar-icon">
  <a href="#" title="Print" class="label label-info" onclick="document.title = '{{$customer->name}}'; window.print();"><i class="fa fa-print"></i></a>
</div>
<div id="table" style="max-width:8.5in;margin:0 auto;border:1px solid #ddd;padding: 25px">
    <img src="/img/banner-print.jpg" class="img-responsive">
  <div class="head">
      {{-- <table class="table no-border">
        <tr>
          <td>
            <img src="{{ asset('img/logo.png') }}" alt="" style="width: 200px;">
          </td>
          <td>
            <h4>Abdul Hamid Super Market<br>Nazirpur Bazar, Gurudaspur, Natore<br>Mobile: 01740969201</h4>
          </td>
          <td>
            <br>
            <small>
            <b>Sales Date:</b> {{$sale->sales_date?date('d M Y h:i:s A',strtotime($sale->sales_date) ):''}}<br>
            <b>Sales Type:</b> {{ $sale->sales_type}}
            </small>
          </td>
        </tr>
      </table> --}}
  </div>
  <div class="col-md-12">
    <table class="table">
      <tbody>
              <tr>
                <th>Customer Name:</th>
                <td>{{$customer->full_name?$customer->full_name:''}}</td>
                <th>Customer Mobile:</th>
                <td>{{$customer->contact?$customer->contact:''}}</td>
              </tr>
              <tr>
                <th>Customer Address:</th>
                <td colspan=3>{{$customer->permanent_address}}</td>
              </tr>
              <tr>
                <th>Referral Information:</th>
                <td colspan=3><b>Name:</b> {{$sale->referral_name}}, <b>Mobile:</b> {{$sale->referral_contact}}, <b>Address:</b> {{$sale->referral_address}}</td>
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
          <th width=130>Total Price</th>
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
</div>

<script type="text/javascript">
    function printDiv() {
    var divToPrint = document.getElementById('table');
    var htmlToPrint = '' +
        '<style type="text/css">' +
        '.pageheader{font-size:12px}'+
        'table { border-collapse:collapse; font-size:11px}' +
        'table th, table td { border:1px solid #666; padding: 5px;}' +
        '</style>';
    htmlToPrint += divToPrint.outerHTML;
    newWin = window.open("");
    newWin.document.write(htmlToPrint);
    newWin.print();
    newWin.close();
}
</script>
@endsection
