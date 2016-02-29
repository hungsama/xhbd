<?php
/**
 * <============ BEGIN = BACKEND LOGS ============>
 */
Route::get('/backend/list-log-views', [
  'as' => 'be-log-view.show',
  'uses' => 'Backend\BeLogController@listViews'
]);

Route::get('/backend/list-log-clicks', [
  'as' => 'be-log-click.show',
  'uses' => 'Backend\BeLogController@listClicks'
]);
/**
 * <============ END = BACKEND LOGS ============>
 */