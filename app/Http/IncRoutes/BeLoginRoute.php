<?php
/**
 * <============ BEGIN = BACKEND LOGIN ============>
 */
Route::get('/backend/auth/login', [
  'as' => 'be-login-admin.show',
  'uses' => 'Backend\BeLoginController@index'
]);

Route::post('/backend/auth/login', [
  'as' => 'be-action-login.show',
  'uses' => 'Backend\BeLoginController@actionLogin'
]);

Route::get('/backend/auth/logout', [
  'as' => 'be-action-logout.show',
  'uses' => 'Backend\BeLoginController@logout'
]);

/**
 * <============ END = BACKEND LOGIN ============>
 */