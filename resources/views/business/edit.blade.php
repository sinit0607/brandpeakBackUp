@extends('layouts.app')

@section('extra_css')
<style type="text/css">

</style>
@endsection

@section('content')
<div class="container">
    <div class="card card-success">
        <div class="card-header">
        <h3 class="card-title">Edit Business</h3>
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

        {!! Form::open(['route' =>['business.update',$business->id],'method'=>'PATCH','files'=>true]) !!}
        {!! Form::hidden('user_id',Auth::user()->id)!!}
        {!! Form::hidden('id',$business->id)!!}
        <div class="row">
            <div class="col-12">
                <div class="form-group row">
                    {!! Form::label('name','Name', ['class' => 'col-sm-2 col-form-label']) !!}
                    <div class="col-sm-4">
                        {!! Form::text('name',$business->name,['class' => 'form-control','required','placeholder'=>'Enter Business Name']) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group row">
                    {!! Form::label('email','Email', ['class' => 'col-sm-2 col-form-label']) !!}
                    <div class="col-sm-4">
                        {!! Form::email('email',$business->email,['class' => 'form-control','required','placeholder'=>'Enter Business Email']) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group row">
                    {!! Form::label('mobile_no','Mobile No', ['class' => 'col-sm-2 col-form-label']) !!}
                    <div class="col-sm-4">
                        {!! Form::number('mobile_no',$business->mobile_no,['class' => 'form-control','required','placeholder'=>'Enter Business Mobile Number']) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group row">
                    {!! Form::label('address','Address', ['class' => 'col-sm-2 col-form-label']) !!}
                    <div class="col-sm-4">
                        {!! Form::textarea('address',$business->address,['class' => 'form-control','required','rows'=>4,'placeholder'=>'Enter Business Address']) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group row">
                    {!! Form::label('website','Website', ['class' => 'col-sm-2 col-form-label']) !!}
                    <div class="col-sm-4">
                        {!! Form::text('website',$business->website,['class' => 'form-control','required','placeholder'=>'Enter Business Website']) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group row">
                    {!! Form::label('category','Business Category', ['class' => 'col-sm-2 col-form-label','placeholder'=>'Enter Name']) !!}
                    <div class="col-sm-4">
                        <select id="business_category_id" name="business_category_id" class="form-control" required>
                            <option value="">Select Business Category</option>
                            @foreach($category as $c)
                                <option value="{{$c->id}}" @if($c->id == $business->business_category_id) selected @endif>{{$c->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group row">
                    {!! Form::label('logo','Logo', ['class' => 'col-sm-2 col-form-label']) !!}
                    <div class="col-sm-4">
                        <input class="form-control" type="file" id="logo" name="logo">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-9" id="preview"><img type="image" class="shadow bg-white rounded" src="@if($business->logo) @if(App\Models\StorageSetting::getStorageSetting('storage') == 'DigitalOcean'){{\Storage::disk('spaces')->url('uploads/'.$business->logo)}} @else {{asset('uploads/'.$business->logo)}} @endif @else {{asset('assets/images/no-user.jpg')}} @endif" alt="Image" style="width: 120px;height: 120px"/></div>
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
        $('#status_id').select2();
        $('#business_category_id').select2();
    });

    function imagePreview(fileInput) 
    { 
        if (fileInput.files && fileInput.files[0]) 
        {
            var fileReader = new FileReader();
            fileReader.onload = function (event) 
            {
                $('#preview').html('<img src="'+event.target.result+'" class="shadow bg-white rounded" width="120px" alt="Select Image" height="120px"/>');
            };
            fileReader.readAsDataURL(fileInput.files[0]);
        }
    }

    $("#logo").change(function () {
        imagePreview(this);
    });
</script>
@endsection