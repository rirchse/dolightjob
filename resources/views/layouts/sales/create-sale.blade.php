@extends('dashboard')
@section('title', 'Place an Order')
@section('content')
<section class="content-header">
  <h1>Place an Order</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Orders</a></li>
    <li class="active">Place an Order</li>
</ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
            <h3 style="color: #800" class="box-title">Sale Information</h3>
        </div>
          {!! Form::open(['route' => 'sale.store', 'method' => 'POST', 'files' => true]) !!}
          <div class="box-body">

            <div class="panel panel-default">
                <h4 align="center">Selling Products</h4>
                <div class="panel-heading">
                    {{ Form::label('product', 'Product [Add To Sale]:', ['class' => 'control-label']) }}
                    <select id="item" name="product" class="form-control" required>
                        <option value="">Select an Product</option>
                        @foreach($items as $item)
                        <option value="{{$item->id}}" price="{{$item->selling_price}}">{{$item->product_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="items" class="table table-bordered table-stripped">
                            <tr>
                                <th>Product Description</th>
                                <th width=120>Unit Price ($)</th>
                                <th width=70>Quantity</th>
                                <th width=120>Total ($)</th>
                                <th width=60>Action</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>


            <div class="clearfix"></div>
            <div class="col-md-8">
                <div class="form-group">
                    {{ Form::label('shipping_address', 'Shipping Address:', ['class' => 'control-label']) }}
                    {{ Form::textarea('shipping_address', null, ['class' => 'form-control', 'rows' => 2])}}
                </div>
                <div class="form-group">
                    {{ Form::label('details', 'Note:', ['class' => 'control-label']) }}
                    {!! Form::textarea('details', null, ['class'=>'form-control', 'rows' => 2]) !!}
                </div>

                <style type="text/css">
                    .ul-status{width: 100%;padding-left: 0}
                    .ul-status li{display: inline-block; padding-right: 20px}
                </style>

                <div class="form-group">
                    {{ Form::label('status', 'Status: ', ['class' => 'control-label']) }}
                    <ul class="ul-status">
                        <li class="radio">
                            <label class="text-primary"><input type="radio" name="status" value="0">New Order</label>
                        </li>
                        <li class="radio">
                            <label class="text-warning"><input type="radio" name="status" value="1">Confirmed</label>
                        </li>
                        <li class="radio">
                            <label class="text-success"><input type="radio" name="status" value="2">Completed</label>
                        </li>
                        <li class="radio">
                            <label class="text-danger"><input type="radio" name="status" value="3">Cancelled</label>
                        </li>
                        <div class="clearfix"></div>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <table class="table table-bordered table-stripped text-right calc-table">
                        <tr>
                            <td>Sub-Total ($): </td>
                            <th>
                                {{ Form::text('sub_total', 0, ['class'=>'form-control', 'id' => 'sub_total', 'style' => 'max-width:100px']) }}
                            </th>
                        </tr>
                        <tr>
                            <td>Discount ($): </td>
                            <th>
                                {{ Form::text('discount', 0, ['class'=>'form-control', 'id' => 'discount', 'style' => 'max-width:100px']) }}
                            </th>
                        </tr>
                        <tr>
                            <td>Shipping ($): </td>
                            <th>
                                {{ Form::text('shipping', 0, ['class'=>'form-control', 'id' => 'shipping', 'style' => 'max-width:100px']) }}
                            </th>
                        </tr>
                        <tr>
                            <td>Grand Total ($): </td>
                            <th>
                                {{ Form::text('gtotal', 0, ['class'=>'form-control', 'id' => 'gtotal', 'style' => 'max-width:100px']) }}
                            </th>
                        </tr>
                        <tr>
                            <td>Paid ($): </td>
                            <th>
                                {{ Form::text('paid', 0, ['class'=>'form-control', 'id' => 'paid', 'style' => 'max-width:100px']) }}
                            </th>
                        </tr>
                        <tr>
                            <td>Due ($): </td>
                            <th>
                                {{ Form::text('due', 0, ['class'=>'form-control', 'id' => 'due', 'style' => 'max-width:100px']) }}
                            </th>
                        </tr>
                    </table>
                </div>
                <div class="clearfix"></div>


            <div class="box-header with-border">
                <h3 style="color: #800" class="box-title">Customer Information</h3>
            </div><br>


            <div class="col-md-6">
                <div class="col-md-6" style="padding-left:0">
                    <div class="form-group">
                        {{ Form::label('customer_name', 'Customer Name:', ['class' => 'control-label']) }}
                        {{ Form::text('customer_name', null, ['class' => 'form-control'])}}
                    </div>
                </div>
                <div class="col-md-6" style="padding-right:0">
                    <div class="form-group">
                        {{ Form::label('contact', 'Contact Number:', ['class' => 'control-label']) }}
                        {{ Form::text('contact', null, ['class' => 'form-control'])}}
                    </div>
                </div>
                <div class="col-md-6" style="padding-left:0">
                    <div class="form-group">
                        {{ Form::label('emali', 'Email Address:', ['class' => 'control-label']) }}
                        {{ Form::email('emali', null, ['class' => 'form-control'])}}
                    </div>
                </div>
                <div class="col-md-6" style="padding-right:0">
                    <style type="text/css">.radio{display: inline-block;}</style>
                    <div class="form-group">
                        {{ Form::label('gender', 'Gender:', ['class' => 'control-label']) }}<br>
                        <div class="radio">
                            <label><input type="radio" name="gender" value="Male"> Male </label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="gender" value="Female"> Female </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('billing_address', 'Billing Address:', ['class' => 'control-label']) }}
                    {{ Form::textarea('billing_address', null, ['class' => 'form-control', 'rows' => 2])}}
                </div>
            </div>

            <div class="col-md-6">
                <div class="col-md-6" style="padding-left:0">
                    <div class="form-group">
                        {{ Form::label('company', 'Company Name:', ['class' => 'control-label']) }}
                        {{ Form::text('company', null, ['class' => 'form-control'])}}
                    </div>
                </div>
                <div class="col-md-6" style="padding-left:0">
                    <div class="form-group">
                        {{ Form::label('designation', 'Designation:', ['class' => 'control-label']) }}
                        {{ Form::text('designation', null, ['class' => 'form-control'])}}
                    </div>
                </div>
                <div class="col-md-6" style="padding-left:0">
                    <div class="form-group">
                        {{ Form::label('referral_name', 'Referral Name:', ['class' => 'control-label']) }}
                        {{ Form::text('referral_name', null, ['class' => 'form-control'])}}
                    </div>
                </div>
                <div class="col-md-6" style="padding-left:0">
                    <div class="form-group">
                        {{ Form::label('referral_contact', 'Referral Contact:', ['class' => 'control-label']) }}
                        {{ Form::text('referral_contact', null, ['class' => 'form-control'])}}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('sales_date', 'Sales Date:', ['class' => 'control-label']) }}
                    {{ Form::date('sales_date', date('Y-m-d'), ['class' => 'form-control', 'required' => '','placeholder'=>'Sale Date'])}}
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"> </i> Save</button>
            </div>
            {!! Form::close() !!}
                </div> <!-- /.box body -->
            </div> <!-- /.box -->
        </div> <!--/.col (left) -->
    </div> <!-- /.row -->
