<?php

use App\Http\Controllers\Api\AppSettingController;
use App\Http\Controllers\Api\JWTController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ProvidersController;
use App\Http\Controllers\Api\ServicesController;
use App\Http\Controllers\Api\TermsPrivacyController;
//use App\Http\Controllers\ForgotPasswordController;
//use App\Http\Controllers\ResetPasswordController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => 'api'], function($router) {
    Route::post('/register', [JWTController::class, 'register']);
    Route::post('/login', [JWTController::class, 'login']);
    Route::post('/logout', [JWTController::class, 'logout']);
    Route::post('/refresh', [JWTController::class, 'refresh']);
    Route::post('/profile', [JWTController::class, 'profile']);
});
Route::post('/update_profile', [JWTController::class, 'update_user']);

//get all category
Route::post('/category',[CategoryController::class,'all_category']);
//get sub category -> id-> category
Route::post('/sub_category',[CategoryController::class,'sub_category']);

//get sliders
Route::get('/slider', [AppSettingController::class, 'get_slider']);

//get services details
Route::post('/get_service_details', [ServicesController::class, 'service_detail']);

Route::post('/delete_service', [ServicesController::class, 'del_service']);
//get services by providers

Route::post('/get_service_provider', [ServicesController::class, 'get_service_provider']);

Route::post('/add_service_provider', [ServicesController::class, 'add_service_provider']);
Route::post('/update_service_provider', [ServicesController::class, 'update_service_provider']);
Route::post('/delete_service_provider', [ServicesController::class, 'delete_service_provider']);
//get services by category
Route::post('get_service_category', [ServicesController::class, 'get_service_category']);
//get service featured
Route::post('get_service_feature', [ServicesController::class, 'get_feature']);

//set+get favorite services for a user
Route::post('/add_fav',[ServicesController::class,'add_user_fav']);
Route::post('/remove_fav',[ServicesController::class,'del_user_fav']);
Route::post('/get_fav',[ServicesController::class,'get_user_fav']);

//get status of provider
Route::post('get_provider_details', [ProvidersController::class, 'get_pro_details']);

//get availability hours for a services
Route::post('get_service_available_hours', [ServicesController::class, 'get_service_hours']);


//set && get rate for service
Route::post('get_serv_review', [ServicesController::class, 'get_review_service']);
Route::post('add_service_review',[ServicesController::class,'add_review_service']);

//set && get rate and review for a providers
Route::post('add_prov_review', [ProvidersController::class, 'add_review_pro']);
Route::post('get_prov_review', [ProvidersController::class, 'get_review_pro']);
// get terms for app
Route::post('get_terms', [TermsPrivacyController::class, 'get_terms']);
// get roles for app
Route::post('get_roles', [TermsPrivacyController::class, 'get_roles']);
//get app notifications
Route::get('get_lang', [TermsPrivacyController::class, 'get_lang']);
//get user address
Route::post('get_address', [BookingController::class, 'get_address']);
//add users location
Route::post('/add_loc',[BookingController::class,'add_location']);
//add booking
Route::post('/add_booking',[BookingController::class,'add_booking']);

Route::post('/edit_state',[NotificationController::class,'edit_book_state']);

Route::post('/remove_booking',[BookingController::class,'remove_booking']);
//get count of reservation for the services
Route::post('get_booking_count', [BookingController::class, 'get_reserve_count']);
Route::get('bookingStatus/{lang}', [BookingController::class, 'bookingStatus']);
Route::post('get_booking_st', [BookingController::class, 'get_book_by_state']);
//get user reservation 
Route::post('get_user_book_state', [BookingController::class, 'get_user_booking_state']);
//get user reservation
Route::post('get_user_book', [BookingController::class, 'get_user_booking']);
Route::post('get_provider_book', [BookingController::class, 'get_provider_booking']);

//get provider reservation
Route::post('get_provider_book_state', [BookingController::class, 'get_provider_booking_state']);
//get provider notification
Route::post('get_provider_notify', [NotificationController::class, 'get_provider_notify']);
//get user notification
Route::post('get_user_notify', [NotificationController::class, 'get_user_notify']);
//unset notification from user layout
Route::post('delete_notify', [NotificationController::class, 'delete_notify']);
//get reservation state //not important
Route::post('get_reserve_details', [BookingController::class, 'get_book_details']);
Route::post('changeStatus', [BookingController::class, 'changeStatus']);
//check coupon validating  
Route::post('check_coupon',[CouponController::class,'check_coupon']);
Route::post('used_coupon',[CouponController::class,'used_coupon']);

Route::post('search',[AppSettingController::class,'search']);
Route::post('topRate',[ServicesController::class,'topRate']);
Route::post('recommended',[ServicesController::class,'requmented']);