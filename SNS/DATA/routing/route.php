<?php
namespace DATA\routing;
class route
{
	/*Route est une matérialisation asbtraite d'une route.
	On y retrouve toutes les données membres nécessaires à son traitement.
	La classe test également équipée des getters et setters nécessaires à son bon paramétrage. */
	private $method;
	private $pattern;
	private $callable;
	private $arguments;

	public function __construct ($method, $pattern, $callable)
	{
		/*Le constructeur permet de configurer toutes les données nécessaires au bon fonctionnement de la route.*/
		$this->method = $method;
		$this->pattern = $pattern;
		$this->callable = $callable;
		$this->arguments = array();
	}

	public function match ($method, $uri)
	{
		/*La méthode match permet d'appliquer une expression régulière sur la route
		pour en extraire ses arguments et les ajouter au tableau $this->arguments */
		if($this->method != $method)
			{return false;}
		if(preg_match($this->compilePattern(), $uri, $this->arguments))
		{
	
			array_shift($this->arguments);
			return true;}
		return false;
		
	}
	public function getArguments()
	{
	return $this->arguments;
	}
	public function getPattern()
        {
        return $this->pattern;
        }
	public function getMethod()
        {
        return $this->method;
        }
	public function getCallable()
        {
        return $this->callable;
        }
	private function compilePattern(){
		/*compilePattern génére une expression régulière pour preg_match.*/
	return sprintf ('#^%s$#', $this->pattern);

	}
}
?>
