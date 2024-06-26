<?php


namespace Admin;

use database\Database;

class Websetting extends Admin
{

    public function index()
    {
        $db = new DataBase();
        $websetting = $db->select('SELECT * FROM websetting ORDER BY `id` DESC')->fetch() ;
        require_once(BASE_PATH . '/template/admin/websettings/index.php');
    }




    public function edit()
    {
        $db = new DataBase();
        $websetting = $db->select('SELECT * FROM websetting')->fetch();
        require_once(BASE_PATH . '/template/admin/websettings/edit.php');

    }

    public function update($request)
    {
        $db = new DataBase();
        $setting = $db->select('SELECT * FROM websetting ')->fetch();
        if($request['logo']['tmp_name'] != '')
        {
            $this->removeImage($setting['logo']);
            $request['logo'] = $this->saveImage($request['logo'], 'settings','logo');
        }
        else
        {
            unset($request['logo']);
        }

        if($request['icon']['tmp_name'] != '')
        {
            $this->removeImage($setting['icon']);
            $request['icon'] = $this->saveImage($request['icon'], 'settings','icon');
        }
        else
        {
            unset($request['icon']);
        }

        if(!empty($setting))
        {
            $db->update('websetting',$setting['id'], array_keys($request), $request);
        }
        else
        {
            $db->insert('websetting', array_keys($request), $request);
        }


        $this->redirect('admin/websetting');
    }

}