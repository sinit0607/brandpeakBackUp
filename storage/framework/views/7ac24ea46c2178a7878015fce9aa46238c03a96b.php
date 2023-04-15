<?php $__env->startSection('extra_css'); ?>
<style type="text/css">

</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <a href="<?php echo e(route('user.index')); ?>">
            <div class="info-box" style="border-radius: 7px;background-color: #28C76F;color:white;">
                <span class="info-box-icon ml-3"><img src="<?php echo e(asset('assets/images/icon/User.svg')); ?>"/></span>
                <div class="info-box-content text-right">
                    <span class="info-box-text mt-2"><b>Total User</b></span>
                    <span class="info-box-number mb-2"><h2><?php echo e($user_count-1); ?></h2></span>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-3 col-xs-6">
        <a href="<?php echo e(route('category.index')); ?>">
            <div class="info-box" style="border-radius: 7px;background-color: #FF3EA6;color:white;">
                <span class="info-box-icon ml-3"><img src="<?php echo e(asset('assets/images/icon/Category.svg')); ?>"/></span>
                <div class="info-box-content text-right">
                    <span class="info-box-text mt-2"><b>Total Category</b></span>
                    <span class="info-box-number mb-2"><h2><?php echo e($category_count); ?></h2></span>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-3 col-xs-6">
        <a href="<?php echo e(route('festivals.index')); ?>">
            <div class="info-box" style="border-radius: 7px;background-color: #1E9FF2;color:white;">
                <span class="info-box-icon ml-3"><img src="<?php echo e(asset('assets/images/icon/Festival.svg')); ?>"/></span>
                <div class="info-box-content text-right">
                    <span class="info-box-text mt-2"><b>Total Festival</b></span>
                    <span class="info-box-number mb-2"><h2><?php echo e($festivals_count); ?></h2></span>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-3 col-xs-6">
        <a href="<?php echo e(route('business.index')); ?>">
            <div class="info-box" style="border-radius: 7px;background-color: #FF9F43;color:white;">
                <span class="info-box-icon ml-3"><img src="<?php echo e(asset('assets/images/icon/Business.svg')); ?>"/></span>
                <div class="info-box-content text-right">
                    <span class="info-box-text mt-2"><b>Total Business</b></span>
                    <span class="info-box-number mb-2"><h2><?php echo e($business_count); ?></h2></span>
                </div>
            </div>
        </a>
    </div>
