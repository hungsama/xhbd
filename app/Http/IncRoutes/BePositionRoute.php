<?php

/**
 * <============ BEGIN = BACKEND POSITIONS ============>
 */
Route::get('/backend/list-postions', [
  'as' => 'be-position.show',
  'uses' => 'Backend\BePositionController@index'
]);

Route::post('/backend/search-postions', [
  'as' => 'be-ajaxsearch-postion.show',
  'uses' => 'Backend\BePositionController@ajaxSearchPosition'
]);

Route::get('/backend/create-position', [
  'as' => 'be-create-position.show',
  'uses' => 'Backend\BePositionController@createPosition'
]);

Route::post('/backend/create-position', [
  'as' => 'be-save-position.show',
  'uses' => 'Backend\BePositionController@savePosition'
]);

Route::get('/backend/detail-position/{id}', [
  'as' => 'be-detail-position.show',
  'uses'=> 'Backend\BePositionController@detailPosition'
]);

Route::put('/backend/detail-position/{id}', [
  'as' => 'be-update-position.show',
  'uses' => 'Backend\BePositionController@updatePosition'
]);

Route::delete('/backend/position/{id}', [
  'as' => 'be-delete-position.show',
  'uses' => 'Backend\BePositionController@deletePosition'
]);
/**
 * <============ END = BACKEND POSITIONS ============>
 */