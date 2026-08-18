<?php

use App\Http\Controllers\API\Seller\SpecificationController;
use App\Http\Controllers\API\Seller\VehicleController;
use App\Http\Controllers\API\Seller\VehicleDetailsController;
use App\Http\Controllers\API\User\ChatController;
use App\Http\Controllers\API\User\CMSController;
use App\Http\Controllers\API\User\ReviewController;
use App\Http\Controllers\API\UserAuthController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware(['jwt.verify'])->prefix('user')->group(function () {
    // Live Chat Route
    Route::controller(ChatController::class)->group(function () {
        Route::post('/chat/send', 'sendMessage');
        Route::post('/chat/get', 'fetchMessages');
    });
    // Review Routes
    Route::controller(ReviewController::class)->group(function () {
        Route::get('/review/get', 'get')->name('review.get');
        Route::post('/review/store', 'store')->name('review.store');
    });
});

// CMS CONTENTS
Route::controller(CMSController::class)->prefix('cms')->group(function () {
    Route::get('/get/aboutus', 'aboutus')->name('cms.aboutus');
    Route::get('/get/blogs', 'blogs')->name('cms.blogs');
    Route::get('/single/blog/{slug}', 'signleblogs')->name('cms.signleblogs');
    Route::get('/get/testmonial', 'testmonial')->name('cms.testmonial');
    Route::get('/get/faqs', 'faqs')->name('cms.faqs');
    Route::get('/page/{page_slug}', 'dynamicPage')->name('cms.dynamicPage');
    Route::get('/site/info', 'site')->name('cms.site');
});


Route::prefix('seller')->group(function () {
    // Specification
    Route::controller(SpecificationController::class)->group(function () {
        Route::get('/get/bodyType', 'bodyType')->name('specification.bodyType');
        Route::get('/get/transmission', 'transmission')->name('specification.transmission');
        Route::get('/get/fuelType', 'fuelType')->name('specification.fuelType');
        Route::get('/get/size', 'size')->name('specification.size');
        Route::get('/get/door', 'door')->name('specification.door');
        Route::get('/get/mileage', 'mileage')->name('specification.mileage');
        Route::get('/get/drivetrain', 'drivetrain')->name('specification.drivetrain');
        Route::get('/get/cylinder', 'cylinder')->name('specification.cylinder');
        Route::get('/get/mpg', 'mpg')->name('specification.mpg');
        Route::get('/get/color', 'color')->name('specification.color');
    });
    // Vehicle Details
    Route::controller(VehicleDetailsController::class)->group(function () {
        Route::get('/get/categories', 'categories');
        Route::get('/get/brands', 'brands');
        Route::get('/get/imageType', 'imageType');
        Route::get('/get/tags', 'tags');
        Route::get('/get/years', 'years');
    });
    Route::controller(VehicleController::class)->group(function () {
        Route::post('/vehicles', 'get');
        Route::post('/vehicle/create', 'create')->name('vehicle.create');
        Route::get('/vehicle/edit/{id}', 'edit')->name('vehicle.edit');
        Route::post('/vehicle/store', 'store')->name('vehicle.store');
        Route::post('/vehicle/update', 'update')->name('vehicle.update');
        Route::patch('/vehicle/status', 'status')->name('vehicle.status');
        Route::get('/vehicle/delete/{id}', 'destroy')->name('vehicle.destroy');
    });
});


Route::controller(UserAuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');

    // Resend Otp
    Route::post('resend-otp', 'resendOtp');

    // Forget Password
    Route::post('forget-password', 'forgetPassword');
    Route::post('verify-otp-password', 'varifyOtpWithOutAuth');
    Route::post('reset-password', 'resetPassword');

    // Google Login
    Route::post('google/login', 'googleLogin');
});

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::post('logout', [UserAuthController::class, 'logout']);
    Route::get('me', [UserAuthController::class, 'me']);
    Route::post('refresh', [UserAuthController::class, 'refresh']);

    Route::delete('/delete/user', [UserController::class, 'deleteUser']);

    Route::post('change-password', [UserController::class, 'changePassword']);
    Route::post('user-update', [UserController::class, 'updateUserInfo']);

    // Get Notifications
    Route::get('/my-notifications', [UserController::class, 'getMyNotifications']);
    // Route::get('send-notification', function () {
    //     $user = User::where('id', Auth::id())->first();
    //     $user->notify(new UserNotifications('Jb', "Test Notification"));

    //     //Send fire base notification
    //     $device_tokens = FirebaseTokens::where(function ($query) {
    //         $query->where('user_id', Auth::id())
    //             ->orWhereNull('user_id');
    //     })
    //         ->where('is_active', '1')
    //         ->get();
    //     $data = [
    //         'message' => $user->name . ' has sent you a notification',
    //     ];
    //     foreach ($device_tokens as $device_token) {
    //         Helper::sendNotifyMobile($device_token->token, $data);
    //     }

    //     return $response = ['success' => true, 'message' => 'Notification sent successfully'];
    // });
});

// User/Customer Role Access
// Route::middleware(['jwt.verify', 'user'])->prefix('user')->group(function () {
//     Route::post('/create-payment-intent', 'createPaymentIntent');
// });
//================== END of User/Customer Role Access =====================
