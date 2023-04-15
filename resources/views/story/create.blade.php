@extends('layouts.app')

@section('extra_css')
<style type="text/css">

</style>
@endsection

@section('content')
<div class="container">
<div class="card card-success">
    <div class="card-header">
    <h3 class="card-title">Add Home Stories</h3>
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

    {!! Form::open(['route' => 'story.store','method'=>'post','files'=>true]) !!}
    {!! Form::hidden('user_id',Auth::user()->id)!!}
    <div class="row">
        <div class="col-12">
            <div class="form-group row">
                {!! Form::label('story_type','Select Story Type', ['class' => 'col-sm-3 col-form-label']) !!}
                <div class="col-sm-4">
                    <select id="story_type" name="story_type" class="form-control" required>
                        <option value="">Select Story Type</option>
                        <option value="category">Category</option>
                        <option value="festival">Festival</option>
                        <option value="custom">Custom</option>
                        <option value="externalLink">External Link</option>
                        <option value="subscriptionPlan">Subscription Plan</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="form-group" id="otherText">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="form-group row">
                {!! Form::label('image',' Select Image', ['class' => 'col-sm-3 col-form-label']) !!}
                <div class="col-sm-4">
                    <input class="form-control" type="file" id="image" name="image" required>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-9" id="preview"><img type="image" class="shadow bg-white rounded" src="{{asset('assets/images/no-image.png')}}" alt="Image" style="width: auto;height: 120px"/></div>
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
        $('#story_type').select2();
        $('#category_id').select2();
        $('#festival_id').select2();

        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
        });
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

    $("#image").change(function () {
        imagePreview(this);
    });
  
    $("#story_type").change(function() {
        $('#otherText').empty();
        if($(this).find("option:selected").text() == "Category")
        {
            $('#otherText').append('<div class="row"><div class="col-sm-3"><label class="col-form-label">Select Category</label></div><div class="col-sm-4"><select id="category_id" name="category_id" class="form-control" required><option value="">Select Category</option>@foreach($category as $c)<option value="{{$c->id}}">{{$c->name}}</option>@endforeach</select></div></div>');
        }
        if($(this).find("option:selected").text() == "Festival")
        {
            $('#otherText').append('<div class="row"><div class="col-sm-3"><label class="col-form-label">Select Festival</label></div><div class="col-sm-4"><select id="festival_id" name="festival_id" class="form-control" required><option value="">Select Festival</option>@foreach($festival as $f)<option value="{{$f->id}}">{{$f->title}}</option>@endforeach</select></div></div>');
        }
        if($(this).find("option:selected").text() == "Custom")
        {
            $('#otherText').append('<div class="row"><div class="col-sm-3"><label class="col-form-label">Select Custom Category</label></div><div class="col-sm-4"><select id="custom_category_id" name="custom_category_id" class="form-control" required><option value="">Select Custom Category</option>@foreach($custom as $c)<option value="{{$c->id}}">{{$c->name}}</option>@endforeach</select></div></div>');
        }
        if($(this).find("option:selected").text() == "External Link")
        {
            $('#otherText').append('<div class="row"><div class="col-sm-3"><label class="col-form-label">External Link Title</label></div><div class="col-sm-4"><input type="text" id="external_link_title" class="form-control" name="external_link_title" placeholder="Enter Title"></div></div>');
            $('#otherText').append('<div class="row"><div class="col-sm-3"><label class="col-form-label mt-3">External Link</label></div><div class="col-sm-4 mt-3"><input type="text" id="external_link" class="form-control" name="external_link" placeholder="http://www.google.com"></div></div>');
        }
        if($(this).find("option:selected").text() == "Subscription Plan")
        {
            $('#otherText').append('<div class="row"><div class="col-sm-3"><label class="col-form-label">Subscription Plan</label></div><div class="col-sm-4"><select id="plan_id" name="plan_id" class="form-control" required><option value="">Select Subscription Plan</option>@foreach($plan as $p)<option value="{{$p->id}}">{{$p->plan_name}}</option>@endforeach</select></div></div>');
        }
        $('#category_id').select2();
        $('#festival_id').select2();
        $('#custom_category_id').select2();
        $('#plan_id').select2();
    });
</script>
@endsection