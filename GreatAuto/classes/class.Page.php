<?php

class Page
{    
    protected $readyPage;
    protected $htmlFile;
    protected $SM;
    
    public function __construct($htmlFile, SessionManager $SM)
    {
        $this->readyPage  = "";
        $this->SM = $SM;
        
        $this->setHTMLFile($htmlFile);
        $this->buildPage();
    }
    
    private function setHTMLFile($htmlFile)
    {
        $this->htmlFile = $htmlFile;
    }

    private function buildPage()
    {
        $this->readyPage = file_get_contents($this->htmlFile);
        
        if($this->checkIsLogined())
        {
            $this->changeWelcomeMessage("Welcome, ". $this->SM->getValue('session_username'));
            $this->setLogOutButton(LOGOUTBUTTON);
        }
        else
        {
            $this->setLogInButton(LOGINBUTTON);
        }
    }

    public function showContent()
    {
        echo ($this->readyPage);
    }
    
    public function changeWelcomeMessage($content)
    {
        $this->readyPage = str_replace('Login or registrate to enter', $content, $this->readyPage);
    }
    
    public function setLogInButton($loginButtonHTML)
    {
        $loginButton = file_get_contents($loginButtonHTML);
        $this->readyPage = str_replace('AUTHENTICATIONBUTTON', $loginButton, $this->readyPage);
    }
    
    public function setLogOutButton($logoutButtonHTML)
    {
        $logoutButton = file_get_contents($logoutButtonHTML);
        $this->readyPage = str_replace('AUTHENTICATIONBUTTON', $logoutButton, $this->readyPage);
    }
    
    public function checkIsLogined()
    {
        return $this->SM->checkValue('session_username');
    }
}
