<?php

use App\Http\Controllers\Web\backend\AboutController;
use App\Http\Controllers\Web\backend\admin\FAQController;
use App\Http\Controllers\Web\backend\BlogController;
use App\Http\Controllers\Web\backend\BodyTypeSpecificationController;
use App\Http\Controllers\Web\backend\BrandController;
use App\Http\Controllers\Web\backend\CategoryController;
use App\Http\Controllers\Web\backend\ColorSpecificationController;
use App\Http\Controllers\Web\backend\CylinderSpecificationController;
use App\Http\Controllers\Web\backend\DashboardController;
use App\Http\Controllers\Web\backend\DeclarationController;
use App\Http\Controllers\Web\backend\DoorSpecificationController;
use App\Http\Controllers\Web\backend\DrivetrainSpecificationController;
use App\Http\Controllers\Web\backend\FuelTypeSpecificationController;
use App\Http\Controllers\Web\backend\ImageTypeController;
use App\Http\Controllers\Web\backend\MileageSpecificationController;
use App\Http\Controllers\Web\backend\MPGSpecificationController;
use App\Http\Controllers\Web\backend\PremissionController;
use App\Http\Controllers\Web\backend\RoleController;
use App\Http\Controllers\Web\backend\SettingController;
use App\Http\Controllers\Web\backend\settings\DynamicPagesController;
use App\Http\Controllers\Web\backend\settings\ProfileSettingController;
use App\Http\Controllers\Web\backend\SizeSpecificationController;
use App\Http\Controllers\Web\backend\TagController;
use App\Http\Controllers\Web\backend\TestimonialController;
use App\Http\Controllers\Web\backend\TransmissionSpecificationController;
use App\Http\Controllers\Web\backend\UserController;
use App\Http\Controllers\Web\backend\VehicleController;
use Illuminate\Support\Facades\Route;

// Dashboard
Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'index')->name('dashboard');
});

// ====================================================
// CMS Routes
// ====================================================

// About Routes
Route::controller(AboutController::class)->group(function () {
    Route::get('/about', 'index')->name('about.index');
    Route::post('/about/update', 'update')->name('about.update');
});

// Blog Routes
Route::controller(BlogController::class)->group(function () {
    Route::get('/blog', 'index')->name('blog.index');
    Route::get('/blog/edit/{slug}', 'edit')->name('blog.edit');
    Route::post('/blog/store', 'store')->name('blog.store');
    Route::post('/blog/update', 'update')->name('blog.update');
    Route::get('/blog/destroy/{id}', 'destroy')->name('blog.destroy');
    Route::get('/blog/status', 'status')->name('blog.status');
    Route::get('/blog/isFront', 'isFront')->name('blog.isFront');
});

// Testimonial Controller
Route::controller(TestimonialController::class)->group(function () {
    Route::get('/testimonial/get', 'get')->name('testimonial.get');
    Route::get('/testimonial', 'index')->name('testimonial.index');
    Route::post('/testimonial/store', 'store')->name('testimonial.store');
    Route::post('/testimonial/update', 'update')->name('testimonial.update');
    Route::get('/testimonial/destroy/{id}', 'destroy')->name('testimonial.destroy');
    Route::get('/testimonial/status', 'status')->name('testimonial.status');
});

// FAQ Route
Route::controller(FAQController::class)->group(function () {
    Route::get('/faq', 'index')->name('faq.index');
    Route::get('/faq/get', 'get')->name('faq.get');
    Route::post('/faq/priorities', 'priority')->name('faq.priority');
    Route::get('/faq/status', 'status')->name('faq.status');
    Route::post('/faq/store', 'store')->name('faq.store');
    Route::post('/faq/update', 'update')->name('faq.update');
    Route::get('/faq/destroy/{id}', 'destroy')->name('faq.destroy');
});

//Dynamic Pages Route
Route::controller(DynamicPagesController::class)->group(function () {
    Route::get('/dynamicpages', 'index')->name('dynamicpages.index');
    Route::get('/dynamicpages/create', 'create')->name('dynamicpages.create');
    Route::get('/dynamicpages/edit/{id}', 'edit')->name('dynamicpages.edit');
    Route::post('/dynamicpages/store', 'store')->name('dynamicpages.store');
    Route::post('/dynamicpages/update/{id}', 'update')->name('dynamicpages.update');
    Route::delete('/dynamicpages/destroy/{id}', 'destroy')->name('dynamicpages.destroy');
    Route::post('/dynamicpages/status/{id}', 'changeStatus')->name('dynamicpages.status');
    Route::post('/dynamicpages/bulk-delete', 'bulkDelete')->name('dynamicpages.bulk-delete');
});

// ====================================================
// Vehicle Routes
// ====================================================

// Brand Routes
Route::controller(BrandController::class)->group(function () {
    Route::get('/brand/get', 'get')->name('brand.get');
    Route::post('/brand/priorities', 'priority')->name('brand.priority');
    Route::get('/brand/status', 'status')->name('brand.status');
    Route::get('/brand', 'index')->name('brand.index');
    Route::post('/brand/store', 'store')->name('brand.store');
    Route::post('/brand/update', 'update')->name('brand.update');
    Route::get('/brand/destroy/{id}', 'destroy')->name('brand.destroy');
});

