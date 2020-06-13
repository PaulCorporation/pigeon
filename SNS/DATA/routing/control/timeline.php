<?php
namespace DATA\routing\control;
use DATA\routing\control\controller;
use DATA\BASE\bdd;
use DATA\BASE\models\gateway\accountGW;
use DATA\BASE\models\gateway\tweetGW;
class timeline extends controller {
    /*Controlleur de la timeline */
    public function __construct($app)
    {
        parent::__construct($app);
    }
    public function timelineHandler($arg) { 
        /*Récupération des tweets de la timeline par le tweetFinder. */
        if(isset($_SESSION["compte"]))
        {
        $this->render("light/timeline", ["TWEET" => $this->app->getService("TWEET")->getTimeline(intval($arg[0])*10, $_SESSION["compte"]->getId()), "compte" => $_SESSION["compte"], "pagecount"=> $this->app->getService("TWEET")->getTimeLineCount($_SESSION["compte"]->getId()) ,"page" => $arg[0]]);
        }
        else
        {
        $this->render("light/login");
        }

    }
   public function postTimelineHandler($arg)
	{
	    if(isset($_SESSION["compte"]))
	    {
	        if(isset($_POST["retweet"]))
                {
                $this->app->getService("TWEET")->toggleRetweet($_POST["retweet"], $_SESSION["compte"]->getId());
                }
         else if(isset($_POST["like"]))
                {$this->app->getService("TWEET")->toggleLike($_POST["like"], $_SESSION["compte"]->getId());
                }
	}

	$this->timelineHandler($arg);
	}
}
?>
