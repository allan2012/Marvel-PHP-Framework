<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HomeController
 *
 * @author Allan
 */
class HomeController extends Controller
{

    public function index()
    {
        $view_data = [
            'title' => 'Marvel PHP Framework'
        ];
        
        $this->view->render('index', $view_data);
    }

}
