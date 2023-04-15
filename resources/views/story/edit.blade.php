@extends('layouts.app')

@section('extra_css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-lite.css" rel="stylesheet">
<style type="text/css">

</style>
@endsection

@section('content')
<div class="container">
    <div class="card card-success">
        <div class="card-header">
        <h3 class="card-title">Update Story</h3>
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

        {!! Form::open(['route' =>['story.update',$story->id],'method'=>'PATCH','files'=>true]) !!}
        {!! Form::hidden('user_id',Auth::user()->id)!!}
        {!! Form::hidden('id',$story->id)!!}
        <div class="row">
            <div class="col-12">
                <div class="form-group row">
                    {!! Form::label('story_type','Select Story Type', ['class' => 'col-sm-3 col-form-label']) !!}
                    <div class="col-sm-4">
                        <select id="story_type" name="story_type" class="form-control" required>
                            <option value="">Select Story Type</option>
                            <option value="category" @if($story->story_type == "category") selected @endif>Category</option>
                            <option value="festival" @if($story->story_type == "festival") selected @endif>Festival</option>
                            <option value="custom" @if($story->story_type == "custom") selected @endif>Custom</option>
                            <option value="externalLink" @if($story->story_type == "externalLink") selected @endif>External Link</option>
                            <option value="subscriptionPlan" @if($story->story_type == "subscriptionPlan") selected @endif>Subscription Plan</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group" id="otherText">
                    @if($story->category_id)
                        <div class="row">
                            {!! Form::label('category_id','Select Category', ['class' => 'col-sm-3 col-form-label']) !!}
                            <div class="col-sm-4">
                                <select id="category_id" name="category_id" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach($category as $c)
                                    <option value="{{$c->id}}" @if($story->category_id == $c->id) selected @endif>{{$c->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                    @if($story->festival_id)
                        <div class="row">
                            {!! Form::label('festival_id','Select Festival', ['class' => 'col-sm-3 col-form-label']) !!}
                            <div class="col-sm-4">
                                <select id="festival_id" name="festival_id" class="form-control">
                                    <option value="">Select Festival</option>
                                    @foreach($festival as $f)
                                    <option value="{{$f->id}}" @if($story->festival_id == $f->id) selected @endif>{{$f->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                    @if($story->custom_category_id)
                        <div class="row">
                            {!! Form::label('custom_category_id','Select Custom Category', ['class' => 'col-sm-3 col-form-label']) !!}
                            <div class="col-sm-4">
                                <select id="custom_category_id" name="custom_category_id" class="form-control">
                                    <option value="">Select Custom Category</option>
                                    @foreach($custom as $c)
                                    <option value="{{$c->id}}" @if($story->custom_category_id == $c->id) selected @endif>{{$c->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                    @if($story->external_link)
                        <div class="row">
                            {!! Form::label('external_link_title','External Link Title', ['class' => 'col-sm-3 col-form-label']) !!}
                            <div class="col-sm-4">
                                {!! Form::text('external_link_title', $story->external_link_title,['class' => 'form-control','placeholder'=>'Enter Title']) !!}
                            </div>
                        </div>
                        <div class="row">
                            {!! Form::label('external_link','External Link', ['class' => 'col-sm-3 col-form-label mt-3']) !!}
                            <div class="col-sm-4 mt-3">
                                {!! Form::text('external_link', $story->external_link,['class' => 'form-control','placeholder'=>'External Link']) !!}
                            </div>
                        </div>
                    @endif
                    @if($story->subscription_id)
                        <div class="row">
                            {!! Form::label('plan_id','Subscription Plan', ['class' => 'col-sm-3 col-form-label']) !!}
                            <div class="col-sm-4">
                                <select id="plan_id" name="plan_id" class="form-control">
                                    <option value="">Select Festival</option>
                                    @foreach($plan as $p)
                                    <option value="{{$p->id}}" @if($story->subscription_id == $p->id) selected @endif>{{$p->plan_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group row">
                    {!! Form::label('image',' Select Image', ['class' => 'col-sm-3 col-form-label']) !!}
                    <div class="col-sm-4">
                        <input class="form-control" type="file" id="image" name="image">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9" id="preview"><img src="@if(App\Models\StorageSetting::getStorageSetting('storage') == 'DigitalOcean'){{\Storage::disk('spaces')->url('uploads/'.$story->image)}} @else {{asset('uploads/'.$story->image)}} @endif" alt="Image" class="shadow bg-white rounded" width="auto" height="120px"></div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-lite.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#story_type').select2();
        $('#category_id').select2();
        $('#festival_id').select2();

        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
        });

        $('#desc_text').summernote({
            placeholder: '',
            tabsize: 2,
            height: 150
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