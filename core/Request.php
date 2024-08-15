<?php 

namespace Core;

class Request 
{
    public function all()
    {
        return array_merge($_GET, $_POST);
    }

    public function get($key, $default = null) 
    {
        return filter_var($_GET[$key], FILTER_UNSAFE_RAW) ?? $default;
    }

    public function post($key, $default = null) 
    {
        return $_POST[$key] ?? $default;
    }
}