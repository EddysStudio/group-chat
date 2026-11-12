<?php

use Illuminate\Support\Facades\Route;
use EddysStudio\GroupChat\Http\Controllers\GChatController;

Route::middleware('web')->group(function () {
    Route::get('/ourchat', [GChatController::class, 'index'])->name('group-chat.index');
    Route::post('/ourchat/messages', [GChatController::class, 'storeMessage'])->name('group-chat.messages.store');
    Route::get('/ourchat/messages', [GChatController::class, 'getMessages'])->name('group-chat.messages.index');
    Route::get('/ourchat/statuses', [GChatController::class, 'getStatuses'])->name('group-chat.statuses');
});