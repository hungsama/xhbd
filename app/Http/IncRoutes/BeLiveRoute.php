<?php
/**
 * <============ BEGIN = BACKEND CATEGORIES ============>
 */
Route::get('backend/list-lives', [
  'as' => 'be-lives.show',
  'uses' => 'Backend\BeLiveController@index'
]);

Route::post('/backend/search-lives', [
  'as' => 'be-ajaxsearch-live.show',
  'uses' => 'Backend\BeLiveController@ajaxSearchLive'
]);

Route::get('/backend/detail-live/{id}', [
  'as' => 'be-detail-live.show',
  'uses' => 'Backend\BeLiveController@detailLive'
]);

Route::get('/backend/create-live', [
  'as' => 'be-create-live.show',
  'uses' => 'Backend\BeLiveController@createLive'
]);

Route::post('/backend/create-live', [
  'as' => 'be-save-live.show',
  'uses' => 'Backend\BeLiveController@saveLive'
]);

Route::put('/backend/detail-live/{id}', [
  'as' => 'be-update-live.show',
  'uses' => 'Backend\BeLiveController@updateLive'
]);

Route::delete('/backend/live/{id}', [
  'as' => 'be-delete-live.show',
  'uses' => 'Backend\BeLiveController@deleteLive'
]);

Route::post('/backend/live/listRank', [
  'as' => 'be-delete-live.show',
  'uses' => 'Backend\BeLiveController@listRank'
]);

Route::post('/backend/live/changeStatus', [
  'as' => 'be-change-status-live.show',
  'uses' => 'Backend\BeLiveController@changeStatus'
]);

Route::post('/backend/live/changeNation', [
  'as' => 'be-change-nation-live.show',
  'uses' => 'Backend\BeLiveController@changeNation'
]);
/**
 * <============ END = BACKEND CATEGORIES ============>
 */
