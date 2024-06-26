<?php


namespace Admin;

use database\Database;

class Comment extends Admin
{

    public function index()
    {
        $db = new DataBase();
        $comments = $db->select('SELECT comments.* , users.username , posts.title FROM comments JOIN users ON comments.user_id = users.id JOIN posts ON comments.post_id = posts.id
    ORDER BY `id` DESC');
        $unseenComments = $db->select('SELECT * FROM comments WHERE status = ?', ['unseen']);
        foreach($unseenComments as $comment){
            $db->update('comments', $comment['id'], ['status'], ['seen']);
        }
        require_once(BASE_PATH . '/template/admin/comments/index.php');
    }




    public function change($id)
    {
        $db = new DataBase();
        $comments = $db->select('SELECT * FROM comments WHERE id = ?;', [$id])->fetch();
        if (empty($comments))
        {
            $this->redirectBack();
        }
        if ($comments['status'] == 'seen')
        {
            $db->update('comments', $id, ['status'], ['approved']);
        }
        else
        {
            $db->update('comments', $id, ['status'], ['seen']);
        }
        $this->redirectBack();
    }


}