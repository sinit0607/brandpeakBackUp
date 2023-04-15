@extends('layouts.app')

@section('extra_css')
<style type="text/css">
.profile_img{
    height: 100px;
    width: 100px;
    border: 1px solid #eee;
    position: absolute;
    left: 50%;
    top: 0;
    transform: translate(-50%,-50%);
}

.userCard{
    position:relative;
    width: 100%;
    border-radius: 5px;
    border: none;
    
}

.panel-title {
	cursor:pointer;
}
h4.tab-title
{
	font-family: "avenirheavy", Helvetica, Arial, "sans-serif";
	font-weight: normal;
	font-size: 22px;
	color: #ffffff;
}
.vertab-content ul, .vertab-content ol {
	padding-left: 15px;
}
@media (min-width:768px) {
.vertab-container {
	z-index: 10;
	background-color: #fff;
	padding: 0 !important;
	margin-top: 20px;
	background-clip: padding-box;
	opacity: 0.97;
	filter: alpha(opacity=97);
	overflow: auto;
	margin-bottom: 50px;
}
.vertab-menu {
	padding-right: 0;
	padding-left: 0;
	padding-bottom: 0;
	display: block;
	background-color: #ffff;
}
.vertab-menu .list-group {
	margin-bottom: 0;
}
.vertab-menu .list-group>a {
	margin-bottom: 0;
	border-radius: 0;
}
.vertab-menu .list-group>a, .vertab-menu .list-group>a {
	color: #818181;
	background-image: none;
	background-color: #F6F6F6;
	border-radius: 0;
	box-sizing: border-box;
	border: none;
	border-bottom: 1px solid #CACACA;
	padding: 15px 10px;
}
.vertab-menu .list-group>a.active, .vertab-menu .list-group>a:hover, .vertab-menu .list-group>a:focus {
	position: relative;
	border: none;
	border-radius: 0;
	border-bottom: 1px solid #CACACA;
	border-left: 5px solid #7952b3;
	padding-left: 5px;
	background-image: none;
	background-color: #F6F6F6;
	color: #7952b3;
}
.vertab-content {
	padding-left: 20px;
	padding-top: 10px;
	color: #000;
}
.vertab-accordion .vertab-content:not(.active) {
	display: none;
}
.vertab-accordion .vertab-content.active .collapse {
	display: block;
}	
.vertab-container .panel-heading {
	display: none;
}
.vertab-container .panel-body {
	border-top: none !important;
}
}

/* If the tc_breakpoint variable is changed, this breakpoint should be changed as well */
@media (max-width:767px) {
.vertab-container {
	margin-top: 20px;
	margin-bottom: 20px;
}
.vertab-container .vertab-menu {
	display: none;
}
.vertab-container .panel-heading {
	background-color: #F6F6F6;
	color: #818181;
	padding: 15px;
	border-bottom: 1px solid #F6F6F6;
	border-top-left-radius: 0;
	border-top-right-radius: 0;
	border-left: 5px solid #F6F6F6;
}
.vertab-container .panel-heading:hover, .vertab-container .panel-heading:focus, .vertab-container .panel-heading.active {
	border-left: 5px solid #7952b3;
	border-bottom: 1px solid #7952b3;
}
.vertab-content {
	border-bottom: 1px solid #CACACA;
}
.vertab-container .panel-title a:focus, .vertab-container .panel-title a:hover, .vertab-container .panel-title a:active {
	color: #818181;
	text-decoration: none;
}
.panel-collapse.collapse, .panel-collapse.collapsing {
	background-color: #ffffff !important;
	color: #000;
}
.vertab-container .panel-collapse .panel-body {
	border-top: none !important;
}
}

.switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 25px;
}

/* Hide default HTML checkbox */
.switch input {display:none;}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 16px;
  width: 16px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

.select2-container
{
    display: inline;
}

.notification {
  position: relative;
  display: inline-block;
}

