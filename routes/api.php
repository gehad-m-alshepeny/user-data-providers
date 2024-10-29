<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\DataProviders\DataProviderController;


Route::group(['prefix' => '/v1'], function () 
{
  Route::get('/users',[DataProviderController::class,'index']);
});
