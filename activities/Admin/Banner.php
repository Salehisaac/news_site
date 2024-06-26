<?php


namespace Admin;

use database\Database;

class Banner extends Admin
{

    public function index()
    {

        $db = new DataBase();
        $banners = $db->select('SELECT * FROM banner ORDER BY `id` DESC');
        require_once(BASE_PATH . '/template/admin/banners/index.php');
    }

    public function create()
    {

        require_once(BASE_PATH . '/template/admin/banners/create.php');

    }

    public function store($request)
    {


        $db = new DataBase();

            $request['image'] = $this->saveImage($request['image'], 'banner-image');

        if($request['image'])
            {

                $db->insert('banner', array_keys($request), $request);
                $this->redirect('admin/banner');

            }
            else
            {

                $this->redirect('admin/banner');
            }
        }




    public function edit($id)
    {
        $db = new DataBase();
        $banner = $db->select('SELECT * FROM banner WHERE id = ?;', [$id])->fetch();
        require_once(BASE_PATH . '/template/admin/banners/edit.php');

    }

    public function update($request,$id)
    {


        $db = new DataBase();



            if($request['image']['tmp_name'] != null)
            {

                $banner = $db->select('SELECT * FROM banner WHERE id = ?;', [$id])->fetch();
                $this->removeImage($banner['image']);
                $request['image'] = $this->saveImage($request['image'], 'banner-image');

            }
            else
            {
                unset($request['image']);
            }

            $request = array_merge($request, ['user_id' => 1]);
            $db->update('banner',$id, array_keys($request), $request);
            $this->redirect('admin/banner');
        }



    public function delete($id)
    {
        $db = new DataBase();
        $banner = $db->select('SELECT * FROM banner WHERE id = ?;', [$id])->fetch();
        $this->removeImage($banner['image']);
        $db->delete('banner',$id);
        $this->redirect('admin/banner');

    }

}