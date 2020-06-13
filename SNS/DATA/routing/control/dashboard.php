<?php
namespace DATA\routing\control;
use DATA\routing\control\controller;
use DATA\BASE\bdd;
use DATA\BASE\models\gateway\accountGW;
use DATA\BASE\models\gateway\tweetGW;
class dashboard extends controller {
	/*Controleur de la page principale (dashboard)
	*/
    public function __construct($app)
    {
        parent::__construct($app);
    }
    public function dashboardHandler() { 
		/*DashboardHandler affiche la page suite à une requête GET, il n'y a donc aucune donnée à traiter de l'utilisateur.
		Si l'utilisateur n'est pas authentifié, la page de login est affichée. */
		if(isset($_SESSION["compte"]))
		{
			$tweets = $this->app->getService("TWEET")->premiersTweetsParNom(0, $_SESSION["compte"]->getNickname(), $_SESSION["compte"]->getId());
			$this->render("light/index", ["compte" => $_SESSION["compte"], "tweets" => $tweets, "pagecount" => $this->app->getService("TWEET")->pageCount($_SESSION["compte"]->getNickname())]);
		}
		else
		{
			$this->render("light/login");
		}
	
    }
	public function postdashboardHandler() { 
		/*Vérification de l'authentification de l'user, puis traitement des données entrantes.
		*/
        if(isset($_SESSION["compte"]))
        {
			if(isset($_POST["retweet"]))
          	      {
        	  	      $this->app->getService("TWEET")->toggleRetweet($_POST["retweet"], $_SESSION["compte"]->getId());
          	      }
		else if(isset($_POST["like"]))
		{	$this->app->getService("TWEET")->toggleLike($_POST["like"], $_SESSION["compte"]->getId());
		}
		else if(isset($_POST["tweet"]))
			{	if(strlen($_POST["tweet"]) <= 140)
				$this->app->getService("TWEET")->sendTweet(new tweetGW(htmlspecialchars($_POST["tweet"]), 0, $_SESSION["compte"]->getNickname(), time(), "FALSE", 0));
			}
        	$tweets = $this->app->getService("TWEET")->premiersTweetsParNom(0, $_SESSION["compte"]->getNickname(), $_SESSION["compte"]->getId());
        	$this->render("light/index", ["compte" => $_SESSION["compte"], "tweets" => $tweets, "pagecount" => $this->app->getService("TWEET")->pageCount($_SESSION["compte"]->getNickname())]);
        }
        else
        {
			if(isset($_POST["Adresse_connexion"]) AND isset($_POST["Password_connexion"]))
			{	
				if(strlen($_POST["Adresse_connexion"]) <= 150 AND strlen($_POST["Password_connexion"]) <= 150)
				{
 		       		$account = $this->app->getService("ACCOUNT")->authentication($_POST["Adresse_connexion"], $_POST["Password_connexion"]);
                        		if($account !== false)
                        		{
						$_SESSION["compte"] = $account;
						$this->dashboardHandler();
					}
					else
					{
						$this->render("echec_connexion");
					}
				}
				else
                                {
                                        $this->render("echec_connexion");
                                }
			}
			else
                        {
                                $this->render("echec_connexion");
                        }
        }
	}
    
}


