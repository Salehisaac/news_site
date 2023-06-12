<?php


namespace Admin;

use database\Database;

class Post extends Admin
{

    public function index()
    {
        $db = new DataBase();
        $posts = $db->select('SELECT * FROM posts ORDER BY `id` DESC');
        require_once(BASE_PATH . '/template/admin/posts/index.php');
    }

    public function create()
    {
        $db = new DataBase();
        $categories = $db->select('SELECT * FROM categories');
        require_once(BASE_PATH . '/template/admin/posts/create.php');

    }

    public function store($request)
    {
        $db = new DataBase();
        $db->insert('categories', array_keys($request), $request);
        $this->redirect('admin/category');
    }

    public function edit($id)
    {
        $db = new DataBase();
        $category = $db->select('SELECT * FROM categories WHERE id = ?;', [$id])->fetch();
        require_once(BASE_PATH . '/template/admin/categories/edit.php');

    }

    public function update($request,$id)
    {
        $db = new DataBase();
        $db->update('categories',$id,array_keys($request), $request);
        $this->redirect('admin/category');
    }

    public function delete($id)
    {
        $db = new DataBase();
        $db->delete('categories',$id);
        $this->redirect('admin/category');
    }

    public static function show_category_name($id)
    {
        $db = new DataBase();
        $category = $db->select('SELECT * FROM categories WHERE id = ?;', [$id])->fetch();
        return $category['name'];
    }
    public static function show_user_name($id)
    {
        $db = new DataBase();
        $user = $db->select('SELECT * FROM users WHERE id = ?;', [$id])->fetch();
        return $user['username'];

    }

}