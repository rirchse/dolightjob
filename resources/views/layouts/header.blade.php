<?php
$user = Auth::user();
$withdraw = DB::table('withdrawals')->where('created_by', Auth::id())->sum('usd', 'charge');
$earning = App\EarningBalance::where('user_id', Auth::id())->first();
$deposit = App\DepositBalance::where('user_id', Auth::id())->first();
$project_costs = DB::table('myjobs')->where('created_by', Auth::id())->where('status', 1)->sum('total_cost');
//system earning(project charge)
$charge = DB::table('myjobs')->where('status', 1)->sum('charge');
$cost = DB::table('myjobs')->where('status', 1)->where('created_by', Auth::id())->sum('total_cost');
// dd($cost);

//permition check
function check($roles){
  return Auth::user()->authorizeRoles($roles);
}

?>

  <header class="main-header">
    <!-- Logo -->
    <a href="/home" class="logo" style="{{check(['user'])?'background:#fff':''}}">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="{{asset('/img/logo.png')}}" width="50"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="{{asset('/img/logo.png')}}" class="img-responsive"></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" style="{{check(['user'])? 'background:#fff':''}}">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <style type="text/css">
      @media(max-width: 480px){
        .bal-label{display: none!important;}
        .messages-menu{display: block;}
      }
      @media(min-width: 481px){
        .messages-menu{display: none!important;}
      }
      </style>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          @if(check(['SuperAdmin', 'Admin']))
          <li><a href="#"> <span class="">Earning: <b>${{ $charge?$charge:00.00 }}</b></span></a></li>
          @else
          <li><a href="/earning_to_diposit"><span class="text-info">Earning to Deposit</span></a></li>
          <li>
          <li class="bal-label"><a href="#"><i class="fa fa-money"></i> <span class="">Earning: <b>$<span id="earnings">{{ $earning?$earning->amount:0 }}</span></b></span> &nbsp; 
          <span class=""> <i class="fa fa-bank"></i> Deposits: <b>${{ $deposit?$deposit->amount: 0}} </b></span></a>
        </li>

          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-usd"></i> Balance
              <span class="label label-success">{{-- 4 --}}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Balance</li>
              <li>
                <ul class="menu">
                  <li><a href="/earning_to_diposit"><span class="text-info">Earning to Deposit</span></a></li>
                  <li>
                  <a href="#">
                    <i class="fa fa-money text-aqua"></i> <span class="text-info"> Earning: <b>${{ $earning?$earning->amount:0 }}</b></span>
                  </a>
                  </li>
                <li>
                  <a href="#"><i class="fa fa-bank  text-success"></i>
                    <span class="text-success">Deposits: <b>${{ $deposit?$deposit->amount: 0}} </b></span></a>
                  </li>
              </ul>
            </li>
            </ul>
            
          </li>
          @endif
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>              
                <?php
                $admin_msgs = App\Message::orderBy('id', 'DESC')->where('status', 0)->where('receiver_type', 'admin')->get();
                $user_msgs = App\Message::orderBy('id', 'DESC')->where('status', 0)->where('receiver_type', 'user')->where('receiver', Auth::id())->get();
                ?>

                @if(check(['SuperAdmin', 'Admin']) && count($admin_msgs) > 0)
                <span class="label label-danger">
                  {{count($admin_msgs)}}
                </span>
                @elseif(count($user_msgs) > 0)
                <span class="label label-danger">
                  {{count($user_msgs)}}
                </span>
                @endif
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  @if(check(['SuperAdmin', 'Admin']))
                  @foreach($admin_msgs as $msg)
                  <li>
                    <a onclick="markRead(this)" id="{{$msg->id}}" href="{{$msg->url}}" title="{{$msg->message}}">
                      <i class="fa fa-circle-o text-aqua"></i> {{$msg->message}}
                    </a>
                  </li>
                  @endforeach
                  @endif
                  @if(check(['user']))
                  @foreach($user_msgs as $msg)
                  <li>
                    <a onclick="markRead(this)" id="{{$msg->id}}" href="{{$msg->url}}" title="{{$msg->message}}">
                      <i class="fa fa-circle-o text-aqua"></i> {{$msg->message}}
                    </a>
                  </li>
                  @endforeach
                  @endif
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
         
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{$user->image?$user->image:'/img/avatar.png'}}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ $user->name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{$user->image?$user->image:'/img/avatar.png'}}" class="img-circle" alt="User Image">
              </li>
              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="/user/{{$user->id}}" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{ route('logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                </div>
              </li>
            </ul>
          </li>
          
        </ul>
      </div>
    </nav>
  </header>

  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{$user->image?$user->image:'/img/avatar.png'}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info" style="text-align:right">
          <p>{{ $user->name }}</p>          
          <a href="#"><i class="fa fa-circle text-success"></i>
          @if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin']))
          {{App\Role::find(DB::table('role_user')->where('user_id', Auth::id())->first()->role_id)->name}}
        </a><br>
        @else
        Active
        @endif
          {{-- <span>Account No. {{$user->account_number}}</span> --}}
        </div>
      </div>
      <!-- search form -->
      
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        {{-- <li class="header">MAIN NAVIGATION</li> --}}
        <li class="">
          <a href="/home">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li><a href="/jobs"><i class="fa fa-search"></i><span>Find Job</span></a></li>
        <li><a href="{{ route('myjob.create') }}"><i class="fa fa-plus"></i> Post a Job</a></li>
        <li><a href="{{ route('myjob.index') }}"><i class="fa fa-list"></i> View My Jobs</a></li>
        <li><a href="{{route('mytask.index')}}"><i class="fa fa-tasks"></i> View My Tasks</a></li>

        <li><a href="/diposit"><i class="fa fa-money"></i> Deposits</a></li>
        <li><a href="/earning_to_diposit"><i class="fa fa-money"></i> Earning to Deposits</a></li>
        <li><a href="/withdraw"><i class="fa fa-circle-o"></i> Withdraw</a></li>
        <li><a href="/withdraw/mobile/recharge"><i class="fa fa-mobile"></i> Mobile Recharge</a></li>

        <li><a href="/referral"><i class="fa fa-users"></i> <span>Referrals</span></a></li>
        
        @if(Auth::user()->authorizeRoles(['SuperAdmin', 'Admin']))
        
        <li><a href="/notice"><i class="fa fa-file"></i> <span>Notice Board</span></a></li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-circle-o"></i>
            <span>Advertiesments</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="/ad/create"><i class="fa fa-circle-o"></i> Create a Ad</a></li>
            <li><a href="/ad"><i class="fa fa-circle-o"></i> View Advertiesments</a></li>
          </ul>
        </li>
       
        <li class="treeview">
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>Category</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('category.create')}}"><i class="fa fa-circle-o"></i> Create Category</a></li>
            <li><a href="{{route('category.index')}}"><i class="fa fa-circle-o"></i> View Categories</a></li>
            
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>Sub-Category</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('sub_category.create')}}"><i class="fa fa-circle-o"></i> Create Sub Category</a></li>
            <li><a href="{{route('sub_category.index')}}"><i class="fa fa-circle-o"></i> View Sub Categories</a></li>            
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-user-secret"></i> <span>Accounts</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('user.create') }}"><i class="fa fa-user-plus"></i> Create User</a></li>
            <li><a href="{{ route('user.index') }}"><i class="fa fa-users"></i> View User</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-gears"></i> <span>Settings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="/complete_task" onclick="return confirm('Are you sure you want to do this action?')"><i class="fa fa-user-plus"></i> Complete/Satisfy All Tasks</a></li>
            <li><a href="/time_over_task/delete" onclick="return confirm('Are you sure you want to do this action?')"><i class="fa fa-users"></i> Delete All Time Over Task</a></li>
          </ul>
        </li>

        @endif
        <li><a href="{{ route('user.show', $user->id) }}"><i class="fa fa-user"></i> My Profile</a></li>
        <li><a href="/password_change"><i class="fa fa-lock"></i> Change My Password</a></li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>


  <div class="alert-section" style="">
    <div class="clearfix"></div>
      @include('partials.messages')   
    <div class="clearfix"></div>
  </div>

<?php $notice = App\Notice::orderBy('id', 'DESC')->where('status', 1)->where('position', 'header')->first();?>
    
  @if($notice)
  <div style="text-align:right;color:#d00;background:#fff;height:25px">
    <ul class="my-news-ticker">
    <li>
      {!! $notice->details !!}
    </li>
    </ul>
  </div>
  @endif