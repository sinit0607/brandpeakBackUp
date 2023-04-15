@extends('layouts.app')

@section('extra_css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-lite.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/clean-switch.css')}}">
<style type="text/css">
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
.select2-container{
    display: inline;
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
                <h3 class="card-title"><b>Setting</b></h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mt-2">
                        @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="container-fluid">
                            <div class="row vertab-container">
                                <div class="col-lg-2 col-md-3 col-sm-12 vertab-menu">
                                    <div class="list-group">
                                        <a href="#" class="list-group-item text-left"><img type="image" class="mr-2" src="{{asset('assets/images/Setting Icon/App Setting.svg')}}" alt="Image">App Setting</a>
                                        <a href="#" class="list-group-item text-left"><i class="fas fa-ad fa-lg mr-1 text-primary"></i>Ads Setting</a>
                                        <a href="#" class="list-group-item text-left"><img type="image" class="mr-2" src="{{asset('assets/images/Setting Icon/Notification.svg')}}" alt="Image">Notification</a>
                                        <a href="#" class="list-group-item text-left"><img type="image" class="mr-2" src="{{asset('assets/images/Setting Icon/Email Setting.svg')}}" alt="Image">Email Setting</a>
                                        <a href="#" class="list-group-item text-left"><img type="image" class="mr-2" src="{{asset('assets/images/Setting Icon/Payment Setting.svg')}}" alt="Image">Payment Setting</a>
                                        <a href="#" class="list-group-item text-left"><i class="fas fa-cog fa-lg mr-1 text-primary"></i>Api Setting</a>
                                        <a href="#" class="list-group-item text-left"><i class="fa-brands fa-whatsapp fa-lg mr-1 text-primary"></i>Whatsapp Setting</a>
                                        <a href="#" class="list-group-item text-left"><i class="fas fa-database fa-lg mr-1 text-primary"></i>Storage Setting</a>
                                        <a href="#" class="list-group-item text-left"><img type="image" class="mr-2" src="{{asset('assets/images/Setting Icon/App Upadate Popup.svg')}}" alt="Image">App Update Popup</a>
                                        <a href="#" class="list-group-item text-left"><img type="image" class="mr-2" src="{{asset('assets/images/Setting Icon/Privacy Policy.svg')}}" alt="Image">Privacy Policy</a>
                                        <a href="#" class="list-group-item text-left"><img type="image" class="mr-2" src="{{asset('assets/images/Setting Icon/Refund Policy.svg')}}" alt="Image">Refund Policy</a>
                                        <a href="#" class="list-group-item text-left"><img type="image" class="mr-2" src="{{asset('assets/images/Setting Icon/Terms & Condition.svg')}}" alt="Image">Terms & Condition</a>
                                        <a href="#" class="list-group-item text-left"><i class="fa-brands fa-whatsapp fa-lg mr-1 text-primary"></i> Whatsapp Contact</a>
                                    </div>
                                </div>
                                <div id="accordion" class="col-lg-10 col-md-9 col-sm-12 vertab-accordion panel-group"> 
                                    <div class="vertab-content">
                                        <div class="panel-heading">
                                            <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" data-target="#collapse1">
                                                App Setting
                                            </h4>
                                        </div>
                                        <div id="collapse1" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                {!! Form::open(['url' =>'admin/app-setting','method'=>'POST','files'=>true]) !!}

                                                <div class="row mt-3">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('app_title','App Title', ['class' => 'col-xl-2 col-md-3 col-3 col-form-label']) !!}
                                                            <div class="col-xl-10 col-md-9 col-9">
                                                                {!! Form::text('name[app_title]',App\Models\AppSetting::getAppSetting('app_title'),['class' => 'form-control','required']) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('app_logo','App Logo', ['class' => 'col-xl-2 col-md-3 col-3 col-form-label']) !!}
                                                            <div class="col-xl-10 col-md-9 col-9">
                                                                <div class="row">
                                                                    <div class="col-3"><input class="form-control" type="file" id="app_logo" name="name[app_logo]"></div>
                                                                    <div class="col-9" id="preview"><img type="image" class="shadow bg-white rounded" src="@if(App\Models\AppSetting::getAppSetting('app_logo')) @if(App\Models\StorageSetting::getStorageSetting('storage') == 'DigitalOcean'){{\Storage::disk('spaces')->url('uploads/'.App\Models\AppSetting::getAppSetting('app_logo'))}} @else {{asset('uploads/'.App\Models\AppSetting::getAppSetting('app_logo'))}} @endif @else{{asset('assets/images/no-image.png')}}@endif" alt="Image" style="width: 100px;height: 100px" /></div>  
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('admin_favicon','Admin Favicon', ['class' => 'col-xl-2 col-md-3 col-3 col-form-label']) !!}
                                                            <div class="col-xl-10 col-md-9 col-9">
                                                                <div class="row">
                                                                    <div class="col-3"><input class="form-control" type="file" id="admin_favicon" name="name[admin_favicon]"></div>
                                                                    <div class="col-9" id="preview1"><img type="image" class="shadow bg-white rounded" src="@if(App\Models\AppSetting::getAppSetting('admin_favicon')) @if(App\Models\StorageSetting::getStorageSetting('storage') == 'DigitalOcean'){{\Storage::disk('spaces')->url('uploads/'.App\Models\AppSetting::getAppSetting('admin_favicon'))}} @else {{asset('uploads/'.App\Models\AppSetting::getAppSetting('admin_favicon'))}} @endif @else{{asset('assets/images/no-image.png')}}@endif" alt="Image" style="width: 40px;height: 40px" /></div>  
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('author', 'Author', ['class' => 'col-xl-2 col-md-3 col-3 col-form-label']) !!}
                                                            <div class="col-xl-10 col-md-9 col-9">
                                                                {!! Form::text('name[author]',App\Models\AppSetting::getAppSetting('author'),['class' => 'form-control','required']) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('description','Description', ['class' => 'col-sm-2 col-form-label']) !!}
                                                            <div class="col-sm-10">
                                                                <textarea name="name[description]" id="desc_text" class="form-control" required>{!! App\Models\AppSetting::getAppSetting('description') !!}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('api_key', 'Api Key', ['class' => 'col-xl-2 col-md-3 col-3 col-form-label']) !!}
                                                            <div class="col-xl-10 col-md-9 col-9">
                                                                {!! Form::text('name[api_key]',App\Models\AppSetting::getAppSetting('api_key'),['class' => 'form-control','required']) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('product_enable','Product Enable', ['class' => 'col-xl-2 col-md-3 col-3 col-form-label']) !!}
                                                            <div class="col-xl-5 col-md-9 col-9 mt-1">
                                                                <label class="cl-switch cl-switch-blue">
                                                                    <input type="checkbox" id="product_enable" value="1" name="name[product_enable]" @if(App\Models\AppSetting::getAppSetting('product_enable')==1) checked @endif>
                                                                    <span class="switcher"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('app_timezone', 'Timezone', ['class' => 'col-xl-2 col-md-3 col-3 col-form-label']) !!}
                                                            <div class="col-xl-10 col-md-9 col-sm-9">
                                                                <select class="form-control" id="timezone" name="name[app_timezone]" required>
                                                                    @foreach($timezone as $t)
                                                                        <option value="{{$t->timezone}}" @if(App\Models\AppSetting::getAppSetting("app_timezone") == $t->timezone) selected @endif>{{$t->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('currency','Currency', ['class' => 'col-xl-2 col-md-3 col-3 col-form-label']) !!}
                                                            <div class="col-xl-10 col-md-9 col-9">
                                                                <select class="form-control" id="currency" name="name[currency]" required>
                                                                    <option value="INR" @if(App\Models\AppSetting::getAppSetting('currency') == "INR") selected @endif>INR</option>
                                                                    <option value="USD" @if(App\Models\AppSetting::getAppSetting('currency') == "USD") selected @endif>USD</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('app_version','App Version', ['class' => 'col-xl-2 col-md-3 col-3 col-form-label']) !!}
                                                            <div class="col-xl-10 col-md-9 col-9">
                                                                {!! Form::text('name[app_version]',App\Models\AppSetting::getAppSetting('app_version'),['class' => 'form-control','required']) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('contact','Contact', ['class' => 'col-xl-2 col-md-3 col-3 col-form-label']) !!}
                                                            <div class="col-xl-10 col-md-9 col-9">
                                                                {!! Form::text('name[contact]', App\Models\AppSetting::getAppSetting('contact'),['class' => 'form-control','required']) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('email','Email', ['class' => 'col-xl-2 col-md-3 col-3 col-form-label']) !!}
                                                            <div class="col-xl-10 col-md-9 col-9">
                                                                {!! Form::text('name[email]', App\Models\AppSetting::getAppSetting('email'),['class' => 'form-control','required']) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('website','Website', ['class' => 'col-xl-2 col-md-3 col-3 col-form-label']) !!}
                                                            <div class="col-xl-10 col-md-9 col-9">
                                                                {!! Form::text('name[website]', App\Models\AppSetting::getAppSetting('website'),['class' => 'form-control','required']) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('developed_by','Developed By', ['class' => 'col-xl-2 col-md-3 col-3 col-form-label']) !!}
                                                            <div class="col-xl-10 col-md-9 col-9">
                                                                {!! Form::text('name[developed_by]', App\Models\AppSetting::getAppSetting('developed_by'),['class' => 'form-control','required']) !!}
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
                                            <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" data-target="#collapse2">
                                                Ads Setting
                                            </h4>
                                        </div>
                                        <div id="collapse2" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                {!! Form::open(['url' =>'admin/ads-setting','method'=>'POST','files'=>true]) !!}

                                                <div class="row mt-3">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('ads_enable','Ads Enable', ['class' => 'col-xl-2 col-md-3 col-3 col-form-label']) !!}
                                                            <div class="col-xl-5 col-md-9 col-9 mt-1">
                                                                <label class="cl-switch cl-switch-blue">
                                                                    <input type="checkbox" id="ads_enable" value="1" name="name[ads_enable]" @if(App\Models\AdsSetting::getAdsSetting('ads_enable')==1) checked @endif>
                                                                    <span class="switcher"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('ads_network','Ads Network', ['class' => 'col-xl-2 col-md-3 col-3 col-form-label']) !!}
                                                            <div class="col-xl-5 col-md-9 col-9">
                                                                <select id="ads_network" name="name[ads_network]" class="form-control" required>
                                                                    <option value="Admob" @if(App\Models\AdsSetting::getAdsSetting('ads_network') == "Admob") selected @endif>Admob</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('publisher_id','Publisher Id', ['class' => 'col-xl-2 col-md-3 col-3 col-form-label']) !!}
                                                            <div class="col-xl-5 col-md-9 col-9">
                                                                {!! Form::text('name[publisher_id]',App\Models\AdsSetting::getAdsSetting('publisher_id'),['class' => 'form-control','required']) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col-md-6">
                                                        <div class="card card-success">
                                                            <div class="card-header">
                                                                <span>Banner Ads</span>
                                                                <label class="cl-switch cl-switch-blue float-right">
                                                                    <input type="checkbox" id="banner_ads_enable" value="1" name="name[banner_ads_enable]" @if(App\Models\AdsSetting::getAdsSetting('banner_ads_enable')==1) checked @endif>
                                                                    <span class="switcher"></span>
                                                                </label>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <label for="banner_ads_id">Banner Ads ID</label>
                                                                    <input type="text" class="form-control" name="name[banner_ads_id]" value="{{App\Models\AdsSetting::getAdsSetting('banner_ads_id')}}" id="banner_ads_id" placeholder="Enter Banner Ads Id">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="card card-success">
                                                            <div class="card-header">
                                                                <span>APP Opens Ads</span>
                                                                <label class="cl-switch cl-switch-blue float-right">
                                                                    <input type="checkbox" id="app_opens_ads_enable" value="1" name="name[app_opens_ads_enable]" @if(App\Models\AdsSetting::getAdsSetting('app_opens_ads_enable')==1) checked @endif>
                                                                    <span class="switcher"></span>
                                                                </label>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <label for="app_open_ads_id">App Open Ads ID</label>
                                                                    <input type="text" class="form-control" name="name[app_open_ads_id]" id="app_open_ads_id" value="{{App\Models\AdsSetting::getAdsSetting('app_open_ads_id')}}" placeholder="Enter App Open Ads Id">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col-md-6">
                                                        <div class="card card-success">
                                                            <div class="card-header">
                                                                <span>Native Ads</span>
                                                                <label class="cl-switch cl-switch-blue float-right">
                                                                    <input type="checkbox" id="native_ads_enable" value="1" name="name[native_ads_enable]" @if(App\Models\AdsSetting::getAdsSetting('native_ads_enable')==1) checked @endif>
                                                                    <span class="switcher"></span>
                                                                </label>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <label for="native_ads_id">Native Ads ID</label>
                                                                    <input type="text" class="form-control" name="name[native_ads_id]" id="native_ads_id" value="{{App\Models\AdsSetting::getAdsSetting('native_ads_id')}}" placeholder="Enter Native Ads Id">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="card card-success">
                                                            <div class="card-header">
                                                                <span>Rewarded Ads</span>
                                                                <label class="cl-switch cl-switch-blue float-right">
                                                                    <input type="checkbox" id="rewarded_ads_enable" value="1" name="name[rewarded_ads_enable]" @if(App\Models\AdsSetting::getAdsSetting('rewarded_ads_enable')==1) checked @endif>
                                                                    <span class="switcher"></span>
                                                                </label>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <label for="rewarded_ads_id">Rewarded Ads ID</label>
                                                                    <input type="text" class="form-control" name="name[rewarded_ads_id]" id="rewarded_ads_id" value="{{App\Models\AdsSetting::getAdsSetting('rewarded_ads_id')}}" placeholder="Enter Rewarded Ads Id">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col-md-6">
                                                        <div class="card card-success">
                                                            <div class="card-header">
                                                                <span>Interstitial Ads</span>
                                                                <label class="cl-switch cl-switch-blue float-right">
                                                                    <input type="checkbox" id="interstitial_ads_enable" value="1" name="name[interstitial_ads_enable]" @if(App\Models\AdsSetting::getAdsSetting('interstitial_ads_enable')==1) checked @endif>
                                                                    <span class="switcher"></span>
                                                                </label>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <label for="interstitial_ads_id">Interstitial Ads ID</label>
                                                                    <input type="text" class="form-control" name="name[interstitial_ads_id]" id="interstitial_ads_id" value="{{App\Models\AdsSetting::getAdsSetting('interstitial_ads_id')}}" placeholder="Enter Interstitial Ads Id">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="interstitial_ads_click">Interstitial Ads Click</label>
                                                                    <input type="text" class="form-control" name="name[interstitial_ads_click]" id="interstitial_ads_click" value="{{App\Models\AdsSetting::getAdsSetting('interstitial_ads_click')}}" placeholder="Enter Interstitial Ads Click">
                                                                </div>
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
                                        <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" data-target="#collapse3">
                                            <h4 class="panel-title">
                                                Notification
                                            </h4>
                                        </div>
                                        <div id="collapse3" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                {!! Form::open(['url' =>'admin/notification-setting','method'=>'POST','files'=>true]) !!}

                                                <div class="row mt-3">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('one_signal_app_id','One Signal App Id', ['class' => 'col-xl-2 col-md-3 col-3 col-form-label']) !!}
                                                            <div class="col-xl-5 col-md-9 col-9">
                                                                {!! Form::text('name[one_signal_app_id]',App\Models\NotificationSetting::getNotificationSetting('one_signal_app_id'),['class' => 'form-control','required']) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('one_signal_rest_key','One Signal Rest Key', ['class' => 'col-xl-2 col-md-3 col-3 col-form-label']) !!}
                                                            <div class="col-xl-5 col-md-9 col-9">
                                                                {!! Form::text('name[one_signal_rest_key]',App\Models\NotificationSetting::getNotificationSetting('one_signal_rest_key'),['class' => 'form-control','required']) !!}
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
                                                Email Setting
                                            </h4>
                                        </div>
                                        <div id="collapse4" class="panel-collapse collapse">
                                            <div class="panel-body">
                                            {!! Form::open(['url' =>'admin/email-setting','method'=>'POST','files'=>true]) !!}

                                            <div class="row mt-3">
                                                <div class="col-12">
                                                    <div class="form-group row">
                                                        {!! Form::label('smtp_host','SMTP Host', ['class' => 'col-xl-2 col-md-3 col-3 col-form-label']) !!}
                                                        <div class="col-xl-5 col-md-9 col-9">
                                                            {!! Form::text('name[smtp_host]',App\Models\EmailSetting::getEmailSetting('smtp_host'),['class' => 'form-control','required']) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-12">
                                                    <div class="form-group row">
                                                        {!! Form::label('username','Username', ['class' => 'col-xl-2 col-md-3 col-3 col-form-label']) !!}
                                                        <div class="col-xl-5 col-md-9 col-9">
                                                            {!! Form::text('name[username]',App\Models\EmailSetting::getEmailSetting('username'),['class' => 'form-control','required']) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-12">
                                                    <div class="form-group row">
                                                        {!! Form::label('password','Password', ['class' => 'col-xl-2 col-md-3 col-3 col-form-label']) !!}
                                                        <div class="col-xl-5 col-md-9 col-9">
                                                            {!! Form::text('name[password]',null,['class' => 'form-control']) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-12">
                                                    <div class="form-group row">
                                                        {!! Form::label('password','SMTP Secure', ['class' => 'col-xl-2 col-md-3 col-3 col-form-label']) !!}
                                                        <div class="col-xl-5 col-md-9 col-9">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <select id="encryption" name="name[encryption]" class="form-control" required>
                                                                        <option value="ssl" @if(App\Models\EmailSetting::getEmailSetting('encryption') == "ssl") selected @endif>SSL</option>
                                                                        <option value="tls" @if(App\Models\EmailSetting::getEmailSetting('encryption') == "tls") selected @endif>TLS</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-6">
                                                                    {!! Form::number('name[port]',App\Models\EmailSetting::getEmailSetting('port'),['class' => 'form-control','required']) !!}
                                                                </div>
                                                            </div>
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
                                            <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" data-target="#collapse5">
                                                Payment Setting
                                            </h4>
                                        </div>
                                        <div id="collapse5" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                {!! Form::open(['url' =>'admin/payment-setting','method'=>'POST','files'=>true]) !!}

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="card card-primary">
                                                            <div class="card-header">
                                                                <span>Razorpay</span>
                                                                <label class="cl-switch cl-switch-blue float-right">
                                                                    <input type="checkbox" id="razorpay_enable" value="1" name="name[razorpay_enable]" @if(App\Models\PaymentSetting::getPaymentSetting('razorpay_enable')==1) checked @endif>
                                                                    <span class="switcher"></span>
                                                                </label>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <label for="razorpay_key_id">Razorpay Key Id</label>
                                                                    <input type="text" class="form-control" name="name[razorpay_key_id]" id="razorpay_key_id" value="{{App\Models\PaymentSetting::getPaymentSetting('razorpay_key_id')}}" placeholder="Enter Razorpay Key Id">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="razorpay_key_secret">Razorpay Secret Key</label>
                                                                    <input type="text" class="form-control" name="name[razorpay_key_secret]" id="razorpay_key_secret" value="{{App\Models\PaymentSetting::getPaymentSetting('razorpay_key_secret')}}" placeholder="Enter Razorpay Secret Key">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="card card-primary">
                                                            <div class="card-header">
                                                                <span>Stripe</span>
                                                                <label class="cl-switch cl-switch-blue float-right">
                                                                    <input type="checkbox" id="stripe_enable" value="1" name="name[stripe_enable]" @if(App\Models\PaymentSetting::getPaymentSetting('stripe_enable')==1) checked @endif>
                                                                    <span class="switcher"></span>
                                                                </label>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <label for="stripe_publishable_Key">Stripe Publishable Key</label>
                                                                    <input type="text" class="form-control" name="name[stripe_publishable_Key]" id="stripe_publishable_Key" value="{{App\Models\PaymentSetting::getPaymentSetting('stripe_publishable_Key')}}" placeholder="Enter Stripe Publishable Key">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="stripe_secret_key">Stripe Secret Key</label>
                                                                    <textarea rows="3" class="form-control" name="name[stripe_secret_key]" id="stripe_secret_key">{{App\Models\PaymentSetting::getPaymentSetting('stripe_secret_key')}}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col-md-6">
                                                        <div class="card card-primary">
                                                            <div class="card-header">
                                                                <span>Cashfree</span>
                                                                <label class="cl-switch cl-switch-blue float-right">
                                                                    <input type="checkbox" id="cashfree_enable" value="1" name="name[cashfree_enable]" @if(App\Models\PaymentSetting::getPaymentSetting('cashfree_enable')==1) checked @endif>
                                                                    <span class="switcher"></span>
                                                                </label>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <label for="cashfree_type">Cashfree Payment</label>
                                                                    <select class="form-control" id="cashfree_type" name="name[cashfree_type]" required>
                                                                        <option value="Test" @if(App\Models\PaymentSetting::getPaymentSetting('cashfree_type') == "Test") selected @endif>Test</option>
                                                                        <option value="Live" @if(App\Models\PaymentSetting::getPaymentSetting('cashfree_type') == "Live") selected @endif>Live</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="cashfree_key_id">Cashfree Key Id</label>
                                                                    <input type="text" class="form-control" name="name[cashfree_key_id]" id="cashfree_key_id" value="{{App\Models\PaymentSetting::getPaymentSetting('cashfree_key_id')}}" placeholder="Enter Cashfree Key Id">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="cashfree_key_secret">Cashfree Secret Key</label>
                                                                    <input type="text" class="form-control" name="name[cashfree_key_secret]" id="cashfree_key_secret" value="{{App\Models\PaymentSetting::getPaymentSetting('cashfree_key_secret')}}" placeholder="Enter Cashfree Secret Key">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="card card-primary">
                                                            <div class="card-header">
                                                                <span>Paytm</span>
                                                                <label class="cl-switch cl-switch-blue float-right">
                                                                    <input type="checkbox" id="paytm_enable" value="1" name="name[paytm_enable]" @if(App\Models\PaymentSetting::getPaymentSetting('paytm_enable')==1) checked @endif>
                                                                    <span class="switcher"></span>
                                                                </label>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <label for="paytm_type">Paytm Payment</label>
                                                                    <select class="form-control" id="paytm_type" name="name[paytm_type]" required>
                                                                        <option value="Test" @if(App\Models\PaymentSetting::getPaymentSetting('paytm_type') == "Test") selected @endif>Test</option>
                                                                        <option value="Live" @if(App\Models\PaymentSetting::getPaymentSetting('paytm_type') == "Live") selected @endif>Live</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="paytm_merchant_id">Paytm Merchant Id</label>
                                                                    <input type="text" class="form-control" name="name[paytm_merchant_id]" id="paytm_merchant_id" value="{{App\Models\PaymentSetting::getPaymentSetting('paytm_merchant_id')}}" placeholder="Enter Paytm Merchant Id">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="paytm_merchant_key">Paytm Merchant Key</label>
                                                                    <input type="text" class="form-control" name="name[paytm_merchant_key]" id="paytm_merchant_key" value="{{App\Models\PaymentSetting::getPaymentSetting('paytm_merchant_key')}}" placeholder="Enter Paytm Merchant Key">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col-md-6">
                                                        <div class="card card-primary">
                                                            <div class="card-header">
                                                                <span>Offline Payment</span>
                                                                <label class="cl-switch cl-switch-blue float-right">
                                                                    <input type="checkbox" id="offline_enable" value="1" name="name[offline_enable]" @if(App\Models\PaymentSetting::getPaymentSetting('offline_enable')==1) checked @endif>
                                                                    <span class="switcher"></span>
                                                                </label>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <label for="offline_payment_details">Offline Payment Details</label>
                                                                    <textarea rows="5" class="form-control" name="name[offline_payment_details]" id="offline_payment_details">{{App\Models\PaymentSetting::getPaymentSetting('offline_payment_details')}}</textarea>
                                                                </div>
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
                                            <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" data-target="#collapse6">
                                                Api Setting
                                            </h4>
                                        </div>
                                        <div id="collapse6" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                {!! Form::open(['url' =>'admin/api-setting','method'=>'POST','files'=>true]) !!}

                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">1</th>
                                                            <td>Get Category Api</td>
                                                            <td>Order By</td>
                                                            <td>
                                                                <select class="form-control" id="category_order_type" name="name[category_order_type]" required>
                                                                    <option value="name" @if(App\Models\ApiSetting::getApiSetting("category_order_type") == "name") selected @endif>Category Name</option>
                                                                    <option value="created_at" @if(App\Models\ApiSetting::getApiSetting("category_order_type") == "created_at") selected @endif>Added Date</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-control" id="category_order_by" name="name[category_order_by]" required>
                                                                    <option value="asc" @if(App\Models\ApiSetting::getApiSetting("category_order_by") == "asc") selected @endif>Ascending</option>
                                                                    <option value="desc" @if(App\Models\ApiSetting::getApiSetting("category_order_by") == "desc") selected @endif>Descending</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">2</th>
                                                            <td>Get Festivals Api</td>
                                                            <td>Order By</td>
                                                            <td>
                                                                <select class="form-control" id="festival_order_type" name="name[festival_order_type]" required>
                                                                    <option value="title" @if(App\Models\ApiSetting::getApiSetting("festival_order_type") == "name") selected @endif>Festival Title</option>
                                                                    <option value="festivals_date" @if(App\Models\ApiSetting::getApiSetting("festival_order_type") == "festivals_date") selected @endif>Festivals Date</option>
                                                                    <option value="activation_date" @if(App\Models\ApiSetting::getApiSetting("festival_order_type") == "activation_date") selected @endif>Activation Date</option>
                                                                    <option value="created_at" @if(App\Models\ApiSetting::getApiSetting("festival_order_type") == "created_at") selected @endif>Added Date</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-control" id="festival_order_by" name="name[festival_order_by]" required>
                                                                    <option value="asc" @if(App\Models\ApiSetting::getApiSetting("festival_order_by") == "asc") selected @endif>Ascending</option>
                                                                    <option value="desc" @if(App\Models\ApiSetting::getApiSetting("festival_order_by") == "desc") selected @endif>Descending</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">3</th>
                                                            <td>Get Custom Category Api</td>
                                                            <td>Order By</td>
                                                            <td>
                                                                <select class="form-control" id="custom_order_type" name="name[custom_order_type]" required>
                                                                    <option value="name" @if(App\Models\ApiSetting::getApiSetting("custom_order_type") == "name") selected @endif>Custom Category Name</option>
                                                                    <option value="created_at" @if(App\Models\ApiSetting::getApiSetting("custom_order_type") == "created_at") selected @endif>Added Date</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-control" id="custom_order_by" name="name[custom_order_by]" required>
                                                                    <option value="asc" @if(App\Models\ApiSetting::getApiSetting("custom_order_by") == "asc") selected @endif>Ascending</option>
                                                                    <option value="desc" @if(App\Models\ApiSetting::getApiSetting("custom_order_by") == "desc") selected @endif>Descending</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">4</th>
                                                            <td>Get Business Category Api</td>
                                                            <td>Order By</td>
                                                            <td>
                                                                <select class="form-control" id="business_order_type" name="name[business_order_type]" required>
                                                                    <option value="name" @if(App\Models\ApiSetting::getApiSetting("business_order_type") == "name") selected @endif>Business Category Name</option>
                                                                    <option value="created_at" @if(App\Models\ApiSetting::getApiSetting("business_order_type") == "created_at") selected @endif>Added Date</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-control" id="business_order_by" name="name[business_order_by]" required>
                                                                    <option value="asc" @if(App\Models\ApiSetting::getApiSetting("business_order_by") == "asc") selected @endif>Ascending</option>
                                                                    <option value="desc" @if(App\Models\ApiSetting::getApiSetting("business_order_by") == "desc") selected @endif>Descending</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">5</th>
                                                            <td>Get News Api</td>
                                                            <td>Order By</td>
                                                            <td>
                                                                <select class="form-control" id="news_order_type" name="name[news_order_type]" required>
                                                                    <option value="title" @if(App\Models\ApiSetting::getApiSetting("news_order_type") == "title") selected @endif>News Title</option>
                                                                    <option value="created_at" @if(App\Models\ApiSetting::getApiSetting("news_order_type") == "created_at") selected @endif>Added Date</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-control" id="news_order_by" name="name[news_order_by]" required>
                                                                    <option value="asc" @if(App\Models\ApiSetting::getApiSetting("news_order_by") == "asc") selected @endif>Ascending</option>
                                                                    <option value="desc" @if(App\Models\ApiSetting::getApiSetting("news_order_by") == "desc") selected @endif>Descending</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <!-- <tr>
                                                            <th scope="row">6</th>
                                                            <td>Get Stories Api</td>
                                                            <td>Order By</td>
                                                            <td>
                                                                <select class="form-control" id="story_order_type" name="name[story_order_type]" required>
                                                                    <option value="name" @if(App\Models\ApiSetting::getApiSetting("story_order_type") == "name") selected @endif>Name</option>
                                                                    <option value="created_at" @if(App\Models\ApiSetting::getApiSetting("story_order_type") == "created_at") selected @endif>Added Date</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-control" id="story_order_by" name="name[story_order_by]" required>
                                                                    <option value="asc" @if(App\Models\ApiSetting::getApiSetting("story_order_by") == "asc") selected @endif>Ascending</option>
                                                                    <option value="desc" @if(App\Models\ApiSetting::getApiSetting("story_order_by") == "desc") selected @endif>Descending</option>
                                                                </select>
                                                            </td>
                                                        </tr> -->
                                                    </tbody>
                                                </table>

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
                                        <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" data-target="#collapse61">
                                            <h4 class="panel-title">
                                                WhatsApp Setting
                                            </h4>
                                        </div>
                                        <div id="collapse61" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                {!! Form::open(['url' =>'admin/whatsapp-setting','method'=>'POST','files'=>true]) !!}

                                                <div class="row mt-3">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('api_key','Api Key', ['class' => 'col-xl-2 col-md-3 col-3 col-form-label']) !!}
                                                            <div class="col-xl-5 col-md-9 col-9">
                                                                {!! Form::text('name[api_key]',App\Models\WhatsAppSetting::getWhatsAppSetting('api_key'),['class' => 'form-control','required']) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('instance_id','Instance id', ['class' => 'col-xl-2 col-md-3 col-3 col-form-label']) !!}
                                                            <div class="col-xl-5 col-md-9 col-9">
                                                                {!! Form::text('name[instance_id]',App\Models\WhatsAppSetting::getWhatsAppSetting('instance_id'),['class' => 'form-control','required']) !!}
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
                                            <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" data-target="#collapse7">
                                                Storage Setting
                                            </h4>
                                        </div>
                                        <div id="collapse7" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                {!! Form::open(['url' =>'admin/storage-setting','method'=>'POST','files'=>true,'id'=>'storage_form']) !!}

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('storage', 'Select Storage', ['class' => 'col-3 col-form-label']) !!}
                                                            <div class="col-9">
                                                                <select class="form-control" id="storage" name="name[storage]" required>
                                                                    <option value="local" @if(App\Models\StorageSetting::getStorageSetting("storage") == "local") selected @endif>Local</option>
                                                                    <option value="DigitalOcean" @if(App\Models\StorageSetting::getStorageSetting("storage") == "DigitalOcean") selected @endif>Digital Ocean</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('digitalOcean_space_name','DigitalOcean Space Name', ['class' => 'col-3 col-form-label']) !!}
                                                            <div class="col-9">
                                                                <input type="text" id="digitalOcean_space_name" name="name[digitalOcean_space_name]" value="{{App\Models\StorageSetting::getStorageSetting('digitalOcean_space_name')}}" class="form-control" @if(App\Models\StorageSetting::getStorageSetting("storage") == "local") readonly @else required @endif>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('digitalOcean_key','DigitalOcean Key', ['class' => 'col-3 col-form-label']) !!}
                                                            <div class="col-9">
                                                                <input type="text" id="digitalOcean_key" name="name[digitalOcean_key]" value="{{App\Models\StorageSetting::getStorageSetting('digitalOcean_key')}}" class="form-control" @if(App\Models\StorageSetting::getStorageSetting("storage") == "local") readonly @else required @endif>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('digitalOcean_secret','DigitalOcean Secret', ['class' => 'col-3 col-form-label']) !!}
                                                            <div class="col-9">
                                                                <input type="text" id="digitalOcean_secret" name="name[digitalOcean_secret]" value="{{App\Models\StorageSetting::getStorageSetting('digitalOcean_secret')}}" class="form-control" @if(App\Models\StorageSetting::getStorageSetting("storage") == "local") readonly @else required @endif>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('digitalOcean_bucket_region','DigitalOcean Bucket Region', ['class' => 'col-3 col-form-label']) !!}
                                                            <div class="col-9">
                                                                <input type="text" id="digitalOcean_bucket_region" name="name[digitalOcean_bucket_region]" value="{{App\Models\StorageSetting::getStorageSetting('digitalOcean_bucket_region')}}" class="form-control" @if(App\Models\StorageSetting::getStorageSetting("storage") == "local") readonly @else required @endif>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('digitalOcean_endpoint','DigitalOcean Endpoint', ['class' => 'col-3 col-form-label']) !!}
                                                            <div class="col-9">
                                                                <input type="text" id="digitalOcean_endpoint" name="name[digitalOcean_endpoint]" value="{{App\Models\StorageSetting::getStorageSetting('digitalOcean_endpoint')}}" class="form-control" @if(App\Models\StorageSetting::getStorageSetting("storage") == "local") readonly @else required @endif>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 text-center">
                                                    @if(Auth::user()->user_type == "Demo")
                                                        <button type="button" class="btn btn-success ToastrButton digitalOcean_btn">Save</button>
                                                    @else
                                                        <button type="submit" class="btn btn-success digitalOcean_btn" id="save_digitalOcean">Save</button>
                                                        <!-- <a href="@if(App\Models\StorageSetting::getStorageSetting('storage') == 'DigitalOcean') {{url('admin/move-local-to-digitalOcean')}} @endif" type="button" class="btn btn-primary">Move Files From Local To Digital Ocean</a> -->
                                                    @endif
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}

                                                <div class="row mt-3">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('test_image','Test Image', ['class' => 'col-sm-3 col-form-label']) !!}
                                                            <div class="col-sm-4">
                                                                <input class="form-control" type="file" id="test_image" name="test_image" accept=".jpg, .png, jpeg, .PNG, .JPG, .JPEG" required @if(App\Models\StorageSetting::getStorageSetting("storage") == "local") disabled @endif>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-3">
                                                    </div>
                                                    <div class="col-9" id="view_test_image">
                                                        
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 text-center">
                                                    @if(Auth::user()->user_type == "Demo")
                                                        <button type="button" class="btn btn-success ToastrButton digitalOcean_test_btn" @if(App\Models\StorageSetting::getStorageSetting("storage") == "local") disabled @endif>Test</button>
                                                    @else
                                                        <button type="submit" class="btn btn-success digitalOcean_test_btn" id="test_btn" @if(App\Models\StorageSetting::getStorageSetting("storage") == "local") disabled @endif>Test</button>
                                                    @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="vertab-content">
                                        <div class="panel-heading">
                                            <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" data-target="#collapse8">
                                                App Update Popup
                                            </h4>
                                        </div>
                                        <div id="collapse8" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                {!! Form::open(['url' =>'admin/app-update-setting','method'=>'POST','files'=>true]) !!}

                                                <div class="row mt-3">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('update_popup_show','App Update Popup Show/Hide', ['class' => 'col-xl-3 col-md-4 col-4 col-form-label']) !!}
                                                            <div class="col-xl-5 col-md-8 col-8">
                                                                <label class="cl-switch cl-switch-blue">
                                                                    <input type="checkbox" id="update_popup_show" value="1" name="name[update_popup_show]" @if(App\Models\AppUpdateSetting::getAppUpdateSetting('update_popup_show')==1) checked @endif>
                                                                    <span class="switcher"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('new_app_version_code','New App Version Code', ['class' => 'col-xl-3 col-md-4 col-4 col-form-label']) !!}
                                                            <div class="col-xl-5 col-md-8 col-8">
                                                                {!! Form::text('name[new_app_version_code]',App\Models\AppUpdateSetting::getAppUpdateSetting('new_app_version_code'),['class' => 'form-control','required']) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('description','Description', ['class' => 'col-xl-3 col-md-4 col-4 col-form-label']) !!}
                                                            <div class="col-xl-5 col-md-8 col-8">
                                                                {!! Form::textarea('name[description]',App\Models\AppUpdateSetting::getAppUpdateSetting('description'),['class' => 'form-control','rows'=>7,'required']) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('app_link','App Link', ['class' => 'col-xl-3 col-md-4 col-4 col-form-label']) !!}
                                                            <div class="col-xl-5 col-md-8 col-8">
                                                                {!! Form::text('name[app_link]',App\Models\AppUpdateSetting::getAppUpdateSetting('app_link'),['class' => 'form-control','required']) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('cancel_option','Cancel Option', ['class' => 'col-xl-3 col-md-4 col-4 col-form-label']) !!}
                                                            <div class="col-xl-5 col-md-8 col-8">
                                                                <label class="cl-switch cl-switch-blue">
                                                                    <input type="checkbox" id="cancel_option" value="1" name="name[cancel_option]" @if(App\Models\AppUpdateSetting::getAppUpdateSetting('cancel_option')==1) checked @endif>
                                                                    <span class="switcher"></span>
                                                                </label>
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
                                            <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" data-target="#collapse9">
                                                Privacy Policy
                                            </h4>
                                        </div>
                                        <div id="collapse9" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                {!! Form::open(['url' =>'admin/other-setting','method'=>'POST','files'=>true]) !!}

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('privacy_policy','Privacy Policy', ['class' => 'col-sm-2 col-form-label']) !!}
                                                            <div class="col-sm-10">
                                                                <textarea name="name[privacy_policy]" id="privacy_policy" class="form-control" required>{{App\Models\OtherSetting::getOtherSetting('privacy_policy')}}</textarea>
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
                                            <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" data-target="#collapse10">
                                                Refund Policy
                                            </h4>
                                        </div>
                                        <div id="collapse10" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                {!! Form::open(['url' =>'admin/other-setting','method'=>'POST','files'=>true]) !!}

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('refund_policy','Refund Policy', ['class' => 'col-sm-2 col-form-label']) !!}
                                                            <div class="col-sm-10">
                                                                <textarea name="name[refund_policy]" id="refund_policy" class="form-control" required>{{App\Models\OtherSetting::getOtherSetting('refund_policy')}}</textarea>
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
                                            <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" data-target="#collapse11">
                                                Terms & Condition
                                            </h4>
                                        </div>
                                        <div id="collapse11" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                {!! Form::open(['url' =>'admin/other-setting','method'=>'POST','files'=>true]) !!}

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('terms_condition','Terms & Condition', ['class' => 'col-sm-2 col-form-label']) !!}
                                                            <div class="col-sm-10">
                                                                <textarea name="name[terms_condition]" id="terms_condition" class="form-control" required>{{App\Models\OtherSetting::getOtherSetting('terms_condition')}}</textarea>
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
                                            <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion" data-target="#collapse12">
                                                Whatsapp Contact
                                            </h4>
                                        </div>
                                        <div id="collapse12" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                {!! Form::open(['url' =>'admin/whatsapp-contact','method'=>'POST','files'=>true]) !!}

                                                <div class="row mt-3">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('whatsapp_contact_enable','Whatsapp Contact Enable', ['class' => 'col-xl-3 col-md-4 col-4 col-form-label']) !!}
                                                            <div class="col-xl-5 col-md-8 col-8">
                                                                <label class="cl-switch cl-switch-blue">
                                                                    <input type="checkbox" id="whatsapp_contact_enable" value="1" name="name[whatsapp_contact_enable]" @if(App\Models\AppSetting::getAppSetting('whatsapp_contact_enable')==1) checked @endif>
                                                                    <span class="switcher"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col-12">
                                                        <div class="form-group row">
                                                            {!! Form::label('whatsapp_number','Whatsapp Number', ['class' => 'col-xl-3 col-md-4 col-4 col-form-label']) !!}
                                                            <div class="col-xl-5 col-md-8 col-8">
                                                                {!! Form::text('name[whatsapp_number]',App\Models\AppSetting::getAppSetting('whatsapp_number'),['class' => 'form-control', 'pattern'=>"[0-9]*",'minlength' =>10,'maxlength' =>10,'required']) !!}
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
          <button id="del_btn" class="btn btn-danger" type="button" data-submit="">Delete</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
