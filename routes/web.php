<?php

use App\Http\Controllers\BillingController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

Route::get('/r/{code}', [RedirectController::class, 'handle']);

Route::middleware(['auth'])->prefix('app')->group(function () {
    Route::get('/billing/checkout', [BillingController::class, 'checkout'])->name('billing.checkout');
    Route::get('/billing/portal',   [BillingController::class, 'portal'])->name('billing.portal');
    Route::get('/billing/success',  [BillingController::class, 'success'])->name('billing.success');
});

Route::post('/stripe/webhook', [
    \Laravel\Cashier\Http\Controllers\WebhookController::class,
    'handleWebhook'
]);



Route::get('/', [LandingController::class, 'index'])->name('landing');