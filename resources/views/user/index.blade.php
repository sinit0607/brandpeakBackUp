@extends("layouts.app")

@section('extra_css')
<style type="text/css">
.switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 25px;
}

/* Hide default HTML checkbox */
.switch input {display:none;}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 16px;
  width: 16px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

.notification {
  position: relative;
  display: inline-block;
}

.notification .badge {
  position: absolute;
  top: -7px;
  right: -7px;
}

.fa-google-plus {
  color: blue;
}
</style>
@endsection
@section('content')
<div class="row">
  <div class="col-md-12">
    @if (count($errors) > 0)
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title float-left">
            User
        </h3>
        <a href="{{ route('user.create')}}" class="btn btn-success float-right">Add New</a>
      </div> 

      <div class="card-body table-responsive table-bordered table-striped">
        <table class="table" id="data_table_user">
          <thead class="thead-inverse">
            <tr>
              <th>User</th>
              <th>Email</th>
              <th>Mobile No</th>
              <th>Entry</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          @foreach($data as $row)
            @if($row->email != "demo2023@gmail.com")
            <tr>
              <td><div class="notification"><img src="@if($row->image) @if(substr($row->image, 0, 4)=="http") {{$row->image}} @else @if(App\Models\StorageSetting::getStorageSetting("storage") == "DigitalOcean"){{\Storage::disk('spaces')->url('uploads/'.$row->image)}} @else {{asset('uploads/'.$row->image)}} @endif @endif @else {{asset('assets/images/no-user.jpg')}} @endif" class="rounded-circle" @if($row->is_subscribe)@if(date_format(date_create(implode("", preg_split("/[-\s:,]/", $row->subscription_end_date))),"Y-m-d") >= date("Y-m-d",strtotime('today'))) style="border: 3px solid red;" @endif @endif alt="Image" width="40" height="40"/>@if($row->login_type=="google")<span class="badge"><i class="fa-brands fa-google-plus fa-xl"></i></span>@endif @if($row->login_type=="phone")<span class="badge rounded-circle bg-primary mt-1 mr-1" style="width:17px;height:17px;"><i class="fas fa-phone fa-xs" style="margin-left:-3px;"></i></span>@endif</div> <a href="{{url('admin/user/'.$row->id) }}" class="ml-3" style="font-size:15px;"><b>{{$row->name}}</b></a></td>
              <td class="align-middle">{{$row->email}}</td>
              <td class="align-middle">{{$row->mobile_no}}</td>
              <td class="align-middle">{{date('d/m/Y g:i a',strtotime($row->created_at))}}</td>
              <td style="align-middle">
                <label class="switch mt-2">
                    <input type="checkbox" name="status" data-id="{{$row->id}}" value="1" class="status" @if($row->status==1) checked @endif>
                    <span class="slider round"></span>
                </label>
              </td>
              <td class="align-middle">
                <div class="btn-group">
                  <a data-id="{{$row->id}}" data-toggle="modal" data-target="#whatsappModal"><button type="button" class="btn btn-primary"><span aria-hidden="true" class="fab fa-whatsapp"></span></button></a>
                  <a href="{{url('admin/user/'.$row->id) }}"><button type="button" class="btn btn-warning ml-2"><span aria-hidden="true" class="fa fa-eye"></span></button></a>
                  @if($row->user_type != "Super Admin")<a data-id="{{$row->id}}" data-toggle="modal" data-target="#myModal"><button type="button" class="btn btn-danger ml-2"><span aria-hidden="true" class="fa fa-trash"></span></button></a>@endif
                </div>
                {!! Form::open(['url' => 'admin/user/'.$row->id,'method'=>'DELETE','class'=>'form-horizontal','id'=>'form_'.$row->id]) !!}
                {!! Form::hidden("id",$row->id) !!}
                {!! Form::close() !!}
              </td>
            </tr>
            @endif
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Start whatsapp Modal -->
<div id="whatsappModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Do you really want to send message on whatsapp ?</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="m-3">
                <div class="row modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                          <label for="example-text-input">Whatsapp Message Tamplate</label><br>
                          <select id="msg_id" name="msg_id" style="width:100%;" required>
                              @foreach($whatsapp_messages as $message)
                              <option value="{{$message->id}}">{{$message->message}}</option>
                              @endforeach
                          </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    @if(Auth::user()->user_type == "Demo")
                    <button type="button" class="btn btn-success ToastrButton">Send</button>
                    @else
                    <button id="send_btn" class="btn btn-success" data-dismiss="modal" data-submit="">Send</button>
                    @endif
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End whatsapp Modal -->

  <!-- Modal -->
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Delete</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to Delete ?</p>
        </div>
        <div class="modal-footer">
          @if(Auth::user()->user_type == "Demo")
          <button type="button" class="btn btn-danger ToastrButton">Delete</button>
          @else
          <button id="del_btn" class="btn btn-danger" type="button" data-submit="">Delete</button>
          @endif
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->