</section> <!-- /.content -->

<script type="text/javascript">
    var total_price = 0;

    var add_item   = document.getElementById('add_item');
    var items  = document.getElementById('items');
    var sub_total = document.getElementById('sub_total');
    var discount = document.getElementById('discount');

    item.addEventListener('change', addRow);
    function addRow(){
        if(item.options[item.options.selectedIndex].value == ""){
            alert('Selected Item is empty!');
            return;
        }
        //add table row/tr and cell/td
        var row     = items.insertRow(-1);
        var name    = row.insertCell(0);
        var price   = row.insertCell(1);
        var qty     = row.insertCell(2);
        var Total   = row.insertCell(3);
        var action  = row.insertCell(4);

        //add item name
        name.innerHTML = item.options[item.options.selectedIndex].innerHTML;

        //add item name
        var itemname   = document.createElement('input');
        itemname.name  = "itemname[]";
        itemname.type  = "hidden";
        itemname.value = item.options[item.options.selectedIndex].innerHTML;
        name.appendChild(itemname);

        //add item id
        var itemid   = document.createElement('input');
        itemid.name  = "itemid[]";
        itemid.type  = "hidden";
        itemid.value = item.options[item.options.selectedIndex].value;
        name.appendChild(itemid);

        //add item price
        var itemPrice   = document.createElement('input');
        itemPrice.name  = "price[]";
        itemPrice.type  = "text";
        itemPrice.setAttribute('class', 'form-control');
        itemPrice.value = item.options[item.options.selectedIndex].getAttribute('price');
        price.appendChild(itemPrice);

        //add item qty
        var itemQty   = document.createElement('input');
        itemQty.name  = "qty[]";
        itemQty.type  = "number";
        itemQty.setAttribute('class', 'form-control');
        itemQty.setAttribute('onchange', 'calcTotal(this)');
        itemQty.setAttribute('min', 1);
        itemQty.value = 0;
        qty.appendChild(itemQty);

        //add item qty
        var itemTotal   = document.createElement('input');
        itemTotal.name  = "total[]";
        itemTotal.type  = "text";
        itemTotal.setAttribute('class', 'form-control itmTotal');
        itemTotal.value = 0;
        Total.appendChild(itemTotal);

        var actbtn = document.createElement('span');
        actbtn.setAttribute('class', 'btn btn-danger btn-sm');
        actbtn.setAttribute('onclick', 'removetr(this)');
        actbtn.innerHTML = '<i class="fa fa-close"></i>';
        action.appendChild(actbtn);
    }

    // remove table row on click close sign
    function removetr(o) {
        sub_total.value = sub_total.value - o.parentElement.previousElementSibling.firstElementChild.value;

        Discount();
        Shipping();
        dueCalc();

        var p = o.parentNode.parentNode;
        p.parentNode.removeChild(p);
    }

    var due = document.getElementById('due');
    var grand_total = document.getElementById('gtotal');
    var paid = document.getElementById('paid');
    var shipping = document.getElementById('shipping');

    discount.addEventListener('keyup', Discount);
    function Discount(){
        grand_total.value = (sub_total.value - discount.value) + Number(shipping.value);
        dueCalc();
    }

    shipping.addEventListener('keyup', Shipping);
    function Shipping(){
        grand_total.value = (sub_total.value - discount.value) + Number(shipping.value);
        dueCalc();
    }

    paid.addEventListener('keyup', dueCalc);
    function dueCalc(){
        due.value = grand_total.value - paid.value;
    }

    //change total change by qty
    var quantity = document.getElementsByName('qty');
    // console.log(quantity);

    function calcTotal(e){
        e.parentElement.nextElementSibling.firstElementChild.value = e.parentElement.previousElementSibling.firstElementChild.value * e.value;

        var itemTotal = document.getElementsByClassName('itemTotal');
        var sub_totals = 0;
        for(var i = 0; itemTotal.length > i; i++){
            sub_totals += Number(itemTotal[i].value);
        }

        sub_total.value = sub_totals;
        Discount();
        Shipping();
        dueCalc();
    }

    /** ----------------------------- Search Customer by ajax --------------- **/
    var mobile = document.getElementById('mobile');
    var search_customer = document.getElementById('search_customer');
    mobile.addEventListener('keyup', getCustomer);

    function getCustomer(elm){
        var customer_name = document.getElementById('customer_name');
        var address = document.getElementById('address');

        if(mobile.value.length != 11){
            customer_name.value = "";
            address.value = "";
            return false;
        }

        // console.log(mobile);

        $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: '/search/customer/'+mobile.value,
            success: function (data) {
                var obj = JSON.parse(JSON.stringify(data));
                // console.log(obj['success']);
                if(obj['success'] == null){
                    alert('Customer not found. Please create a new customer.');
                    return false;
                }

                var customer = obj['success'];

                customer_name.value = customer['full_name'];
                address.value = customer['address'];
            },
            error: function(data) { 
                 alert('Could not retrive data from database!');
            }
        });
    }

    //** ---------------------- customer serch end ----------------------- **//
    
</script>
@endsection