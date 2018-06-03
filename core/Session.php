<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 http://blog.teamtreehouse.com/how-to-create-bulletproof-sessions
 */

/**
 * Description of Session
 *
 * @author Allan
 */
class Session
{
    

    /** Create flash message
     * 
     * @param string $name
     * @param string $value
     * @return type Description void
     */
    public function flash($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * Display flashed message
     * 
     * @param string $name
     * @return any
     */
    public function reflash($name)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }

        session_unset($_SESSION[$name]);
    }
    
    
    public function has($name)
    {
        if (isset($_SESSION[$name])) {
            return true;
        }

        return false;
    }
    
    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }
    
    public function get($name)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }

        return null;
    }

    /** Create session
     * 
     * @param string $name
     * @param any $value
     * @return void
     */
    public function startSession()
    {

        session_start();
        // Make sure the session hasn't expired, and destroy it if it has
        if ($this->validateSession()) {
            // Check to see if the session is new or a hijacking attempt
            if ($this->preventHijacking()) {
                // Reset session data and regenerate id
                $_SESSION = array();
                $_SESSION['IPaddress'] = $_SERVER['REMOTE_ADDR'];
                $_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
                $this->regenerateSession();

                // Give a 5% chance of the session id changing on any request
            } elseif (rand(1, 100) <= 5) {
                $this->regenerateSession();
            }
        } else {
            $_SESSION = array();
            session_destroy();
            session_start();
        }
    }

    /**
     * Unset session
     * 
     * @param string $name
     * @return void
     */
    public function clear($name)
    {
        if (isset($_SESSION[$name])) {
            session_unset($_SESSION[$name]);
        }
    }

    /**
     * Destroy all sessions
     * 
     * @return void
     */
    public function destroy()
    {
        session_destroy();
    }

    private function preventHijacking()
    {
        if (!isset($_SESSION['IPaddress']) || !isset($_SESSION['userAgent'])) {
            return false;
        }

        if ($_SESSION['IPaddress'] != $_SERVER['REMOTE_ADDR']) {
            return false;
        }

        if ($_SESSION['userAgent'] != $_SERVER['HTTP_USER_AGENT']) {
            return false;
        }

        return true;
    }

    private function regenerateSession()
    {
        // If this session is obsolete it means there already is a new id
        if (isset($_SESSION['OBSOLETE']) || $_SESSION['OBSOLETE'] == true)
            return;

        // Set current session to expire in 10 seconds
        $_SESSION['OBSOLETE'] = true;
        $_SESSION['EXPIRES'] = time() + 3600;

        // Create new session without destroying the old one
        session_regenerate_id(false);

        // Grab current session ID and close both sessions to allow other scripts to use them
        $newSession = session_id();
        session_write_close();

        // Set session ID to the new one, and start it back up again
        session_id($newSession);
        session_start();

        // Now we unset the obsolete and expiration values for the session we want to keep
        unset($_SESSION['OBSOLETE']);
        unset($_SESSION['EXPIRES']);
    }

    static protected function validateSession()
    {
        if (isset($_SESSION['OBSOLETE']) && !isset($_SESSION['EXPIRES'])){
            return false;
        }

        if (isset($_SESSION['EXPIRES']) && $_SESSION['EXPIRES'] < time()){
            return false;
        }

        return true;
    }

}