// Category Routes
Route::controller(CategoryController::class)->group(function () {
    Route::get('/category/get', 'get')->name('category.get');
    Route::post('/category/priorities', 'priority')->name('category.priority');
    Route::get('/category/status', 'status')->name('category.status');
    Route::get('/category', 'index')->name('category.index');
    Route::post('/category/store', 'store')->name('category.store');
    Route::post('/category/update', 'update')->name('category.update');
    Route::get('/category/destroy/{id}', 'destroy')->name('category.destroy');
});

// Vehicle Routes
Route::controller(VehicleController::class)->group(function () {
    Route::get('/vehicle/create', 'create')->name('vehicle.create');
    Route::post('/vehicle/store', 'store')->name('vehicle.store');
    Route::post('/vehicle/update', 'update')->name('vehicle.update');
    Route::get('/vehicle/list', 'list')->name('vehicle.list');
    Route::get('/vehicle/edit/{id}', 'edit')->name('vehicle.edit');
    Route::get('/vehicle/view/{id}', 'view')->name('vehicle.view');
    Route::get('/vehicle/status', 'status')->name('vehicle.status');
    Route::get('/vehicle/delete/{id}', 'destroy')->name('vehicle.destroy');
    Route::get('/vehicle/verified/{id}', 'verified')->name('vehicle.verified');
});

// Specification Routes ====================================
Route::controller(BodyTypeSpecificationController::class)->group(function () {
    Route::get('/bodyType/get', 'get')->name('bodyType.get');
    Route::get('/bodyType', 'index')->name('bodyType.index');
    Route::post('/bodyType/store', 'store')->name('bodyType.store');
    Route::post('/bodyType/update', 'update')->name('bodyType.update');
    Route::get('/bodyType/destroy/{id}', 'destroy')->name('bodyType.destroy');
});
Route::controller(TransmissionSpecificationController::class)->group(function () {
    Route::get('/transmission/get', 'get')->name('transmission.get');
    Route::get('/transmission', 'index')->name('transmission.index');
    Route::post('/transmission/store', 'store')->name('transmission.store');
    Route::post('/transmission/update', 'update')->name('transmission.update');
    Route::get('/transmission/destroy/{id}', 'destroy')->name('transmission.destroy');
});
Route::controller(FuelTypeSpecificationController::class)->group(function () {
    Route::get('/fuelType/get', 'get')->name('fuelType.get');
    Route::get('/fuelType', 'index')->name('fuelType.index');
    Route::post('/fuelType/store', 'store')->name('fuelType.store');
    Route::post('/fuelType/update', 'update')->name('fuelType.update');
    Route::get('/fuelType/destroy/{id}', 'destroy')->name('fuelType.destroy');
});
Route::controller(SizeSpecificationController::class)->group(function () {
    Route::get('/size/get', 'get')->name('size.get');
    Route::get('/size', 'index')->name('size.index');
    Route::post('/size/store', 'store')->name('size.store');
    Route::post('/size/update', 'update')->name('size.update');
    Route::get('/size/destroy/{id}', 'destroy')->name('size.destroy');
});
Route::controller(DoorSpecificationController::class)->group(function () {
    Route::get('/door/get', 'get')->name('door.get');
    Route::get('/door', 'index')->name('door.index');
    Route::post('/door/store', 'store')->name('door.store');
    Route::post('/door/update', 'update')->name('door.update');
    Route::get('/door/destroy/{id}', 'destroy')->name('door.destroy');
});
Route::controller(MileageSpecificationController::class)->group(function () {
    Route::get('/mileage/get', 'get')->name('mileage.get');
    Route::get('/mileage', 'index')->name('mileage.index');
    Route::post('/mileage/store', 'store')->name('mileage.store');
    Route::post('/mileage/update', 'update')->name('mileage.update');
    Route::get('/mileage/destroy/{id}', 'destroy')->name('mileage.destroy');
});
Route::controller(DrivetrainSpecificationController::class)->group(function () {
    Route::get('/drivetrain/get', 'get')->name('drivetrain.get');
    Route::get('/drivetrain', 'index')->name('drivetrain.index');
    Route::post('/drivetrain/store', 'store')->name('drivetrain.store');
    Route::post('/drivetrain/update', 'update')->name('drivetrain.update');
    Route::get('/drivetrain/destroy/{id}', 'destroy')->name('drivetrain.destroy');
});
Route::controller(CylinderSpecificationController::class)->group(function () {
    Route::get('/cylinder/get', 'get')->name('cylinder.get');
    Route::get('/cylinder', 'index')->name('cylinder.index');
    Route::post('/cylinder/store', 'store')->name('cylinder.store');
    Route::post('/cylinder/update', 'update')->name('cylinder.update');
    Route::get('/cylinder/destroy/{id}', 'destroy')->name('cylinder.destroy');
});
Route::controller(MPGSpecificationController::class)->group(function () {
    Route::get('/mpg/get', 'get')->name('mpg.get');
    Route::get('/mpg', 'index')->name('mpg.index');
    Route::post('/mpg/store', 'store')->name('mpg.store');
    Route::post('/mpg/update', 'update')->name('mpg.update');
    Route::get('/mpg/destroy/{id}', 'destroy')->name('mpg.destroy');
});
Route::controller(ColorSpecificationController::class)->group(function () {
    Route::get('/color/get', 'get')->name('color.get');
    Route::get('/color', 'index')->name('color.index');
    Route::post('/color/store', 'store')->name('color.store');
    Route::post('/color/update', 'update')->name('color.update');
    Route::get('/color/destroy/{id}', 'destroy')->name('color.destroy');
});
// Image Type Routes
Route::controller(ImageTypeController::class)->group(function () {
    Route::get('/image/get', 'get')->name('image.get');
    Route::post('/image/priorities', 'priority')->name('image.priority');
    Route::get('/image/status', 'status')->name('image.status');
    Route::get('/image', 'index')->name('image.index');
    Route::post('/image/store', 'store')->name('image.store');
    Route::post('/image/update', 'update')->name('image.update');
    Route::get('/image/destroy/{id}', 'destroy')->name('image.destroy');
});
// Declaration Routes
Route::controller(DeclarationController::class)->group(function () {
    Route::get('/declaration/get', 'get')->name('declaration.get');
    Route::post('/declaration/priorities', 'priority')->name('declaration.priority');
    Route::get('/declaration/status', 'status')->name('declaration.status');
    Route::get('/declaration', 'index')->name('declaration.index');
    Route::post('/declaration/store', 'store')->name('declaration.store');
    Route::post('/declaration/update', 'update')->name('declaration.update');
    Route::get('/declaration/destroy/{id}', 'destroy')->name('declaration.destroy');
});
// Tag Routes
Route::controller(TagController::class)->group(function () {
    Route::get('/tag/get', 'get')->name('tag.get');
    Route::get('/tag', 'index')->name('tag.index');
    Route::post('/tag/store', 'store')->name('tag.store');
    Route::post('/tag/update', 'update')->name('tag.update');
    Route::get('/tag/destroy/{id}', 'destroy')->name('tag.destroy');
});

