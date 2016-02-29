<?php

/**
 * <============ BEGIN = BACKEND ADMINS ============>
 */
Route::get('/backend/auth/list-admins', [
  'as' => 'be-admin.show',
  'uses' => 'Backend\BeAuthenticateController@index'
]);

Route::post('/backend/auth/search-admin', [
  'as' => 'be-ajaxsearch-admin.show',
  'uses' => 'Backend\BeAuthenticateController@ajaxSearchAdmin'
]);

Route::get('/backend/auth/create-admin', [
  'as' => 'be-create-admin.show',
  'uses' => 'Backend\BeAuthenticateController@createAdmin'
]);

Route::post('/backend/auth/create-admin', [
  'as' => 'be-save-admin.show',
  'uses' => 'Backend\BeAuthenticateController@saveAdmin'
]);

Route::get('/backend/auth/detail-admin/{id}', [
  'as' => 'be-detail-admin.show',
  'uses'=> 'Backend\BeAuthenticateController@detailAdmin'
]);

Route::put('/backend/auth/detail-admin/{id}', [
  'as' => 'be-update-admin.show',
  'uses' => 'Backend\BeAuthenticateController@updateAdmin'
]);

Route::delete('/backend/auth/admin/{id}', [
  'as' => 'be-delete-admin.show',
  'uses' => 'Backend\BeAuthenticateController@deleteAdmin'
]);

Route::get('/backend/auth/permission/{id}/{type}', [
  'as' => 'be-permission-admin.show',
  'uses' => 'Backend\BeAuthenticateController@getPermissions'
]);

Route::post('/backend/auth/update-permission-group/{id}', [
  'as' => 'be-permission-admin.show',
  'uses' => 'Backend\BeAuthenticateController@updatePermissionGroup'
]);

Route::get('/backend/auth/admin-groups', [
  'as' => 'be-admin-group.show',
  'uses' => 'Backend\BeAuthenticateController@getGroups'
]);

Route::post('/backend/auth/search-group-admin', [
  'as' => 'be-ajaxsearch-group-admin.show',
  'uses' => 'Backend\BeAuthenticateController@ajaxSearchGroupAdmin'
]);

Route::get('/backend/auth/create-admin-group', [
  'as' => 'be-create-admin-group.show',
  'uses' => 'Backend\BeAuthenticateController@createGroup'
]);

Route::post('/backend/auth/create-admin-group', [
  'as' => 'be-save-admin-group.show',
  'uses' => 'Backend\BeAuthenticateController@saveGroup'
]);

Route::delete('/backend/auth/group/{id}', [
  'as' => 'be-delete-admin-group.show',
  'uses' => 'Backend\BeAuthenticateController@deleteGroup'
]);

/**
 * <============ END = BACKEND ADMINS ============>
 */
