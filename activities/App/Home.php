<?php

namespace App;

use database\DataBase;



class Home{

    public function index()
    {
        $db = new DataBase();

        $setting = $db->select('SELECT * FROM websetting')->fetch();

        $menus = $db->select('SELECT * FROM menus WHERE parent_id IS NULL')->fetchAll();


        $topSelectedPosts = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, 
       (SELECT username FROM users WHERE users.id = posts.user_id) AS username, 
       (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts WHERE posts.selected = 1 ORDER BY created_at DESC LIMIT 0,3')->fetchAll();

        $breakingNews = $db->select('SELECT * FROM posts WHERE breaking_news = 1 ORDER BY created_at DESC LIMIT 0,1')->fetch();

        $bodyBanner = $db->select('SELECT * FROM banner  LIMIT 0,1')->fetch();

        $sidebarBanner = $db->select('SELECT * FROM banner  LIMIT 0,1')->fetch();

        $categories = $db->select('SELECT * FROM categories ')->fetchAll();


        $lastPosts = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, 
       (SELECT username FROM users WHERE users.id = posts.user_id) AS username, 
       (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts  ORDER BY created_at DESC LIMIT 0,6')->fetchAll();

        $popularPosts = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, 
       (SELECT username FROM users WHERE users.id = posts.user_id) AS username,
       (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts ORDER BY view DESC LIMIT 0,3')->fetchAll();

        $mostCommentPosts = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, 
       (SELECT username FROM users WHERE users.id = posts.user_id) AS username,
       (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts ORDER BY comments_count DESC LIMIT 0,3')->fetchAll();

        $topSelectedPostside = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, 
       (SELECT username FROM users WHERE users.id = posts.user_id) AS username, 
       (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts WHERE posts.selected = 1 ORDER BY created_at  LIMIT 0,1')->fetchAll();

        $topSelectedPosts = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, 
       (SELECT username FROM users WHERE users.id = posts.user_id) AS username, 
       (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts WHERE posts.selected = 1 ORDER BY created_at DESC LIMIT 0,3')->fetchAll();






        require_once(BASE_PATH . '/template/app/index.php');
    }

    public function show($id)
    {
        $db = new DataBase();

        $setting = $db->select('SELECT * FROM websetting')->fetch();

        $menus = $db->select('SELECT * FROM menus WHERE parent_id IS NULL')->fetchAll();

        $categories = $db->select('SELECT * FROM categories ')->fetchAll();

        $sidebarBanner = $db->select('SELECT * FROM banner  LIMIT 0,1')->fetch();

        $topSelectedPostside = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, 
       (SELECT username FROM users WHERE users.id = posts.user_id) AS username, 
       (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts WHERE posts.selected = 1 ORDER BY created_at  LIMIT 0,1')->fetchAll();

        $post = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, 
       (SELECT username FROM users WHERE users.id = posts.user_id) AS username, 
       (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts WHERE id = ?;', [$id])->fetch();

        $mostCommentPosts = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, 
       (SELECT username FROM users WHERE users.id = posts.user_id) AS username,
       (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts ORDER BY comments_count DESC LIMIT 0,3')->fetchAll();

        $comments = $db->select('SELECT *, (SELECT username FROM users 
        WHERE users.id = comments.user_id) AS username FROM comments  WHERE post_id = ? AND status = "approved"  ORDER BY created_at DESC LIMIT 0,3' , [$id] )->fetchAll();





        require_once(BASE_PATH . '/template/app/show.php');
        require_once BASE_PATH . '/template/app/layouts/footer.php';
    }

    public function category($id)
    {

        $db = new DataBase();
        $categories = $db->select('SELECT * FROM categories ')->fetchAll();
        $category = $db->select("SELECT * FROM categories WHERE id = ?", [$id])->fetch();
        $topSelectedPosts = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, (SELECT username FROM users WHERE users.id = posts.user_id) AS username, (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts WHERE posts.selected = 1 ORDER BY created_at DESC LIMIT 0,1')->fetchAll();
        $popularPosts = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, (SELECT username FROM users WHERE users.id = posts.user_id) AS username, (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts ORDER BY view DESC LIMIT 0,3')->fetchAll();
        $breakingNews = $db->select('SELECT * FROM posts WHERE breaking_news = 1 ORDER BY created_at DESC LIMIT 0,1')->fetch();
        $mostCommentPosts = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, (SELECT username FROM users WHERE users.id = posts.user_id) AS username, (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts ORDER BY comments_count DESC LIMIT 0,3')->fetchAll();
        $setting = $db->select('SELECT * FROM websetting')->fetch();
        $menus = $db->select('SELECT * FROM menus WHERE parent_id IS NULL')->fetchAll();
        $sidebarBanner = $db->select('SELECT * FROM banner LIMIT 0,1')->fetch();
        $bodyBanner = $db->select('SELECT * FROM banner LIMIT 0,1')->fetch();
        $topSelectedPostside = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, 
       (SELECT username FROM users WHERE users.id = posts.user_id) AS username, 
       (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts WHERE posts.selected = 1 ORDER BY created_at  LIMIT 0,1')->fetchAll();
        $categoryPosts = $db->select('SELECT posts.*,(SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, (SELECT username FROM users WHERE users.id = posts.user_id) AS username, (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts WHERE cat_id = ? ORDER BY created_at DESC LIMIT 0,6', [$id])->fetchAll();
        require_once(BASE_PATH . '/template/app/category.php');

    }

    public function commentStore($request,$post_id)
    {

        if(isset($_SESSION['user']))
        {
            if($_SESSION['user'] != null)
            {
                $db = new Database();
                $db->insert('comments', ['user_id', 'post_id', 'comment'], [$_SESSION['user'], $post_id, $request['comment']]);
                $this->redirectBack();
            }
            else{
                $this->redirectBack();
            }
        }
        else{
            $this->redirectBack();
        }
    }

    protected function redirectBack()
    {
        header('Location: '. $_SERVER['HTTP_REFERER']);
        exit;
    }

}