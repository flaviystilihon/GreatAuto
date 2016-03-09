<?php

class UserInputValidator
{
    public function __construct()
    {
    }
    
    public function isNameAllowable($string)
    {
        if ($string == "")
            return FALSE;
        else if (strlen($string) < 5)
            return FALSE;
        else if (strlen($string) > 30)
            return FALSE;
        else if (preg_match("/[^a-zA-Z0-9_-]/", $string))
            return FALSE;
        else
            return TRUE;
    }
    
    public function isPasswordAllowable($string)
    {
        if ($string == "")
            return FALSE;
        else if (strlen($string) < 6)
            return FALSE;
        else if (strlen($string) > 20)
            return FALSE;
        else if (!preg_match("/[a-z]/", $string) ||
                !preg_match("/[A-Z]/", $string) ||
                !preg_match("/[0-9]/", $string))
            return FALSE;
        else
            return TRUE;
    }
    
    public function isEmailAllowable($string)
    {
        if ($string == "")
            return FALSE;
        else if (strlen($string) > 30)
            return FALSE;
        else if (!((strpos($string, ".") > 0) &&
                (strpos($string, "@") > 0)) ||
                preg_match("/[^a-zA-Z0-9.@_-]/", $string))
            return FALSE;
        else
            return TRUE;
    }
    
    public function isCaptchaAllowable()
    {
        $secret = SECRETKEY;
        $response = null;
        $reCaptcha = new ReCaptcha($secret);
        
        if ($_POST["g-recaptcha-response"])
        {
            $response = $reCaptcha->verifyResponse($_SERVER["REMOTE_ADDR"], $_POST["g-recaptcha-response"]);
            if ($response != null && $response->success)
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }
        else
        {
            return FALSE;
        }
    }
    
    public function isReviewAllowable($string)
    {
        if ($string == "")
            return FALSE;
        else if (strlen($string) > 500)
            return FALSE;
        else
            return TRUE;
    }

    public function cryptUserPassword($string)
    {
        $string = md5(SALTLEFT.$string.SALTRIGHT);
        return $string;
    }
    
    public function sanitizeReview($string)
    {
        return $this->sanitizeForSQL($this->sanitizeForHTML($string));
    }
    
    public function sanitizeForHTML($string)
    {
        $string = stripslashes($string);
        $string = strip_tags($string);
        $string = htmlentities($string);
        return $string;
    }
    
    public function sanitizeForSQL($string)
    {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $mysqli->real_escape_string($string);
        $mysqli->close();
        return $string;
    }
    
}