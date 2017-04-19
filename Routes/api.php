<?php

Route::group(['prefix' => 'v1', 'middleware' => 'permission:slide'], function () {
    Route::post('slide/sort', 'Backend\SlideController@sortSlide');
    Route::resource('slide', 'Backend\SlideController', ['only' => ['index', 'show', 'store', 'update', 'destroy']]);
});