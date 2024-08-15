<?php

use Core\Session;

if (!function_exists('base_url')) {
    /**
     * get base url
     * 
     * @param mixed $uri
     * @return string
     */
    function base_url($uri='') {    
        return BASE_URL . $uri;
    }
}
    

if (!function_exists('redirect')) {
    /**
     * redirect to url
     * 
     * @param mixed $url
     * @param array-key $data
     * @param int $statusCode
     * @return never
     */
    function redirect($url, Array $data=[], $statusCode = 200) {
        $session = new Session();
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $session->set($key, $value);
            }
        }
        http_response_code($statusCode);    
        header('Location: ' . filter_var($url, FILTER_SANITIZE_URL));
        exit;
    }
}

