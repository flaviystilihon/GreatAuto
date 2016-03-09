<?php

class MainManager
{
    protected $status;
    protected $currentPage;

    protected $DBM;
    protected $SM;
    protected $UIV;
    protected $AM;
    protected $RM;

    public function __construct()
    {
        $this->setStatus('home_page');
        $this->SM = new SessionManager();
        $this->UIV = new UserInputValidator();
        $this->DBM = new MySQLManager();

        $this->AM = new AuthenticationManager($this->UIV, $this->DBM, $this->SM);
        $this->RM = new ReviewManager($this->UIV, $this->DBM, $this->SM);
        $this->currentPage = '';
    }

    public function setStatus($statusToSet)
    {
        $this->status = $statusToSet;
    }
    
    public function manageStatus()
    {
        try
        {
            switch ($this->status)
            {
                case "home_page":
                    $this->createPage(HOMEPAGE);
                    break;
                case "about_us_page":
                    $this->createPage(ABOUTUSPAGE);
                    break;
                case "contacts_page":
                    $this->createPage(CONTACTSPAGE);
                    break;
                case "reviews_page":
                    $this->createReviewsPage();
                    break;
                case "leave_review":
                    $this->RM->leaveReview();
                    $this->createReviewsPage();
                    break;
                case "login_page":
                    $this->createLoginPage();
                    break;
                case "registrating":
                    if($this->AM->registrateUser()) //registrateUser return TRUE if registration was passed succesfully
                    {
                        $this->createPage(HOMEPAGE);
                    }
                    else
                    {
                        $this->createLoginPage();
                    }
                    break;
                case "logining":
                    if($this->AM->logInUser()) //logInUser return TRUE if logining was passed succesfully
                    {
                        $this->createPage(HOMEPAGE);
                    }
                    else
                    {
                        $this->createLoginPage();
                    }
                    break;
                case "logining_out":
                    $this->AM->logOutUser();
                    $this->createPage(HOMEPAGE);
                    break;

                default :
                    $this->createPage(ERRORPAGE);
                    break;
            }
        }
        catch (MySQLException $ex)
        {
            $this->createPage(ERRORPAGE);
        }
        $this->SM->closeSession();
        $this->DBM->closeDBConnection();
    }
//    
//    public function manageStatus()
//    {      
//        try
//        {
//            switch ($this->status)
//            {
//                case "home_page":
//                    $this->createPage(HOMEPAGE);
//                    break;
//                case "about_us_page":
//                    $this->createPage(ABOUTUSPAGE);
//                    break;
//                case "contacts_page":
//                    $this->createPage(CONTACTSPAGE);
//                    break;
//                case "reviews_page":
//                    $this->createReviewsPage();
//                    break;
//                case "leave_review":
//                    $this->RM->leaveReview();
//                    $this->createReviewsPage();
//                    break;
//                case "login_page":
//                    $this->createLoginPage();
//                    break;
//                case "registrating":
//                    if($this->AM->registrateUser()) //registrateUser return TRUE if registration was passed succesfully
//                    {
//                        $this->createPage(HOMEPAGE);
//                    }
//                    else
//                    {
//                        $this->createLoginPage();
//                    }
//                    break;
//                case "logining":
//                    if($this->AM->logInUser()) //logInUser return TRUE if logining was passed succesfully
//                    {
//                        $this->createPage(HOMEPAGE);
//                    }
//                    else
//                    {
//                        $this->createLoginPage();
//                    }
//                    break;
//                case "logining_out":
//                    $this->AM->logOutUser();
//                    $this->createPage(HOMEPAGE);
//                    break;
//
//                default :
//                    createPage(ERRORPAGE);
//                    break;
//            }
//        }
//        catch (MySQLException $ex)
//        {
//            $this->createPage(ERRORPAGE);
//        }
//        finally
//        {
//            $this->SM->closeSession();
//            $this->DBM->closeDBConnection();
//        }
//    }
    
    public function createPage($htmlFile)
    {
        $this->currentPage = new Page($htmlFile, $this->SM);
    }
    
    public function createReviewsPage()
    {
        $this->currentPage = new ReviewsPage(REVIEWSPAGE, $this->SM, $this->RM);
    }
       
    public function createLoginPage()
    {
        $this->currentPage = new LoginPage(LOGINPAGE, $this->SM, $this->AM);
    }
        
    public function displayPage()
    {
        $this->currentPage->showContent();
    }
}
?>