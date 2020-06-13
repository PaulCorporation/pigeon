<?php
namespace DATA\routing\control;
use DATA\routing\control\controller;
use DATA\BASE\bdd;
use DATA\BASE\models\gateway\accountGW;
use DATA\BASE\models\gateway\tweetGW;
class account_page extends controller {
    /*Controlleur de la page de paramètrage d'un compte utilisateur. 
    Ce controlleur manage les requêtes POST ou GET.*/
    public function __construct($app)
    {
        parent::__construct($app);
    }
    public function account_pageHandler() { 
        /*Affichage de la page de paramètrage, en envoyant des paramètres utiles au bon affichage. */
	if(isset($_SESSION["compte"]))
        {
	$this->render("light/parametres", [ "nickname" => $_SESSION["compte"]->getNickname(), "mail" => $_SESSION["compte"]->getMail()]);
        }
        else
        {
        $this->render("light/login");
        }
    }

	public function postAccount_pageHandler() { 
        /*Avant de traiter les informations du formulaire, vérification de l'utilisateur, puis traitement des informations.
        Le controleur renvoit l'utilisateur à la page de login s'il n'est plus authentifié.*/
        if(isset($_SESSION["compte"]))
        {
	if(isset($_FILES["image"]))
	{
		$this->app->getService("ACCOUNT")->changeAvatar($_SESSION["compte"]->getNickname());
	}
	if(isset($_POST["email"]))
	{	
		if(strlen($_POST["email"]) <= 150)
		$this->app->getService("ACCOUNT")->changeMail($_POST["email"]);
	}
	if(isset($_POST["mot_de_passe"]))
	{
		if(strlen($_POST["mot_de_passe"]) <= 150)
		$this->app->getService("ACCOUNT")->changePassword($_POST["mot_de_passe"]);
	}
		$this->render("light/parametres", [ "nickname" => $_SESSION["compte"]->getNickname()]);
        }
        else
        {
        $this->render("light/login");
        }
    }
}
?>
