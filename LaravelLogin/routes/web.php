<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [UserAuthController::class, 'login'])->middleware('alreadyLoggedIn'); // alreadyLoggedIn是防止在已登入狀態下看到登入和註冊頁面
Route::get('register', [UserAuthController::class, 'register'])->middleware('alreadyLoggedIn');
Route::post('create', [UserAuthController::class, 'create'])->name('auth.create'); // 與註冊頁面的form action相同
// Route::get('register/succsee', [UserAuthController::class, 'success']); 註冊後跳轉
Route::post('check', [UserAuthController::class, 'check'])->name('auth.check');

// profile相關換成小馬的member
Route::get('profile', [UserAuthController::class, 'profile'])->middleware('isLogged'); // isLogged在Kernel裡接到 Middlewares/AuthCheck 未登入會拒絕訪問
//         換成其他名稱會出現 Bad Method Call 先用profile當會員中心

Route::get('logout', [UserAuthController::class, 'logout']);