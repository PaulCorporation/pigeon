<?php
namespace DATA\routing;
use DATA\routing\route;
use DATA\services\serviceContainer;
use Error;
/*app.php contient l'application, c'est l'épine dorsale du site web.
La classe app fonctionne étroitement avec le routeur, contient le service container, et gère l'affichage de la page 404*/
function read($name)
{
	include $name;
}

class app
{
	const GET = "GET";
	const POST = "POST";
	const PUT = "PUT";
	const DELETE = "DELETE";
	private $serviceContainer;
	private $routes = array();
	private $statuscode;
	public function __construct($container)
        {
			/*Le constructeur prend en paramètre le service container. */
        	$this->serviceContainer = $container;

        }
	public function set($name, $serv)
	{
		/*Permet d'ajouter un service, il s'agit en réalité d'une deuxième couche d'interface du service container.*/
		$this->serviceContainer->set($name, $serv);
	}
	public function getService($name)
	{
		/*Permet de récupérer un service, il s'agit en réalité d'une deuxième couche d'interface du service container. */
		return $this->serviceContainer->get($name);
	}
	public function run()
	{
		/*Permet de démarrer app, en analysant la requête gr$ace à l'énumration, et en récupérant les paramètres de l'uri en fonction du chemin défini par le routeur.
		Sinon retourne une page 404.*/
		$method = $_SERVER["REQUEST_METHOD"] ?? self::GET;
		$uri = $_SERVER["REQUEST_URI"] ?? "/";
			foreach($this->routes as $route)
			{
				if($route->match($method, $uri))
				{
					return $this->process($route);
				}
			}
		read("../SITE/pages/light/404.php");
		throw new Error("No route available.");
	}
	private function process (route $route)
	{
		/*Cette méthode process permet de récupérer les paramètres d'une route en foncton de son uri */
		try
		{
			http_response_code($this->statuscode);
			echo call_user_func($route->getCallable(), $route->getArguments());
		}
		catch (HttpException $e)
		{
			throw $e;
		}
		catch(\Exception $e)
		{
			throw new Error ("No route available.");
		}
	}
	public function get($pattern, $callable)
	{
		/*Cette méthode get permet de définir une route avec une méthode get 
		registerRoute est appelée avec l'énumération correspondante.*/
		$this->registerRoute(self::GET, $pattern, $callable);
		return $this;
	}
	public function post($pattern, $callable)
    {
		/*Cette méthode get permet de définir une route avec une méthode get 
		registerRoute est appelée avec l'énumération correspondante.*/
        $this->registerRoute(self::POST, $pattern, $callable);
        return $this;
    }
	private function registerRoute($method, $pattern, $callable)
	{
		/*Cette méthode permet de définir une route*/
		$this->routes[] = new route($method, $pattern, $callable);
	}

}

?>
