<?php
namespace DATA\routing\control;
use DATA\routing\control\controller;
use DATA\BASE\bdd;
use DATA\BASE\models\gateway\accountGW;
use DATA\BASE\models\gateway\tweetGW;
class recovery extends controller {
	/*Controleur de la page de récupération de compte. */
	public function __construct($app)
    {
        parent::__construct($app);
    }
	

	public function recoveryHandler()
	{

	$this->render("light/recovery");
	}
	public function postRecoveryHandler()
	{
	/* Redéfinition du mot de passe perdu, et envoi de mail via le accountFinder */
	if(isset($_POST["mail"]))
		{
			if($this->app->getService("ACCOUNT")->mailexist($_POST["mail"]) AND filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL))
			{
				$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
				$mdp = substr(str_shuffle($permitted_chars), 0, 50);
				$this->app->getService("ACCOUNT")->newPass($_POST["mail"], $mdp);
				$compte = new accountGW($this->app);
                                $compte->loadFromMail($_POST["mail"], $this->app->getService("DB"));
                                $compte->setHash(password_hash($mdp, PASSWORD_DEFAULT));
                                $compte->update($this->app->getService("DB"));
			}
		}
	$this->recoveryHandler();

	}
}

?>
