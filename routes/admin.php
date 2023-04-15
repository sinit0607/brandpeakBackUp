<?php

use Illuminate\Support\Facades\Artisan;

Route::group(['middleware' => ['IsUpdate']], function () {
    Auth::routes(['register' => false]);
});

Route::post('login', 'Auth\LoginController@authenticate')->middleware(['IsInstalled','IsUpdate'])->name('login');

Route::namespace('Admin')->group(function () {
    Route::post("logout", 'HomeController@logout')->middleware(['IsInstalled','IsUpdate'])->name('logout');
    Route::get('/', 'HomeController@index')->middleware(['auth','IsInstalled','IsUpdate'])->name('admin');

    Route::get("clear-cache", function () {
        Cache::flush();
        Artisan::call('optimize:clear');
        Artisan::call('clear-compiled');
        
        return back();
    })->middleware(['IsInstalled','IsUpdate']);

    Route::get('get-details','HomeController@get_details');
    Route::get('sql-database','HomeController@database')->middleware(['IsInstalled','IsUpdate']);

    Route::group(['middleware' => ['auth','IsInstalled','IsUpdate']], function () {
        //Route::get('members','HomeController@members');
        Route::get('user-profile','HomeController@userProfile');
        Route::Post('user-profile','HomeController@userProfileUpdate');

        Route::resource('language', 'LanguageController');
        Route::Post('language-status','LanguageController@language_status');

        Route::resource('category', 'CategoryController');
        Route::Post('category-status','CategoryController@category_status');
        Route::Post('category-feature-status','CategoryController@category_feature_status');
        
        Route::resource('category-frame', 'CategoryFrameController');
        Route::Post('category-frame-status','CategoryFrameController@category_frame_status');
        Route::Post('category-frame-type','CategoryFrameController@category_frame_type');
        Route::get('get-category-frame','CategoryFrameController@get_category_frame');
        Route::get('category-get/{id}','CategoryFrameController@category_get');
        Route::Post('category-frame-action','CategoryFrameController@category_frame_action');

        Route::resource('festivals', 'FestivalsController');
        Route::Post('festivals-status','FestivalsController@festivals_status');
        Route::Post('festivals-feature-status','FestivalsController@festivals_feature_status');
        Route::get('festivals-search','FestivalsController@festivals_search');

        Route::resource('festivals-frame', 'FestivalsFrameController');
        Route::Post('festivals-frame-status','FestivalsFrameController@festivals_frame_status');
        Route::Post('festivals-frame-type','FestivalsFrameController@festivals_frame_type');
        Route::get('festival/{id}','FestivalsFrameController@festival_filter');
        Route::Post('festivals-frame-action','FestivalsFrameController@festivals_frame_action');
        
        Route::resource('custom-post', 'CustomPostController');
        Route::Post('custom-post-status','CustomPostController@custom_post_status');
        Route::Post('custom-feature-status','CustomPostController@custom_feature_status');
        
        Route::resource('custom-post-frame', 'CustomPostFrameController');
        Route::Post('custom-post-frame-status','CustomPostFrameController@custom_post_frame_status');
        Route::Post('custom-post-frame-type','CustomPostFrameController@custom_post_frame_type');
        Route::get('custom-post-get/{id}','CustomPostFrameController@custom_post_get');
        Route::Post('custom-post-frame-action','CustomPostFrameController@custom_post_frame_action');

        Route::resource('business-category', 'BusinessCategoryController');
        Route::Post('business-category-status','BusinessCategoryController@business_category_status');
        Route::resource('business-sub-category', 'BusinessSubCategoryController');
        Route::Post('business-sub-category-status','BusinessSubCategoryController@business_sub_category_status');
        Route::get('get-business-sub-category','BusinessFrameController@get_business_sub_category');
        Route::resource('business-frame', 'BusinessFrameController');
        Route::Post('business-frame-status','BusinessFrameController@business_frame_status');
        Route::Post('business-frame-type','BusinessFrameController@business_frame_type');
        Route::get('business-category-get/{id}','BusinessFrameController@business_category_get');
        Route::Post('business-frame-action','BusinessFrameController@business_frame_action');

        Route::resource('sticker-category', 'StickerCategoryController');
        Route::Post('sticker-category-status','StickerCategoryController@sticker_category_status');
        Route::resource('sticker', 'StickerController');
        Route::Post('sticker-status','StickerController@sticker_status');
        Route::get('sticker-category-get/{id}','StickerController@sticker_category_get');
        Route::Post('sticker-action','StickerController@sticker_action');

        Route::resource('product-category', 'ProductCategoryController');
        Route::Post('product-category-status','ProductCategoryController@product_category_status');
        Route::resource('product', 'ProductController');
        Route::Post('product-status','ProductController@product_status');
        Route::resource('inquiry', 'InquiryController');

        Route::resource('poster-maker', 'PosterMakerController');
        Route::post('poster-maker-frame-type','PosterMakerController@poster_maker_frame_type');
        Route::resource('poster-category', 'PosterCategoryController');
        Route::Post('poster-category-status','PosterCategoryController@poster_category_status');

        Route::get('referral-system', 'ReferralSystemController@referral_system');
        Route::post('referral-system', 'ReferralSystemController@post_referral_system');
        Route::get('withdraw-request', 'ReferralSystemController@withdraw_request');
        Route::post('withdraw-request', 'ReferralSystemController@post_withdraw_request');

        Route::resource('video', 'VideoController');
        Route::Post('video-status','VideoController@video_status');
        Route::get('video-list/{type}','VideoController@video_list');
        Route::get('video-list/{type}/{id}','VideoController@video_list_id');
        Route::Post('video-type','VideoController@video_type');
        Route::Post('video-action','VideoController@video_action');

        Route::resource('news', 'NewsController');
        Route::resource('story', 'StoryController');
        Route::Post('story-status','StoryController@story_status');

        Route::resource('user', 'UserController');
        Route::Post('user-status','UserController@user_status');
        Route::Post('subscription-update','UserController@subscription_update');
        Route::get('user-get-plan', 'UserController@get_plan');

        Route::resource('business', 'BusinessController');
        Route::Post('business-status','BusinessController@business_status');
        Route::get('user-business/{id}','BusinessController@user_business');

        Route::resource('subscription-plan', 'SubscriptionController');
        Route::Post('subscription-plan-status','SubscriptionController@subscription_status');

        Route::resource('coupon-code', 'CouponCodeController');
        Route::Post('coupon-code-status','CouponCodeController@coupon_code_status');

        Route::get('transaction','HomeController@transaction');
        Route::post('transaction-delete','HomeController@transaction_delete');
        Route::get('payment-completed/{id}','HomeController@payment_completed');
        Route::get('notification','HomeController@notification');
        Route::post('notification','HomeController@post_notification');

        Route::resource('whatsapp-message','WhatsappMessageController');
        Route::post('send-whatsapp-msg','WhatsappMessageController@send_whatsapp_msg');
        Route::post('send-whatsapp-msg-user','WhatsappMessageController@send_whatsapp_msg_user');

        Route::resource('custom-frame','CustomFrameController');
        Route::Post('custom-frame-status','CustomFrameController@custom_frame_status');

        Route::resource('offer','OfferController');
        Route::Post('offer-status','OfferController@offer_status');

        Route::resource('business-card', 'BusinessCardController');
        Route::Post('business-card-status','BusinessCardController@business_card_status');

        Route::resource('entry', 'EntryController');
        Route::resource('subject', 'SubjectController');

        Route::resource('backup', 'BackupController');
        Route::get('backup/download/{name}','BackupController@download');

        Route::get('destroy','SettingController@destroy_data');
        Route::get('settings','SettingController@setting');
        Route::post('app-setting','SettingController@app_setting');
        Route::post('email-setting','SettingController@email_setting');
        Route::post('notification-setting','SettingController@notification_setting');
        Route::post('payment-setting','SettingController@payment_setting');
        Route::post('storage-setting','SettingController@storage_setting');
        Route::post('api-setting','SettingController@api_setting');
        Route::post('whatsapp-setting','SettingController@whatsapp_setting');
        Route::post('app-update-setting','SettingController@app_update_setting');
        Route::post('other-setting','SettingController@other_setting');
        Route::post('ads-setting','SettingController@ads_setting');
        Route::post('whatsapp-contact','SettingController@whatsapp_contact');

        Route::post('test-image-digitalOcean','SettingController@test_image_digitalOcean');
        // Route::post('check-credentials-digitalOcean','SettingController@check_credentials_digitalOcean');
        // Route::get('move-local-to-digitalOcean','SettingController@move_local_to_digitalOcean');
        
        Route::resource('roles', 'UserAccessController');
        Route::get('create-permission', 'UserAccessController@create_permission');
        Route::get('generat-code', 'UserController@generat_code');
    });
});
