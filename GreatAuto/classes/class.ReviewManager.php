<?php
/**
 * Description of class
 *
 * @author Vova
 */
class ReviewManager 
{
    private $UIV;
    private $DBM;
    private $SM;
    
    private $error;


    public function __construct(UserInputValidator $UIV, DBManager $DBM, SessionManager $SM)
    {
        $this->UIV = $UIV;
        $this->DBM = $DBM;
        $this->DBM->connectToDB();
        $this->SM  = $SM;
    }


    public function fetchReviews()
    {
        return ($this->DBM->getReviews());
    }
    
    public function leaveReview()
    {
        if($this->checkDataForReview())
        {
            $this->DBM->addReview($this->SM->getValue('session_username'), $this->UIV->sanitizeReview($_POST['form_entry']));
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function checkDataForReview()
    {
        if($this->UIV->isReviewAllowable($_POST['form_entry']) === FALSE)
        {
            $this->setError('review_is_incorrect');
            return FALSE;
        }
        elseif ($this->SM->checkValue('session_username') === FALSE) //theoretically this error never occurs
        {
            $this->setError('user_is_not_logined');
            return FALSE;
        }
        elseif ($this->UIV->isCaptchaAllowable() === FALSE)
        {
            $this->setError('captcha_error');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    
    public function getError()
    {
        return $this->error;
    }
    
    public function setError($error)
    {
        $this->error = $error;
    }
}
