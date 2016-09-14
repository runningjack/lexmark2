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

Route::group(['middleware' => 'auth'], function() {
    Route::get('/',"DashboardController@index");
    Route::get('/dashboard', "DashboardController@index");
    Route::post("/","DashboardController@store");

    Route::get("company/index","CompanyController@index");
    Route::post("company/index","CompanyController@store");
    Route::post("company/companyupdate/{id}","CompanyController@update");
    Route::post("company/companydelete/{id}","CompanyController@destroy");
    Route::get("company/branches","BranchController@index");
    Route::post("company/branches","BranchController@store");
    Route::post("company/branchdelete/{id}","BranchController@destroy");
    Route::post("company/branchupdate/{id}","BranchController@update");
    Route::get("company/companydetail/{id?}","CompanyController@show");


    Route::get("settings/paper","PaperController@index");
    Route::post("settings/paper","PaperController@store");
    Route::post("settings/paperedit/{id}","PaperController@update");
    Route::post("settings/paperdelete/{id}","PaperController@destroy");
    Route::get("settings/jobs","JobController@index");
    Route::post("settings/jobs","JobController@store");
    Route::get("settings/price/{id?}","JobController@getPrice");
    Route::post("settings/price","JobController@postPrice");
    Route::post("settings/priceedit/{id?}","JobpriceController@update");

    Route::get("invoicing/index","InvoicingController@index");
    Route::post("invoicing/index",'InvoicingController@upload');
    Route::get("invoicing/print/{id}","InvoicingController@printInvoice");

    Route::get("invoicing/invoice/{id}","InvoicingController@generateInvoice");
    Route::post("invoicing/invoice/{id?}","InvoicingController@generateInvoice");
    Route::post("invoicing/deleteinvoice/{id?}","InvoicingController@destroy");
    Route::post("invoicing/deletestack/{id?}","InvoicingController@destroyStack");
    Route::post("invoicing/updatestack/{id?}","InvoicingController@updateStack");
    Route::post("invoicing/download/{id?}","InvoicingController@downloadStack");

    Route::get("administrators/index","UserController@index");
    Route::get("administrators/addnew","UserController@create");
    Route::post("administrators/addnew","UserController@store");
    Route::get("administrators/edituser/{id}","UserController@edit");
    Route::post("administrators/edituser/{id}","UserController@update");
    Route::post("administrators/deleteuser/{id}","UserController@destroy");

    Route::get("privileges/index","PrivilegeController@index");
    Route::post("privileges/index","PrivilegeController@store");
    Route::post("privileges/editrole/{id?}","PrivilegeController@update");




    // protected routes here
    Route::get('admin', 'DashboardController@index');
});
// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');


// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
