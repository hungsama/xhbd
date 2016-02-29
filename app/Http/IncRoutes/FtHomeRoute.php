<?php
Route::get('/', [
  'as' => 'ft-home.show',
  'uses' => 'Frontend\HomeController@index'
]);

Route::get('/search/', [
  'as' => 'ft-search.show',
  'uses' => 'Frontend\HomeController@search'
]);

Route::post('/search/', [
  'as' => 'ft-search.show',
  'uses' => 'Frontend\HomeController@search'
]);

Route::get('/chi-tiet-bang-xep-hang/{league}', [
  'as' => 'ft-rank-detail.show',
  'uses' => 'Frontend\HomeController@detailRank'
]);

Route::get('/lich-thi-dau/{league}', [
  'as' => 'ft-lives.show',
  'uses' => 'Frontend\HomeController@lives'
]);

Route::get('/video/{league}', [
  'as' => 'ft-videos.show',
  'uses' => 'Frontend\HomeController@videos'
]);

Route::get('/truc-tiep-bong-da/{league}/{match}', [
  'as' => 'ft-live-detail.show',
  'uses' => 'Frontend\HomeController@liveDetail'
]);

Route::get('/{cate}', [
  'as' => 'ft-articles-in-category.show',
  'uses' => 'Frontend\HomeController@articlesInCategory'
]);

Route::get('/{cate}/{article}', [
  'as' => 'ft-detail.show',
  'uses' => 'Frontend\HomeController@detailArticle'
]);



