@extends('dashboard')
@section('title', 'View Diposits')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>View Diposits</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Transations </a></li>
        <li class="active"> View Diposits</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Diposit</h3>

              <div class="box-tools">
                <a href="/diposit/create" title="Diposit Balance" class="btn btn-info"><i class="fa fa-plus"></i> Diposit</a>

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
                  <th>#ID</th>
                  <th>Payment Method</th>
                  <th>Account No.</th>
                  <th>Amount (BDT)</th>
                  <th>Amount (USD)</th>
                  <th>TrxID</th>
                  <th>Diposited By</th>
                  <th>Diposited at</th>
                  <th>Note</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                <?php $r = 0; ?>

                @foreach($diposits as $diposit)
                <?php $r++; ?>

                <tr>
                  <td>{{$diposit->id}}</td>
                  <td>{{$diposit->account_type}}</td>
                  <td>{{$diposit->account_no}}</td>
                  <td>{{$diposit->amount_bdt}}</td>
                  <td>{{$diposit->amount_usd}}</td>
                  <td>{{$diposit->transaction_id}}</td>
                  <td>
                    <?php $user = App\User::find($diposit->created_by); ?>
                    <a href="/user_review/{{$user?$user->id:''}}">{{$user?$user->name:''}}</a></td>
                  <td>{{$diposit->created_at?date('d M Y H:i:s', strtotime($diposit->created_at)):''}}</td>
                  <td>{{$diposit->note}}</td>
                  <td>
                    @if($diposit->status == 1)
                    <label class="label label-success">Approved</label>
                    @else
                    <label class="label label-warning">Pending</label>
                    @endif
                  </td>
                  <td>
                    {{-- <a href="/diposit/{{$diposit->id}}" class="label label-info" title="Details"><i class="fa fa-file-text"></i></a> --}}

                    @if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin']) && $diposit->status == 0)
                    <a href="/diposit/{{$diposit->id}}/approve" title="Approve Diposit" class="btn btn-success" onclick="return confirm('Are you sure you want to Approve this diposit? Please double check TrxID, Amount with the account number.')">Approve</i></a>
                    
                    <a href="/diposit/{{$diposit->id}}/delete" class="btn btn-danger" title="Delete diposit" onclick="return confirm('Are you sure you want to delete this diposit?');">Delete</a>
                    @endif
                  </td>

                </tr>

                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                {{$diposits->links()}}
              </div>
              
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->

@endsection