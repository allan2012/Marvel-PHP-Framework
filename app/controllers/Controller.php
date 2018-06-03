<?php

/**
 * Description of Controller
 *
 * @author Allan
 */
class Controller
{

    protected $email;
    
    protected $request;
    
    protected $session;
    
    protected $auth;
    
    protected $view;

    protected $response;

    public function __construct()
    {
        
        $this->email = new Mail();
        
        $this->session = new Session();
        
        $this->db = new Db();
        
        $this->view = new View();
        
        $this->request = new Request();
        
        $this->response = new Response();
        
        $this->helpers = new Helpers();
        
        $this->auth = new Auth();
       
    }
    
}
