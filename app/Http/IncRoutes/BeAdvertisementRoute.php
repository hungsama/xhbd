<?php
/**
 * <============ BEGIN = BACKEND ADVERTISEMENTS ============>
 */
Route::get('/backend/list-advertisements', [
  'as' => 'be-advertisement.show',
  'uses' => 'Backend\BeAdvertisementController@index'
]);

Route::post('/backend/search-advertisements', [
  'as' => 'be-ajaxsearch-advertisement.show',
  'uses' => 'Backend\BeAdvertisementController@ajaxSearchAdvertisement'
]);

Route::post('/backend/search-advertisement', [
  'as' => 'be-ajaxsearch-advertisement.show',
  'uses' => 'Backend\BeAdvertisementController@ajaxSearchAdvertisement'
]);

Route::get('/backend/create-advertisement', [
  'as' => 'be-create-advertisement.show',
  'uses' => 'Backend\BeAdvertisementController@createAdvertisement'
]);

Route::post('/backend/create-advertisement', [
  'as' => 'be-save-advertisement.show',
  'uses' => 'Backend\BeAdvertisementController@saveAdvertisement'
]);

Route::get('/backend/detail-advertisement/{id}', [
  'as' => 'be-detail-advertisement.show',
  'uses'=> 'Backend\BeAdvertisementController@detailAdvertisement'
]);

Route::put('/backend/detail-advertisement/{id}', [
  'as' => 'be-update-advertisement.show',
  'uses' => 'Backend\BeAdvertisementController@updateAdvertisement'
]);

Route::delete('/backend/advertisement/{id}', [
  'as' => 'be-delete-advertisement.show',
  'uses' => 'Backend\BeAdvertisementController@deleteAdvertisement'
]);
/**
 * <============ END = BACKEND ADVERTISEMENTS ============>
 */
