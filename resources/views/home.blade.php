@extends('layouts.app')

@section('extra_css')
<style type="text/css">

</style>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <a href="{{route('user.index')}}">
            <div class="info-box" style="border-radius: 7px;background-color: #28C76F;color:white;">
                <span class="info-box-icon ml-3"><img src="{{asset('assets/images/icon/User.svg')}}"/></span>
                <div class="info-box-content text-right">
                    <span class="info-box-text mt-2"><b>Total User</b></span>
                    <span class="info-box-number mb-2"><h2>{{$user_count-1}}</h2></span>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-3 col-xs-6">
        <a href="{{route('category.index')}}">
            <div class="info-box" style="border-radius: 7px;background-color: #FF3EA6;color:white;">
                <span class="info-box-icon ml-3"><img src="{{asset('assets/images/icon/Category.svg')}}"/></span>
                <div class="info-box-content text-right">
                    <span class="info-box-text mt-2"><b>Total Category</b></span>
                    <span class="info-box-number mb-2"><h2>{{$category_count}}</h2></span>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-3 col-xs-6">
        <a href="{{route('festivals.index')}}">
            <div class="info-box" style="border-radius: 7px;background-color: #1E9FF2;color:white;">
                <span class="info-box-icon ml-3"><img src="{{asset('assets/images/icon/Festival.svg')}}"/></span>
                <div class="info-box-content text-right">
                    <span class="info-box-text mt-2"><b>Total Festival</b></span>
                    <span class="info-box-number mb-2"><h2>{{$festivals_count}}</h2></span>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-3 col-xs-6">
        <a href="{{route('business.index')}}">
            <div class="info-box" style="border-radius: 7px;background-color: #FF9F43;color:white;">
                <span class="info-box-icon ml-3"><img src="{{asset('assets/images/icon/Business.svg')}}"/></span>
                <div class="info-box-content text-right">
                    <span class="info-box-text mt-2"><b>Total Business</b></span>
                    <span class="info-box-number mb-2"><h2>{{$business_count}}</h2></span>
                </div>
            </div>
        </a>
    </div>
</div>

@can('FinancialStatistics')
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <div class="info-box bg-light">
            <span class="info-box-icon mt-1 mb-1" style="background-color:#1E9FF2;color:white;"><img src="{{asset('assets/images/icon/Today Payment.svg')}}"/></span>
            <div class="info-box-content" style="color:#1E9FF2;">
                <span class="info-box-text"><b>Today Payment</b></span>
                <span class="info-box-number"><h3><b>{{App\Models\AppSetting::getAppSetting('currency')}} {{$today_payment}}</b></h3></span>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <div class="info-box bg-light">
            <span class="info-box-icon mt-1 mb-1" style="background-color:#28C76F;color:white;"><img src="{{asset('assets/images/icon/Weekly Payment.svg')}}"/></span>
            <div class="info-box-content" style="color:#28C76F;">
                <span class="info-box-text"><b>Weekly Payment</b></span>
                <span class="info-box-number"><h3><b>{{App\Models\AppSetting::getAppSetting('currency')}} {{$weekly_payment}}</b></h3></span>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <div class="info-box bg-light">
            <span class="info-box-icon mt-1 mb-1" style="background-color:#4634FF;color:white;"><img src="{{asset('assets/images/icon/Monthly Payment.svg')}}"/></span>
            <div class="info-box-content" style="color:#4634FF;">
                <span class="info-box-text"><b>Monthly Payment</b></span>
                <span class="info-box-number"><h3><b>{{App\Models\AppSetting::getAppSetting('currency')}} {{$monthly_payment}}</b></h3></span>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <div class="info-box bg-light">
            <span class="info-box-icon mt-1 mb-1" style="background-color:#FF3EA6;color:white;"><img src="{{asset('assets/images/icon/Total Payment.svg')}}"/></span>
            <div class="info-box-content" style="color:#FF3EA6;">
                <span class="info-box-text"><b>Total Payment</b></span>
                <span class="info-box-number"><h3><b>{{App\Models\AppSetting::getAppSetting('currency')}} {{$transaction_count}}</b></h3></span>
            </div>
        </div>
    </div>
