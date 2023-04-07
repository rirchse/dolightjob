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
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of withdraw</h3>

              <div class="box-tools">
                <a href="/withdraw/create" title="withdraw Balance" class="btn btn-info"><i class="fa fa-plus"></i> withdraw</a>

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
                  @if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin']))
                  <th>User Name</th>
                  @endif
                  <th>Account Type</th>
                  <th>Request Type</th>
                  <th>Account No.</th>
                  <th>Amount (USD)</th>
                  <th>Amount (BDT)</th>
                  <th>Approved By</th>
                  <th>Date</th>
                  <th>Note</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                <?php $r = 0; ?>

                @foreach($withdrawals as $withdraw)
                <?php $r++;?>

                <tr>
                  @if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin']))
                  <?php
                  $user = App\User::find($withdraw->created_by);
                  if($user){
                  ?>                  
                  <td>
                    <a target="_blank" href="/user/{{$user->id}}">{{$user->name}}</td>
                  <?php
                  }
                  ?>
                  @endif
                  <td>{{$withdraw->account_type}}</td>
                  <td>{{$withdraw->request_type}}</td>
                  <td>{{$withdraw->account_no}}</td>
                  <td>{{$withdraw->usd}}</td>
                  <td>{{$withdraw->bdt}}</td>
                  <td>{{$withdraw->approved_by?DB::table('users')->find($withdraw->approved_by)->name:''}}</td>
                  <td>{{$withdraw->created_at?date('d M Y H:i:s', strtotime($withdraw->created_at)):''}}</td>
                  <td>{{$withdraw->note}}</td>
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
      </div>
    </section>
    <!-- /.content -->

@endsection