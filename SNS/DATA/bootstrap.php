<?php
use DATA\routing\routing;
use DATA\routing\app;
use DATA\services\serviceContainer;
use DATA\BASE\bdd;
use DATA\BASE\models\accountFinder;
use DATA\BASE\models\tweetFinder;
/*Bootstrap.php 
Ce fichier permet d'intialiser les différents services, et les ajouter à l'application grâce à la méthode set.
L'initialisation des services est ainsi centralisée au même endroit.
Le fichier bootstrap permet également d'initialiser le routeur.*/ 
$services = new serviceContainer();
$services->set("DB", new bdd());
$app = new app($services);
$app->set("ACCOUNT", new accountFinder($app));
$app->set("TWEET", new tweetFinder($app));
$routing = new routing($app);
$routing->setup();
$app->run();
return $app;
?>