</div>
@endcan

<div class="row">
    <div class="col-md-12">
        <div class="row">
            @can('FinancialStatistics')
            <div class="col-md-6">
                <div class="card card-light">
                    <div class="card-header text-primary border-bottom"><h5><b>Monthly Payment Report</b></h5></div>
                    <div class="card-body">
                        <canvas id="myChart" style="width:100%;max-width:800px"></canvas>
                    </div>
                </div>
            </div>
            @endcan
            <div class="col-md-6">
                <div class="card card-light">
                    <div class="card-header text-primary border-bottom"><h5><b>Monthly User Report</b></h5></div>
                    <div class="card-body">
                        <canvas id="myChart1" style="width:100%;max-width:800px"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="text-primary"><b>Today Event</b></h5>
    </div>
    <div class="card-body">
        <div class="row grid7">
            @foreach($today_event as $e)
            <div class="col-xl-1 col-md-4 col-6 text-center">
                <img class="rounded-circle border border-primary mb-2" src="@if($e->image) @if(App\Models\StorageSetting::getStorageSetting('storage') == 'DigitalOcean'){{\Storage::disk('spaces')->url('uploads/'.$e->image)}} @else {{asset('uploads/'.$e->image)}} @endif @else {{asset('assets/images/noimage.png')}} @endif" width="100px" height="100px"></br>
                <span class="text-primary" style="font-size:15px;">{{$e->title}}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="text-primary"><b>User Subscription Plan Expire</b></h5>
    </div>
    <div class="card-body">
        <div class="row grid7">
            @foreach($subscription_end_user as $subscription_user)
            <div class="col-xl-1 col-md-4 col-6 text-center">
                <img class="rounded-circle border border-primary mb-2" src="@if($subscription_user->image) @if(substr($subscription_user->image, 0, 4)=='http') {{$subscription_user->image}} @else @if(App\Models\StorageSetting::getStorageSetting('storage') == 'DigitalOcean'){{\Storage::disk('spaces')->url('uploads/'.$subscription_user->image)}} @else {{asset('uploads/'.$subscription_user->image)}} @endif @endif @else {{asset('assets/images/no-user.jpg')}} @endif" width="100px" height="100px"></br>
                <span class="text-primary" style="font-size:15px;"><a href="{{url('admin/user/'.$subscription_user->id) }}">{{$subscription_user->name}}</a></span><br>
                <span class="text-primary" style="font-size:15px;"><a href="{{url('admin/user/'.$subscription_user->id) }}">{{date('d M, y',strtotime($subscription_user->subscription_end_date))}}</a></span>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-4">
        <div class="card card-primary">
            <div class="card-header text-center border-bottom">
                <h5><b>Recent Register User</b></h5>
            </div>
            <ul class="list-group list-group-flush">
                @foreach($user as $u)
                    @if($u->email != "demo2023@gmail.com")
                    <li class="list-group-item">
                        <div class="d-flex flex-row">
                            <img class="rounded-circle border border-primary" src="@if($u->image) @if(substr($u->image, 0, 4)=='http') {{$u->image}} @else @if(App\Models\StorageSetting::getStorageSetting('storage') == 'DigitalOcean'){{\Storage::disk('spaces')->url('uploads/'.$u->image)}} @else {{asset('uploads/'.$u->image)}} @endif @endif @else {{asset('assets/images/no-user.jpg')}} @endif" width="60px" height="60px">
                            <div class="d-flex flex-column ml-3">
                                <span class="d-block font-weight-bold my-auto name"><a href="{{url('admin/user/'.$u->id) }}" class="text-dark" style="font-size:18px;">{{$u->name}}</a></span>
                                <span class="date text-muted" style="font-size:15px;">
                                @php 
                                    $time_ago = strtotime($u->created_at);
                                    $cur_time   = time();
                                    $time_elapsed   = $cur_time - $time_ago;
                                    $seconds    = $time_elapsed ;
                                    $minutes    = round($time_elapsed / 60 );
                                    $hours      = round($time_elapsed / 3600);
                                    $days       = round($time_elapsed / 86400 );
                                    $weeks      = round($time_elapsed / 604800);
                                    $months     = round($time_elapsed / 2600640 );
                                    $years      = round($time_elapsed / 31207680 );
                                    // Seconds
                                    if($seconds <= 60){
                                        echo "just now";
                                    }
                                    //Minutes
                                    else if($minutes <=60){
                                        if($minutes==1){
                                            echo "1 minute ago";
                                        }
                                        else{
                                            echo "$minutes minutes ago";
                                        }
                                    }
                                    //Hours
                                    else if($hours <=24){
                                        if($hours==1){
                                            echo "1 hour ago";
                                        }else{
                                            echo "$hours hrs ago";
                                        }
                                    }
                                    //Days
                                    else if($days <= 7){
                                        if($days==1){
                                            echo "yesterday";
                                        }else{
                                            echo "$days days ago";
                                        }
                                    }
                                    //Weeks
                                    else if($weeks <= 4.3){
                                        if($weeks==1){
                                            echo "1 week ago";
                                        }else{
                                            echo "$weeks weeks ago";
                                        }
                                    }
                                    //Months
                                    else if($months <=12){
                                        if($months==1){
                                            echo "1 month ago";
                                        }else{
                                            echo "$months months ago";
                                        }
                                    }
                                    //Years
                                    else{
                                        if($years==1){
                                            echo "1 year ago";
                                        }else{
                                            echo "$years years ago";
                                        }
                                    }
                                @endphp
                                </span>
                            </div>
                        </div>
                    </li>
                    @endif
                @endforeach
            </ul>
            <div class="card-footer text-center">
                <a href="{{route('user.index')}}" class="btn btn-primary">View More</a>
            </div>
        </div>
    </div>

    @can('FinancialStatistics')
    <div class="col-xl-4">
        <div class="card card-primary">
            <div class="card-header text-center border-bottom">
                <h5><b>Recent Purchase</b></h5>
            </div>
            <ul class="list-group list-group-flush">
                @foreach($transaction as $key=>$t)
                <li class="list-group-item d-flex justify-content-between">
                    <div class="d-flex flex-row">
                        <img class="rounded-circle border border-primary" src="@if($t->user->image) @if(substr($t->user->image, 0, 4)=='http') {{$t->user->image}} @else @if(App\Models\StorageSetting::getStorageSetting('storage') == 'DigitalOcean'){{\Storage::disk('spaces')->url('uploads/'.$t->user->image)}} @else {{asset('uploads/'.$t->user->image)}} @endif @endif @else {{asset('assets/images/no-user.jpg')}} @endif" width="60px" height="60px">
                        <div class="d-flex flex-column ml-2">
                            <span class="d-block font-weight-bold my-auto name"><a href="{{url('admin/user/'.$t->user->id) }}" class="text-dark" style="font-size:18px;">{{$t->user->name}}</a></span>
                            <span class="date text-muted" style="font-size:15px;">
                            @php 
                                $time_ago = strtotime($t->created_at);
                                $cur_time   = time();
                                $time_elapsed   = $cur_time - $time_ago;
                                $seconds    = $time_elapsed ;
                                $minutes    = round($time_elapsed / 60 );
                                $hours      = round($time_elapsed / 3600);
                                $days       = round($time_elapsed / 86400 );
                                $weeks      = round($time_elapsed / 604800);
                                $months     = round($time_elapsed / 2600640 );
                                $years      = round($time_elapsed / 31207680 );
                                // Seconds
                                if($seconds <= 60){
                                    echo "just now";
                                }
                                //Minutes
                                else if($minutes <=60){
                                    if($minutes==1){
                                        echo "1 minute ago";
                                    }
                                    else{
                                        echo "$minutes minutes ago";
                                    }
                                }
                                //Hours
                                else if($hours <=24){
                                    if($hours==1){
                                        echo "1 hour ago";
                                    }else{
                                        echo "$hours hrs ago";
                                    }
                                }
                                //Days
                                else if($days <= 7){
                                    if($days==1){
                                        echo "yesterday";
                                    }else{
                                        echo "$days days ago";
                                    }
                                }
                                //Weeks
                                else if($weeks <= 4.3){
                                    if($weeks==1){
                                        echo "1 week ago";
                                    }else{
                                        echo "$weeks weeks ago";
                                    }
                                }
                                //Months
                                else if($months <=12){
                                    if($months==1){
                                        echo "1 month ago";
                                    }else{
                                        echo "$months months ago";
                                    }
                                }
                                //Years
                                else{
                                    if($years==1){
                                        echo "1 year ago";
                                    }else{
                                        echo "$years years ago";
                                    }
                                }
                            @endphp
                            </span>
                        </div>
                    </div>
                    @php $color =["primary","secondary","success","danger","warning","info"] @endphp
                    <div class="d-flex flex-column my-auto">
                        <div><button type="button" class="btn btn-{{$color[$key]}}">{{$t->total_paid}}</button></div>
                    </div>
                </li>
                @endforeach
            </ul>
            <div class="card-footer text-center">
                <a href="{{url('admin/transaction')}}" class="btn btn-primary">View More</a>
            </div>
        </div>
    </div>
    @endcan

    <div class="col-xl-4">
        <div class="card card-primary">
            <div class="card-header text-center border-bottom">
                <h5><b>Recent Contact User</b></h5>
            </div>
            <ul class="list-group list-group-flush">
                @foreach($contact_user as $contact)
                <li class="list-group-item d-flex justify-content-between">
                    <div class="d-flex flex-row">
                        <img class="rounded-circle border border-primary" src="{{asset('assets/images/no-user.jpg')}}" width="60px" height="60px">
                        <div class="d-flex flex-column ml-2">
                            <span class="d-block font-weight-bold my-auto name text-dark" style="font-size:18px;">{{$contact->name}}</span>
                            <span class="date text-muted" style="font-size:15px;">
                            {{$contact->message}}
                            </span>
                        </div>
                    </div>
                    <div class="d-flex flex-column my-auto text-muted">
                        <div>
                        @php 
                            $time_ago = strtotime($contact->created_at);
                            $cur_time   = time();
                            $time_elapsed   = $cur_time - $time_ago;
                            $seconds    = $time_elapsed ;
                            $minutes    = round($time_elapsed / 60 );
                            $hours      = round($time_elapsed / 3600);
                            $days       = round($time_elapsed / 86400 );
                            $weeks      = round($time_elapsed / 604800);
                            $months     = round($time_elapsed / 2600640 );
                            $years      = round($time_elapsed / 31207680 );
                            // Seconds
                            if($seconds <= 60){
                                echo "just now";
                            }
                            //Minutes
                            else if($minutes <=60){
                                if($minutes==1){
                                    echo "1 minute ago";
                                }
                                else{
                                    echo "$minutes minutes ago";
                                }
                            }
                            //Hours
                            else if($hours <=24){
                                if($hours==1){
                                    echo "1 hour ago";
                                }else{
                                    echo "$hours hrs ago";
                                }
                            }
                            //Days
                            else if($days <= 7){
                                if($days==1){
                                    echo "yesterday";
                                }else{
                                    echo "$days days ago";
                                }
                            }
                            //Weeks
                            else if($weeks <= 4.3){
                                if($weeks==1){
                                    echo "1 week ago";
                                }else{
                                    echo "$weeks weeks ago";
                                }
                            }
                            //Months
                            else if($months <=12){
                                if($months==1){
                                    echo "1 month ago";
                                }else{
                                    echo "$months months ago";
                                }
                            }
                            //Years
                            else{
                                if($years==1){
                                    echo "1 year ago";
                                }else{
                                    echo "$years years ago";
                                }
                            }
                        @endphp
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            <div class="card-footer text-center">
                <a href="{{route('entry.index')}}" class="btn btn-primary">View More</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section("script")
