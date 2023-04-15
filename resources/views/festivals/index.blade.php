@extends("layouts.app")

@section('extra_css')
<link href="{{ asset('assets/css/frame.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/clean-switch.css')}}">
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
              Festivals
          </h3>
      </div> 
      
      <div class="card-body">
        <div class="row d-flex justify-content-end mb-3">
          <!-- <div class="col-md-3">
            <label style="font-weight: 400;font-size: 1em;">Filter by Date Range</label>
            <input type="text" value="" name="date" class="form-control filter" id="date_range_filter" placeholder="mm/dd/YYYY - mm/dd/YYYY">
          </div> -->
          <!-- <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Select Festival
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  @foreach($festival as $f)
                  <a class="dropdown-item" href="#">{{$f->title}}</a>
                  @endforeach
              </div>
          </div> -->
          <div class="d-flex">
            <form class="form-inline" action="{{url('admin/festivals-search')}}" method="GET">
              @csrf
              <input class="form-control mr-sm-2" type="search" name="search" value="@if(!empty($name)) {{$name}} @endif" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
            <a href="{{ route('festivals.create')}}" class="btn btn-success ml-2">Add New</a>
          </div>
        </div>

        <div class="row mt-3">
          @foreach($data as $frame)
          <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="block_wallpaper add_wall_category" style="box-shadow:0px 3px 8px rgba(0, 0, 0, 0.3)">
              <div class="wall_category_block" style="z-index: 1">
                <h2 style="font-size: 20px">
                  {{$frame->title}}               
                </h2>
                <div class="checkbox" style="float: right;z-index: 1">
                  @php $post = App\Models\FeaturePost::where("festival_id",$frame->id)->get(); @endphp
                  <input type="checkbox" name="feature_status" id="checkbox0" data-id="{{$frame->id}}" value="1" class="feature_status mt-1" style="width: 16px;height: 16px;" @if(!$post->isEmpty()) checked @endif>
                </div>
              </div>
              <div class="wall_image_title">
                <p class="my-auto"><i class="fa fa-calendar-days mr-2"></i>{{ date_format(date_create(implode("", preg_split("/[-\s:,]/",$frame->festivals_date))),"d M, y") }}</p>
                <ul>
                  <li><a href="{{url('admin/festivals/'.$frame->id.'/edit')}}" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a></li>
                  <li><a href="#" data-id="{{$frame->id}}" class="btn_delete_a" data-toggle="modal" data-target="#myModal"><i class="fa fa-trash"></i></a></li>
                  <li>
                    <label class="cl-switch cl-switch-red">
                      <input type="checkbox" class="festivals-switch" data-id="{{$frame->id}}" value="1" @if($frame->status==1) checked @endif>
                      <span class="switcher"></span>
                    </label>
                  </li>
                </ul>
                {!! Form::open(['url' => 'admin/festivals/'.$frame->id,'method'=>'DELETE','class'=>'form-horizontal','id'=>'form_'.$frame->id]) !!}
                {!! Form::hidden("id",$frame->id) !!}
                {!! Form::close() !!}
              </div>
              <span>
                <img src="@if(App\Models\StorageSetting::getStorageSetting('storage') == 'DigitalOcean'){{\Storage::disk('spaces')->url('uploads/'.$frame->image)}} @else {{asset('uploads/'.$frame->image)}} @endif"/>
              </span>
            </div>
          </div>
          @endforeach
        </div>
        <div class="d-flex justify-content-center">{{ $data->links() }}</div>
      </div>
    </div>
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
<script type="text/javascript">
    $("#del_btn").on("click",function(){
        var id=$(this).data("submit");
        $("#form_"+id).submit();
    });

    $('#myModal').on('show.bs.modal', function(e) {
        var id = e.relatedTarget.dataset.id;
        $("#del_btn").attr("data-submit",id);
    });

    $(".festivals-switch").change(function(){
      var checked = $(this).is(':checked');
      var id = $(this).data("id");
     
      $.ajax({
        type: "POST",
        url: "{{url('admin/festivals-status')}}",
        data: { checked : checked , id : id},
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(data) {
          new PNotify({
            title: 'Success!',
            text: "Festivals Status Has Been Changed.",
            type: 'success'
          });
        },
      });
    });

    $(".feature_status").change(function(){
      var checked = $(this).is(':checked');
      var id = $(this).data("id");
      
      $.ajax({
        type: "POST",
        url: "{{url('admin/festivals-feature-status')}}",
        data: { checked : checked , id : id},
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(data) {
          if(data == 1){
            new PNotify({
              title: 'Success!',
              text: "Festival Feature Set!.",
              type: 'success'
            });
          }
          else
          {
            new PNotify({
              title: 'Success!',
              text: "Festival Feature Unset!.",
              type: 'success'
            });
          }
        },
      });
    });
</script>
@endsection