@endsection

@section("script")
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-lite.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#timezone').select2();
        $('#currency').select2();
        $('#category_order_by').select2();
        $('#category_order_type').select2();
        $('#news_order_by').select2();
        $('#news_order_type').select2();
        $('#festival_order_by').select2();
        $('#festival_order_type').select2();
        $('#custom_order_by').select2();
        $('#custom_order_type').select2();
        $('#business_order_by').select2();
        $('#business_order_type').select2();
        $('#story_order_by').select2();
        $('#story_order_type').select2();
        $('#storage').select2();
        $('#ads_network').select2();
        $('#encryption').select2();
        $('#payment_gateway').select2();
    });

    var msg = "{{Session::get('alert')}}";
    var exist = "{{Session::has('alert')}}";
    if(exist){
      alert(msg);
    }
    
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
    });

    $("#del_btn").on("click",function(){
        var id=$(this).data("submit");
        $("#form_"+id).submit();
    });

    $('#myModal').on('show.bs.modal', function(e) {
        var id = e.relatedTarget.dataset.id;
        $("#del_btn").attr("data-submit",id);
    });

    $('#desc_text').summernote({
        placeholder: '',
        tabsize: 2,
        height: 150
    });

    $('#privacy_policy').summernote({
        placeholder: '',
        tabsize: 2,
        height: 400
    });

    $('#refund_policy').summernote({
        placeholder: '',
        tabsize: 2,
        height: 400
    });

    $('#terms_condition').summernote({
        placeholder: '',
        tabsize: 2,
        height: 400
    });

    $("#payment_gateway").change(function() {
        $('#otherText').empty();
        if($(this).find("option:selected").text() == "Razorpay")
        {
            $('#otherText').append('<div class="row"><div class="col-xl-2 col-md-3 col-3"><label class="col-form-label">Razorpay key Id</label></div><div class="col-xl-5 col-md-9 col-9"><input type="text" class="form-control" name="name[razorpay_key_id]" value="{{App\Models\PaymentSetting::getPaymentSetting("razorpay_key_id")}}"></div></div>');
            $('#otherText').append('<div class="row mt-3"><div class="col-xl-2 col-md-3 col-3"><label class="col-form-label">Razorpay Key Secret</label></div><div class="col-xl-5 col-md-9 col-9"><input type="text" class="form-control" name="name[razorpay_key_secret]" value="{{App\Models\PaymentSetting::getPaymentSetting("razorpay_key_secret")}}"></div></div>');
        }
        if($(this).find("option:selected").text() == "Cashfree")
        {
            $('#otherText').append('<div class="row"><div class="col-xl-2 col-md-3 col-3"><label class="col-form-label">Cashfree key Id</label></div><div class="col-xl-5 col-md-9 col-9"><input type="text" class="form-control" name="name[cashfree_key_id]" value="{{App\Models\PaymentSetting::getPaymentSetting("cashfree_key_id")}}"></div></div>');
            $('#otherText').append('<div class="row mt-3"><div class="col-xl-2 col-md-3 col-3"><label class="col-form-label">Cashfree Key Secret</label></div><div class="col-xl-5 col-md-9 col-9"><input type="text" class="form-control" name="name[cashfree_key_secret]" value="{{App\Models\PaymentSetting::getPaymentSetting("cashfree_key_secret")}}"></div></div>');
        }
    });

    $("#storage").change(function() {
        if($(this).find("option:selected").text() == "Local")
        {
            $("#digitalOcean_space_name").prop("readonly", true);
            $("#digitalOcean_key").prop("readonly", true);
            $("#digitalOcean_secret").prop("readonly", true);
            $("#digitalOcean_bucket_region").prop("readonly", true);
            $("#digitalOcean_endpoint").prop("readonly", true);
            $(".digitalOcean_test_btn").attr('disabled','disabled');
        }
        if($(this).find("option:selected").text() == "Digital Ocean")
        {
            $("#digitalOcean_space_name").prop("readonly", false);
            $("#digitalOcean_space_name").attr("required", "true");
            $("#digitalOcean_key").prop("readonly", false);
            $("#digitalOcean_key").attr("required", "true");
            $("#digitalOcean_secret").prop("readonly", false);
            $("#digitalOcean_secret").attr("required", "true");
            $("#digitalOcean_bucket_region").prop("readonly", false);
            $("#digitalOcean_bucket_region").attr("required", "true");
            $("#digitalOcean_endpoint").prop("readonly", false);
            $("#digitalOcean_endpoint").attr("required", "true");
            $(".digitalOcean_btn").removeAttr('disabled');
        }
    });

    $('#save_digitalOcean').on('click',function() {
        var storage = $('#storage').val();
        var digitalOcean_space_name = $('#digitalOcean_space_name').val();
        var digitalOcean_key = $('#digitalOcean_key').val();
        var digitalOcean_secret = $('#digitalOcean_secret').val();
        var digitalOcean_bucket_region = $('#digitalOcean_bucket_region').val();
        var digitalOcean_endpoint = $('#digitalOcean_endpoint').val();

        var form = new FormData();
        form.append("name[storage]", storage);
        form.append("name[digitalOcean_space_name]", digitalOcean_space_name);
        form.append("name[digitalOcean_key]", digitalOcean_key);
        form.append("name[digitalOcean_secret]", digitalOcean_secret);
        form.append("name[digitalOcean_bucket_region]", digitalOcean_bucket_region);
        form.append("name[digitalOcean_endpoint]", digitalOcean_endpoint);

        $.ajax({
            type: "POST",
            url: "{{url('admin/storage-setting')}}",
            data: form,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(data) {
                if(data == 1)
                {
                    $("#storage_form").submit();
                }
                if(data == 0)
                {
                    location.reload(true);
                }
            },
        });
    });

    $("#test_btn").on('click',function() {
        var file = $('#test_image').prop("files")[0];
        var form = new FormData();
        form.append("image", file);

        $.ajax({
            type: "POST",
            url: "{{url('admin/test-image-digitalOcean')}}",
            data: form,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(data) {
                if(data == 0)
                {
                    $('#view_test_image').html('<div class="alert alert-danger" role="alert">Digital Ocean Invalid Credentials!</div>');
                }
                else
                {
                    $('#view_test_image').html('<div class="alert alert-success" role="alert">Digital Ocean valid Credentials!</div>');
                }
            },
        });
    });

    function imagePreview(fileInput) 
    { 
        if (fileInput.files && fileInput.files[0]) 
        {
            var fileReader = new FileReader();
            fileReader.onload = function (event) 
            {
                $('#preview').html('<img src="'+event.target.result+'" class="shadow bg-white rounded" width="100px" alt="Select Image" height="100px"/>');
            };
            fileReader.readAsDataURL(fileInput.files[0]);
        }
    }

    $("#app_logo").change(function () {
        imagePreview(this);
    });

    function imagePreview1(fileInput) 
    { 
        if (fileInput.files && fileInput.files[0]) 
        {
            var fileReader = new FileReader();
            fileReader.onload = function (event) 
            {
                $('#preview1').html('<img src="'+event.target.result+'" class="shadow bg-white rounded" width="40px" alt="Select Image" height="40px"/>');
            };
            fileReader.readAsDataURL(fileInput.files[0]);
        }
    }

    $("#admin_favicon").change(function () {
        imagePreview1(this);
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