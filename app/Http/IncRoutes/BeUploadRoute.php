<?php
/**
 * <============ BEGIN = BACKEND UPLOAD ============>
 */
Route::get('/backend/upload/listfiles', [
  'as' => 'list-file.show',
  'uses' => 'Backend\BeUploadPluginController@index'
]);

Route::post('/backend/upload/uploadfile', [
  'as' => 'upload-file.show',
  'uses' => 'Backend\BeUploadPluginController@uploadFile'
]);

Route::post('/backend/upload/search-file', [
  'as' => 'be-ajaxsearch-file.show',
  'uses' => 'Backend\BeUploadPluginController@ajaxSearchFile'
]);
/**
 * <============ END = BACKEND UPLOAD ============>
 */