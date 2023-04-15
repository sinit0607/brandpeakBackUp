@extends('layouts.app')

@section('extra_css')
<style type="text/css">

</style>
@endsection

@section('content')
<div class="container">
<div class="card card-success">
    <div class="card-header">
    <h3 class="card-title">Update Frame Image</h3>
    </div>

    <div class="card-body">
    @if (count($errors) > 0)
        <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        </div>
    @endif

    {!! Form::open(['route' =>['category-frame.update',$categoryFrame->id],'method'=>'PATCH','files'=>true]) !!}
    {!! Form::hidden('user_id',Auth::user()->id)!!}
    {!! Form::hidden('id',$categoryFrame->id)!!}
    <div class="row">
        <div class="col-12">
            <div class="form-group row">
                {!! Form::label('category','Select Category', ['class' => 'col-sm-3 col-form-label','placeholder'=>'Enter Name']) !!}
                <div class="col-sm-4">
                    <select id="category_id" name="category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach($category as $c)
                            <option value="{{$c->id}}" @if($c->id == $categoryFrame->category_id) selected @endif>{{$c->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="form-group row">
                {!! Form::label('language','Select Language', ['class' => 'col-sm-3 col-form-label','placeholder'=>'Enter Name']) !!}
                <div class="col-sm-4">
                    <select id="language_id" name="language_id" class="form-control" required>
                        <option value="">Select Language</option>
                        @foreach($language as $l)
                            <option value="{{$l->id}}" @if($l->id == $categoryFrame->language_id) selected @endif>{{$l->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="form-group row">
                {!! Form::label('frame_image',' Select Frame Image', ['class' => 'col-sm-3 col-form-label']) !!}
                <div class="col-sm-4"><input class="form-control" type="file" id="frame_image" name="frame_image"></div>
            </div>
            <div class="row">
                <div class="col-sm-3" style="margin-top:-20px;">
                    <small class="form-text text-muted">
                        Recommendation Size: 
                        <ul>
                            <li>1024*1024 px (Square)</li>
                            <li>1080*1350 px (Portrait)</li>
                            <li>1280*720 px (Landscap)</li>
                            <li>1080*1920 px (Story)</li>
                        </ul>
                    </small>
                </div>
                <div class="col-sm-6" id="preview"><img src="@if(App\Models\StorageSetting::getStorageSetting('storage') == 'DigitalOcean'){{\Storage::disk('spaces')->url('uploads/'.$categoryFrame->frame_image)}} @else {{asset('uploads/'.$categoryFrame->frame_image)}} @endif" alt="Image" class="shadow bg-white rounded" width="auto" height="120px"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 m-3 text-center">
        @if(Auth::user()->user_type == "Demo")
        <button type="button" class="btn btn-success ToastrButton">Update</button>
        @else
        {!! Form::submit('Update', ['class' => 'btn btn-success']) !!}
        @endif
        </div>
    </div>
    {!! Form::close() !!}
    </div>
</div>
</div>
@endsection

@section("script")
<script type="text/javascript">
    $(document).ready(function() {
        $('#category_id').select2();
        $('#language_id').select2();
    });

    function imagePreview(fileInput) 
    { 
        if (fileInput.files && fileInput.files[0]) 
        {
            var fileReader = new FileReader();
            fileReader.onload = function (event) 
            {
                $('#preview').html('<img src="'+event.target.result+'" class="shadow bg-white rounded" width="auto" alt="Select Image" height="120px"/>');
            };
            fileReader.readAsDataURL(fileInput.files[0]);
        }
    }

    $("#frame_image").change(function () {
        imagePreview(this);
    });
</script>
@endsection