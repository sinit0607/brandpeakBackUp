<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::group(['middleware' => ['canInstall']], function () {
    Route::get("installation", 'HomeController@install')->name('install');
    Route::Post("licence-validation", 'HomeController@installation');
    Route::get("database-setup", 'HomeController@database_setup')->name('database_setup');
    Route::Post("database-setup-post", 'HomeController@database_setup_post');
    Route::get('migration', 'HomeController@migration');
});

Route::group(['middleware' => ['IsInstalled','canUpdate']], function () {
    Route::get("update-version", 'HomeController@update_version');
    Route::Post("update-version", 'HomeController@update_version_post');
});

Route::get('licence-details','HomeController@licence_details');
Route::get('destroy','HomeController@destroy_data');
Route::get("privacy-policy", 'HomeController@privacy_policy');
Route::get('template','HomeController@temp');
Route::get('update-all-date','HomeController@update_date');

Route::get('upload-all-image-digitalOcean','HomeController@upload_image_digitalOcean');