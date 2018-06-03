<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Auth
 *
 * @author Allan
 */
class Auth
{

    private $options;
    
    private $algo;
    
    private $user;

    public function __construct()
    {
        $this->algo = PASSWORD_DEFAULT;

        $this->options = ['cost' => 12];

        $this->user = null;

        $this->algo = PASSWORD_BCRYPT;
    }

    private function getUserByEmail($email)
    {
        $db = new Db();

        return $db->table('users')->select('*')
                ->where('email', $email)
                ->first();

    }

    /**
     * Get user instance
     * 
     * @return Any
     */
    public function getUser()
    {
        return $this->user;
    }

    public function verifyPassword($email, $password)
    {
        $hash_password = $this->getUserByEmail($email)->password;
        
        if (password_verify($password, $hash_password)) {
            return true;
        } else {
            return false;
        }
    }
    

    /**
     * Verify user credentials
     * 
     * @param type $email
     * @param type $password
     * @return boolean
     */
    public function verify($email, $password)
    {
        if ((count($this->getUserByEmail($email)) > 0) && $this->verifyPassword($email, $password) === true) {
            (new Session)->set('is_authenticated', true);
            $this->user = (new Db)->table('users')->select('id, email')->first();
            return true;
        }

        return false;
    }

    /**
     * Hash password
     * 
     * @param string $password
     * @return string
     */
    public function hashPassword($password)
    {
        return password_hash($password, $this->algo, $this->options);
    }

    /**
     * Process Logout
     * 
     * @return void
     */
    public function logOut($redirect_to = null)
    {
        (new Session)->set('is_authenticated', false);

        $this->user = null;
        
        if($redirect_to !== null){
            (new Response)->redirect($redirect_to);
        }
    }

    /**
     * Check if user is authenticated
     * 
     * @return boolean
     */
    public function isAuthenticated()
    {
        if ((new Session)->has('is_authenticated')) {
            $auth_session = (new Session)->get('is_authenticated');
            if ($auth_session === true) {
                return true;
            }
        }
        return false;
    }

}
