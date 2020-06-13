<?php
namespace DATA\BASE\models\gateway;
class accountGW
{
	/*Cette classe est la gateway pour les comptes utilisateur.
        La classe est équipée de getters et de setters 
        Elle permet de charger et d'enregistrer un compte depuis la base de données, et de manipuler les données indépendamment.*/
	private $mail;
	private $nickname;
	private $id;
	private $isAdmin;
	private $picture;
	private $hash;
	public function __construct($app)
	{
	}
	public function loadFromId($id, $bdd) // Charge un compte depuis la base à partir de son ID.
	{
	$str = "SELECT * FROM user WHERE ( id = :id)";
        $query = $bdd->get()->prepare($str);
        $query->execute([":id" => $id]);
        $tab = $query->fetch();
        $this->mail=  $tab["address"];
	$this->nickname = $tab["name"];
	$this->id = $tab["id"];
	$this->isAdmin = $tab["admin"];
	$this->hash = $tab["password"];
	}
	public function loadFromMail($mail, $bdd) // Charge un compte depuis la base à partir de son mail.
        {
        $str = "SELECT * FROM user WHERE ( address like :mail)";
        $query = $bdd->get()->prepare($str);
        $query->execute([":mail" => $mail]);
        $tab = $query->fetch();
        $this->mail=  $tab["address"];
        $this->nickname = $tab["name"];
        $this->id = $tab["id"];
        $this->isAdmin = $tab["admin"];
        $this->hash = $tab["password"];
        }
	public function save($bdd) // Entre le compte dans la base
	{
	$str = "INSERT INTO user (address, name, admin, password) VALUES (:address, :name, :admin, :password)";
        $query = $bdd->get()->prepare($str);
        $query->execute([":address" => $this->mail, ":name" => $this->nickname, ":admin" => $this->isAdmin, ":password" => $this->hash]);
	}
	public function update($bdd) // Mets à jour un compte déjà existant dans la base.
	{
	$str = "UPDATE user SET address = :address, name = :name, admin = :admin, password = :password WHERE id = :id";
        $query = $bdd->get()->prepare($str);
        $query->execute([":address" => $this->mail, ":name" => $this->nickname, ":admin" => $this->isAdmin, ":password" => $this->hash, ":id" => $this->id]);
	}
	public function getId()
	{
	return $this->id;
	}
	public function setID($id)
	{
	$this->id = $id;
	}
	public function getMail()
	{
	return $this->mail;
	}
	public function setMail($mail)
        {
        $this->mail = $mail;
        }
	public function getIsAdmin()
	{
	return $this->isAdmin;
	}
	public function setIdAdmin($isAdmin)
        {
        $this->isAdmin = $isAdmin;
        }
	public function getPicture()
	{
	return $this->picture;
	}
	public function setPicture($picture)
        {
        $this->picture = $picture;
        }
	public function getNickname()
	{
	return $this->nickname;
	}
	public function setNickname($nickname)
        {
        $this->nickname = $nickname;
        }
	public function setHash($hash)
	{
	$this->hash = $hash;
	}
	public function getHash()
	{
	return $this->hash;
	}

}


?>
