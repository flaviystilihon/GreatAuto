<?php

/**
 * @author Vova
 */
abstract class DBManager 
{
    protected $DBconnection;
    
    abstract public function connectToDB();
    
    abstract public function closeDBConnection();
}
