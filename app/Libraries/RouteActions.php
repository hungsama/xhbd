<?php 
namespace App\Libraries;
class RouteActions {
    public function __construct() {
        parent::__construct();
    }
    public static function actions() {
        $article = self::getGroups('article');
        $category = self::getGroups('category');
        $group = array (
            (object)array(
                'group_name' => 'Article', 
                'group_alias' => "Quản lý bài báo",
                'actions' => $article
            ),
            (object) array(
                'group_name' => 'Category',
                'group_alias' => "Quản lý danh mục",
                'actions' => $category
            )
        );
        return $group;
    }

    private static function getGroups($group_name) {
        switch ($group_name) {
            case 'article':
                $data = array(
                    (object) array(
                        'alias' => 'Xem toàn bộ bài báo',
                        'url' => 'backend/article/list-articles',
                        'methods' => ['GET']
                    ),
                    (object) array(
                        'alias' => 'Thêm mới bài báo',
                        'url' => 'backend/article/create-article',
                        'methods' => ['GET', 'POST']
                    ),
                    (object) array(
                        'alias' => 'Xem chi tiết một bài báo',
                        'url' => '/backend/article/detail-article',
                        'methods' => ['GET']
                    ),
                    (object) array(
                        'alias' => 'Cập nhật bài báo',
                        'url' => '/backend/article/detail-article',
                        'methods' => ['PUT']
                    ),
                    (object) array(
                        'alias' => 'Tìm kiếm một bài báo',
                        'url' => '/backend/article/search-articles',
                        'methods' => ['POST']
                    ),
                    (object) array(
                        'alias' => 'Xóa một bài báo',
                        'url' => '/backend/article/article',
                        'methods' => ['DELETE']
                    )
                );
                break;
            case 'category':
                $data = array(
                    (object) array(
                        'alias' => 'Xem toàn bộ danh mục',
                        'url' => '/backend/category/list-categories',
                        'methods' => ['GET']
                    ),
                    (object) array(
                        'alias' => 'Thêm mới danh mục',
                        'url' => '/backend/category/create-category',
                        'methods' => ['GET','POST']
                    ),
                    (object) array(
                        'alias' => 'Xem chi tiết một danh mục',
                        'url' => '/backend/category/detail-category',
                        'methods' => ['GET']
                    ),
                    (object) array(
                        'alias' => 'Tìm kiếm danh mục',
                        'url' => '/backend/category/search-categories',
                        'methods' => ['POST']
                    ),
                    (object) array(
                        'alias' => 'Xóa một danh mục',
                        'url' => '/backend/category/category',
                        'methods' => ['DELETE']
                    )
                );
                break;
            
            default:
                # code...
                break;
        }
        return $data;
    }
}
