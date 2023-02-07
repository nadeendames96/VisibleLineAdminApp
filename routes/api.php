<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin'], function () {
    // All Gates
    Route::apiResource('all-gates', 'AllGatesApiController');

    // Ads
    Route::post('ads/media', 'AdsApiController@storeMedia')->name('ads.storeMedia');
    Route::apiResource('ads', 'AdsApiController');
});
