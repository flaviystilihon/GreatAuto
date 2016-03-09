<?php

/**
 * Description of class
 *
 * @author Vova
 */
class AuthenticationManager
{
    private $error;
    private $isAuthorized;

    private $UIV;
    private $DBM;
    private $SM;
    
    public function __construct(UserInputValidator $UIV, DBManager $DBM, SessionManager $SM)
    {
        $this->setError('');
        $this->SM  = $SM;
        $this->UIV = $UIV;
        $this->DBM = $DBM;
        $this->DBM->connectToDB();
        
        $this->setLoginStatus(FALSE);
    }
    public function registrateUser()
    {
        if($this->checkDataForRegistration())
        {
            $password = $this->UIV->cryptUserPassword($_POST['form_password']);
            $this->DBM->addUser($_POST['form_username'], $password, $_POST['form_email']);
            $this->SM->setValue('session_username', $_POST['form_username']);
            $this->setLoginStatus(TRUE);
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    public function logInUser()
    {
        if($this->checkDataForLogin())
        {
            $this->SM->setValue('session_username', $_POST['form_username']);
            $this->setLoginStatus(TRUE);
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    public function logOutUser()
    {
        $this->SM->unsetValue('session_username');
        $this->setLoginStatus(FALSE);
    }
    
    public function checkDataForRegistration()
    {
        if ($this->UIV->isNameAllowable($_POST['form_username']) === FALSE)
        {
            $this->setError('username_is_incorrect');
            return FALSE;
        }
        elseif ($this->UIV->isPasswordAllowable($_POST['form_password']) === FALSE)
        {
            $this->setError('password_is_incorrect');
            return FALSE;
        } 
        elseif (($this->UIV->isPasswordAllowable($_POST['form_password_repeat']) === FALSE) OR
                 ($_POST['form_password'] !== $_POST['form_password_repeat']))
        {
            $this->setError('repeat_password_error');
            return FALSE;
        }
        elseif ($this->UIV->isEmailAllowable($_POST['form_email']) === FALSE)
        {
            $this->setError('email_is_incorrect');
            return FALSE;
        }
        elseif ($this->UIV->isCaptchaAllowable() === FALSE)
        {
            $this->setError('captcha_error');
            return FALSE;
        }
        
        //part that uses DB connection to validate data
        elseif (!$this->DBM->checkUserNameUnique($_POST['form_username']))
        {
            $this->setError('name_is_occupied');
            return FALSE;
        }
        elseif (!$this->DBM->checkEmailUnique($_POST['form_email']))
        {
            $this->setError('email_is_occupied');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    
    public function checkDataForLogin()
    {
        if ($this->UIV->isNameAllowable($_POST['form_username']) === FALSE)
        {
            $this->setError('username_is_incorrect');
            return FALSE;
        }
        elseif ($this->UIV->isPasswordAllowable($_POST['form_password']) === FALSE)
        {
            $this->setError('password_is_incorrect');
            return FALSE;
        }
        elseif ($this->UIV->isCaptchaAllowable() === FALSE)
        {
            $this->setError('captcha_error');
            return FALSE;
        }
        
        $password = $this->UIV->cryptUserPassword($_POST['form_password']);
        
        if ($this->DBM->checkUser($_POST['form_username'], $password) === FALSE)
        {
            $this->setError('user_not_found');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    
    public function setError($error)
    {
        $this->error = $error;
    }
    
    public function setLoginStatus($status)
    {
        $this->isAuthorized = $status;
    }
    
    public function getError()
    {
        return $this->error;
    }
    
}
