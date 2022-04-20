<?php 
    public function sec_session_start() {
        $session_name = 'sec_session_id';
        $secure = false; 
        $httponly = true; 
        ini_set('session.use_only_cookies', 1); 
        $cookieParams = session_get_cookie_params(); 
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 
        session_name($session_name); 
        session_start(); 
        session_regenerate_id(); 
    }

    public function sec_session_stop() {
	   $_SESSION = array();
	   $params = session_get_cookie_params();
	   setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
	   session_destroy();
    }