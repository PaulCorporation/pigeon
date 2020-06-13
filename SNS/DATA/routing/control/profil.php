<?php
namespace DATA\routing\control;
use DATA\routing\control\controller;
use DATA\BASE\bdd;
use DATA\BASE\models\gateway\accountGW;
use DATA\BASE\models\gateway\tweetGW;
class profil extends controller {
    /*Controlleur pour la page de profil */
    public function __construct($app)
    {
        parent::__construct($app);
    }
    public function profilHandler($arg) { 
        /*Récupération des tweets par le service tweetfinder */

        if(isset($_SESSION["compte"]))
        {
            $tweets = $this->app->getService("TWEET")->premiersTweetsParNom($arg[1]*10, $arg[0], $_SESSION["compte"]->getId());
            $this->render("light/profil", ["compte" => $_SESSION["compte"], "tweets" => $tweets, "name" => $arg[0], "page" => $arg[1], "pagecount" => $this->app->getService("TWEET")->pageCount($arg[0]),"page" => $arg[1] , "total" => $this->app->getService("TWEET")->totalTweets($arg[0]), "FOLLOW" => $this->app->getService("ACCOUNT")->isFollowed($arg[0],$_SESSION["compte"]->getId())]);
        }
        else
        {
            $this->render("light/login");
        }

    }
   public function postProfilHandler($arg)
	{
        /*Traitement de la fonctionnalité de retweet, de like et de follow. */
	    if(isset($_SESSION["compte"]))
	    {
	        if(isset($_POST["retweet"]))
		        {
		            $this->app->getService("TWEET")->toggleRetweet($_POST["retweet"], $_SESSION["compte"]->getId());
		        }
	        else if(isset($_POST["like"]))
                    {$this->app->getService("TWEET")->toggleLike($_POST["like"], $_SESSION["compte"]->getId());
                    }
	        else if(isset($_POST["follow"]))
		        {$this->app->getService("ACCOUNT")->toggleFollow($arg[0], $_SESSION["compte"]->getId());
		        }
	        $this->profilHandler($arg);
	    }
	}
}
?>
