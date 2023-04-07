@extends('dashboard')
@section('title', 'View Withdraw')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>View Withdrawals</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Transactions </a></li>
        <li class="active"> View Withdraw</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-9">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of withdraw</h3>

              <div class="box-tools">

                {{-- <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div> --}}

              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>Account Type</th>
                  <th>Request Type</th>
                  <th>Account No.</th>
                  <th>Amount (USD)</th>
                  <th>Amount (BDT)</th>
                  <th>Approved By</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                <?php $r = 0; ?>

                @foreach($withdrawals as $withdraw)
                <?php $r++;?>

                <tr>
                  <td>{{$withdraw->account_type}}</td>
                  <td>{{$withdraw->request_type}}</td>
                  <td>{{$withdraw->account_no}}</td>
                  <td>{{$withdraw->usd}}</td>
                  <td>{{$withdraw->bdt}}</td>
                  <td>{{$withdraw->approved_by?DB::table('users')->find($withdraw->approved_by)->name:''}}</td>
                  <td>{{$withdraw->created_at?date('d M Y H:i:s', strtotime($withdraw->created_at)):''}}</td>
                  <td>
                    @if($withdraw->status == 1)
                    <label class="label label-success">Approved</label>
                    @else
                    <label class="label label-warning">Pending</label>
                    @endif
                  </td>
                  <td>
                    {{-- <a href="/withdraw/{{$withdraw->id}}" class="label label-info" title="Details"><i class="fa fa-file-text"></i></a> --}}

                    @if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin']))
                    <a href="/withdraw/{{$withdraw->id}}/approve" title="Approve withdraw" class="btn btn-success" onclick="return confirm('Are you sure you want to Approve this withdraw? Please make a manual transaction with requested amount to the account number.')">Approve</a>                    
                    
                    @if($withdraw->status == 0)
                    <a href="/withdraw/{{$withdraw->id}}/delete" class="label label-danger" title="Delete withdraw request" onclick="return confirm('Are you sure you want to delete this withdraw?');"><i class="fa fa-trash"></i></a>
                    @endif
                    @endif
                  </td>

                </tr>

                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                {{$withdrawals->links()}}
              </div>
              
            </div>
          </div>
          <!-- /.box -->
        </div>
        <div class="col-sm-3">
          <div class="box">
            <div class="box-header">
              <img class="img-responsive" src="{{$user->image}}" style="border-radius:50%; max-width:150px; margin:auto">
            </div>
            <div class="box-body" style="text-align:center;border-top:1px solid #eee">
              <h4>{{$user->name}}</h4>
              <p>{{$user->contact}}<br>{{$user->email}}</p>
              <p> <a href="/user/{{$user->id}}" class="btn btn-info">Read More...</a> </p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->

@endsection