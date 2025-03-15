<?php

use App\Constants\UserRoles;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('site.dashboard');
    })->name('site.dashboard');
}); 


///////////////////////*** módulo "login" ***///////////////////////


Route::get('/', function () 
{
        if (Auth::check()) {
            return view('site.dashboard');
        }

    return view('auth.login');
});

Route::post('/auth', [LoginController::class, 'auth'])->name('login.auth');

Route::get('/logout', [LoginController::class, 'logout'])->name('login.logout');

Route::put('/reset-password', [LoginController::class, 'resetPassword'])->name('login.resetPassword');



///////////////////////*** módulo "user" ***///////////////////////


Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('auth');
//aceita todos os usuários logados

Route::prefix('user')->group(function()
{
    Route::get('/show/{id}', [UserController::class, 'show'])->name('user.show')->middleware('auth', 'accept:'.UserRoles::PARTNER);
    //sócio

    Route::get('/create', [UserController::class, 'create'])->name('user.create')->middleware('auth', 'accept:'.UserRoles::PARTNER);
    //sócio

    Route::post('/create', [UserController::class, 'store'])->name('user.store')->middleware('auth', 'accept:'.UserRoles::PARTNER);
    //sócio

    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit')->middleware('auth', 'accept:'.UserRoles::PARTNER);
    //sócio

    Route::put('/update/{id}', [UserController::class, 'update'])->name('user.update')->middleware('auth', 'accept:'.UserRoles::PARTNER);
    //sócio

    Route::delete('/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy')->middleware('auth', 'accept:'.UserRoles::PARTNER);
    //sócio
});


///////////////////////*** módulo "client" ***///////////////////////


Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index')->middleware('auth');
//aceita todos os usuários logados

Route::prefix('project')->group(function()
{
    Route::get('/show/{id}', [ProjectController::class, 'show'])->name('project.show')->middleware('auth');
    //aceita todos os usuários logados

    Route::get('/create', [ProjectController::class, 'create'])->name('project.create')->middleware('auth', 'accept:'.UserRoles::PARTNER.','.UserRoles::CONSULTANT);
    //sócio e consultor

    Route::post('/create', [ProjectController::class, 'store'])->name('project.store')->middleware('auth', 'accept:'.UserRoles::PARTNER.','.UserRoles::CONSULTANT);
    //sócio e consultor

    Route::get('/edit/{id}', [ProjectController::class, 'edit'])->name('project.edit')->middleware('auth', 'accept:'.UserRoles::PARTNER.','.UserRoles::CONSULTANT);
    //sócio e consultor

    Route::put('/update/{id}', [ProjectController::class, 'update'])->name('project.update')->middleware('auth', 'accept:'.UserRoles::PARTNER.','.UserRoles::CONSULTANT);
    //sócio e consultor

    Route::delete('/destroy/{id}', [ProjectController::class, 'destroy'])->name('project.destroy')->middleware('auth', 'accept:'.UserRoles::PARTNER.','.UserRoles::CONSULTANT);
    //sócio e consultor
});


///////////////////////*** módulo "client" ***///////////////////////


Route::get('/clients', [ClientController::class, 'index'])->name('clients.index')->middleware('auth'); 
//aceita todos os usuários logados

Route::prefix('client')->group(function()
{
    Route::get('/show/{id}', [ClientController::class, 'show'])->name('client.show')->middleware('auth');
    //aceita todos os usuários logados

    Route::get('/create', [ClientController::class, 'create'])->name('client.create')->middleware('auth', 'accept:'.UserRoles::PARTNER.','.UserRoles::CONSULTANT);
    //sócio e consultor

    Route::post('/create', [ClientController::class, 'store'])->name('client.store')->middleware('auth', 'accept:'.UserRoles::PARTNER.','.UserRoles::CONSULTANT);
    //sócio e consultor

    Route::get('/edit/{id}', [ClientController::class, 'edit'])->name('client.edit')->middleware('auth', 'accept:'.UserRoles::PARTNER.','.UserRoles::CONSULTANT);
    //sócio e consultor

    Route::put('/update/{id}', [ClientController::class, 'update'])->name('client.update')->middleware('auth', 'accept:'.UserRoles::PARTNER.','.UserRoles::CONSULTANT);
    //sócio e consultor

    Route::delete('/destroy/{id}', [ClientController::class, 'destroy'])->name('client.destroy')->middleware('auth', 'accept:'.UserRoles::PARTNER.','.UserRoles::CONSULTANT);
    //sócio e consultor
});


///////////////////////*** módulo "task" (atividade) ***///////////////////////


