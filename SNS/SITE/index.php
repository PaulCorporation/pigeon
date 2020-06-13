<?php
use DATA\autoloader;
require_once "/SNS/DATA/autoloader.php";
autoloader::register();
$app = require_once "../DATA/bootstrap.php";
/*Le script index permet l'initialisation de l'autoloader, et le lancement de boostrap.php (et donc de l'app et du routing)*/
?>
