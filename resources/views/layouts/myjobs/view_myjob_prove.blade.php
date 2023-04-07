@extends('dashboard')
@section('title', 'View All Proves')
@section('content')
<?php
$working = $pending = $satisfied = 0;
foreach($proves as $task){
  if($task->status == 0){
    $working++;
  }elseif($task->status == 1){
    $pending++;
  }elseif($task->status == 2){
    $satisfied++;
  }
}
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>View Proves</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i>MyJob</a></li>
    {{-- <li><a href="#">Tables</a></li> --}}
    <li class="active">View Proves</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">List of Proves &nbsp; &nbsp; <span style="color:green;text-align:right">[Working= {{$working}}, Pending= {{$pending}}, Satisfied= {{$satisfied}}]</span></h3>
              <div class="box-tools">
                {{-- <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div> --}}
                {{-- <a href="/myjob">View My Job</a> --}}
              </div>
            </div>
            <!-- /.box-header -->
            <style type="text/css">
            @media(max-width: 320px){
              .word_wrap{width: 300px}
            }
            </style>
            <div class="box-body table-responsive no-padding">
              <table id="example1" class="table table-bordered table-hover">
                <tr>
                  <th>Worker</th>
                  <th>Prove ID</th>
                  <th>Status</th>
                  <th>Time Left (Hour)</th>
                  <th>Proof</th>
                  <th>Note</th>
                  <th>Action</th>
                </tr>
                <?php $x = 0; ?>
                @foreach($proves as $task)
                <?php $x++; ?>
                <tr>
                  <td><a href="#" onclick="window.location.href='/user_review/{{$task->created_by}}'">{{$task->name}}</a></td>
                  <td>{{$task->id}}</td>
                  <td onclick="{{$task->status == 1?'prove(this)':''}}" id="{{$task->id}}">
                    @if($task->status == 0)
                    <span class="label label-primary">Working</span>
                    @elseif($task->status == 1)
                    <span class="btn btn-warning">Pending</span>
                    @elseif($task->status == 2)
                    <span class="label label-success">Satisfied</span>
                    @elseif($task->status == 3)
                    <span class="label label-danger">Unsatisfied</span>
                    @endif
                  </td>
                  <td class="word_wrap">
                    <?php $hour = (strtotime(date('Y-m-d H:i'))-strtotime($task->created_at))/60/60; ?>
                    {{$hour < 3?number_format(3-$hour):'Time Over' }}
                  </td>
                  <td class="word_wrap">{{$task->proof}}</td>
                  <td class="word_wrap">{{$task->comment}}</td>
                  <td>
                    @if($task->status == 0 && $hour > 3 || Auth::user()->authorizeRoles(['SuperAdmin', 'Admin']))
                    <a href="/task/{{$task->id}}/delete" class="btn btn-danger" title="Delete this task" onclick="return confirm('Are you sure you want to delete this?')">Delete</a>
                    @endif
                  </td>
                </tr>
                @endforeach
              </table>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
              <div class="pagination-sm no-margin pull-right">
                {{$proves->links()}}
              </div>
            </div>
          </div><!-- /.box -->
        </div>
      </div>
    </section><!-- /.content -->
    <style type="text/css">
    .working_rate{color:orange;font-size:18px}
    .screenshots{display: table;max-width: 600px;margin: 15px auto;}
    .screenshots .prove_image{width:100%;max-width:50%;padding-bottom: 15px}
    .prove_image img{border: 1px solid #000;max-width: 230px}
    .action-btns{max-width: 200px;margin: auto}
    @media(min-width: 480px){
      .screenshots .prove_image{max-width:100%!important;display: table-cell;}
    }
    </style>

    <!-- worker prove panel -->
    <div class="modal fade" id="user_proof">
      <div class="modal-dialog">
        <div class="modal-content" style="height:550px;overflow-y:auto">
          <form action="#" method="post" id="prove_form" >
            {{csrf_field()}}
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" onclick="hide()">&times;</span></button>
            <h4 class="modal-title">Rate This Prove</h4>
          </div>
          <div class="modal-body">
            <div class="info-box">
              <div class="box-header with-border">
                <b>Submitted Prove:</b>
              </div>
              <div class="box-body">
                <div id="prove_text">No Proof Text</div><br>
                <div class="screenshots">
                  <div class="prove_image">
                    <img class="img-responsive" id="prove_img_1" src="" alt="" onclick="Preview(this)">
                  </div>
                  <div class="prove_image">
                    <img class="img-responsive" id="prove_img_2" src="" alt="" onclick="Preview(this)">
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <input type="hidden" name="approval" id="approval" required>
                <div class="action-btns">
                <a class="btn btn-default" onclick="satisfy(this)" id="satisfy">Satisfy</a>
                <a class="btn btn-default pull-right" onclick="unsatisfy(this)" id="unsatisfy">Unsatisfy</a>
                </div>
                <div class="form-group" hidden>
                  <label for="" class="control-label">Why you are unsatisfy?</label>
                  <textarea class="form-control" name="note" placeholder="Why you are unsatisfy?" id="note" rows=1></textarea>
                </div>

            <input type="hidden" name="feedback" id="feedback">
            <p id="feedbackpanel" style="text-align:center;margin-top:15px" hidden>Working Rate: &nbsp; &nbsp;  
              <span class="working_rate" id="working_rate">
                @for($x = 1; $x <= 5; $x++)
                <i class="fa fa-star-o" onclick="ad(this)" feedback="{{$x}}"></i>
                @endfor
              </span>
            </p>
              </div>
            </div>              
            <p style="color:red; text-align:center" id="error"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal" onclick="hide()">Cancel</button>
            <button type="submit"  name="submit-btn" id="submit-btn" class="btn btn-success">Submit</button>
          </div>
          {!! Form::close() !!}
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script type="text/javascript">
    var result_error = document.getElementById('error');
    var user_proof = document.getElementById('user_proof');
    var prove_text = document.getElementById('prove_text');
    var prove_img_1 = document.getElementById('prove_img_1');
    var prove_img_2 = document.getElementById('prove_img_2');
    var prove_id = '';    
    var sat = document.getElementById('satisfy');
    var unsat = document.getElementById('unsatisfy');
    var note = document.getElementById('note');
    var approval = document.getElementById('approval');
    var feedpanel = document.getElementById('feedbackpanel');
    var working_rate = document.getElementById('working_rate');

    function prove(elm){
      prove_id = elm.id;
      $.ajax({
        type: 'GET',
        url: '/get_task/'+elm.id,
        success: function(data){
          prove_text.innerHTML = data.proof;
          prove_img_1.src = data.screenshot;
          prove_img_2.src = data.screenshot_2;
          //show the prove panel
          user_proof.classList.add('in');
          user_proof.style.display = 'block';
        },
        error: function(data){
          // console.log('What?')
        }
      });
      document.getElementById('prove_form').setAttribute('action', '/task/'+elm.id+'/approve');
    }

    function satisfy(elm) {
      elm.classList.add('btn-info');
      elm.classList.remove('btn-default');
      unsat.classList.remove('btn-danger');
      unsat.classList.add('btn-default');
      note.parentNode.setAttribute('hidden', 'hidden');
      note.removeAttribute('required');
      approval.value = elm.innerHTML;
      feedpanel.removeAttribute('hidden');
      result_error.innerHTML = '';
    }
    function unsatisfy(elm) {
      elm.classList.add('btn-danger');
      elm.classList.remove('btn-default');
      sat.classList.add('btn-default');
      sat.classList.remove('btn-info');
      note.parentNode.removeAttribute('hidden');
      note.setAttribute('required', 'required');
      approval.value = elm.innerHTML;
      feedpanel.setAttribute('hidden', 'hidden');
      result_error.innerHTML = '';
    }

    //feedback change
    function ad(e) {
      var feedback_inner = '';
      for(var a = 1; a <= 5; a++){
        if(e.getAttribute('feedback') >= a){
          feedback_inner += '<i class="fa fa-star" onclick="ad(this)" feedback="'+a+'"> </i> ';
        }else{
          feedback_inner += '<i class="fa fa-star-o" onclick="ad(this)" feedback="'+a+'"> </i> ';
        }
      }
      working_rate.innerHTML = feedback_inner;
      document.getElementById('feedback').value = e.getAttribute('feedback');
    }

    function hide(){
      user_proof.classList.add('in');
      user_proof.style.display = 'none';
      prove_text.innerHTML = prove_img_1.src = prove_img_2.src = note.value = approval.value = '';
      sat.classList.remove('btn-info');
      sat.classList.add('btn-default');
      unsat.classList.remove('btn-danger');
      unsat.classList.add('btn-default');
      note.parentNode.setAttribute('hidden', 'hidden');
      feedpanel.setAttribute('hidden', 'hidden');

      var feedback_inner = '';
      for(var c = 1; c <= 5; c++){
        feedback_inner += '<i class="fa fa-star-o" onclick="ad(this)" feedback="'+c+'"> </i> ';
      }
      working_rate.innerHTML = feedback_inner;
    }

    function Preview(img){
      window.open(img.src, '_blank');
    }

    </script>

@endsection
@section('scripts')
  <script type="text/javascript">

    //submit prove from by ajax
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $(document).ready(function(){
      $('#prove_form').submit(function (e) {
        e.preventDefault(); //to prevent normal form submission and page reload

        $.ajax({
          type : 'POST',
          url : '/task/'+prove_id+'/approve',
          data : {
            approval: $("input#approval").val(),
            note: $("input#note").val(),
            feedback: $("input#feedback").val(),
          },
          success: function(result){
            var action_id = document.getElementById(result.id);
            if(result.status == 2){
              action_id.innerHTML = '<span class="label label-success">Satisfied</span>';
              hide();
              action_id.removeAttribute('onclick');
            }else if(result.status == 3){
              action_id.innerHTML = '<span class="label label-danger">Unsatisfied</span>';
              hide();
              action_id.removeAttribute('onclick');
            }
            
          },
          error: function (xhr, ajaxOptions, thrownError) {
            //alert(xhr.status);
            //alert(thrownError);
            // console.log($("input#approval").val().length);
            if($("input#approval").val().length == 0)
            {
              result_error.innerHTML = 'Please select the prove option.';
            }
          }
        });
      });
    });
  </script>
@endsection