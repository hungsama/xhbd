<?php
/**
 * <============ BEGIN = BACKEND TAGS ============>
 */
Route::get('/backend/list-tags', [
  'as' => 'be-tag.show',
  'uses' => 'Backend\BetagController@index'
]);

Route::post('/backend/search-tags', [
  'as' => 'be-ajaxsearch-tag.show',
  'uses' => 'Backend\BeTagController@ajaxSearchTag'
]);

Route::get('/backend/detail-tag/{id}', [
  'as' => 'be-detail-tag.show',
  'uses' => 'Backend\BeTagController@detailTag'
]);

Route::get('/backend/create-tag', [
  'as' => 'be-create-tag.show',
  'uses' => 'Backend\BeTagController@createTag'
]);

Route::post('/backend/create-tag', [
  'as' => 'be-save-tag.show',
  'uses' => 'Backend\BeTagController@saveTag'
]);

Route::put('/backend/detail-tag/{id}', [
  'as' => 'be-update-tag.show',
  'uses' => 'Backend\BeTagController@updateTag'
]);

Route::delete('/backend/tag/{id}', [
  'as' => 'be-delete-tag.show',
  'uses' => 'Backend\BeTagController@deleteTag'
]);
/**
 * <============ END = BACKEND TAGS ============>
 */