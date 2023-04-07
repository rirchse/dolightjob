@extends('dashboard')
@section('title', 'User Details')
@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Account Details</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{$user->user_role}}</a></li>
        <li class="active">User Details</li>
      </ol>
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"><!-- left column -->
      <div class="col-md-6"><!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">Account Information</h4>
          </div>
          <div class="col-md-12 text-right toolbar-icon">
            @if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin']))
            <a href="{{route('user.index')}}" title="View {{Session::get('_types')}} users" class="label label-success"><i class="fa fa-list"></i></a>
            <a href="{{route('user.edit',$user->id)}}" class="label label-warning" title="Edit this User"><i class="fa fa-edit"></i></a>
            @else
            <a href="/profile_edit" class="label label-warning" title="Edit this User"><i class="fa fa-edit"></i></a>
            @endif

            {{-- <a href="{{route('user.delete',$user->id)}}" class="label label-danger" onclick="return confirm('Are you sure want to delete this account!');" title="Delete this account"><i class="fa fa-close"></i></a> --}}
            
          </div>
          <div class="col-md-12">
            <table class="table">
                <tbody>
                  <tr>
                    <th>ID:</th>
                    <td><b>#{{$user->id}}</b></td>
                  </tr>
                  <tr>
                    <th>Skill:</th>
                    <td><b>{{$user->skill}}</b></td>
                  </tr>
                  <tr>
                    <th>Profile:</th>
                    <td>
                      @if($user->image)
                      <a href="{{$user->image}}" target="_blank" title="View large image"><img src="{{$user->image}}" width=100 style="border: 5px solid #eee"></a>
                      @else
                      No image
                      @endif
                    </td>
                  </tr>
                  @if(Auth::id() == $user->id || Auth::user()->authorizeRoles(['SuperAdmin', 'Admin']))
                  <tr>
                    <th>Facebook Profile:</th>
                    <td><a target="_blank" href="{{$user->facebook}}">{{$user->facebook}}</a></td>
                  </tr>
                  <tr>
                    <th>User Permission:</th>
                    <td>{{$user_role->name}} [{{$user_role->description}}]</td>
                  </tr>
                  @endif
                  <tr>
                    <th>Name:</th>
                    <td>{{$user->name}}</td>
                  </tr>
                  <tr>
                    <th>Email:</th>
                    <td>{{$user->email}}</td>
                  </tr>
                  <tr>
                    <th>Contact:</th>
                    <td>{{$user->contact}}</td>
                  </tr>
                  <tr>
                    <th>Referer:</th>
                    <td>
                      <?php $aff = App\User::find($user->aff_id); ?>
                      {{$aff?$aff->name:''}}</td>
                  </tr>
                  <tr>
                    <th>Your Referal ID:</th>
                    <td><span style="color:blue">{{url('/')}}/{{$user->id}}/aff</span></td>
                  </tr>
                   <tr>
                    <th>Status:</th>
                    <td>
                      @if($user->status == 0)
                      <span class="label label-warning">Pending</span>
                      @elseif($user->status == 1)
                      <span class="label label-success">Active</span>
                      @elseif($user->status == 2)
                      <span class="label label-danger">Suspended</span>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <th>Address:</th>
                    <td>{{$user->address}} </td>
                  </tr>
                  <tr>
                    <th>City:</th>
                    <td>{{$user->city}} </td>
                  </tr>
                  <tr>
                    <th>State:</th>
                    <td>{{$user->state}} </td>
                  </tr>
                  <tr>
                    <th>Country:</th>
                    <td>{{$user->country}} </td>
                  </tr>
                  <tr>
                    <th>Join Date:</th>
                    <td>{{date('d M Y h:i:s A',strtotime($user->created_at) )}} </td>
                  </tr>
                  <tr>
                    <th>Updated On:</th>
                    <td>{{date('d M Y h:i:s A',strtotime($user->updated_at) )}} </td>
                  </tr>
              </tbody>
            </table>
          </div>
          <div class="clearfix"></div>
          @if(Auth::user()->authorizeRoles(['SuperAdmin']) && $user->status == 0)
          <p><a href="{{route('user.delete', $user->id)}}" onclick="return confirm('Are sure you want to permanently delete this user?')" class="text-danger" style="padding:15px" title="Permanently Remove?"><i class="fa fa-remove"></i></a></p>
          @endif
        </div><!-- /.box -->
      </div><!--/.col (left) -->
      @if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin']))
      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4 class="box-title">User History</h4>
          </div>
          <div class="box-body">
            <table class="table">
              <tr>
                <?php $earning_bal = App\EarningBalance::where('user_id', $user->id)->first(); ?>
                <td>Pre-Earning:{{$earning_bal->pre_amount}}<h4>Earning Balance: <b class="text-info">${{$earning_bal?$earning_bal->amount:0}}</b></h4></td>
                <?php $depo_bal = App\DepositBalance::where('user_id', $user->id)->first();?>
                <td>Pre-Deposit:{{$depo_bal->pre_amount}}<h4>Deposit Balance: <b class="text-success">
                  ${{$depo_bal?$depo_bal->amount:0}}</b></h4></td>
              </tr>
              <tr>
                <td><h4>Tasks:</h4> <a href="/view_user_tasks/{{$user->id}}">More...</a></td>
                <td>
                  <label class="text-primary">Working: {{$task['working']}}</label><br>
                  <label class="text-warning">Pending: {{$task['pending']}}</label><br>
                  <label class="text-success">Satisfied: {{$task['satisfied']}}</label><br>
                  <label class="text-danger">Unsatisfied: {{$task['unsatisfied']}}</label><br>
                  <h4 style="color:#f00">Earning: <b>${{$task['earning']}}</b></h4>
                </td>
              </tr>
              <tr>
                <td><h4>Withdraw</h4> <a href="/view_user_withdraw/{{$user->id}}">More...</a></td>
                <td>
                  <label class="text-warning">Pending: {{$withdraw['pending']}}</label><br>
                  <label class="text-success">Active: {{$withdraw['approved']}}</label><br>
                  <label class="text-danger">Cancelled: {{$withdraw['cancelled']}}</label><br>
                  <h4 style="color:#f00">Withdraw: <b>${{$withdraw['withdrawan']}}</b></h4>
                </td>
              </tr>
              <tr>
                <td><h4>Deposit:</h4> <a href="/view_user_deposits/{{$user->id}}">More...</a></td>
                <td>
                  <label class="text-warning">Pending: {{$deposit['pending']}}</label><br>
                  <label class="text-success">Active: {{$deposit['active']}}</label><br>
                  <label class="text-danger">Cancelled: {{$deposit['cancelled']}}</label><br>
                  <h4 style="color:#f00">Deposited: <b>${{$deposit['deposited']}}</b></h4>
                </td>
              </tr>
              <tr>
                <td><h4>Job Posts:</h4> <a href="/view_user_jobs/{{$user->id}}">More...</a></td>
                <td>
                  <label class="text-warning">Pending: {{$job['pending']}}</label><br>
                  <label class="text-success">Active: {{$job['active']}}</label><br>
                  <label class="text-danger">Cancelled: {{$job['cancelled']}}</label><br>
                  <label class="text-info">Completed: {{$job['completed']}}</label><br>
                  <label class="text-default">Pause: {{$job['pause']}}</label><br>
                  <label class="text-primary">Auto Pause: {{$job['autopause']}}</label><br>
                </td>
              </tr>
            </table>
          </div>
        </div>
        {{-- @if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin'])) --}}
          <div class="box">
            <div class="box-body">
              <table class="table">
                <tr>
                  <td>
                    <a href="/update_user_earning/{{$user->id}}">Update User Earning Balance</a>
                  </td>
                  <td>
                    <a href="/update_user_deposit/{{$user->id}}">Update User Deposit Balance</a>
                  </td>
                </tr>
              </table>
            </div>
          </div><!--box-->
        {{-- @endif --}}
      </div><!--/.col-md-6-->
      @endif

    </div><!-- /.row -->
  </section><!-- /.content -->
   
@endsection