.notification .badge {
  position: absolute;
  top: -7px;
  right: -7px;
}
.list-group-item+.list-group-item.active {
    margin-top: 0px;
}
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header border-bottom">
                <h3 class="card-title"><b>User Detail</b></h3>
            </div>

            <div class="card-body" style="background-color:#f1f3f4;">
                <div class="row">
                    <div class="col-md-8 mt-2">
                        <div class="card card-light shadow bg-white rounded" style="margin-top:50px;">
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
                                <div class="container">
                                    <div class="row vertab-container">
                                        @if($data->user_type != "Super Admin" && $data->user_type != "Demo")
                                        <div class="col-lg-3 col-md-4 col-12 vertab-menu">
                                            <div class="list-group">
                                                <a href="#" class="list-group-item text-left"><img type="image" class="mr-2" src="{{asset('assets/images/add_user_Icon/Edit profile_icon.svg')}}" alt="Image">Edit Profile</a>
                                                <a href="#" class="list-group-item text-left"><img type="image" class="mr-2" src="{{asset('assets/images/add_user_Icon/Business.svg')}}" alt="Image">Business</a>
                                                <a href="#" class="list-group-item text-left"><img type="image" class="mr-2" src="{{asset('assets/images/add_user_Icon/Subscription_Icon.svg')}}" alt="Image">Subscription</a>
                                                <a href="#" class="list-group-item text-left"><img type="image" class="mr-2" src="{{asset('assets/images/add_user_Icon/Transication.svg')}}" alt="Image">Transaction</a>
                                                <a href="#" class="list-group-item text-left"><img type="image" class="mr-2" src="{{asset('assets/images/add_user_Icon/Custom Frame.svg')}}" alt="Image">Custom Frame</a>
                                                <a href="#" class="list-group-item text-left"><i class="fa-solid fa-sack-dollar mr-2 text-primary fa-lg"></i> Earning</a>
                                                <a href="#" class="list-group-item text-left"><i class="fa-solid fa-coins mr-2 text-primary fa-lg"></i> Earning History</a>
                                            </div>
                                        </div>
                                        @endif
                                        <div id="accordion" class="col-lg-8 col-md-8 col-12 vertab-accordion panel-group"> 
                                            <div class="vertab-content">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" data-target="#collapse1">
                                                        Edit Profile
                                                    </h4>
                                                </div>
                                                <div id="collapse1" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        {!! Form::open(['route' => ['user.update',$data->id],'method'=>'PATCH','files'=>true]) !!}
                                                        {!! Form::hidden('id',$data->id) !!}

                                                        @if (count($errors) > 0)
                                                            <div class="alert alert-danger">
                                                                <ul>
                                                                    @foreach ($errors->all() as $error)
                                                                    <li>{{ $error }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endif

                                                        <div class="row mt-3">
                                                            <div class="col-12">
                                                                <div class="form-group row">
                                                                    {!! Form::label('name','Name', ['class' => 'col-xl-3 col-md-3 col-3 col-form-label']) !!}
                                                                    <div class="col-xl-9 col-md-9 col-9">
                                                                        {!! Form::text('name',$data->name,['class' => 'form-control','required']) !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group row">
                                                                    {!! Form::label('email','Email', ['class' => 'col-xl-3 col-md-3 col-3 col-form-label']) !!}
                                                                    <div class="col-xl-9 col-md-9 col-9">
                                                                        {!! Form::email('email',$data->email,['class'=>'form-control','required']) !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group row">
                                                                    {!! Form::label('mobile_no','Mobile No', ['class' => 'col-xl-3 col-md-3 col-3 col-form-label']) !!}
                                                                    <div class="col-xl-9 col-md-9 col-9">
                                                                        {!! Form::number('mobile_no',$data->mobile_no,['class' => 'form-control','required']) !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group row">
                                                                    {!! Form::label('password', 'Password', ['class' => 'col-xl-3 col-md-3 col-3 col-form-label']) !!}
                                                                    <div class="col-xl-9 col-md-9 col-9">
                                                                        {!! Form::password('password', ['class' => 'form-control']) !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        @if($data->user_type != "Super Admin" && $data->user_type != "Demo")
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group row">
                                                                    {!! Form::label('role', 'User Role', ['class' => 'col-sm-3 col-form-label']) !!}
                                                                    <div class="col-sm-9">
                                                                        <select id="role_id" name="role_id" class="form-control">
                                                                            <option value="">Select Role</option>
                                                                            @foreach($roles as $role)         
                                                                            <option value="{{$role->id}}" @if($data->roles->first() != null) @if($data->roles->first()->id == $role->id) selected @endif @endif>{{$role->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif

                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group row">
                                                                    {!! Form::label('image','Select Image', ['class' => 'col-xl-3 col-md-3 col-3 col-form-label']) !!}
                                                                    <div class="col-xl-9 col-md-9 col-9">
                                                                        {!! Form::file('image', null,['class' => 'form-control','required']) !!}
                                                                        @if($data->image)
                                                                        <img src="@if(substr($data->image, 0, 4)=="http") {{$data->image}} @else @if(App\Models\StorageSetting::getStorageSetting("storage") == "DigitalOcean"){{\Storage::disk('spaces')->url('uploads/'.$data->image)}} @else {{asset('uploads/'.$data->image)}} @endif @endif" class="mt-2" width="100px" height="100px">
                                                                        @endif
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
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="vertab-content">
                                                <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" data-target="#collapse2">
                                                    <h4 class="panel-title">
                                                        Business
                                                    </h4>
                                                </div>
                                                <div id="collapse2" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <div class="card" style="background-color: #cdf4fa;">
                                                            <div class="card-body text-center">
                                                                <a href="{{ url('admin/user-business/'.$data->id) }}"><span class="border rounded-circle p-3" style="background-color: #ffffff;"><i class="fa-solid fa-plus fa-xl"></i></span></a>
                                                            </div>
                                                        </div>
                                                        @foreach($business as $b)
                                                        <div class="card">
                                                            <div class="card-body d-flex flex-row">
                                                                <img class="rounded-circle shadow ml-2 my-auto" src="@if($b->logo) @if(App\Models\StorageSetting::getStorageSetting('storage') == 'DigitalOcean'){{\Storage::disk('spaces')->url('uploads/'.$b->logo)}} @else {{asset('uploads/'.$b->logo)}} @endif @else {{asset('assets/images/user-noimage.png')}} @endif" width="60px" height="60px">
                                                                <div class="d-flex flex-column ml-2">
                                                                    <span class="d-block font-weight-bold my-auto name"><a href="{{url('admin/business/'.$b->id) }}" class="ml-3 text-dark" style="font-size:22px;"><b>{{$b->name}}</b></a></span>
                                                                    <span>
                                                                        <div class="btn-group ml-3">
                                                                            <a href="{{url('admin/business/'.$b->id) }}" class="my-auto text-secondary"><span aria-hidden="true" class="fa fa-eye fa-xl"></span></a>
                                                                            <label class="switch mx-2 my-auto">
                                                                                <input type="checkbox" name="status" data-id="{{$b->id}}" value="1" class="status" @if($b->status==1) checked @endif>
                                                                                <span class="slider round"></span>
                                                                            </label>
                                                                            <a href="{{url('admin/business/'.$b->id.'/edit') }}"><button type="button" class="btn btn-success" style="padding: .10rem .40rem .10rem .40rem;"><span aria-hidden="true" class="fa fa-edit fa-sm"></span></button></a>
                                                                            <a data-id="{{$b->id}}" data-toggle="modal" data-target="#myModal"><button type="button" class="btn btn-danger ml-2" style="padding: .10rem .40rem .10rem .40rem;"><span aria-hidden="true" class="fa fa-trash fa-sm"></span></button></a>
                                                                        </div>
                                                                        {!! Form::open(['url' => 'admin/business/'.$b->id,'method'=>'DELETE','class'=>'form-horizontal','id'=>'form_'.$b->id]) !!}
                                                                        {!! Form::hidden("id",$b->id) !!}
                                                                        {!! Form::close() !!}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="vertab-content">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" data-target="#collapse3">
                                                        Subscription
                                                    </h4>
                                                </div>
                                                <div id="collapse3" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        {!! Form::open(['url' => 'admin/subscription-update','method'=>'post','files'=>true]) !!}
                                                        {!! Form::hidden('id',$data->id)!!}
                                                        @if (count($errors) > 0)
                                                            <div class="alert alert-danger">
                                                                <ul>
                                                                    @foreach ($errors->all() as $error)
                                                                    <li>{{ $error }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endif
                                                        <div class="row mt-5">
                                                            <div class="col-12">
                                                                <div class="form-group row">
                                                                    {!! Form::label('plan','Select Plan', ['class' => 'col-sm-4 col-form-label']) !!}
                                                                    <div class="col-sm-8">
                                                                        <select id="plan" name="plan" class="form-control" required>
                                                                            <option value="">Select Plan</option>
                                                                            @foreach($subscription as $sub)
                                                                            <option value="{{$sub->id}}" @if($sub->id == $data->subscription_id) selected @endif>{{$sub->plan_name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group row">
                                                                    {!! Form::label('subscription_start_from','Subscription Start From', ['class' => 'col-sm-4 col-form-label']) !!}
                                                                    <div class="col-sm-8">
                                                                        {!! Form::text('subscription_start_from',($data->subscription_start_date)?date('d M, y',strtotime($data->subscription_start_date)):"",['class' => 'form-control datepicker','required','placeholder'=>'Ex 02 Jan, 22',"autocomplete"=>"off"]) !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group row">
                                                                    {!! Form::label('subscription_start_to','Subscription Start To', ['class' => 'col-sm-4 col-form-label']) !!}
                                                                    <div class="col-sm-8">
                                                                        {!! Form::text('subscription_start_to',($data->subscription_end_date)?date('d M, y',strtotime($data->subscription_end_date)):"",['class' => 'form-control datepicker','required','placeholder'=>'Ex 02 Jan, 22',"autocomplete"=>"off"]) !!}
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
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="vertab-content">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" data-target="#collapse4">
                                                        Transaction
                                                    </h4>
                                                </div>
                                                <div id="collapse4" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <table class="table table-bordered">
                                                            <thead class="thead-inverse" style="background-color: #cdf4fa;">
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Plan</th>
                                                                    <th>Payment</th>
                                                                    <th>Date</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($transaction as $t)
                                                                <tr>
                                                                    <td>{{$t->id}}</td>
                                                                    <td>@if($t->subscription_id){{$t->subscription->plan_name}}@endif</td>
                                                                    <td>{{$t->total_paid}}</td>
                                                                    <td>{{date('d M, y',strtotime($t->date))}}</td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="vertab-content">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" data-target="#collapse5">
                                                        Custom Frame
                                                    </h4>
                                                </div>
                                                <div id="collapse5" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <div class="card" style="background-color: #cdf4fa;">
                                                            <div class="card-body text-center">
                                                                <span class="border rounded-circle p-3 plusButton" data-toggle="modal" data-target="#customModal" style="background-color: #ffffff;"><i class="fa-solid fa-plus fa-xl"></i></span>
                                                            </div>
                                                        </div>
                                                        @foreach($customFrame as $c)
                                                        <div class="card">
                                                            <div class="card-body d-flex flex-row">
                                                                <img class="rounded-circle shadow ml-2 my-auto" src="@if($c->frame_image) @if(App\Models\StorageSetting::getStorageSetting('storage') == 'DigitalOcean'){{\Storage::disk('spaces')->url('uploads/'.$c->frame_image)}} @else {{asset('uploads/'.$c->frame_image)}} @endif @else {{asset('assets/images/no-image.png')}} @endif" width="60px" height="60px">
                                                                <div class="d-flex flex-column ml-2">
                                                                    <span class="d-block font-weight-bold my-auto name ml-3 text-dark" style="font-size:22px;"><b>{{$c->user->name}}</b></span>
                                                                    <span>
                                                                        <div class="btn-group ml-3">
                                                                            <div class="my-auto text-secondary plusButton" data-url="@if(App\Models\StorageSetting::getStorageSetting('storage') == 'DigitalOcean'){{\Storage::disk('spaces')->url('uploads/'.$c->frame_image)}} @else {{asset('uploads/'.$c->frame_image)}} @endif" data-toggle="modal" data-target="#customModal1"><span aria-hidden="true" class="fa fa-eye fa-xl"></span></div>
                                                                            <label class="switch mx-2 my-auto">
                                                                                <input type="checkbox" name="status" data-id="{{$c->id}}" value="1" class="status1" @if($c->status==1) checked @endif>
                                                                                <span class="slider round"></span>
                                                                            </label>
                                                                            <button type="button" class="btn btn-success" data-url="@if(App\Models\StorageSetting::getStorageSetting('storage') == 'DigitalOcean'){{\Storage::disk('spaces')->url('uploads/'.$c->frame_image)}} @else {{asset('uploads/'.$c->frame_image)}} @endif" data-id="{{$c->id}}" style="padding: .10rem .40rem .10rem .40rem;" data-toggle="modal" data-target="#customModal2"><span aria-hidden="true" class="fa fa-edit fa-sm"></span></button></a>
                                                                            <a data-id="{{$c->id}}" data-toggle="modal" data-target="#customModalDel"><button type="button" class="btn btn-danger ml-2" style="padding: .10rem .40rem .10rem .40rem;"><span aria-hidden="true" class="fa fa-trash fa-sm"></span></button></a>
                                                                        </div>
                                                                        {!! Form::open(['url' => 'admin/custom-frame/'.$c->id,'method'=>'DELETE','class'=>'form-horizontal','id'=>'form1_'.$c->id]) !!}
                                                                        {!! Form::hidden("id",$c->id) !!}
                                                                        {!! Form::close() !!}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="vertab-content">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" data-target="#collapse6">
                                                        Earning
                                                    </h4>
                                                </div>
                                                <div id="collapse6" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <div class="card" style="border-radius: 7px;">
                                                                    <div class="card-body" style="border-radius: 7px;background-color: #FF3EA6;color:white;">
                                                                        <h5><b style="font-size:17px;">Referral Code</b></h5>
                                                                        <p class="card-text">@if($data->referral_code) {{$data->referral_code}} @endif</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="card" style="border-radius: 7px;">
                                                                    <div class="card-body" style="border-radius: 7px;background-color: #1E9FF2;color:white;">
                                                                        <h5><b style="font-size:17px;">Current Balance</b></h5>
                                                                        <p class="card-text">{{$data->current_balance}}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="card" style="border-radius: 7px;">
                                                                    <div class="card-body" style="border-radius: 7px;background-color: #FF9F43;color:white;">
                                                                        <h5><b style="font-size:17px;">Total Balance</b></h5>
                                                                        <p class="card-text">{{$data->total_balance}}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <h5>Refer User</h5>
                                                        <table class="table table-bordered">
                                                            <thead class="thead-inverse" style="background-color: #cdf4fa;">
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>User</th>
                                                                    <th>Date</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($referralRegister as $r)
                                                                <tr>
                                                                    <td>{{$r->user->id}}</td>
                                                                    <td>{{$r->user->name}}</td>
                                                                    <td>{{date('d M, y',strtotime($r->created_at))}}</td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>

                                                        <h5 class="mt-5">Subscription Using Refer Code</h5>
                                                        <table class="table table-bordered">
                                                            <thead class="thead-inverse" style="background-color: #cdf4fa;">
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>User</th>
                                                                    <th>Plan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($referralRegister as $rr)
                                                                    @if($rr->subscription == 1)
                                                                    <tr>
                                                                        <td>{{$rr->user->id}}</td>
                                                                        <td>{{$rr->user->name}}</td>
                                                                        <td>{{$rr->user->subscription->plan_name}}</td>
                                                                    </tr>
                                                                    @endif
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="vertab-content">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" data-target="#collapse7">
                                                        Earning History
                                                    </h4>
                                                </div>
                                                <div id="collapse7" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <table class="table table-bordered">
                                                            <thead class="thead-inverse" style="background-color: #cdf4fa;">
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>User</th>
                                                                    <th>Amount</th>
                                                                    <th>Date</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($earningHistory as $h)
                                                                <tr>
                                                                    <td>{{$h->id}}</td>
                                                                    <td>@if($h->refer_user){{$h->referUser->name}}@endif</td>
                                                                    <td>@if($h->amount_type == 1)+@else-@endif{{$h->amount}}</td>
                                                                    <td>{{date('d M, y',strtotime($h->created_at))}}</td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mt-2">
                        <div class="card card-light shadow bg-white rounded userCard" style="margin-top:50px;">
                            <div class="w-100">
                                <img src="@if($data->image) @if(substr($data->image, 0, 4)=="http") {{$data->image}} @else @if(App\Models\StorageSetting::getStorageSetting("storage") == "DigitalOcean"){{\Storage::disk('spaces')->url('uploads/'.$data->image)}} @else {{asset('uploads/'.$data->image)}} @endif @endif @else {{asset('assets/images/no-user.jpg')}} @endif" alt="Profile Image" class="rounded-circle profile_img shadow bg-white rounded">
                                <div class="card-body">
                                    
                                    <div class="row mt-5">
                                        <div class="col-12">
                                            <div class="form-group row">
                                                {!! Form::label('name','Name', ['class' => 'col-sm-4 col-form-label text-primary']) !!}
                                                <span class="my-auto col-sm-8">{{$data->name}}</sapn>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group row">
                                                {!! Form::label('email','Email', ['class' => 'col-sm-4 col-form-label text-primary']) !!}
                                                <span class="my-auto col-sm-8">{{$data->email}}</sapn>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group row">
                                                {!! Form::label('mobile_no','Mobile No', ['class' => 'col-sm-4 col-form-label text-primary']) !!}
                                                <span class="my-auto col-sm-8">{{$data->mobile_no}}</sapn>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group row">
                                                {!! Form::label('created_at','Entry', ['class' => 'col-sm-4 col-form-label text-primary']) !!}
                                                <span class="my-auto col-sm-8">{{$data->created_at->format('d/m/Y')}}</sapn>
                                            </div>
                                        </div>
                                    </div>

                                    @if($data->user_type != "Super Admin" && $data->user_type != "Demo")
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group row">
                                                {!! Form::label('current_plan','Current Plan', ['class' => 'col-sm-4 col-form-label text-primary']) !!}
                                                <span class="my-auto col-sm-8">@if($data->subscription_id){{$data->subscription->plan_name}}@endif</sapn>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group row">
                                                {!! Form::label('sub_date','Subscription Date', ['class' => 'col-sm-4 col-form-label text-primary']) !!}
                                                <span class="my-auto col-sm-8">@if($data->subscription_start_date){{date('d M, y',strtotime($data->subscription_start_date))}}@endif</sapn>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group row">
                                                {!! Form::label('expire_date','Expire Date', ['class' => 'col-sm-4 col-form-label text-primary']) !!}
                                                <span class="my-auto col-sm-8">@if($data->subscription_end_date){{date('d M, y',strtotime($data->subscription_end_date))}}@endif</sapn>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Delete</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to Delete ?</p>
        </div>
        <div class="modal-footer">
            @if(Auth::user()->user_type == "Demo")
            <button type="button" class="btn btn-danger ToastrButton">Delete</button>
            @else
            <button id="del_btn" class="btn btn-danger" type="button" data-submit="">Delete</button>
            @endif
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
<!-- Modal -->

<!-- Modal -->
<div id="customModalDel" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Delete</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to Delete ?</p>
        </div>
        <div class="modal-footer">
            @if(Auth::user()->user_type == "Demo")
            <button type="button" class="btn btn-danger ToastrButton">Delete</button>
            @else
            <button id="custom_btn" class="btn btn-danger" type="button" data-submit="">Delete</button>
            @endif
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
<!-- Modal -->

<!-- Modal -->
<div class="modal fade" id="customModal" tabindex="-1" role="dialog" aria-labelledby="customModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="customModalLabel">Add Custom Frame</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        @if (count($errors) > 0)
            <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            </div>
        @endif

        {!! Form::open(['route' => 'custom-frame.store','method'=>'post','files'=>true]) !!}
        {!! Form::hidden('user_id',$data->id)!!}
        <div class="row">
            <div class="col-12">
                <div class="form-group row">
                    {!! Form::label('frame_image',' Select Frame Images', ['class' => 'col-sm-12 col-form-label']) !!}
                    <input class="form-control col-sm-12" type="file" onchange="imagePreview()" id="frame_image" name="frame_image[]" accept=".jpg, .png, jpeg, .PNG, .JPG, .JPEG" multiple required>
                    <div class="border p-3 mt-3 col-sm-12" id="preview"></div>
                </div>
                <input type="hidden" name="deleted_file_ids" class="deleted_file_ids" id="deleted_file_ids"  value="">
            </div>
        </div>
        @if(Auth::user()->user_type == "Demo")
        <button type="button" class="btn btn-primary ToastrButton">Save</button>
        @else
        <button type="submit" class="btn btn-primary">Save</button>
        @endif
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="customModal1" tabindex="-1" role="dialog" aria-labelledby="customModal1Label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="customModal1Label">View Custom Frame</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img src="{{asset('assets/images/no-image.png')}}" id="show_image" class="border rounded shadow bg-white" alt="Image" width="auto" height="150px"/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="customModal2" tabindex="-1" role="dialog" aria-labelledby="customModal2Label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="customModal2Label">Update Custom Frame</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            </div>
        @endif

        <form action="" method="POST" id="edit_url" enctype="multipart/form-data">
        @csrf
        <input name="_method" type="hidden" value="PATCH">
        <input type="hidden" id="id" name="id" value="">
        <div class="row">
            <div class="col-12">
                <div class="form-group row">
                    <label for="frame_image" class="col-sm-12 col-form-label">Select Custom Frame Images</label>
                    <input class="form-control col-sm-12" type="file" id="frame_image3" name="frame_image" accept=".jpg, .png, jpeg, .PNG, .JPG, .JPEG">
                    <div class="border p-3 mt-3 col-sm-12" id="preview3"><img src="{{asset('assets/images/no-image.png')}}" id="edit_image" class="border rounded shadow bg-white mt-3" alt="Image" width="auto" height="150px"/></div>
                </div>
            </div>
        </div>
        @if(Auth::user()->user_type == "Demo")
        <button type="button" class="btn btn-primary ToastrButton">Save</button>
        @else
        <button type="submit" class="btn btn-primary">Save</button>
        @endif
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section("script")
<script type="text/javascript">
    $('#role_id').select2();    
    $('.plusButton').css('cursor', 'pointer');

    $('.datepicker').datepicker({
        dateFormat: 'dd M, y',
        minDate:'today',  
    });

    $("#del_btn").on("click",function(){
        var id=$(this).data("submit");
        $("#form_"+id).submit();
    });

    $('#myModal').on('show.bs.modal', function(e) {
        var id = e.relatedTarget.dataset.id;
        $("#del_btn").attr("data-submit",id);
    });

    $('#customModalDel').on('show.bs.modal', function(e) {
        var id = e.relatedTarget.dataset.id;
        $("#custom_btn").attr("data-submit",id);
    });

    $("#custom_btn").on("click",function(){
        var id=$(this).data("submit");
        $("#form1_"+id).submit();
    });

    $('#customModal1').on('show.bs.modal', function(e) {
        var url = e.relatedTarget.dataset.url;
        $("#show_image").attr("src",url);
    });

    $('#customModal2').on('show.bs.modal', function(e) {
        var id = e.relatedTarget.dataset.id;
        var url = e.relatedTarget.dataset.url;
        $("#edit_image").attr("src",url);
        $("#id").attr("value",id);
        var new_url = "{{ url('admin/custom-frame/:id') }}".replace(':id', id);
        $("#edit_url").attr("action", new_url)
    });

    $(".status").change(function(){
      var checked = $(this).is(':checked');
      var id = $(this).data("id");
     
      $.ajax({
        type: "POST",
        url: "{{url('admin/business-status')}}",
        data: { checked : checked , id : id},
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(data) {
          new PNotify({
            title: 'Success!',
            text: "Business Status Has Been Changed.",
            type: 'success'
          });
        },
      });
    });

    $(".status1").change(function(){
      var checked = $(this).is(':checked');
      var id = $(this).data("id");
     
      $.ajax({
        type: "POST",
        url: "{{url('admin/custom-frame-status')}}",
        data: { checked : checked , id : id},
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(data) {
          new PNotify({
            title: 'Success!',
            text: "Custom Frame Status Has Been Changed.",
            type: 'success'
          });
        },
      });
    });

    window.newFileList = [];

    function imagePreview(fileInput) 
    { 
        var total_file=document.getElementById("frame_image").files.length;
        for(var i=0;i<total_file;i++)
        {
            $('#preview').append("<div class='notification mt-3'><img class='img-responsive mr-3' src='"+URL.createObjectURL(event.target.files[i])+"' style='width:200px;height:auto;'><p class='remove pull-right bg-danger' style='cursor:pointer;position: absolute;top: 0px;right: 15px;padding: 6px 10px;' id='"+i+"'><i class='fa fa-close'></i></p></span></div>");
        }
    }

    $('.remove').css('cursor', 'pointer');

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

    function imagePreview3(fileInput) 
    { 
        if (fileInput.files && fileInput.files[0]) 
        {
            var fileReader = new FileReader();
            fileReader.onload = function (event) 
            {
                $('#preview3').html('<img src="'+event.target.result+'" class="shadow bg-white rounded" width="120px" alt="Select Image" height="120px"/>');
            };
            fileReader.readAsDataURL(fileInput.files[0]);
        }
    }

    $("#frame_image3").change(function () {
        imagePreview3(this);
    });

$(document).ready(function()
{
    $('#plan').select2();
    $("#plan").change(function(){
      var value = $(this).val();
      
      $.ajax({
        type: "GET",
        url: "{{url('admin/user-get-plan')}}",
        data: { id : value},
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(data) {
          $("#subscription_start_from").val(data['start_date']);
          $("#subscription_start_to").val(data['end_date']);
        },
      });
    });
});
</script>

<script>
// Screen-width breakpoint
var tc_breakpoint = 767;

jQuery(document).ready(function() 
{
	"use strict";
	
	// Switch tabs and update panels classes - Adjust container height
    jQuery(".vertab-container .vertab-menu .list-group a").click(function(e) 
	{
        
        var index = jQuery(this).index();
		var container = jQuery(this).parents('.vertab-container');
		var accordion = container.find('.vertab-accordion');
		var contents = accordion.find(".vertab-content");
		
		e.preventDefault();
		
        jQuery(this).addClass("active");
        jQuery(this).siblings('a.active').removeClass("active");
        
		contents.removeClass("active");
        contents.eq(index).addClass("active");
		container.data('current',index);
        //alert(jQuery(container).height());
		//Adjust container height
		//jQuery(this).parents('.vertab-menu').css('min-height',jQuery(container).children('.vertab-accordion').height());
    });
	
	// Collapse accordion panels (except the one the user just opened) and add "active" class to the panel heading 
	jQuery('.vertab-accordion').on('show.bs.collapse','.collapse', function() 
	{
		var accordion, container, current, index;
		
		accordion = jQuery(this).parents('.vertab-accordion');
		container = accordion.parents('.vertab-container');
		
		accordion.find('.collapse.in').each(function()
		{
			jQuery(this).collapse('hide');
		});		
		
		jQuery(this).siblings('.panel-heading').addClass('active');
		
		current = accordion.find('.panel-heading.active');
		index = accordion.find('.panel-heading').index(current);
		
		container.data('current',index);
	});
								   
	// Remove "active" class from heading when collapsing the current panel 
	jQuery('.vertab-accordion .panel-collapse').on('hide.bs.collapse', function () {
		jQuery(this).siblings('.panel-heading').removeClass('active');
	});	
	
	// Manage resize / rotation events
	jQuery( window ).on( "resize orientationchange", function(  ) 
	{
		resize_vertical_accordions();
	});
	
	// Scroll accordion to show the current panel
	jQuery(".vertab-accordion .panel-heading").click(function () 
	{
		var el = this;
		setTimeout(function(){jQuery("html, body").animate({scrollTop: jQuery(el).offset().top - 10 }, 1000);},500);
		
		return true;
	});
	
	//Initial Panels setup
	resize_vertical_accordions(  );
});

function resize_vertical_accordions(  ) 
{
	"use strict";
	jQuery('.vertab-container').each(function(i, e)
	{
		var index, menu, contents; 
		var container = jQuery(this);
		
		// Setup current tab/panel (default to first tab/panel)
		index = jQuery(this).data('current');
		if(index === undefined)
		{
			jQuery(this).data('index',0);
			index = 0;
		}
		
		// If using a desktop-size screen, manage as tabbed panels
		if( jQuery( window ).width() > tc_breakpoint)
		{
			// Reset panels heights (Bootstrap's accordions sets heights to zero)
			jQuery(this).find('.panel-collapse.collapse').css('height','auto');
			
			// Clean tab-navigation styles
			menu = jQuery(this).find('.vertab-menu .list-group a');
			menu.removeClass("active");

			// Clean tab-panels styles
			contents = jQuery(this).find(".vertab-accordion .vertab-content");
			contents.removeClass("active");
			
			// Update tab navigation and panels styles
			menu.eq(index).addClass('active');			
			contents.eq(index).addClass("active");
			
			// Update tab navigation's height to match current tab
			jQuery(this).children('.vertab-menu').css('min-height',jQuery(this).children('.vertab-accordion').height());			
		}
		else // If using a mobile device (phone + tablets), manage as accordion
		{
			// Close all panels
			jQuery(this).find('.vertab-content .panel-collapse.collapse').collapse('hide');
			
			// Clean styles from headings
			jQuery(this).find('.vertab-content .panel-heading').removeClass('active');
			
			// Wait until all panels have collapsed and mark the one the user selected as active.
			setTimeout(function()
			{
				jQuery(container).find('.vertab-content .panel-heading').eq(index).addClass("active");
				jQuery(container).find('.vertab-content .panel-collapse.collapse').eq(index).collapse('show');				
			},1000);

		}	
	});	
}
</script>
@endsection