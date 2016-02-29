  <?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::group(['middleware' => 'csrf', 'middleware' => 'functauth'], function()
{
    include_once 'IncRoutes/BeCategoryRoute.php';
    include_once 'IncRoutes/BeArticleRoute.php';
    include_once 'IncRoutes/BeTagRoute.php';
    include_once 'IncRoutes/BeAdvertiserRoute.php';
    include_once 'IncRoutes/BeAdvertisementRoute.php';
    include_once 'IncRoutes/BePositionRoute.php';
    include_once 'IncRoutes/BeAdminRoute.php';
    include_once 'IncRoutes/BeUploadRoute.php';
    include_once 'IncRoutes/BeErrorRoute.php';
    include_once 'IncRoutes/BeLogRoute.php';
    include_once 'IncRoutes/BeClubRoute.php';
    include_once 'IncRoutes/BeRankRoute.php';
    include_once 'IncRoutes/BeLiveRoute.php';
});
include_once 'IncRoutes/BeLoginRoute.php';
include_once 'IncRoutes/BeCommonRoute.php';

include_once 'IncRoutes/FtHomeRoute.php';

