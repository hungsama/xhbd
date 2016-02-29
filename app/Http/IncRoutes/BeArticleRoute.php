<?php
/**
 * <============ BEGIN = BACKEND ARTICLES ============>
 */
Route::get('/backend/article/list-articles', [
  'as' => 'be-article.show',
  'uses' => 'Backend\BeArticleController@index'
]);

Route::post('/backend/article/search-articles', [
  'as' => 'be-ajaxsearch-article.show',
  'uses' => 'Backend\BeArticleController@ajaxSearchArticle'
]);

Route::get('/backend/article/create-article', [
  'as' => 'be-create-article.show',
  'uses' => 'Backend\BeArticleController@createArticle'
]);

Route::post('/backend/article/create-article', [
  'as' => 'be-save-article.show',
  'uses' => 'Backend\BeArticleController@saveArticle'
]);

Route::get('/backend/article/detail-article/{id}', [
  'as' => 'be-detail-article.show',
  'uses'=> 'Backend\BeArticleController@detailArticle'
]);

Route::put('/backend/article/detail-article/{id}', [
  'as' => 'be-update-article.show',
  'uses' => 'Backend\BeArticleController@updateArticle'
]);

Route::delete('/backend/article/article/{id}', [
  'as' => 'be-delete-article.show',
  'uses' => 'Backend\BeArticleController@deleteArticle'
]);

Route::post('/backend/article/changeStatus', [
  'as' => 'be-change-status-article.show',
  'uses' => 'Backend\BeArticleController@changeStatus'
]);
/**
 * <============ END = BACKEND ARTICLES ============>
 */