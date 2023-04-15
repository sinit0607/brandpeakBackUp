<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::namespace ('Api')->middleware(['throttle'])->group(function () {
	Route::post('/login', 'AuthApi@login');
    Route::post('/registration', 'AuthApi@registration');
    Route::post('/google-registration', 'AuthApi@google_registration');
    Route::post('/phone-login', 'AuthApi@phone_login');
    Route::post('/forgot-password', 'AuthApi@forgot_password');
});

Route::namespace ('Api')->middleware(['throttle'])->group(function(){
    Route::post('/change-password', 'AuthApi@change_password');
    // Route::post('/register-fcm', 'AuthApi@register_fcm');
    // Route::post('/logout', 'AuthApi@logout');
    Route::post('/verify-account', 'AuthApi@verifyAccount'); 
    Route::post('/resend-verify-code', 'AuthApi@resendVerifyCode');

    Route::get('/user', 'AuthApi@user_data');
    Route::post('/profile-update', 'AuthApi@profile_update');

    Route::get('/get-home-data', 'HomeApi@getHomeData');
    Route::get('/story', 'HomeApi@getStory');
    Route::get('/festival', 'HomeApi@getFestival');
    Route::get('/category', 'HomeApi@getCategory');
    Route::get('/custom-post', 'HomeApi@customPost');
    Route::get('/personal', 'HomeApi@personal');
    Route::post('/search', 'HomeApi@search');

    Route::get('/news', 'HomeApi@getNews');
    Route::get('/business', 'HomeApi@getBusiness');
    Route::post('/add-business', 'HomeApi@addBusiness');
    Route::post('/update-business', 'HomeApi@updateBusiness');
    Route::post('/delete-business', 'HomeApi@deleteBusiness');
    Route::get('/get-post', 'HomeApi@getPost');

    Route::get('/language', 'HomeApi@getLanguage');
    Route::get('/subscription-plan', 'HomeApi@getSubscriptionplan');

    Route::post('/create-payment', 'HomeApi@addPayment');
    Route::post('stripe-payment', 'HomeApi@stripePayment');
    Route::post('paytm-payment','HomeApi@paytmPayment');
    // Route::post('verify-Paytm-payment','HomeApi@verifyPaytmPayment');
    Route::post('offline-payment', 'HomeApi@offlinePayment');
    Route::get('/payment-details', 'HomeApi@getPaymentDetails');
    Route::post('/create-order-cashfree', 'HomeApi@create_order_cashfree');
    Route::post('get-val','HomeApi@get_val');

    Route::get('/contact-subject', 'HomeApi@getContactSubject');
    Route::post('/contact-massage', 'HomeApi@postContacts');
    Route::get('/app-about', 'HomeApi@getAppAbout');
    Route::post('/set-default-business', 'HomeApi@setDefaultBusiness');

    Route::get('/custom-category', 'HomeApi@getCustomCategory');
    Route::get('/custom-frame', 'HomeApi@getCustomFrame');

    Route::get('/business-category', 'HomeApi@getBusinessCategory');
    Route::get('/business-sub-category', 'HomeApi@getBusinessSubCategory');
    Route::get('/business-frame', 'HomeApi@getBusinessFrame');

    Route::get('/get-sticker', 'HomeApi@getSticker');
    Route::post('/search-sticker', 'HomeApi@searchSticker');

    Route::get('/product-category', 'HomeApi@getProductCategory');
    Route::get('/product', 'HomeApi@getProduct');
    Route::post('/inquiry', 'HomeApi@postInquiry');
    Route::get('/poster-category', 'HomeApi@posterCategory');
    Route::post('/poster-json', 'HomeApi@getPosterJson');
    Route::post('/withdraw-request', 'HomeApi@withdraw_request');
    Route::get('/referral-detail', 'HomeApi@referral_detail');

    Route::get('/user-custom-frame', 'HomeApi@userCustomFrame');

    Route::get('/get-video', 'HomeApi@getVideo');
    Route::post('/coupon-code-validation', 'HomeApi@coupon_code_validation');
    Route::post('/profile-card', 'HomeApi@profile_card');
    Route::post('/profile-card-image-upload', 'HomeApi@profile_card_image_upload');
    Route::get('/business-card-list', 'HomeApi@business_card_list');

    Route::Post('whatsapp-api','HomeApi@whatsapp_api');
});

Route::middleware('auth:api')->post('/user', function (Request $request) {
	return $request->user();
});