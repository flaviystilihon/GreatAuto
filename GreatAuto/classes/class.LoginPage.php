<?php

class LoginPage extends Page
{
    private $AM;
    
    public function __construct($htmlFile, SessionManager $SM, AuthenticationManager $AM)
    {
        parent::__construct($htmlFile, $SM);
        $this->AM = $AM;
        $this->adjustLoginErrorMessage();
    }
    
    public function adjustLoginErrorMessage()
    {
        switch ($this->AM->getError())
        {
            case 'username_is_incorrect':
                $this->setErrorMessage("Entered name is invalid");
                break;
            case 'password_is_incorrect':
                $this->setErrorMessage("Entered password is invalid");
                break;
            case 'repeat_password_error':
                $this->setErrorMessage("Entered passwords don't match");
                break;
            case 'email_is_incorrect':
                $this->setErrorMessage("Entered email is invalid");
                break;
            case 'user_not_found':
                $this->setErrorMessage("User with entered username and password is not found");
                break;
            case 'captcha_error':
                $this->setErrorMessage("Captcha error occured");
                break;
            case 'name_is_occupied':
                $this->setErrorMessage("Chosen name is already occupied");
                break;
            case 'email_is_occupied':
                $this->setErrorMessage("Chosen email is already registered");
                break;
            default :
                break;
        }
    }
    
    public function setErrorMessage($message)
    {
        $loginError = file_get_contents(LOGINERROR);
        $loginError = str_replace('<!--MESSAGE-->', $message, $loginError);
        $this->readyPage = str_replace('<!--ERRORMESSAGE-->', $loginError, $this->readyPage);
    }
    
}