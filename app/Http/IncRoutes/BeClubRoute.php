<?php
/**
 * <============ BEGIN = BACKEND CATEGORIES ============>
 */
Route::get('backend/list-clubs', [
  'as' => 'be-clubs.show',
  'uses' => 'Backend\BeClubController@index'
]);

Route::post('/backend/search-clubs', [
  'as' => 'be-ajaxsearch-club.show',
  'uses' => 'Backend\BeClubController@ajaxSearchClub'
]);

Route::get('/backend/detail-club/{id}', [
  'as' => 'be-detail-club.show',
  'uses' => 'Backend\BeClubController@detailClub'
]);

Route::get('/backend/create-club', [
  'as' => 'be-create-club.show',
  'uses' => 'Backend\BeClubController@createClub'
]);

Route::post('/backend/create-club', [
  'as' => 'be-save-club.show',
  'uses' => 'Backend\BeClubController@saveClub'
]);

Route::put('/backend/detail-club/{id}', [
  'as' => 'be-update-club.show',
  'uses' => 'Backend\BeClubController@updateClub'
]);

Route::delete('/backend/club/{id}', [
  'as' => 'be-delete-club.show',
  'uses' => 'Backend\BeClubController@deleteClub'
]);

Route::post('/backend/club/listRank', [
  'as' => 'be-delete-club.show',
  'uses' => 'Backend\BeClubController@listRank'
]);

Route::post('/backend/club/changeStatus', [
  'as' => 'be-change-status-club.show',
  'uses' => 'Backend\BeClubController@changeStatus'
]);
/**
 * <============ END = BACKEND CATEGORIES ============>
 */
