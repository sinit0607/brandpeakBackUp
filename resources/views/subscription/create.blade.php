@extends('layouts.app')

@section('heading')
<div class="mt-5">Add Subscription Plan</div>
@endsection

@section('extra_css')
<link rel="stylesheet" href="{{ asset('assets/css/clean-switch.css')}}">
<style type="text/css">

</style>
@endsection

@section('content')
    {!! Form::open(['route' => 'subscription-plan.store','method'=>'post','files'=>true]) !!}
    {!! Form::hidden('user_id',Auth::user()->id)!!}
    <div class="row mt-5">
        <div class="col-12">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row">
                                {!! Form::label('plan_name','Plan Name', ['class' => 'col-sm-3 col-form-label']) !!}
                                <div class="col-sm-9">
                                    {!! Form::text('plan_name', null,['class' => 'form-control','required','placeholder'=>'Enter Plan Name']) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row">
                                {!! Form::label('plan_price','Plan Price', ['class' => 'col-sm-3 col-form-label']) !!}
                                <div class="col-sm-9">
                                    {!! Form::number('plan_price', null,['class' => 'form-control','required','placeholder'=>'Enter Plan Price']) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row">
                                {!! Form::label('discount_price','Discount Price', ['class' => 'col-sm-3 col-form-label']) !!}
                                <div class="col-sm-9">
                                    {!! Form::number('discount_price', null,['class' => 'form-control','required','placeholder'=>'Enter Discount Price']) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row">
                                {!! Form::label('duration','Duration', ['class' => 'col-sm-3 col-form-label']) !!}
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-6">
                                            {!! Form::number('duration', null,['class' => 'form-control','required']) !!}
                                        </div>
                                        <div class="col-6">
                                            <select id="duration_type" name="duration_type" class="form-control" required>
                                                <option value="">Select Plan</option>
                                                <option value="Day">Day</option>
                                                <option value="Week">Week</option>
                                                <option value="Month">Month</option>
                                                <option value="Year">Year</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row">
                                {!! Form::label('business_limit','Business Limit', ['class' => 'col-sm-3 col-form-label']) !!}
                                <div class="col-sm-9">
                                    {!! Form::number('business_limit', null,['class' => 'form-control','required','placeholder'=>'Enter Business Limit']) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="row">
                        <div class="col-12">
                            <div class="form-group row">
                                {!! Form::label('google_product_enable','Google In Purchases', ['class' => 'col-sm-3 col-form-label']) !!}
                                <div class="col-sm-9">
                                    <label class="cl-switch cl-switch-blue mt-2">
                                        <input type="checkbox" id="google_product_enable" value="1" name="google_product_enable">
                                        <span class="switcher"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row google-product" style="display:none;">
                        <div class="col-12">
                            <div class="form-group row">
                                {!! Form::label('google_product_id','Google In-app Product Id', ['class' => 'col-sm-3 col-form-label']) !!}
                                <div class="col-sm-9 mt-3">
                                    {!! Form::text('google_product_id', null,['class' => 'form-control','id'=>'google_product_id','placeholder'=>'Enter Google In-app Product Id']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <small>* If You are using Google In-App Purchase, Set the price as you define in Play Console.</small><br>
                                <small>* Coupon Code Not Working in Google In-App Purchase Plan</small>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <b>Plan Details:</b>
                    <div class="card mt-3">
                        <div class="card-body text-center">
                            <span id="add_plan"><i class="fa-solid fa-plus fa-xl"></i></span>
                        </div>
                    </div>
                    <div id="add_text"></div>
                </div>
            </div> 
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 text-center">
        @if(Auth::user()->user_type == "Demo")
        <button type="button" class="btn btn-success ToastrButton">Save</button>
        @else
        {!! Form::submit('Save', ['class' => 'btn btn-success']) !!}
        @endif
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section("script")
<script type="text/javascript">
    $(document).ready(function() {
        $('#duration_type').select2();

        $('#google_product_enable').change(function(){
            if($(this).is(':checked'))
            {
                $(".google-product").css("display","block");
                $("#google_product_id").prop('required',true);
            }
            else
            {
                $(".google-product").css("display","none");
                $("#google_product_id").prop('required',false);
            }
        });
    });

    $(function() {
        var count = 1;
        $('#add_plan').on('click', function(e){
            e.preventDefault();
            $('#add_text').append('<div class="row mb-2"><div class="col-11"><input type="text" class="form-control" name="detail[data' + count +']" placeholder="Enter Detail"></div><div class="col-1"><button type="button" class="btn btn-danger remove"><i class="fa fa-xmark"></i></button></div></div>');
            count++;
        });
        $(document).on('click', 'button.remove', function( e ) {
            e.preventDefault();
            $(this).closest( 'div.row' ).remove();
        });
    });
</script>
@endsection