<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlusController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\DooDuagController;
use App\Http\Controllers\ResellerController;

 // ใช้ Session facade
use Illuminate\Support\Facades\Session;
// Route::match(['get', 'post'], '/loadGI', [PlusController::class, 'loadGI']);

Route::get('/duag', function () {
    // Session::put('key', '123456789');
    return redirect('/duag/home');
});



Route::post('/checklogin', [LoginController::class, 'checklogin']);
Route::get('/login', [LoginController::class, 'login']);
Route::get('/home', [MainController::class, 'dashbord']);
Route::post('/load_page1', [MainController::class, 'load_page1']);
Route::post('/load_page2', [MainController::class, 'load_page2']);
Route::post('/load_page3', [MainController::class, 'load_page3']);
Route::post('/load_page4', [MainController::class, 'load_page4']);
Route::post('/load_page5', [MainController::class, 'load_page5']);
Route::post('/load_page6', [MainController::class, 'load_page6']);
Route::post('/load_page7', [MainController::class, 'load_page7']);
Route::post('/load_page8', [MainController::class, 'load_page8']);
Route::post('/load_location', [MainController::class, 'load_location']);
Route::post('/trnsave1', [MainController::class, 'trnsave1']);
Route::post('/trnsave2', [MainController::class, 'trnsave2']);
Route::post('/trnsave3', [MainController::class, 'trnsave3']);
Route::post('/trnsave4', [MainController::class, 'trnsave4']);
Route::post('/trnsave5', [MainController::class, 'trnsave5']);

Route::post('/load_wk', [MainController::class, 'load_wk']);
Route::post('/load_wk_dash', [MainController::class, 'load_wk_dash']);

///===================================================================///
Route::get('/plus', [PlusController::class, 'index']);
Route::post('/plus/loadMainGI', [PlusController::class, 'loadMainGI']);
Route::post('/plus/uploadexcel', [PlusController::class, 'uploadexcel']);
Route::post('/plus/Search_Data', [PlusController::class, 'Search_Data']);
Route::post('/plus/LoadDropDrow_Reg', [PlusController::class, 'LoadDropDrow_Reg']);
Route::post('/plus/LoadDropDrow_DC', [PlusController::class, 'LoadDropDrow_DC']);
Route::post('/plus/LoadDropDrow_Rouge', [PlusController::class, 'LoadDropDrow_Rouge']);
Route::post('/plus/Save_txt', [PlusController::class, 'Save_txt']);
Route::post('/plus/ImgDownLoad', [PlusController::class, 'ImgDownLoad']);


Route::get('/plus/pdftest', [PlusController::class, 'pdftest']);


Route::get('/plus/playground', [PlusController::class, 'playground']);

Route::get('/plus/playground/myhouse', [PlusController::class, 'myhouse']);


//Dooduag
Route::get('/duag/settingpage', [DooDuagController::class, 'settingpage']);
Route::post('/duag/LoadDooDuagMain', [DooDuagController::class, 'LoadDooDuagMain']);
Route::post('/duag/LoadDooDuagSub', [DooDuagController::class, 'LoadDooDuagSub']);

Route::post('/duag/AddDooDuagSub', [DooDuagController::class, 'AddDooDuagSub']);
Route::post('/duag/RemoveDooDuagSub', [DooDuagController::class, 'RemoveDooDuagSub']);




Route::post('/duag/HandleIsActiveMain', [DooDuagController::class, 'HandleIsActiveMain']);


// Customer

Route::get('/duag/home', [DooDuagController::class, 'homecustomer']);
Route::post('/duag/LoadDooDuagAll', [DooDuagController::class, 'LoadDooDuagAll']);
Route::post('/duag/LoadDooDuagTime', [DooDuagController::class, 'LoadDooDuagTime']);
Route::post('/duag/SaveDooDuagTran', [DooDuagController::class, 'SaveDooDuagTran']);
Route::post('/duag/LoadListCustomer', [DooDuagController::class, 'LoadListCustomer']);
Route::post('/duag/RemoveCustomer', [DooDuagController::class, 'RemoveCustomer']);



// Reseller
Route::get('/reseller', function () {
    // Session::put('key', '123456789');
    return redirect('/reseller/home');
});
Route::get('/reseller/login', [ResellerController::class, 'login']);
Route::post('/reseller/checklogin', [ResellerController::class, 'checklogin']);
Route::get('/reseller/home', [ResellerController::class, 'home']);
Route::post('/reseller/ManageProduct', [ResellerController::class, 'ManageProduct']);
Route::post('/reseller/LoadDataCustomer', [ResellerController::class, 'LoadDataCustomer']);
Route::post('/reseller/AddDataCustomer', [ResellerController::class, 'AddDataCustomer']);

