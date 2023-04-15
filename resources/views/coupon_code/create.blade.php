@extends('layouts.app')

@section('extra_css')
<style type="text/css">

</style>
@endsection

@section('content')
<div class="container">
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Add Coupon Code</h3>
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

            {!! Form::open(['route' => 'coupon-code.store','method'=>'post','files'=>true]) !!}
            {!! Form::hidden('user_id',Auth::user()->id)!!}
            <div class="row">
                <div class="col-12">
                    <div class="form-group row">
                        {!! Form::label('code','Code', ['class' => 'col-sm-2 col-form-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::text('code', null,['class' => 'form-control','placeholder'=>'Enter Coupon Code','maxlength' => 6,'required']) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="form-group row">
                        {!! Form::label('discount','Discount(%)', ['class' => 'col-sm-2 col-form-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::number('discount', null,['class' => 'form-control','placeholder'=>'Enter Discount','required']) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="form-group row">
                        {!! Form::label('limit','Limit', ['class' => 'col-sm-2 col-form-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::number('limit', null,['class' => 'form-control','placeholder'=>'Enter limit','required']) !!}
                        </div>
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

</script>
@endsection