@extends('layouts.app')

@section('extra_css')
<style type="text/css">

</style>
@endsection

@section('content')
<div class="container">
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Add Business Card</h3>
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

            {!! Form::open(['route' => 'business-card.store','method'=>'post','files'=>true]) !!}
            {!! Form::hidden('user_id',Auth::user()->id)!!}
            <div class="row">
                <div class="col-12">
                    <div class="form-group row">
                        {!! Form::label('name','Name', ['class' => 'col-sm-2 col-form-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::text('name', null,['class' => 'form-control','placeholder'=>'Enter Business Card Name','required','autocomplete'=>"off"]) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="form-group row">
                        {!! Form::label('image','Select Image', ['class' => 'col-sm-2 col-form-label']) !!}
                        <div class="col-sm-4"><input class="form-control" type="file" id="image" name="image" required></div>
                    </div>
                    <div class="row"><div class="col-sm-2"></div><div class="col-sm-4" id="preview"><img type="image" class="shadow bg-white rounded" src="{{asset('assets/images/no-image.png')}}" alt="Image" style="width: auto;height: 120px"/></div></div>  
                </div>
            </div>

        <!-- <div class="row">
            <div class="col-6">
            <div class="form-group">
                {!! Form::label('status','Status', ['class' => 'form-label']) !!}
                <select id="status_id" name="status" class="form-control" required>
                    <option value="">Select Status</option>
                    <option value="1">Active</option>
                    <option value="0">Disabled</option>
                </select>
            </div>
            </div> -->

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
        $('#status_id').select2();
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
</script>
@endsection