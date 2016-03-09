<?php

//classes
require_once 'classes/class.MainManager.php';
require_once 'classes/class.Page.php';
require_once 'classes/class.LoginPage.php';
require_once 'classes/class.ReviewsPage.php';
require_once 'classes/class.Entry.php';
require_once 'classes/class.SessionManager.php';
require_once 'classes/class.UserInputValidator.php';
require_once 'classes/abstract.DBManager.php';
require_once 'classes/class.MySQLManager.php';
require_once 'classes/class.AuthenticationManager.php';
require_once 'classes/class.ReviewManager.php';

//exceptions
require_once 'classes/exception.MySQLException.php';

//libraries
require_once 'library/recaptchalib.php';

//configuration file
require_once 'config.php';

if(isset($_GET['page']))
{
    $page = $_GET['page'];
}
 else
{
    $page = 'home_page';
}

$MM = new MainManager();
$MM->setStatus($page);
$MM->manageStatus();
$MM->displayPage();
     
?>