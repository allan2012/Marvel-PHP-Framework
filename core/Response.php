<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Response
 *
 * @author Allan
 */
class Response
{

    public function renderJSON($array)
    {
        header('Content-Type: application/json');
        
        echo json_encode($array);
    }

    public function redirect($path)
    {
        header("Location: $path");
    }
}
