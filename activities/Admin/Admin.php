<?php

namespace Admin;

class Admin{

    function __construct(){
        $this->basePath = BASE_PATH;
        $this->currentDomain = CURRENT_DOMAIN;
    }

    protected function redirect($url){

        header('location: ' . trim($this->currentDomain,'/ ') . '/' . trim($url,'/ '));
    }
}
