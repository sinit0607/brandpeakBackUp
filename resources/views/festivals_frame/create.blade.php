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

hr.solid {
  border-top: 1px solid #bbb;
}
</style>
@endsection

@section('content')
<div class="container">
<div class="card card-success">
    <div class="card-header">
    <h3 class="card-title">Add Frame Image</h3>
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

    {!! Form::open(['route' => 'festivals-frame.store','method'=>'post','files'=>true]) !!}
    {!! Form::hidden('user_id',Auth::user()->id)!!}
    <input type="hidden" name="total" value="" id="total">
    <div class="row">
        <div class="col-12">
            <div class="form-group row">
                {!! Form::label('festivals','Select Festival', ['class' => 'col-sm-3 col-form-label','placeholder'=>'Enter Name']) !!}
                <div class="col-sm-4">
                    <select id="festivals_id" name="festivals_id" class="form-control" required>
                        <option value="">Select Festival</option>
                        @foreach($festivals as $f)
                            <option value="{{$f->id}}">{{$f->title}}</option>
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
                            <option value="{{$l->id}}">{{$l->title}}</option>
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
                <div class="col-sm-4">
                    <input class="form-control" type="file" id="frame_image" onchange="imagePreview()" name="frame_image[]" accept=".jpg, .png, jpeg, .PNG, .JPG, .JPEG" multiple required>
                </div>
                <input type="hidden" name="deleted_file_ids" class="deleted_file_ids" id="deleted_file_ids"  value="">
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
                <div class="col-sm-9"><div class="border p-3 mt-3" id="preview"></div></div>
            </div>
        </div>
    </div>

    <div id="add-container"></div>

    <div class="row">
        <div class="col-md-1 mt-3">
            <button type="button" class="btn btn-primary d-none" id="plus-btn"><i class="fas fa-plus"></i></button>
        </div>
        <div class="col-md-10 m-3 text-center">
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
        $('#festivals_id').select2();
        $('#language_id').select2();
    });

    function imagePreview(val) 
    { 
        $('#plus-btn').removeClass('d-none');
        if(val)
        {
            var total_file=document.getElementById("frame_image"+val).files.length;
            $('#preview'+val).empty();
        }
        else
        {
            var total_file=document.getElementById("frame_image").files.length;
            $('#preview').empty();
        }
        
        for(var i=0;i<total_file;i++)
        {
            if(val)
            {
                $('#preview'+val).append("<div class='notification'><img class='img-responsive mr-3 mt-3' src='"+URL.createObjectURL(event.target.files[i])+"' style='width:150px;height:auto;'></span></div>");
            }
            else
            {
                $('#preview').append("<div class='notification'><img class='img-responsive mr-3 mt-3' src='"+URL.createObjectURL(event.target.files[i])+"' style='width:150px;height:auto;'><p class='remove pull-right bg-danger' style='cursor:pointer;position: absolute;top: 15px;right: 15px;padding: 6px 10px;' id='"+i+"'><i class='fa fa-close'></i></p></span></div>");
            }
        }
    }

    $('.remove').css('cursor', 'pointer');

    window.newFileList = [];
    
    $(document).on('click', 'p.remove', function( e ) {
        e.preventDefault();
        var id = $(this).attr('id');
        $(this).closest( 'div.notification' ).remove();
        
            var input = document.getElementById('frame_image');
            var files = input.files;
            if (files.length) {
                if (typeof files[id] !== 'undefined') {
                    window.newFileList.push(files[id].name)
                }
            }
            document.getElementById('deleted_file_ids').value = JSON.stringify(window.newFileList);
            if($(".notification").length == 0) document.getElementById('frame_image').value="";
    });

    $(function() {
        var count = 1;
        var total = [];
        $('#plus-btn').on('click', function(e){
            e.preventDefault();
            $('#add-container').append('<hr class="solid">');
            $('#add-container').append('<div class="row mt-3"><div class="col-12"><div class="form-group row"><label class="col-sm-3 col-form-label">Select Language</label><div class="col-sm-4"><select id="language_id'+count+'" name="language_id'+count+'" class="form-control" required><option value="">Select Language</option>@foreach($language as $l)<option value="{{$l->id}}">{{$l->title}}</option>@endforeach</select></div></div></div></div>');
            $('#add-container').append('<div class="row"><div class="col-12"><div class="form-group row"><label class="col-sm-3 col-form-label">Select Frame Image</label><div class="col-sm-4"><input class="form-control" type="file" id="frame_image'+count+'" name="frame_image'+count+'[]" onchange="imagePreview('+count+')" accept=".jpg, .png, jpeg, .PNG, .JPG, .JPEG" multiple required></div></div><div class="row"><div class="col-sm-3" style="margin-top:-20px;"><small class="form-text text-muted">Recommendation Size:<ul><li>1024*1024 px (Square)</li><li>1080*1350 px (Portrait)</li><li>1280*720 px (Landscap)</li><li>1080*1920 px (Story)</li></ul></small></div><div class="col-sm-9"><div class="border p-3" id="preview'+count+'"></div></div></div></div></div>');
            $('#language_id'+count).select2();
            total.push(count);
            $('#total').val(total);
            count++;
        });
    });
</script>
@endsection