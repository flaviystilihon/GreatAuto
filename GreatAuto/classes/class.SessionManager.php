<?php

class SessionManager
{
    public function __construct()
    {    
        $this->startSession();
    }
    
    public function startSession()
    {
        session_start();
    }
    
    public function setValue($name, $content)
    {
        $_SESSION["$name"] = $content;
    }
    
    public function unsetValue($name)
    {
        unset($_SESSION["$name"]);
    }
    
    public function getValue($name)
    {
        return $_SESSION["$name"];
    }
    
    public function checkValue($name)
    {
        return (isset($_SESSION["$name"]));
    }
    
    public function closeSession()
    {
        session_write_close();
    }
}