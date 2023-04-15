@extends('layouts.app')

@section('extra_css')
<link rel="stylesheet" href="{{ asset('assets/css/clean-switch.css')}}">
<style type="text/css">

</style>
@endsection

@section('content')
<div class="container">
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Referral System</h3>
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

            {!! Form::open(['url' => 'admin/referral-system','method'=>'post']) !!}
            {!! Form::hidden('user_id',Auth::user()->id)!!}
            <div class="row">
                <div class="col-12">
                    <div class="form-group row">
                        {!! Form::label('referral_system_enable', 'Referral System', ['class' => 'col-xl-2 col-md-3 col-3 col-form-label']) !!}
                        <div class="col-xl-6 col-md-4 col-4">
                            <label class="cl-switch cl-switch-blue">
                                <input type="checkbox" id="referral_system_enable" value="1" name="name[referral_system_enable]" @if(App\Models\ReferralSystem::getReferralSystem('referral_system_enable')==1) checked @endif>
                                <span class="switcher"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="form-group row">
                        {!! Form::label('register_point','Register Point', ['class' => 'col-sm-2 col-form-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::number('name[register_point]',App\Models\ReferralSystem::getReferralSystem('register_point'),['class' => 'form-control','placeholder'=>'Enter Register Point','required','autocomplete'=>"off"]) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="form-group row">
                        {!! Form::label('subscription_point','Subscription Point', ['class' => 'col-sm-2 col-form-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::number('name[subscription_point]',App\Models\ReferralSystem::getReferralSystem('subscription_point'),['class' => 'form-control','placeholder'=>'Enter Subscription Point','required','autocomplete'=>"off"]) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="form-group row">
                        {!! Form::label('withdrawal_limit','Withdrawal Limit', ['class' => 'col-sm-2 col-form-label']) !!}
                        <div class="col-sm-4">
                            {!! Form::number('name[withdrawal_limit]',App\Models\ReferralSystem::getReferralSystem('withdrawal_limit'),['class' => 'form-control','placeholder'=>'Enter Withdrawal Limit','required','autocomplete'=>"off"]) !!}
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
    $(document).ready(function() {
        
    });
</script>
@endsection