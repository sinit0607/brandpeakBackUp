@extends("layouts.app")

@section('extra_css')
<link href="{{ asset('assets/css/frame.css') }}" rel="stylesheet">
<style>
.ui-switcher {
  background-color: #bdc1c2;
  display: inline-block;
  top: 10px;
  height: 25px;
  width: 70px;
  border-radius: 15px;
  box-sizing: border-box;
  vertical-align: middle;
  position: relative;
  cursor: pointer;
  transition: border-color 0.25s;
  box-shadow: inset 1px 1px 1px rgba(0, 0, 0, 0.15);
}
.ui-switcher:before {
  font-family: sans-serif;
  font-size: 13px;
  font-weight: 400;
  color: #ffffff;
  line-height: 1;
  display: inline-block;
  position: absolute;
  top: 6px;
  height: 15px;
  width: 27px;
  text-align: center;
}
.ui-switcher[aria-checked=false]:before {
  content: 'Free';
  right: 10px;
}
.ui-switcher[aria-checked=true]:before {
  content: 'Paid';
  left: 10px;
}
.ui-switcher[aria-checked=true] {
  background-color: #e91e63;
}
.ui-switcher:after {
  background-color: #ffffff;
  content: '\0020';
  display: inline-block;
  position: absolute;
  top: 2px;
  height: 20px;
  width: 20px;
  border-radius: 50%;
  transition: left 0.25s;
}
.ui-switcher[aria-checked=false]:after {
  left: 5px;
}
.ui-switcher[aria-checked=true]:after {
  left: 45px;
}
</style>
@endsection

@section('content')
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
          <h3 class="card-title">
            Frame
          </h3>
      </div> 
      
      <div class="card-body">
        <div class="row d-flex justify-content-end mb-3">
          <div>
            <a href="{{ route('poster-maker.create')}}" class="btn btn-success ml-2">Add New</a>
          </div>
        </div>

        <div class="row">
          @foreach($data as $frame)
          <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="block_wallpaper add_wall_category" style="box-shadow:0px 3px 8px rgba(0, 0, 0, 0.3)">
              <div class="wall_category_block" style="z-index: 1">
                <h2>
                  {{$frame->poster_category->name}}               
                </h2>
              </div>
              <div class="wall_image_title">
                <ul>
                  <li><a href="{{url('admin/poster-maker/'.$frame->id.'/edit')}}" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a></li>
                  <li><a href="#" data-id="{{$frame->id}}" class="btn_delete_a" data-toggle="modal" data-target="#myModal"><i class="fa fa-trash"></i></a></li>
                  <li>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input checkbox2" type="checkbox" data-id="{{$frame->id}}" value="1" @if($frame->paid==1) checked @endif>
                    </div>
                  </li>
                  <li><div class="bg-primary rounded-circle" style="width:40px;height:40px;text-align:center;vertical-align:middle;line-height:40px;margin-left:-10px;">{{$frame->template_type}}</div></li>
                </ul>
                {!! Form::open(['url' => 'admin/poster-maker/'.$frame->id,'method'=>'DELETE','class'=>'form-horizontal','id'=>'form_'.$frame->id]) !!}
                {!! Form::hidden("id",$frame->id) !!}
                {!! Form::close() !!}
              </div>
              <span>
                <img src="@if(App\Models\StorageSetting::getStorageSetting('storage') == 'DigitalOcean'){{\Storage::disk('spaces')->url('uploads/'.$frame->post_thumb)}} @else {{asset('uploads/'.$frame->post_thumb)}} @endif"/>
              </span>
            </div>
          </div>
          @endforeach
        </div>
        <div class="d-flex justify-content-center">{{ $data->links() }}</div>
      </div>
    </div>

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
@endsection

@section('script')
<script src="{{ asset('assets/js/jquery.switcher.js')}}"></script>
<script type="text/javascript">
    $.switcher('.checkbox2');

    $("#del_btn").on("click",function(){
        var id=$(this).data("submit");
        $("#form_"+id).submit();
    });

    $('#myModal').on('show.bs.modal', function(e) {
        var id = e.relatedTarget.dataset.id;
        $("#del_btn").attr("data-submit",id);
    });

    $(".checkbox2").change(function(){
      var checked = $(this).is(':checked');
      var id = $(this).data("id");

      $.ajax({
        type: "POST",
        url: "{{url('admin/poster-maker-frame-type')}}",
        data: { checked : checked , id : id},
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(data) {
          if(data == 1)
          {
            new PNotify({
              title: 'Success!',
              text: "Custom Frame Set Paid",
              type: 'success'
            });
          }
          else
          {
            new PNotify({
              title: 'Success!',
              text: "Custom Frame Set Free",
              type: 'success'
            });
          }
        },
      });
    });
</script>
@endsection
