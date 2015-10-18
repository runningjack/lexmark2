<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', "DashboardController@index");
Route::get('/dashboard', "DashboardController@index");
Route::post("/","DashboardController@store");

Route::get("company/index","CompanyController@index");
Route::post("company/index","CompanyController@store");
Route::post("company/companyupdate/{id}","CompanyController@update");
Route::post("company/companydelete/{id}","CompanyController@update");
Route::get("company/branches","BranchController@index");
Route::post("company/branches","BranchController@store");


Route::post("company/index","CompanyController@store");
Route::post("company/companyupdate/{id}","CompanyController@update");
Route::post("company/companydelete/{id}","CompanyController@update");
Route::get("company/branches","BranchController@index");
Route::post("company/branches","BranchController@store");
Route::get("company/companydetail/{id?}","CompanyController@show");


Route::get("settings/paper","PaperController@index");
Route::post("settings/paper","PaperController@store");
Route::get("settings/jobs","JobController@index");
Route::post("settings/jobs","JobController@store");
Route::get("settings/price","JobController@getPrice");
Route::post("settings/price","JobController@postPrice");

Route::get("invoicing/index","InvoicingController@index");
Route::post("invoicing/index",'InvoicingController@upload');
Route::get("invoicing/print","InvoicingController@print");

Route::get("invoicing/invoice/{id}","InvoicingController@generateInvoice");
Route::post("invoicing/invoice","InvoicingController@postGenerateInvoice");

Route::get("administrators/index","UserController@index");
Route::get("administrators/addnew","UserController@create");

Route::get("privileges/index","PrivilegeController@index");
Route::post("privileges/index","PrivilegeController@store");

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');


// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
