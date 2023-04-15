@extends('layouts.app')

@section('extra_css')
<style type="text/css">
.notification {
  position: relative;
  display: inline-block;
}

.notification .badge {
  position: absolute;
  top: -7px;
  right: -7px;
}
</style>
@endsection

@section('content')
<div class="container">
<div class="card card-success">
    <div class="card-header">
    <h3 class="card-title">Add Frame</h3>
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

    {!! Form::open(['route' => 'poster-maker.store','method'=>'post','files'=>true]) !!}
    {!! Form::hidden('user_id',Auth::user()->id)!!}
    <div class="row">
        <div class="col-12">
            <div class="form-group row">
                {!! Form::label('poster_category','Select Frame Category', ['class' => 'col-sm-3 col-form-label','placeholder'=>'Enter Name']) !!}
                <div class="col-sm-4">
                    <select id="poster_category_id" name="poster_category_id" class="form-control" required>
                        <option value="">Select Frame Category</option>
                        @foreach($category as $c)
                            <option value="{{$c->id}}">{{$c->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="form-group row">
                {!! Form::label('template_type','Template Type', ['class' => 'col-sm-3 col-form-label']) !!}
                <div class="col-sm-4">
                    <select id="template_type" name="template_type" class="form-control" required>
                        <option value="">Select Type</option>
                        <option value="1:1">1:1 (Square)</option>
                        <option value="2:1">2:1 (Twitter Post)</option>
                        <option value="3:4">3:4 (Pinterest)</option>
                        <option value="4:5">4:5 (Portrait)</option>
                        <option value="9:16">9:16 (Story)</option>
                        <option value="16:9">16:9 (Landscap)</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="form-group row">
                {!! Form::label('zip',' Zip', ['class' => 'col-sm-3 col-form-label']) !!}
                <div class="col-sm-4">
                    <input class="form-control" type="file" id="zip" name="zip" required>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="form-group row">
                {!! Form::label('post_thumb','Post Thumb', ['class' => 'col-sm-3 col-form-label']) !!}
                <div class="col-sm-4">
                    <input class="form-control" type="file" id="post_thumb" onchange="imagePreview()" name="post_thumb" accept=".jpg, .png, jpeg, .PNG, .JPG, .JPEG" required>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-4"  id="preview"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 m-3 text-center">
        @if(Auth::user()->user_type == "Demo")
        <button type="button" class="btn btn-success ToastrButton">Save</button>
        @else
        {!! Form::submit('Save', ['class' => 'btn btn-success']) !!}
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
        $('#poster_category_id').select2();
        $('#template_type').select2();
    });

    function imagePreview(fileInput) 
    { 
        var total_file=document.getElementById("post_thumb").files.length;
        for(var i=0;i<total_file;i++)
        {
            $('#preview').append("<img class='img-responsive mr-3 shadow bg-white rounded' src='"+URL.createObjectURL(event.target.files[i])+"' style='width:150px;height:auto;'>");
        }
    }
</script>
@endsection