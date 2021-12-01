<?php

use App\Events\Notifications\MessageNotification;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\MainCategoriesController;
use App\Http\Controllers\Admin\SubCategoriesController;
use App\Http\Controllers\Admin\AppsController;
//use App\Http\Controllers\Admin\UserInterfaceController;
use App\Http\Controllers\Admin\CardsController;
use App\Http\Controllers\Admin\ComponentsController;
use App\Http\Controllers\Admin\ExtensionController;
use App\Http\Controllers\Admin\PageLayoutController;
use App\Http\Controllers\Admin\FormsController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\MiscellaneousController;
use App\Http\Controllers\Admin\AuthenticationController;
use App\Http\Controllers\Admin\ChartsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ConversationsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\SendNotificationController;
use App\Http\Controllers\Admin\PaymentsController;
use App\Http\Controllers\Admin\SettingsController;
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

/* Webhook */
//I disabled the Csrf from (VerifyCsrfToken) file
Route::post('qrcode', function (Request $request) {
    $admin = \App\Models\User::find(1);
    $notification['message'] = 'Webhook working!...' . $_POST['clientSession'];

    $notification['user_id'] = 1;
    $notification['link'] = '';

    $admin->notify(new \App\Notifications\SendMessageNotificationToUser($notification));
})->name('qrcode');


/* Webhook */


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){
/* Frontend */

    Route::get('successPayment', [PaymentsController::class, 'success'])->name('payments.success');


    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

    /* Login */
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'doLogin'])->name('login.do');
    /* Login */

    /* Register */
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'store'])->name('register.do');
    /* Register */

    /* Frontend */

