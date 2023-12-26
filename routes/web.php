<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppSettingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AvailabilityHoursController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingStateController;
use App\Http\Controllers\BookNotifyController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PaymentStateController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ProviderReviewController;
use App\Http\Controllers\ProviderWorkHourController;
use App\Http\Controllers\RoleConditionController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\ServiceViewController;
use App\Http\Controllers\SubProvController;
use App\Http\Controllers\SubscriptionsController;
use App\Http\Controllers\TermPrivacyController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserFavController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



//Route::head('/', function () {return view('auth.login');});
//Route::view('/', 'auth.login');

Route::get('/',function (){
    return view('auth.login');
});
//Route::get('/',[LoginController::class,'showLoginForm']);
Route::get('/home', [HomeController::class, 'index'])->name('home');

//Route::group(['middleware' => ['auth']], function() {
//    Route::get('/home', [AppSettingController::class,'home'])->name('home');


Route::group(['middleware' => ['auth']], function () {



    Route::get('/profile', [UserController::class, 'showProfile'])->name("profile");
    Route::post('/profile', [UserController::class, 'updateProfile'])->name("profile.update");

    Route::post("/logout",[UserController::class ,'logout'])->name("logout");

    
//provider route \
Route::resource('providers',ProviderController::class);
Route::resource('prov_review',ProviderReviewController::class);
Route::resource('prov_work',ProviderWorkHourController::class);
Route::resource('providers_subs',SubProvController::class);
Route::post('agree/providerReview/{id}',[ProviderReviewController::class,'agree'])->name('review.agree');

Route::get('accepted/providers',[ProviderController::class,'acceptableProviders'])->name('providers.accepted');
Route::post('agree/provider/{id}',[ProviderController::class,'agree'])->name('providers.agree');

    Route::resource('admin',AdminController::class);
//user route
    Route::resource('users',UserController::class);
    Route::get('accepted/users',[UserController::class,'acceptableUsers'])->name('users.accepted');
    Route::post('agree/user/{id}',[UserController::class,'agree'])->name('users.agree');

//coupon route
    Route::resource('coupons',CouponController::class);
    Route::resource('subscriptions',SubscriptionsController::class);
Route::post('edit_sub',[SubscriptionsController::class, 'update_sub'])->name('update_sub');

Route::get('filter/service/provider/{id}', [CouponController::class,'getServices'])->name('services.filter');


    Route::post('projects/store/{table}', [MediaController::class, 'storeMedia'])
        ->name('projects.storeMedia');

    Route::post('projects/delete/{table}', [MediaController::class, 'storeMedia'])
        ->name('projects.deleteMedia');

//services route
    Route::resource('services',ServicesController::class);
    Route::resource('services_review',ServiceViewController::class);

    Route::post('/service_image',[ServicesController::class,'service_image'])->name('service_image');
    Route::get('add_new_serv',[ServicesController::class, 'add_new_serv']);
    Route::post('edit_serv',[ServicesController::class, 'update_serv'])->name('services_update');

    Route::get('filter/service/{cat_id}',[ServicesController::class, 'filter'])->name('service');

    Route::get('accepted/review',[ServiceViewController::class,'acceptableReviews'])->name('review.accepted');
    // Route::post('agree/review/{id}',[ServiceViewController::class,'agree'])->name('review.agree');
//category route
    Route::resource('categories',CategoriesController::class);

    Route::get('add_new',[CategoriesController::class, 'add_new_cat']);
    Route::post('edit_cat',[CategoriesController::class, 'update_cat'])->name('update_cat');
    Route::post('/category_image',[CategoriesController::class,'category_image'])->name('category_image');

Route::resource('availability_hours',AvailabilityHoursController::class);

//booking
    Route::resource('bookings',BookingController::class);
    Route::get('accepted/bookings',[BookingController::class,'acceptableBooking'])->name('booking.accepted');
    Route::post('agree/booking/{id}',[BookingController::class,'agree'])->name('booking.agree');
    Route::resource('payment_method',PaymentMethodController::class);
    Route::resource('payment_state',PaymentStateController::class);
    Route::resource('bookingStates',BookingStateController::class);
    Route::resource('notify',BookNotifyController::class);

//
    Route::resource('term_privacy',TermPrivacyController::class);
    Route::get('add_new_term',[TermPrivacyController::class, 'add_new_term']);
    Route::post('update_term',[TermPrivacyController::class, 'update_ter'])->name('update_term');

    Route::resource('role_condition',RoleConditionController::class);
    Route::get('add_new_cond',[RoleConditionController::class, 'add_new_role']);
    Route::post('update_rol',[RoleConditionController::class, 'update_role'])->name('update_role');

Route::resource('setting',AppSettingController::class);
    Route::resource('colors',ColorController::class);

    Route::resource('user_address',UserAddressController::class);

    Route::resource('user_fav',UserFavController::class);

    Route::resource('sliders',AppSettingController::class);
    Route::post('/slider_image',[CategoriesController::class,'slider_image'])->name('slider_image');


//    });
    Route::get('storage-link', function(){
        return Artisan::call('storage:link');
    });

//    Route::get('locale',[AppSettingController::class,'getLocal']);
//    Route::post('setlocale/{locale}',function($lang){
//        \App::setlocale($lang);
//        \Session::put('locale',$lang);
//        return redirect()->back();
//    });

Route::get('/changeLanguage/{locale}', function ($locale) {
    App::setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
});
});
Auth::routes();
