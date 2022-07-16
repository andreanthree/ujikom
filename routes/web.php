<?php

use App\Http\Controllers\Admin\ArtikelAdminController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\DashboardController as UserDashboardController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KomentarAdminController;
use App\Http\Controllers\Admin\WriterAdminController;
use App\Http\Controllers\ChangePassController;
use App\Http\Controllers\Writer\ArtikelWriterController;
use App\Http\Controllers\Writer\DashboardWriterController;
use Illuminate\Support\Facades\Auth;


Auth::routes(['register' => true, 'reset' => false, 'verify' => false]);

Route::prefix('/')
    ->get('/', [UserDashboardController::class, 'index'])
 
    ->middleware(['auth', 'which.home'])
    ->name('user.dashboard');

    Route::prefix('admin')
    ->middleware(['auth', 'is.admin'])
    ->group(function(){
       
        Route::get('/', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');
        Route::get('/penulis/json',[WriterAdminController::class,'json'])->name('penulisjsonadmin');
        Route::get('/artikel/json',[ArtikelAdminController::class,'json'])->name('artikeljsonadmin');
        Route::get('/komentar/json',[KomentarAdminController::class,'json'])->name('komentarjsonadmin');

        Route::resources([
            '/penulis' => WriterAdminController::class,
            '/artikel' => ArtikelAdminController::class,
            '/komentar' => KomentarAdminController::class,
        ]);
       

    });
    Route::prefix('writer')
        ->middleware(['auth', 'is.writer'])
        ->group(function(){
           
            // Session::forget('buku');
            Route::get('/', [DashboardWriterController::class, 'index'])
            ->name('writer.dashboard');
            Route::get('/artikel/json',[ArtikelWriterController::class,'json'])->name('artikeljsonwriter');
            Route::resources([
                '/artikel' => ArtikelWriterController::class,
            ]);
           
    
        });

/* 
| So basically we have 2 users here, USER and ADMIN. USER prefix is '/'
| and ADMIN prefix is 'admin'. Here we have change password feature that 
| can be used by either USER nor ADMIN.
*/

$users = [
    '/', 'admin',
];

foreach ($users as $user) {
    Route::prefix($user)
    ->middleware(['auth'])
    ->group(function () use ($user) {
        if($user == '/') $user = 'user';
        Route::get('/change-pass', [ChangePassController::class, 'index'])
        ->name($user.'.change-pass.index');
        Route::put('/change-pass/update', [ChangePassController::class, 'update'])
        ->name($user.'.change-pass.update');
    });
}