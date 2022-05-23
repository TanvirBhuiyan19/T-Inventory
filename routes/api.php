<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetRequestController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SalaryeController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ReportController;

Route::group([ 'middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::Class, 'login']);
    Route::post('register', [AuthController::Class, 'register']);
    Route::post('logout', [AuthController::Class, 'logout']);
    Route::post('refresh', [AuthController::Class, 'refresh']);
    Route::post('me', [AuthController::Class, 'me']);
    Route::post('sendPasswordResetLink', [PasswordResetRequestController::Class, 'sendEmail' ]);
    Route::post('resetPassword', [ChangePasswordController::Class, 'passwordResetProcess' ]);
    
});

Route::group([ 'middleware' => 'api' ], function ($router) {
    Route::apiResource('/employee', EmployeeController::Class);
    Route::apiResource('/supplier', SupplierController::Class);
    Route::apiResource('/category', CategoryController::Class);
    Route::apiResource('/product', ProductController::Class);
    Route::post('/update-stock/{product_id}', [ProductController::Class, 'stockUpdate']);
    Route::apiResource('/expense', ExpenseController::Class);
    Route::apiResource('/salary', SalaryController::Class);
    Route::post('/salary/{employee_id}', [SalaryController::Class, 'store']);
    Route::apiResource('/customer', CustomerController::Class);
    //Cart Routes
    Route::get('/cart', [CartController::Class, 'index']);
    Route::get('/add-cart/{product_id}', [CartController::Class, 'store']);
    Route::get('/increment-cart/{id}', [CartController::Class, 'increment']);
    Route::get('/decrement-cart/{id}', [CartController::Class, 'decrement']);
    Route::get('/remove-cart/{id}', [CartController::Class, 'destroy']);
    //POS Routes
    Route::get('/category-product/{category_id}', [PosController::Class, 'categoryProduct']);
    Route::post('/order', [PosController::class, 'orderDone']);
    Route::get('/invoice/{order_id}', [PosController::class, 'invoiceDownload']);
    Route::get('/invoice-view/{order_id}', [PosController::class, 'invoiceView']);
    //Order Routes
    Route::get('/all-order', [OrderController::class, 'index']);
    Route::get('/today-order', [OrderController::class, 'todayOrders']);
    Route::get('/order-details/{order_id}', [OrderController::class, 'orderDetail']);
    Route::get('/orderdetails/{order_id}', [OrderController::class, 'orderdetails']);
    Route::post('/order-delete/{order_id}', [OrderController::class, 'orderDelete']);
    Route::get('/today-orders-pdf', [OrderController::class, 'todayOrdersPDF']);
    Route::get('/order-by-date-pdf/{date}', [OrderController::class, 'orderByDatePDF']);
    Route::get('/order-by-month-pdf/{month}', [OrderController::class, 'orderByMonthPDF']);
    Route::get('/order-by-year-pdf/{year}', [OrderController::class, 'orderByYearPDF']);
    Route::get('/order-by-month-year-pdf/{month}/{year}', [OrderController::class, 'orderByMonthYearPDF']);
    //Settings Routes
    Route::get('/settings', [SettingsController::class, 'index']);
    Route::post('/settings', [SettingsController::class, 'create']);
    //Home Components Routes
    Route::get('/today-data', [PosController::class, 'todayData']);
    Route::get('/this-month-data', [PosController::class, 'thisMonthData']);
    Route::get('/alltime-data', [PosController::class, 'allTimeData']);
    Route::get('/stock-out', [PosController::class, 'stockOut']);
    Route::get('/payby-data', [PosController::class, 'payBy']);
    //Report Routes
    Route::get('/today-report', [ReportController::class, 'todayReport']);
    Route::get('/report-years', [ReportController::class, 'reportYears']);
    Route::get('/report-by-date/{date}', [ReportController::class, 'reportByDate']);
    Route::get('/report-by-month/{month}', [ReportController::class, 'reportByMonth']);
    Route::get('/report-by-year/{year}', [ReportController::class, 'reportByYear']);
    Route::get('/report-by-month-year/{month}/{year}', [ReportController::class, 'reportByMonthYear']);
    //Report PDF Routes
    Route::get('/today-report-pdf', [ReportController::class, 'todayReportPDF']);
    Route::get('/report-by-date-pdf/{date}', [ReportController::class, 'reportByDatePDF']);
    Route::get('/report-by-month-pdf/{month}', [ReportController::class, 'reportByMonthPDF']);
    Route::get('/report-by-year-pdf/{year}', [ReportController::class, 'reportByYearPDF']);
    Route::get('/report-by-month-year-pdf/{month}/{year}', [ReportController::class, 'reportByMonthYearPDF']);
    //User Info Route
    Route::get('/user-info/{user_id}', [EmployeeController::class, 'userInfo']);

});