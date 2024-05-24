<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//enable auth routes
Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

//Verify Login
Route::group(['middleware' => ['auth']], function () {

//register
    Route::get('/register', [App\Http\Controllers\HomeController::class, 'index'])->name('register');

//home
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//INTERVENTIONS--------------------------------------------------------------------------------------------------------------------
//Interventions list
    Route::get('/interventions', [App\Http\Controllers\InterventionsController::class, 'index'])->name('interventions');

//Interventions create
    Route::post('/interventions', [App\Http\Controllers\InterventionsController::class, 'create'])->name('intervention.create');

//See intervention
    Route::get('/admin/intervention/{id?}', [App\Http\Controllers\InterventionsController::class, 'intervention'])->name('intervention.view');

//update intervention
    Route::post('/admin/intervention/update/{id?}', [App\Http\Controllers\InterventionsController::class, 'interventionUpdate'])->name('intervention.update');

//delete intervention
    Route::post('/admin/intervention/delete/{id?}', [App\Http\Controllers\InterventionsController::class, 'interventionDelete'])->name('intervention.delete');

//Filter intervention
    Route::get('/interventions/filter', [App\Http\Controllers\InterventionsController::class, 'interventionFilter'])->name('interventions.filter');

//Create Invoice for intervention
    Route::post('/admin/intervention/createInvoice/{id?}', [App\Http\Controllers\InterventionsController::class, 'createInvoice'])->name('intervention.createInvoice');

//Generating pedfs
    Route::get('/interventions/pdf/{id?}', [App\Http\Controllers\InterventionsController::class, 'generatePdf'])->name('intervention.pdf');

//USERS--------------------------------------------------------------------------------------------------------------------
//List Users
    Route::get('/tables/users', [App\Http\Controllers\UsersController::class, 'users'])->name('users');

//User view
    Route::get('/tables/user/{id?}', [App\Http\Controllers\UsersController::class, 'user'])->name('user.view');

//Create Users
    Route::post('/tables/users/create', [App\Http\Controllers\UsersController::class, 'userCreate'])->name('user.create');

//Edit Users
    Route::post('/tables/users/update/{id?}', [App\Http\Controllers\UsersController::class, 'userUpdate'])->name('user.update');

//Delete Fluids
    Route::post('/tables/user/delete/{id?}', [App\Http\Controllers\UsersController::class, 'userDelete'])->name('user.delete');

//TABLES--------------------------------------------------------------------------------------------------------------------
//List Tables
    Route::get('/tables', [App\Http\Controllers\TablesController::class, 'tables'])->name('tables');

//FLUIDS--------------------------------------------------------------------------------------------------------------------
//List Fluids
    Route::get('/tables/fluids', [App\Http\Controllers\TablesController::class, 'fluids'])->name('fluids');

//View Fluid
    Route::get('/tables/fluid/{id?}', [App\Http\Controllers\TablesController::class, 'fluid'])->name('fluid.view');

//Create Fluids
    Route::post('/tables/fluids', [App\Http\Controllers\TablesController::class, 'fluidsCreate'])->name('fluid.create');

//Edit Fluids
    Route::post('/tables/fluids/update/{id?}', [App\Http\Controllers\TablesController::class, 'fluidUpdate'])->name('fluid.update');

//Delete Fluids
    Route::post('/tables/fluid/delete/{id?}', [App\Http\Controllers\TablesController::class, 'fluidDelete'])->name('fluid.delete');

//CARS--------------------------------------------------------------------------------------------------------------------
//list Cars
    Route::get('/tables/cars', [App\Http\Controllers\TablesController::class, 'cars'])->name('cars');

//View Car
    Route::get('/tables/car/{id?}', [App\Http\Controllers\TablesController::class, 'car'])->name('car.view');

//Create Cars
    Route::post('/tables/cars', [App\Http\Controllers\TablesController::class, 'carsCreate'])->name('car.create');

//Verify License Plate
    Route::post('/tables/checkPlate', [App\Http\Controllers\TablesController::class, 'checkPlate'])->name('car.checkPlate');

//Verify License Plate on Editing
    Route::post('/tables/checkPlate/edit', [App\Http\Controllers\TablesController::class, 'checkPlateEdit'])->name('car.checkPlateEdit');

//Edit car
    Route::post('/tables/car/update/{id?}', [App\Http\Controllers\TablesController::class, 'carUpdate'])->name('car.update');

//Delete Car
    Route::post('/tables/car/delete/{id?}', [App\Http\Controllers\TablesController::class, 'carDelete'])->name('car.delete');

//INVOICES--------------------------------------------------------------------------------------------------------------------
//List invoices
    Route::get('/invoices', [App\Http\Controllers\InvoicesController::class, 'index'])->name('invoices');

//View Invoice
    Route::get('/invoice/{id?}', [App\Http\Controllers\InvoicesController::class, 'invoice'])->name('invoice.view');

//Download Invoice
    Route::get('/invoice/pdf/{id?}', [App\Http\Controllers\InvoicesController::class, 'invoiceDownload'])->name('invoice.pdf');

//Send invoice by e-mail
    Route::post('/admin/intervention/sendInvoice/{id?}', [App\Http\Controllers\InvoicesController::class, 'sendInvoice'])->name('intervention.sendInvoice');


//Testing-----------------------------------------------------------------------------------------------------------------------------
// Default testing response
    Route::get('/test', [App\Http\Controllers\TestController::class, 'index'])->name('test.page');

// Default testing response
    Route::get('/test/default', [App\Http\Controllers\TestController::class, 'testDefault'])->name('test.default');

// Force session expiration
    Route::get('/test/expireSession', [App\Http\Controllers\TestController::class, 'forceSessionExpiration'])->name('forceSessionExpiration');

// Example testing route
    Route::get('/test/example', [App\Http\Controllers\TestController::class, 'testExample'])->name('test.example');

// Validation testing route
    Route::get('/test/validation', [App\Http\Controllers\TestController::class, 'testValidation'])->name('test.validation');

// API testing route
    Route::get('/test/api', [App\Http\Controllers\TestController::class, 'testAPI'])->name('test.api');

// Performance testing route
    Route::get('/test/performance', [App\Http\Controllers\TestController::class, 'testPerformance'])->name('test.performance');

// Button 6 testing route
    Route::get('/test/button6', [App\Http\Controllers\TestController::class, 'testButton6'])->name('test.button6');

// Button 7 testing route
    Route::get('/test/button7', [App\Http\Controllers\TestController::class, 'testButton7'])->name('test.button7');

// Button 8 testing route
    Route::get('/test/button8', [App\Http\Controllers\TestController::class, 'testButton8'])->name('test.button8');

// Button 9 testing route
    Route::get('/test/button9', [App\Http\Controllers\TestController::class, 'testButton9'])->name('test.button9');

// Button 10 testing route
    Route::get('/test/button10', [App\Http\Controllers\TestController::class, 'testButton10'])->name('test.button10');

});