</div>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('FinancialStatistics')): ?>
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <div class="info-box bg-light">
            <span class="info-box-icon mt-1 mb-1" style="background-color:#1E9FF2;color:white;"><img src="<?php echo e(asset('assets/images/icon/Today Payment.svg')); ?>"/></span>
            <div class="info-box-content" style="color:#1E9FF2;">
                <span class="info-box-text"><b>Today Payment</b></span>
                <span class="info-box-number"><h3><b><?php echo e(App\Models\AppSetting::getAppSetting('currency')); ?> <?php echo e($today_payment); ?></b></h3></span>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <div class="info-box bg-light">
            <span class="info-box-icon mt-1 mb-1" style="background-color:#28C76F;color:white;"><img src="<?php echo e(asset('assets/images/icon/Weekly Payment.svg')); ?>"/></span>
            <div class="info-box-content" style="color:#28C76F;">
                <span class="info-box-text"><b>Weekly Payment</b></span>
                <span class="info-box-number"><h3><b><?php echo e(App\Models\AppSetting::getAppSetting('currency')); ?> <?php echo e($weekly_payment); ?></b></h3></span>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <div class="info-box bg-light">
            <span class="info-box-icon mt-1 mb-1" style="background-color:#4634FF;color:white;"><img src="<?php echo e(asset('assets/images/icon/Monthly Payment.svg')); ?>"/></span>
            <div class="info-box-content" style="color:#4634FF;">
                <span class="info-box-text"><b>Monthly Payment</b></span>
                <span class="info-box-number"><h3><b><?php echo e(App\Models\AppSetting::getAppSetting('currency')); ?> <?php echo e($monthly_payment); ?></b></h3></span>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <div class="info-box bg-light">
            <span class="info-box-icon mt-1 mb-1" style="background-color:#FF3EA6;color:white;"><img src="<?php echo e(asset('assets/images/icon/Total Payment.svg')); ?>"/></span>
            <div class="info-box-content" style="color:#FF3EA6;">
                <span class="info-box-text"><b>Total Payment</b></span>
                <span class="info-box-number"><h3><b><?php echo e(App\Models\AppSetting::getAppSetting('currency')); ?> <?php echo e($transaction_count); ?></b></h3></span>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-md-12">
        <div class="row">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('FinancialStatistics')): ?>
            <div class="col-md-6">
                <div class="card card-light">
                    <div class="card-header text-primary border-bottom"><h5><b>Monthly Payment Report</b></h5></div>
                    <div class="card-body">
                        <canvas id="myChart" style="width:100%;max-width:800px"></canvas>
                    </div>
                </div>
            </div>
            <?php endif; ?>
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
            <?php $__currentLoopData = $today_event; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-xl-1 col-md-4 col-6 text-center">
                <img class="rounded-circle border border-primary mb-2" src="<?php if($e->image): ?> <?php if(App\Models\StorageSetting::getStorageSetting('storage') == 'DigitalOcean'): ?><?php echo e(\Storage::disk('spaces')->url('uploads/'.$e->image)); ?> <?php else: ?> <?php echo e(asset('uploads/'.$e->image)); ?> <?php endif; ?> <?php else: ?> <?php echo e(asset('assets/images/noimage.png')); ?> <?php endif; ?>" width="100px" height="100px"></br>
                <span class="text-primary" style="font-size:15px;"><?php echo e($e->title); ?></span>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="text-primary"><b>User Subscription Plan Expire</b></h5>
    </div>
    <div class="card-body">
        <div class="row grid7">
            <?php $__currentLoopData = $subscription_end_user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription_user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-xl-1 col-md-4 col-6 text-center">
                <img class="rounded-circle border border-primary mb-2" src="<?php if($subscription_user->image): ?> <?php if(substr($subscription_user->image, 0, 4)=='http'): ?> <?php echo e($subscription_user->image); ?> <?php else: ?> <?php if(App\Models\StorageSetting::getStorageSetting('storage') == 'DigitalOcean'): ?><?php echo e(\Storage::disk('spaces')->url('uploads/'.$subscription_user->image)); ?> <?php else: ?> <?php echo e(asset('uploads/'.$subscription_user->image)); ?> <?php endif; ?> <?php endif; ?> <?php else: ?> <?php echo e(asset('assets/images/no-user.jpg')); ?> <?php endif; ?>" width="100px" height="100px"></br>
                <span class="text-primary" style="font-size:15px;"><a href="<?php echo e(url('admin/user/'.$subscription_user->id)); ?>"><?php echo e($subscription_user->name); ?></a></span><br>
                <span class="text-primary" style="font-size:15px;"><a href="<?php echo e(url('admin/user/'.$subscription_user->id)); ?>"><?php echo e(date('d M, y',strtotime($subscription_user->subscription_end_date))); ?></a></span>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                <?php $__currentLoopData = $user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($u->email != "demo2023@gmail.com"): ?>
                    <li class="list-group-item">
                        <div class="d-flex flex-row">
                            <img class="rounded-circle border border-primary" src="<?php if($u->image): ?> <?php if(substr($u->image, 0, 4)=='http'): ?> <?php echo e($u->image); ?> <?php else: ?> <?php if(App\Models\StorageSetting::getStorageSetting('storage') == 'DigitalOcean'): ?><?php echo e(\Storage::disk('spaces')->url('uploads/'.$u->image)); ?> <?php else: ?> <?php echo e(asset('uploads/'.$u->image)); ?> <?php endif; ?> <?php endif; ?> <?php else: ?> <?php echo e(asset('assets/images/no-user.jpg')); ?> <?php endif; ?>" width="60px" height="60px">
                            <div class="d-flex flex-column ml-3">
                                <span class="d-block font-weight-bold my-auto name"><a href="<?php echo e(url('admin/user/'.$u->id)); ?>" class="text-dark" style="font-size:18px;"><?php echo e($u->name); ?></a></span>
                                <span class="date text-muted" style="font-size:15px;">
                                <?php 
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
                                ?>
                                </span>
                            </div>
                        </div>
                    </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <div class="card-footer text-center">
                <a href="<?php echo e(route('user.index')); ?>" class="btn btn-primary">View More</a>
            </div>
        </div>
    </div>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('FinancialStatistics')): ?>
    <div class="col-xl-4">
        <div class="card card-primary">
            <div class="card-header text-center border-bottom">
                <h5><b>Recent Purchase</b></h5>
            </div>
            <ul class="list-group list-group-flush">
                <?php $__currentLoopData = $transaction; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="list-group-item d-flex justify-content-between">
                    <div class="d-flex flex-row">
                        <img class="rounded-circle border border-primary" src="<?php if($t->user->image): ?> <?php if(substr($t->user->image, 0, 4)=='http'): ?> <?php echo e($t->user->image); ?> <?php else: ?> <?php if(App\Models\StorageSetting::getStorageSetting('storage') == 'DigitalOcean'): ?><?php echo e(\Storage::disk('spaces')->url('uploads/'.$t->user->image)); ?> <?php else: ?> <?php echo e(asset('uploads/'.$t->user->image)); ?> <?php endif; ?> <?php endif; ?> <?php else: ?> <?php echo e(asset('assets/images/no-user.jpg')); ?> <?php endif; ?>" width="60px" height="60px">
                        <div class="d-flex flex-column ml-2">
                            <span class="d-block font-weight-bold my-auto name"><a href="<?php echo e(url('admin/user/'.$t->user->id)); ?>" class="text-dark" style="font-size:18px;"><?php echo e($t->user->name); ?></a></span>
                            <span class="date text-muted" style="font-size:15px;">
                            <?php 
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
                            ?>
                            </span>
                        </div>
                    </div>
                    <?php $color =["primary","secondary","success","danger","warning","info"] ?>
                    <div class="d-flex flex-column my-auto">
                        <div><button type="button" class="btn btn-<?php echo e($color[$key]); ?>"><?php echo e($t->total_paid); ?></button></div>
                    </div>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <div class="card-footer text-center">
                <a href="<?php echo e(url('admin/transaction')); ?>" class="btn btn-primary">View More</a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="col-xl-4">
        <div class="card card-primary">
            <div class="card-header text-center border-bottom">
                <h5><b>Recent Contact User</b></h5>
            </div>
            <ul class="list-group list-group-flush">
                <?php $__currentLoopData = $contact_user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="list-group-item d-flex justify-content-between">
                    <div class="d-flex flex-row">
                        <img class="rounded-circle border border-primary" src="<?php echo e(asset('assets/images/no-user.jpg')); ?>" width="60px" height="60px">
                        <div class="d-flex flex-column ml-2">
                            <span class="d-block font-weight-bold my-auto name text-dark" style="font-size:18px;"><?php echo e($contact->name); ?></span>
                            <span class="date text-muted" style="font-size:15px;">
                            <?php echo e($contact->message); ?>

                            </span>
                        </div>
                    </div>
                    <div class="d-flex flex-column my-auto text-muted">
                        <div>
                        <?php 
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
                        ?>
                        </div>
                    </div>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <div class="card-footer text-center">
                <a href="<?php echo e(route('entry.index')); ?>" class="btn btn-primary">View More</a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("script"); ?>
<script src="<?php echo e(asset('assets/js/cdn/Chart.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/cdn/canvasjs.min.js')); ?>"></script>
<script>
$( document ).ready(function() {

    new Chart("myChart", {
        type: "line",
        data: {
            labels: [<?php $__currentLoopData = $payment_chart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> "<?php echo e($data['month']); ?>", <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>],
            datasets: [{
                data: [<?php $__currentLoopData = $payment_chart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($data['count']); ?>, <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>],
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
                        <?php $__currentLoopData = $payment_chart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            if(tooltipItems[0].xLabel == "<?php echo e($data['month']); ?>")
                            {
                                return "<?php echo e($data['fullMonth']); ?>";
                            }
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
            labels:[<?php $__currentLoopData = $user_chart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> "<?php echo e($data['month']); ?>", <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>],
            datasets: [{
                data: [<?php $__currentLoopData = $user_chart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($data['count']); ?>, <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>],
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
                        <?php $__currentLoopData = $payment_chart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            if(tooltipItems[0].xLabel == "<?php echo e($data['month']); ?>")
                            {
                                return "<?php echo e($data['fullMonth']); ?>";
                            }
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\brandkit\resources\views/home.blade.php ENDPATH**/ ?>