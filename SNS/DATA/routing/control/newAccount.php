<?php
namespace DATA\routing\control;
use DATA\routing\control\controller;
use DATA\BASE\bdd;
class newAccount extends controller {
	/*Controlleur de la page de création de compte. */
    public function __construct($app)
    {
        parent::__construct($app);
    }
        public function postPageHandler() { 
		/*Validation des données de formulaire avant traitement.*/
			if(isset($_POST["mail"]) AND isset($_POST["pseudo"]))
			{
				if(strlen($_POST["mail"]) <= 150 AND strlen($_POST["pseudo"]) <= 150)
				{
					if($this->app->getService("ACCOUNT")->register($_POST["mail"], htmlspecialchars($_POST["pseudo"])))
						$this->render("congratulations");
					else
						$this->render("echec_creation");}
					else
                		$this->render("echec_creation");
			}
                else
                {include("echec_creation");}
                

	}

	public function pageHandler() { 
		$this->render("light/account");
	
	}
}
?>
