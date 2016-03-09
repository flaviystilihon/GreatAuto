<?php

class ReviewsPage extends Page
{
    protected $RM;
    protected $entryArray;

    public function __construct($htmlFile, SessionManager $SM, ReviewManager $RM)
    {
        parent::__construct($htmlFile, $SM);
        $this->RM = $RM;
        $this->entryArray = [];
        $this->adjustReviewsList();
        $this->adjustReviewForm();
        $this->adjustReviewErrorMessage();
    }

    protected function buildReviewsArray()
    {
        $result = $this->RM->fetchReviews();
        
        $rows = $result->num_rows;
        for ($j = 0; $j < $rows; ++$j)
        {
            $result->data_seek($j);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            
            $E = new Entry($row['username'], $row['date'], $row['content']);
            $this->entryArray[] = $E->getReadyEntry();
        }
    }
    
    protected function adjustReviewsList()
    {
        $this->buildReviewsArray();
        
        if (!empty($this->entryArray))
        {
            $reviews = implode('', $this->entryArray);
        }
        else
        {
            $reviews = file_get_contents(EMPTYREVIEWS);
        }
        $this->readyPage = str_replace('<!--REVIEWS-->', $reviews, $this->readyPage);
    }
    
    protected function adjustReviewForm()
    {
        if($this->SM->checkValue('session_username'))
        {
            $reviewForm = file_get_contents(REVIEWFORM);
        }
        else
        {
            $reviewForm = file_get_contents(REVIEWFORMALT);
        }
        $this->readyPage = str_replace('<!--REVIEWFORM-->', $reviewForm, $this->readyPage);
    }
    
    public function adjustReviewErrorMessage()
    {
        switch ($this->RM->getError())
        {
            case 'review_is_incorrect':
                $this->setErrorMessage("Entered review is invalid (perhaps, empty or more than 500 signs)");
                break;
            case 'user_is_not_logined':
                $this->setErrorMessage("You must be logined first to leave review");
                break;
            case 'captcha_error':
                $this->setErrorMessage("Captcha error occured");
                break;
            default :
                break;
        }
    }
    
    public function setErrorMessage($message)
    {
        $reviewError = file_get_contents(REVIEWERROR);
        $reviewError = str_replace('<!--MESSAGE-->', $message, $reviewError);
        $this->readyPage = str_replace('<!--ERRORMESSAGE-->', $reviewError, $this->readyPage);
    }
}