// ====================================================
// Settings Routes
// ====================================================

// Settings Route
Route::controller(SettingController::class)->group(function () {
    Route::get('/general/setting', 'create')->name('general.setting');
    Route::post('/system/update', 'update')->name('system.update');
    Route::get('/system/setting', 'systemSetting')->name('system.setting');
    Route::post('/system/setting/update', 'systemSettingUpdate')->name('system.settingupdate');
    Route::get('/setting', 'adminSetting')->name('admin.setting');
    Route::get('/stripe', 'stripe')->name('admin.setting.stripe');
    Route::post('/stripe', 'stripestore')->name('admin.setting.stripestore');
    Route::get('/paypal', 'paypal')->name('admin.setting.paypal');
    Route::post('/paypal', 'paypalstore')->name('admin.setting.paypalstore');
    Route::get('/mail', 'mail')->name('admin.setting.mail');
    Route::post('/mail', 'mailstore')->name('admin.setting.mailstore');
    Route::post('/setting/update', 'adminSettingUpdate')->name('admin.settingupdate');
});

// Permission Route
Route::prefix('permissions')->controller(PremissionController::class)->group(function () {
    Route::get('/list', 'index')->name('admin.permissions.list');
    Route::get('/create', 'create')->name('admin.permissions.create');
});

// Role Route
Route::prefix('role')->controller(RoleController::class)->group(function () {
    Route::get('/list', 'index')->name('admin.role.list');
    Route::get('/create', 'create')->name('admin.role.create');
    Route::post('/store', 'store')->name('admin.role.store');
    Route::get('/edit/{id}', 'edit')->name('admin.role.edit');
    Route::post('/update/{id}', 'update')->name('admin.role.update');
    Route::delete('/destroy/{id}', 'destroy')->name('admin.role.destroy');
});

// User Route
Route::controller(UserController::class)->group(function () {
    Route::get('/users/create', 'create')->name('user.create');
    Route::post('/users/store', 'store')->name('user.store');
    Route::get('/edit/users/{id}', 'edit')->name('user.edit');
    Route::post('/update/user', 'update')->name('user.update');
    Route::get('/users/list', 'index')->name('user.list');
    Route::get('/view/users/{id}', 'show')->name('show.user');
    Route::get('/status/users/{id}', 'status')->name('user.status');
    Route::post('/users/delete', 'destroy')->name('user.user.destroy');
});

// Profile Settings Routes
Route::controller(ProfileSettingController::class)->group(function () {
    Route::get('/profile', 'index')->name('profile');
    Route::post('/profile/update', 'updateProfile')->name('profile.update');
    Route::post('/profile/update/password', 'updatePassword')->name('profile.update.password');
    Route::post('/profile/update/profile-picture', 'updateProfilePicture')->name('profile.update.profile.picture');
    Route::get('/checkusername', 'checkusername')->name('checkusername');
});