Route::prefix('task')->group(function()
{
    Route::get('/show/{id}', [TaskController::class, 'show'])->name('task.show')->middleware('auth', 'accept:'.UserRoles::PARTNER.','.UserRoles::CONSULTANT.','.UserRoles::FINANCIER);
    //sócio, consultor e estagiário
    
    Route::get('/create/{id}', [TaskController::class, 'create'])->name('task.create')->middleware('auth', 'accept:'.UserRoles::PARTNER.','.UserRoles::CONSULTANT);
    //sócio e consultor
    
    Route::post('/store', [TaskController::class, 'store'])->name('task.store')->middleware('auth', 'accept:'.UserRoles::PARTNER.','.UserRoles::CONSULTANT);
    //sócio e consultor
    
    Route::get('/edit/{id}', [TaskController::class, 'edit'])->name('task.edit')->middleware('auth', 'accept:'.UserRoles::PARTNER.','.UserRoles::CONSULTANT.','.UserRoles::FINANCIER);
    //sócio, consultor e estagiário
    
    Route::put('/update/{id}', [TaskController::class, 'update'])->name('task.update')->middleware('auth', 'accept:'.UserRoles::PARTNER.','.UserRoles::CONSULTANT.','.UserRoles::FINANCIER);
    //sócio, consultor e estagiário
    
    Route::delete('/destroy/{id}', [TaskController::class, 'destroy'])->name('task.destroy')->middleware('auth', 'accept:'.UserRoles::PARTNER.','.UserRoles::CONSULTANT);
    //sócio e consultor
});



/////////////////*** módulo financeiro ***///////////////

Route::get("/finances", [FinanceController::class, 'index'])->name('finance.index')->middleware('auth');


////////////////*** módulo Receita (receipt) ***/////////////////////////

Route::prefix('receipt')->group(function()
{
    Route::get('/create', [ReceiptController::class, 'create'])->name('receipt.create')->middleware('auth', 'accept:'.UserRoles::PARTNER.','.UserRoles::FINANCIER);
    //sócio e financeiro

    Route::post('/store', [ReceiptController::class, 'store'])->name('receipt.store')->middleware('auth', 'accept:'.UserRoles::PARTNER.','.UserRoles::FINANCIER);
    //sócio e financeiro

    Route::get('/edit/{id}', [ReceiptController::class, 'edit'])->name('receipt.edit')->middleware('auth', 'accept:'.UserRoles::PARTNER.','.UserRoles::FINANCIER);
    //sócio e financeiro

    Route::put('/update/{id}', [ReceiptController::class, 'update'])->name('receipt.update')->middleware('auth', 'accept:'.UserRoles::PARTNER.','.UserRoles::FINANCIER);
    //sócio e financeiro

    Route::delete('/destroy/{id}', [ReceiptController::class, 'destroy'])->name('receipt.destroy')->middleware('auth', 'accept:'.UserRoles::PARTNER.','.UserRoles::FINANCIER);
    //sócio e financeiro
});

////////////////*** módulo Despesa (expense) ***/////////////////////////

Route::prefix('expense')->group(function()
{
    Route::get('/create', [ExpenseController::class, 'create'])->name('expense.create')->middleware('auth', 'accept:'.UserRoles::PARTNER.','.UserRoles::FINANCIER);
    //sócio e financeiro

    Route::post('/store', [ExpenseController::class, 'store'])->name('expense.store')->middleware('auth', 'accept:'.UserRoles::PARTNER.','.UserRoles::FINANCIER);
    //sócio e financeiro

    Route::get('/edit/{id}', [ExpenseController::class, 'edit'])->name('expense.edit')->middleware('auth', 'accept:'.UserRoles::PARTNER.','.UserRoles::FINANCIER);
    //sócio e financeiro

    Route::put('/update/{id}', [ExpenseController::class, 'update'])->name('expense.update')->middleware('auth', 'accept:'.UserRoles::PARTNER.','.UserRoles::FINANCIER);
    //sócio e financeiro

    Route::delete('/destroy/{id}', [ExpenseController::class, 'destroy'])->name('expense.destroy')->middleware('auth', 'accept:'.UserRoles::PARTNER.','.UserRoles::FINANCIER);
    //sócio e financeiro

});

///////////////////////*** módulo "category" (atividade) ***///////////////////////

Route::get("/categories", [CategoryController::class, 'index'])->name('categories.index')->middleware('auth', 'accept:'.UserRoles::PARTNER.','.UserRoles::FINANCIER);
//sócio e financeiro

Route::prefix('category')->group(function()
{
    Route::get('/create', [CategoryController::class, 'create'])->name('category.create')->middleware('auth', 'accept:'.UserRoles::PARTNER.','.UserRoles::FINANCIER);
    //sócio e financeiro
    
    Route::post('/store', [CategoryController::class, 'store'])->name('category.store')->middleware('auth', 'accept:'.UserRoles::PARTNER.','.UserRoles::FINANCIER);
    //sócio e financeiro
    
    Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit')->middleware('auth', 'accept:'.UserRoles::PARTNER.','.UserRoles::FINANCIER);
    //sócio e financeiro
    
    Route::put('/update/{id}', [CategoryController::class, 'update'])->name('category.update')->middleware('auth', 'accept:'.UserRoles::PARTNER.','.UserRoles::FINANCIER);
    //sócio e financeiro
    
    Route::delete('/destroy/{id}', [CategoryController::class, 'destroy'])->name('category.destroy')->middleware('auth', 'accept:'.UserRoles::PARTNER.','.UserRoles::FINANCIER);
    //sócio e financeiro
});