<!-- Modal -->
<div id="changepass" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Change Password</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        {!! Form::open(['url'=>url('admin/change_password'),'id'=>'changepass_form']) !!}
        <form id="change" action="{{url('admin/change_password')}}" method="POST">

          {!! Form::hidden('user_id',"",['id'=>'user_id'])!!}
       <div class="form-group">
        {!! Form::label('passwd','Password',['class'=>"form-label"]) !!}
        <div class="input-group mb-3">
          <div class="input-group-prepend">
          <span class="input-group-text"><i class="fa fa-lock"></i></span></div>
        {!! Form::password('passwd',['class'=>"form-control",'id'=>'passwd','required']) !!}
        </div>
      </div>
      <div class="modal-footer">
        @if(Auth::user()->user_type == "Demo")
        <button type="button" class="btn btn-info ToastrButton">Change Password</button>
        @else
        <button id="password" class="btn btn-info" type="submit">Change Password</button>
        @endif
      </form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close
        </button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
@endsection

@section('script')
<script type="text/javascript">
  $('#changepass').on('show.bs.modal', function(e) {
    var id = e.relatedTarget.dataset.id;
    $("#user_id").val(id);
  });

  $('.ToastrButton').click(function() {
    toastr.error('This Action Not Available Demo User');
  });

  $("#changepass_form").on("submit",function(e){
    $.ajax({
      type: "POST",
      url: $(this).attr("action"),
      data: $(this).serialize(),
      success: function(data){

       new PNotify({
            title: 'Success!',
            text: "Password Has Been Changed.",
            type: 'info'
        });
      },

      dataType: "html"
    });
    $('#changepass').modal("hide");
    e.preventDefault();
  });

  $("#del_btn").on("click",function(){
    var id=$(this).data("submit");
    $("#form_"+id).submit();
  });

  $('#myModal').on('show.bs.modal', function(e) {
    var id = e.relatedTarget.dataset.id;
    $("#del_btn").attr("data-submit",id);
  });

  $(".status").change(function(){
    var checked = $(this).is(':checked');
    var id = $(this).data("id");
    
    $.ajax({
      type: "POST",
      url: "{{url('admin/user-status')}}",
      data: { checked : checked , id : id},
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      success: function(data) {
        new PNotify({
          title: 'Success!',
          text: "User Status Has Been Changed.",
          type: 'success'
        });
      },
    });
  });

  $("#whatsappModal").on('show.bs.modal', function(e){
      var id = e.relatedTarget.dataset.id;
      $("#send_btn").attr("data-submit",id);
      $('#msg_id').select2();
  });
  
  $("#send_btn").on("click",function(){
      var id = $(this).data("submit");
      var msg_id = document.getElementById("msg_id").value;
      
      $.ajax({
        type: "POST",
        url: "{{url('admin/send-whatsapp-msg-user')}}",
        data: { user_id : id,msg_id : msg_id },
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(data) {
          console.log(data);
          var text = data.replace('<br>', '');
          var result = $.parseJSON(text);
          if(result.message == "Message sent")
          {
            toastr.success("Message Send Successfully");
          }
          else
          {
            toastr.error(result.message);
          }  
        },
        error (data) {
            toastr.error(JSON.stringify(data));
        }
        
      });
  });

  $(document).ready(function() {
    var table = $('#data_table_user').DataTable({
      "ordering": false,
      // individual column search
      "initComplete": function() {
              table.columns().every( function () {
                  var that = this;
                  $('input', this.footer()).on('keyup change', function () {
                    // console.log($(this).parent().index());
                      that.search(this.value).draw();
                  });
                });
              }
    });
  });
</script>
@endsection
