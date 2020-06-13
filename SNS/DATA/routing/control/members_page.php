<?php
namespace DATA\routing\control;
use DATA\routing\control\controller;
use DATA\BASE\bdd;
use DATA\BASE\models\gateway\accountGW;
use DATA\BASE\models\gateway\tweetGW;
class members_page extends controller {
	/*Controller de la page des membres.
	Comme il n'y a aucun formulaire, seul une route GET a été implémentée. */
    public function __construct($app)
    {
        parent::__construct($app);
    }
    public function members_pageHandler($arg) { 
	if(isset($_SESSION["compte"]))
        {
		$this->render("light/membres", ["count" => $this->app->getService("ACCOUNT")->getUsersPageCount(), "users" => $this->app->getService("ACCOUNT")->getUsers($arg[0]), "page" => $arg[0]]);
   	}
	else
	{
		$this->render("light/login");
	}
}
}
?>
