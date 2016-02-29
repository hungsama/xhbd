<?php
/**
 * <============ BEGIN = BACKEND ADVERTISERS ============>
 */
Route::get('/backend/list-advertisers', [
  'as' => 'be-advertiser.show',
  'uses' => 'Backend\BeAdvertiserController@index'
]);

Route::post('/backend/search-advertisers', [
  'as' => 'be-ajaxsearch-advertiser.show',
  'uses' => 'Backend\BeAdvertiserController@ajaxSearchAdvertiser'
]);

Route::get('/backend/create-advertiser', [
  'as' => 'be-create-advertiser.show',
  'uses' => 'Backend\BeAdvertiserController@createAdvertiser'
]);

Route::post('/backend/create-advertiser', [
  'as' => 'be-save-advertiser.show',
  'uses' => 'Backend\BeAdvertiserController@saveAdvertiser'
]);

Route::get('/backend/detail-advertiser/{id}', [
  'as' => 'be-detail-advertiser.show',
  'uses'=> 'Backend\BeAdvertiserController@detailAdvertiser'
]);

Route::put('/backend/detail-advertiser/{id}', [
  'as' => 'be-update-advertiser.show',
  'uses' => 'Backend\BeAdvertiserController@updateAdvertiser'
]);

Route::delete('/backend/advertiser/{id}', [
  'as' => 'be-delete-advertiser.show',
  'uses' => 'Backend\BeAdvertiserController@deleteAdvertiser'
]);
/**
 * <============ END = BACKEND ADVERTISERS ============>
 */