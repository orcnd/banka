<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransferController;

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

Auth::routes();

Route::get('/home', [
    App\Http\Controllers\HomeController::class,
    'index',
])->name('home');

/**
 * Creates Routes for basic crud operations
 *
 * @param class $controller controller object for crud operation
 * @param string $name name of crud element
 * @param string $modelName name of crud eloquent model for model binding
 *
 * @return void
 */
function createCrudRoutes($controller, $name, $modelName)
{
    Route::get('/' . $name, [$controller, 'index'])->name($name . '.index');

    Route::get('/' . $name . '/{' . $modelName . '}/show', [
        $controller,
        'show',
    ])->name($name . '.show');

    Route::get('/' . $name . '/create', [$controller, 'create'])->name(
        $name . '.create'
    );

    Route::post('/' . $name . '/create', [$controller, 'store'])->name(
        $name . '.store'
    );

    Route::get('/' . $name . '/{' . $modelName . '}/edit', [
        $controller,
        'edit',
    ])->name($name . '.edit');

    Route::post('/' . $name . '/{' . $modelName . '}', [
        $controller,
        'update',
    ])->name($name . '.update');

    Route::post('/' . $name . '/{' . $modelName . '}/delete', [
        $controller,
        'destroy',
    ])->name($name . '.destroy');
}

Route::get('/accounts', [AccountController::class, 'index'])->name(
    'account.index'
);

Route::get('/account/{account}/show', [AccountController::class, 'show'])->name(
    'account.show'
);

Route::get('/account/create', [AccountController::class, 'create'])->name(
    'account.create'
);

Route::post('/account/create', [AccountController::class, 'store'])->name(
    'account.store'
);

Route::get('/account/{account}/edit', [AccountController::class, 'edit'])->name(
    'account.edit'
);

Route::post('/account/{account}', [AccountController::class, 'update'])->name(
    'account.update'
);

Route::post('/account/{account}/delete', [
    AccountController::class,
    'destroy',
])->name('account.destroy');

Route::get('/transfer/{transfer}/show', [
    TransferController::class,
    'show',
])->name('transfer.show');

Route::get('/transfer/between', [
    TransferController::class,
    'createBetween',
])->name('transfer.between');

Route::post('/transfer/between', [
    TransferController::class,
    'storeBetween',
])->name('transfer.storeBetween');

Route::get('/transfer/eft', [TransferController::class, 'createEft'])->name(
    'transfer.eft'
);

Route::post('/transfer/eft', [TransferController::class, 'storeEft'])->name(
    'transfer.storeEft'
);

Route::get('/transfer/cash', [TransferController::class, 'createCash'])->name(
    'transfer.cash'
);

Route::post('/transfer/cash', [TransferController::class, 'storeCash'])->name(
    'transfer.storeCash'
);
