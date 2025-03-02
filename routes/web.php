<?php

use Illuminate\Support\Facades\Route;
use LaravelLookbook\Http\Controllers\LookbookController;

Route::get(config('lookbook.route', 'lookbook'), [LookbookController::class, 'index'])
  ->name('lookbook.index');

Route::get(config('lookbook.route', 'lookbook') . '/{component}', [LookbookController::class, 'show'])
  ->where('component', '.*')
  ->name('lookbook.show');
