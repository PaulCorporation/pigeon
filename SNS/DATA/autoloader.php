<?php 

namespace DATA;
class autoloader
{
	/*La classe autoloader permet de charger des fichiers php automatiquement
	en réimplémentant la fonction __autoload par la fonction autoload de la classe.
	php se sert de __autoload en lui envoyant le namespace et le nom de la classe en paramètre afin de retrouver le fichier
	à inclure.*/
	public static function register()
	{
		spl_autoload_register(array(__CLASS__, 'autoload'));
	//réimplémentation de __autoload
	}
	public static function autoload(string $class)
	{
	/*La fonction autoload va partir de la racine et suivre le chemin décrit par le namespace pour parvenir jusqu'au fichier
	qui possède le même nom que la classe.*/ 
	$namespace = explode('\\', $class);
	//$namespace = array_map('strtolower', $namespace);
	$i = count($namespace) - 1;
	//$namespace[$i] = ucfirst($namespace[$i]);
	$class = implode('/', $namespace);
	require_once '/SNS/' . $class . '.php';

	}


}
?>
