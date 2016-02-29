<?php
/**
 * <============ BEGIN = BACKEND CATEGORIES ============>
 */
Route::get('backend/list-categories', [
  'as' => 'be-category.show',
  'uses' => 'Backend\BeCategoryController@index'
]);

Route::post('/backend/search-categories', [
  'as' => 'be-ajaxsearch-category.show',
  'uses' => 'Backend\BeCategoryController@ajaxSearchCategory'
]);

Route::get('/backend/detail-category/{id}', [
  'as' => 'be-detail-category.show',
  'uses' => 'Backend\BeCategoryController@detailCategory'
]);

Route::get('/backend/create-category', [
  'as' => 'be-create-category.show',
  'uses' => 'Backend\BeCategoryController@createCategory'
]);

Route::post('/backend/create-category', [
  'as' => 'be-save-category.show',
  'uses' => 'Backend\BeCategoryController@saveCategory'
]);

Route::put('/backend/detail-category/{id}', [
  'as' => 'be-update-category.show',
  'uses' => 'Backend\BeCategoryController@updateCategory'
]);

Route::delete('/backend/category/{id}', [
  'as' => 'be-delete-category.show',
  'uses' => 'Backend\BeCategoryController@deleteCategory'
]);

Route::post('/backend/category/listRank', [
  'as' => 'be-listrank-category.show',
  'uses' => 'Backend\BeCategoryController@listRank'
]);

Route::post('/backend/category/changeStatus', [
  'as' => 'be-change-status-category.show',
  'uses' => 'Backend\BeCategoryController@changeStatus'
]);
/**
 * <============ END = BACKEND CATEGORIES ============>
 */
