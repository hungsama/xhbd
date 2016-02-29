<?php
Route::get('/backend/dashboard', [
  'as' => 'be-dashboard.show',
  'uses' => 'Backend\BeDashboardController@index'
]);