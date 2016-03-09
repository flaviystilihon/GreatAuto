<?php

class MySQLManager extends DBManager
{        
    public function __construct()
    {
        
    }
    
    public function connectToDB()
    {
        $this->DBconnection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    }
    
    public function closeDBConnection ()
    {
        $this->DBconnection->close();
    }
        
    public function addUser($userName, $userPassword, $userEmail)
    {
        $statement = $this->DBconnection->prepare('INSERT INTO '.DB_USERSTABLE.' (username, password, useremail) VALUES (?,?,? )');
        if($statement == FALSE)
            throw new MySQLException();
        $statement->bind_param('sss', $userName, $userPassword, $userEmail);
        $statement->execute();
        $statement->close();
    }
    
    public function checkUserNameUnique($userName)
    {
        $statement = $this->DBconnection->prepare('SELECT username FROM '.DB_USERSTABLE.' WHERE username = ?');
        if($statement == FALSE)
            throw new MySQLException();
        $statement->bind_param('s', $userName);
        $statement->execute();
        $check = $statement->fetch();
        $statement->close();
        
        if($check == 1)
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    
    public function checkEmailUnique($userEmail)
    {
        $statement = $this->DBconnection->prepare('SELECT useremail FROM '.DB_USERSTABLE.' WHERE useremail = ?');
        if($statement == FALSE)
            throw new MySQLException();
        $statement->bind_param('s', $userEmail);
        $statement->execute();
        $check = $statement->fetch();
        $statement->close();
        
        if($check == 1)
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    
    public function checkUser($userName, $userPassword)
    {        
        $statement = $this->DBconnection->prepare('SELECT * FROM '.DB_USERSTABLE.' WHERE username = ? AND password = ?');
        if($statement == FALSE)
            throw new MySQLException();
        $statement->bind_param('ss', $userName, $userPassword);
        $statement->execute();
        
        $check = $statement->fetch();
        $statement->close();
        
        if($check == 1)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    public function getUserId($userName)
    {
        $statement = $this->DBconnection->prepare('SELECT userid FROM '.DB_USERSTABLE.' WHERE username = ?');
        if($statement == FALSE)
            throw new MySQLException();
        $statement->bind_param('s', $userName);
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        
        $result->data_seek(0);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        return $row['userid'];
    }
        
    public function getReviews()
    {
        $statement = $this->DBconnection->prepare('SELECT username, content, date FROM '.DB_REVIEWSTABLE.', '.DB_USERSTABLE.' WHERE '.DB_USERSTABLE.'.userid='.DB_REVIEWSTABLE.'.user_id ORDER BY date');
        if($statement == FALSE)
            throw new MySQLException();
        $statement->execute();
        $result = $statement->get_result();
        $statement->close();
        return $result;
    }
    
    public function addReview($userName, $content)
    {        
        $userId = $this->getUserId($userName);
        $date = time();
        
        $statement = $this->DBconnection->prepare('INSERT INTO '.DB_REVIEWSTABLE.' (user_id, content, date) VALUES (?, ?, ?)');
        if($statement == FALSE)
            throw new MySQLException();
        $statement->bind_param('sss', $userId, $content, $date);
        $statement->execute();
        $statement->close();
    }
}