/* ADMIN BACKEND */
    Route::group(['namespace' => '', 'middleware' => ['auth']], function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboardEcommerce'])->name('dashboard-ecommerce');


        /* Route Dashboards */
        Route::group(['prefix' => 'dashboard'], function () {
            Route::get('analytics', [DashboardController::class, 'dashboardAnalytics'])->name('dashboard-analytics');
        });
        /* Route Dashboards */

        /* Route Roles / Users */

        Route::resource('roles',RoleController::class, ['only'=> ['index', 'update', 'create','store', 'edit']] );
        Route::get('roles/ajax', [RoleController::class, 'ajax'])->name('roles-ajax');
        Route::get('roles/delete/{id}', [RoleController::class , 'destroy'])->name('roles.destroy');
        Route::resource('users',UserController::class, ['only'=> ['index', 'update', 'create','store', 'edit']]);
        Route::get('users/ajax', [UserController::class, 'ajax'])->name('users-ajax');
        Route::get('users/delete/{id}', [UserController::class , 'destroy'])->name('users.destroy');

        /* Route Roles / Users */

        /* Route Products */
        Route::resource('products',ProductsController::class, ['only'=> ['index', 'update', 'create','store', 'edit']] );
        Route::get('products/ajax', [ProductsController::class, 'ajax'])->name('products-ajax');
        Route::get('products/bids_ajax/{id}', [ProductsController::class, 'bids_ajax'])->name('products-bids_ajax');
        Route::get('products/bid_accept/{id}', [ProductsController::class, 'bid_accept'])->name('products-bid_accept');
        Route::get('products/bid_confirm/{id}', [ProductsController::class, 'bid_confirm'])->name('products-bid_confirm');
        Route::get('products/bid_cancel/{id}', [ProductsController::class, 'bid_cancel'])->name('products-bid_cancel');
        Route::get('products/delete/{id}', [ProductsController::class , 'destroy'])->name('products.destroy');
        /* Route Products */

        /* Route Categories */
        Route::resource('main_categories', MainCategoriesController::class, ['only'=> ['index', 'update', 'create','store', 'edit']]);
        Route::get('main_categories/delete/{id}', [MainCategoriesController::class , 'destroy'])->name('main_categories.destroy');
        Route::get('main_categories/ajax', [MainCategoriesController::class, 'ajax'])->name('main_category-ajax');
        Route::resource('sub_categories', SubCategoriesController::class, ['only'=> ['index', 'update', 'create','store', 'edit']]);
        Route::get('sub_categories/delete/{id}', [SubCategoriesController::class , 'destroy'])->name('sub_categories.destroy');
        Route::get('sub_categories/ajax', [SubCategoriesController::class, 'ajax'])->name('sub_category-ajax');
        /* Route Categories */

        /* Route Send Notification */
        Route::get('send_notification', [SendNotificationController::class, 'sendNotification'])->name('send_notification');
        Route::post('send_notification', [SendNotificationController::class, 'store'])->name('send_notification.store');
        /* Route Send Notification */

        /* Route Settings */
        Route::get('settings', [SettingsController::class, 'index'])->name('settings');
        Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
        /* Route Settings */

        /* Route Conversations/Chat */

        Route::get('chat', [ConversationsController::class, 'index'])->name('chat.index');
        Route::get('chat/{conversation}', [ConversationsController::class, 'show'])->name('chat.show');
        Route::get('chat/join/{conversation}', [ConversationsController::class, 'join'])->name('chat.join');
        Route::put('chat/confirm/{conversation}', [ConversationsController::class, 'confirmAccountData'])->name('chat.confirm');
        Route::get('chat/reject/{conversation}', [ConversationsController::class, 'rejectAccountData'])->name('chat.reject');
        Route::get('chat/create/{product_id}', [ConversationsController::class, 'create'])->name('chat.create');

                /* Route Middleman/Chat */
                Route::post('chat/middleman/{conversation_id}', [ConversationsController::class, 'middleman'])->name('middleman');
                Route::put('chat/updateAccountData/{id}', [ConversationsController::class , 'updateAccountData'])->name('chat.updateAccountData');
                Route::put('chat/updateAccountData2/{id}', [ConversationsController::class , 'updateAccountData2'])->name('chat.updateAccountData2');

        /* Route Middleman/Chat */

        /* Route Conversations/Chat */

        /* Route Payments */
        Route::post('sendPayment', [PaymentsController::class, 'send'])->name('payments.sendPayment');
        Route::post('withdrawFunds', [PaymentsController::class, 'withdraw'])->name('payments.withdrawFunds');
        Route::get('withdrawFunds/requestComplete/{id}', [PaymentsController::class, 'withdrawComplete'])->name('payments.withdrawComplete');
        Route::get('withdrawFunds/requestRefund/{id}', [PaymentsController::class, 'withdrawRefund'])->name('payments.withdrawRefund');
        Route::get('withdrawFunds/requestsAjax', [PaymentsController::class, 'withdrawRequestsAjax'])->name('payments.withdrawRequestsAjax');
        Route::get('withdrawFunds/detailsAjax/{id}', [PaymentsController::class, 'withdrawDetailsAjax'])->name('payments.withdrawDetailsAjax');
        Route::get('transactionsAjax', [PaymentsController::class, 'transactionsAjax'])->name('payments.transactionsAjax');


        Route::get('payments/ajax', [PaymentsController::class, 'ajax'])->name('payments-ajax');

        Route::resource('payments', PaymentsController::class, ['only'=> ['index', 'show' ,'update', 'create','store', 'edit']]);

        Route::get('payments/delete/{id}', [PaymentsController::class , 'destroy'])->name('payments.destroy');
        /* Route Payments */

        Route::get('/error', [MiscellaneousController::class, 'error'])->name('error');

        /* Route Charts */
        Route::group(['prefix' => 'chart'], function () {
            Route::get('apex', [ChartsController::class, 'apex'])->name('chart-apex');
            Route::get('chartjs', [ChartsController::class, 'chartjs'])->name('chart-chartjs');
            Route::get('echarts', [ChartsController::class, 'echarts'])->name('chart-echarts');
        });
        /* Route Charts */

// map leaflet
        Route::get('/maps/leaflet', [ChartsController::class, 'maps_leaflet'])->name('map-leaflet');
    });
    
});

/* Socialte */

Route::get('/auth/{service}', [LoginController::class, 'socialite_redirect'])->name('socialite.login');
Route::get('/auth/{service}/callback', [LoginController::class, 'socialite_callback']);

/* Socialite */
