<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Request
 *
 * @author Allan
 */
class Request
{

    /**
     * Get posted data
     * 
     * @param string $name
     * @param any $default
     * @return any
     */
    public function post($name, $default = null, $xss_filter = false)
    {
        $val = (isset($_POST[$name]) && ($_POST[$name] != '')) ? $_POST[$name] : $default;

        if ($xss_filter == true) {
            return htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
        } else {
            return $val;
        }
    }

    /**
     * Get request data
     * 
     * @param string $name
     * @param any $default
     * @return any
     */
    public function get($name, $default = null, $xss_filter = false)
    {
        $val = (isset($_GET[$name]) && ($_GET[$name] != '')) ? $_GET[$name] : $default;

        if ($xss_filter == true) {
            return htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
        } else {
            return $val;
        }
    }

    public function isPost()
    {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            return true;
        }
    }

    public function isGet()
    {
        if ($_SERVER["REQUEST_METHOD"] == 'GET') {
            return true;
        }
    }

}
