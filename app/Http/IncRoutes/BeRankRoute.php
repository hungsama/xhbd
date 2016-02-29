<?php
/**
 * <============ BEGIN = BACKEND CATEGORIES ============>
 */
Route::get('backend/list-ranks', [
  'as' => 'be-ranks.show',
  'uses' => 'Backend\BeRankController@index'
]);

Route::post('/backend/search-ranks', [
  'as' => 'be-ajaxsearch-rank.show',
  'uses' => 'Backend\BeRankController@ajaxSearchRank'
]);

Route::get('/backend/detail-rank/{id}', [
  'as' => 'be-detail-rank.show',
  'uses' => 'Backend\BeRankController@detailRank'
]);

Route::get('/backend/create-rank', [
  'as' => 'be-create-rank.show',
  'uses' => 'Backend\BeRankController@createRank'
]);

Route::post('/backend/create-rank', [
  'as' => 'be-save-rank.show',
  'uses' => 'Backend\BeRankController@saveRank'
]);

Route::put('/backend/detail-rank/{id}', [
  'as' => 'be-update-rank.show',
  'uses' => 'Backend\BeRankController@updateRank'
]);

Route::delete('/backend/rank/{id}', [
  'as' => 'be-delete-rank.show',
  'uses' => 'Backend\BeRankController@deleteRank'
]);

Route::post('/backend/rank/listRank', [
  'as' => 'be-delete-rank.show',
  'uses' => 'Backend\BeRankController@listRank'
]);

Route::post('/backend/rank/changeStatus', [
  'as' => 'be-change-status-rank.show',
  'uses' => 'Backend\BeRankController@changeStatus'
]);

Route::post('/backend/rank/changeNation', [
  'as' => 'be-change-nation-rank.show',
  'uses' => 'Backend\BeRankController@changeNation'
]);
/**
 * <============ END = BACKEND CATEGORIES ============>
 */
