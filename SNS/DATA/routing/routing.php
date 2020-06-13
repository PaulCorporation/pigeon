<?php
namespace DATA\routing;
use DATA\routing\app;
use DATA\BASE\bdd;
use DATA\routing\control\controller;
use DATA\routing\control\dashboard;
use DATA\routing\control\newAccount;
use DATA\routing\control\profil;
use DATA\routing\control\recovery;
use DATA\routing\control\members_page;
use DATA\routing\control\account_page;
use DATA\routing\control\timeline;


class routing
{
	/*Classe implémentant le routing, cette classe permet de définir chaque route ainsi que sa natue
	Elle est construite à partir de l'app, pour pouvoir la renvoyer aux différents controleurs pour chaque page */
	private $app;

	public function __construct(app $app)
	{
	$this->app = $app;
	}
	public function setup()
	{
	$this->app->get("/", function(){
		session_start();
		$d = new dashboard($this->app);
		$d->dashboardHandler();
	});
	$this->app->post("/", function(){
		session_start();
                        $d = new dashboard($this->app);
                        $d->postdashboardHandler();
        });
	$this->app->post("/signup", function(){
		$n = new newAccount($this->app);
		$n->postPageHandler();
        });
	$this->app->get("/signup", function(){
                $n = new newAccount($this->app);
                $n->pageHandler();
        });
	$this->app->get("/profil/([a-zA-Z0-9_]+)/([0-9]+)", function($arg){
		session_start();
		$p = new profil ($this->app);
		$p->profilHandler($arg);
	});
	$this->app->post("/profil/([a-zA-Z0-9_]+)/([0-9]+)", function($arg){
                session_start();
                $p = new profil ($this->app);
                $p->postProfilHandler($arg);
        });
	$this->app->get("/recovery", function(){
                $p = new recovery ($this->app);
                $p->recoveryHandler();
        });
	$this->app->post("/recovery", function(){
                $p = new recovery ($this->app);
                $p->postRecoveryHandler();
        });
	$this->app->get("/members/([0-9]+)", function($arg){
		session_start();
                $p = new  members_page($this->app);
                $p->members_pageHandler($arg);
        });
	$this->app->get("/account", function(){
		session_start();
                $p = new  account_page($this->app);
                $p->account_pageHandler();
        });
	$this->app->post("/account", function(){
		session_start();
                $p = new account_page ($this->app);
                $p->postAccount_pageHandler();
        });
	$this->app->get("/timeline/([0-9]+)", function($arg){
                session_start();
                $p = new  timeline($this->app);
                $p->timelineHandler($arg);
        });
	$this->app->post("/timeline/([0-9]+)", function($arg){
                session_start();
                $p = new  timeline($this->app);
                $p->postTimelineHandler($arg);
        });
	}


}

?>
