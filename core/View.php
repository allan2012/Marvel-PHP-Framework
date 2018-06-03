<?php

//include '/../App/configs.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of View
 *
 * @author Allan
 */
class View
{

    private $data = array();
    
    private $render;
    
    public function __construct()
    {
        $this->render = false;
    }

    public function render($template, $data = [])
    {
        try {
            $file = APP_PATH . '/app/views/' . strtolower($template) . '.php';

            if (file_exists($file)) {
                $this->render = $file;
                $this->assign($data);
                
            } else {
                die('View not found');
            }
        } catch (Exception $ex) {
            
        }
    }

    public function assign($data)
    {
        foreach($data as $key=>$value){
            $this->data[$key] = $value;
        }
    }

    public function __destruct()
    {
        extract($this->data);

        @include($this->render);
    }

}
