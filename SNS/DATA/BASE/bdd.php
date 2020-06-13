<?php
namespace DATA\BASE;
use DATA\BASE\compte;
use DATA\BASE\tweet;
use PDO;
class bdd
{
	/*Classe BDD
	La classe BDD permet de se connecter à la base et d'en récupérer une référence pour l'appeler depuis n'importe où dans le code
	Comme un service.*/
	private $dbh;
	public function __construct()
	{
	if(!$this->connect())
	{
	//ERREUR DATABASE
	}
	}
	public function connect()
	{ /*Connexion à la base de donnée.*/
	$host = "*****";
        $name = "*****";
        $user = "*****";
        $pass = "******";

        try
        {
        $this->dbh = new PDO ("mysql:host:=$host; dbname=$name", $user, $pass);
        }
        catch(PDOException $e)
        {
	return false;
        die();
        }
	return true;
	}
	public function get()
	{/*La fonction get permet de retourner l'objet PDO pour utiliser les fonctions PDO ailleurs dans le code.*/
	return $this->dbh;
	}
} 
?>