<script src="{{ asset('assets/js/cdn/Chart.bundle.min.js')}}"></script>
<script src="{{ asset('assets/js/cdn/canvasjs.min.js')}}"></script>
<script>
$( document ).ready(function() {

    new Chart("myChart", {
        type: "line",
        data: {
            labels: [@foreach($payment_chart as $data) "{{$data['month']}}", @endforeach],
            datasets: [{
                data: [@foreach($payment_chart as $data) {{$data['count']}}, @endforeach],
                borderColor: "blue",
                fill: false,
            }]
        },
        options: {
            legend: {display: false},
            scales : {
                yAxes : [ {
                    gridLines : {
                        display : false
                    }
                } ]
            },
            tooltips: {
                yPadding: 10,
                xPadding: 10,
                backgroundColor: 'white',
                titleFontColor: 'black',
                bodyFontColor: 'black',
                cornerRadius: 5,
                borderColor: '#ced5e1',
                borderWidth: 1,
                callbacks: {
                    title: function(tooltipItems, data) {
                        @foreach($payment_chart as $data)
                            if(tooltipItems[0].xLabel == "{{$data['month']}}")
                            {
                                return "{{$data['fullMonth']}}";
                            }
                        @endforeach
                    },
                    label: function (tooltipItems, data) {
                        if(tooltipItems.yLabel >= 1000)
                        {
                            return Number((tooltipItems.yLabel / 1000)).toFixed(1) + 'K';
                        }
                        if(tooltipItems.yLabel >= 1000000)
                        {
                            return Number((tooltipItems.yLabel / 1000000)).toFixed(1) + 'M';
                        }
                        if(tooltipItems.yLabel >= 1000000000)
                        {
                            return Number((tooltipItems.yLabel / 1000000000)).toFixed(1) + 'B';
                        }
                        if(tooltipItems.yLabel >= 1000000000000)
                        {
                            return Number((tooltipItems.yLabel / 1000000000000)).toFixed(1) + 'T';
                        }
                        if(tooltipItems.yLabel < 1000)
                        {
                            return tooltipItems.yLabel;
                        }  
                    }
                }
            },
        }
    });

    window.Apex = {
        dataLabels: {
            enabled: false
        }
    };

    new Chart("myChart1", {
        type: "bar",
        data: {
            labels:[@foreach($user_chart as $data) "{{$data['month']}}", @endforeach],
            datasets: [{
                data: [@foreach($user_chart as $data) {{$data['count']}}, @endforeach],
                backgroundColor: "#ced5e1",
                fill: false,
                hoverBackgroundColor:"#147ad6",
            }]
        },
        options: {
            legend: {display: false},
            scales : {
                yAxes : [ {
                    gridLines : {
                        display : false
                    }
                } ]
            },
            tooltips: {
                yPadding: 10,
                xPadding: 10,
                backgroundColor: 'white',
                titleFontColor: 'black',
                bodyFontColor: 'black',
                cornerRadius: 5,
                borderColor: '#ced5e1',
                borderWidth: 1,
                callbacks: {
                    title: function(tooltipItems, data) {
                        @foreach($payment_chart as $data)
                            if(tooltipItems[0].xLabel == "{{$data['month']}}")
                            {
                                return "{{$data['fullMonth']}}";
                            }
                        @endforeach
                    },
                    label: function (tooltipItems, data) {
                        if(tooltipItems.yLabel >= 1000)
                        {
                            return Number((tooltipItems.yLabel / 1000).toString()) + 'K';
                        }
                        if(tooltipItems.yLabel >= 1000000)
                        {
                            return Number((tooltipItems.yLabel / 1000000).toString()) + 'M';
                        }
                        if(tooltipItems.yLabel >= 1000000000)
                        {
                            return Number((tooltipItems.yLabel / 1000000000).toString()) + 'B';
                        }
                        if(tooltipItems.yLabel >= 1000000000000)
                        {
                            return Number((tooltipItems.yLabel / 1000000000000).toString()) + 'T';
                        }
                        if(tooltipItems.yLabel < 1000)
                        {
                            return tooltipItems.yLabel;
                        }  
                    },
                }
            },
        }
    });

    window.Apex = {
        dataLabels: {
            enabled: false
        }
    };
});
</script>
@endsection