<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Invoices_Report;
use App\Http\Controllers\Customers_Report;
use App\Http\Controllers\fuseController;

use App\Http\Controllers\SectionController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use Illuminate\Support\Facades\Storage;
use App\Mail\TestMail;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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
Auth::routes();

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/vatora',  [AdminController::class, 'vat']);
Route::get('/section', function () {
    return view('sections.store');
});
Route::post('/jj',  [SectionController::class, 'store'])->name('hom');
;

Route::get('/sections.section',  [SectionController::class, 'index']);
Route::put('/sections/update',  [SectionController::class, 'update']);
Route::put('/sections/destroy',  [SectionController::class, 'destroy']);


Route::get('/products.products',  [ProductsController::class, 'index']);

Route::put('/products/store',  [ProductsController::class, 'store']);
Route::put('/products/update',  [ProductsController::class, 'update']);
Route::delete('/products/destroy',  [ProductsController::class, 'destroy']);

Route::delete('/invoices/destrooy',  [InvoicesController::class, 'destrooy']);
Route::get('/invoices.invoices_paid',  [InvoicesController::class, 'Invoice_Paid']);
Route::get('/invoices.invoices_unpaid',  [InvoicesController::class, 'Invoice_unPaid']);


Route::get('/invoices/create',  [InvoicesController::class, 'create']);
Route::get('/section/{id}', [InvoicesController::class, 'getproducts']);

Route::post('/invoices/store',  [InvoicesController::class, 'store']);
Route::get('vatora.empty',  [InvoicesController::class, 'index']);
Route::get('users.show_users',  [UserController::class, 'index']);
Route::get('users.Add_user',  [UserController::class, 'create']);
Route::get('roles.index',  [RoleController::class, 'index']);
Route::get('roles.create',  [RoleController::class, 'create']);
Route::post('roles.store',  [RoleController::class, 'store']);



// Route::get('users.create',  [UserController::class, 'create']);

// Route::get('/users.Add_user', function () {
//     return view('users.Add_user');
// });
Route::post('users.store',  [UserController::class,'store']);
Route::get('users.edit/{id}',  [UserController::class,'editt']);
Route::put('users.update/{id}',  [UserController::class,'update'])->name('users.update');


Route::get('/roles.show_roles/{id}',  [RoleController::class,'show_roles']);
Route::get('roles.edit_roles/{id}',  [RoleController::class,'edit_roles']);
Route::put('roles.update/{id}',  [RoleController::class,'update'])->name('roles.update');
Route::post('roles.store}',  [RoleController::class,'store']);


Route::delete('users.destroy',  [UserController::class,'destroy']);
// Route::post('users.edit',  [UserController::class,'edit']);




Route::get('/InvoicesDetails/{id}', [InvoicesDetailsController::class, 'edit']);
Route::get('View_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'open_file']);
Route::get('download/{invoice_number}/{file_name}',  [InvoicesDetailsController::class, 'get_file']);
Route::post('delete_file', [InvoicesDetailsController::class, 'destory'])->name('delete_file');
Route::get('Print_invoice/{id}', [InvoicesDetailsController::class, 'Print_invoice']);
Route::get('/Status_show/{id}', [InvoicesController::class, 'show'])->name('Status_show');
Route::post('/Status_update/{id}', [InvoicesController::class, 'update'])->name('Status_update');
// Route::get('Invoice_Paid',[InvoicesDetailsController::class, 'Invoice_Paid']);


route::get('tee',function(){
   Storage::disk('local')->put('hhhmmmh.txt','yyyyhh');
  return  Storage::download('hhhmmmh.txt');
;
});
Route::get('/send', function () {
    Mail::to('ms11567111@gmail.com')->send(new TestMail());
return 'done';
});
// Route::get('/Add_user',  [fuseController::class, 'index']);

// Route::middleware('auth')->group(function () {

//     // Our resource routes
//     Route::get('/Add_user',  [UserController::class, 'index']);

//     Route::resource('roles', RoleController::class);
// });
Route::get('/invoices_report', [Invoices_Report::class ,'index']);
Route::post('/Search_invoices', [Invoices_Report::class ,'Search_invoices']);

Route::get('customers_report', [Customers_Report::class,'index'])->name("customers_report");
Route::post('Search_customers', [Customers_Report::class, 'Search_customers']);


// Route::group(['middleware' => ['auth']], function() {

//     // Route::resource('roles','RoleController');

//     // Route::resource('users','UserController');

//     });








Auth::routes();


Auth::routes();

Route::get('/{page}',  [AdminController::class, 'index']);

