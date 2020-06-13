<?php
namespace DATA\services;
class serviceContainer
{
	/*service container.
	Cette classe permet de stocker l'ensemble des services en offrant une interface permettant de les paramètrer et récupérer.
	Cette interface est utilisée par l'application et réimplémentée pour interfacer directement depuis l'app.*/
private $container = array();
	public function get($serviceName) // Récupère un service "$serviceName"
	{
		return $this->container[$serviceName];
	}
	public function set($name, $assigned) // Stocke un service "$name"
	{
	$this->container[$name] = $assigned;

	}
	public function unset ($name)
	{
		unset($this->container[$name]); //Retire le service "$name"
	}


}
?>
