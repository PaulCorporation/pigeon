<?php
namespace DATA\BASE\models\gateway;
class tweetGW
{
        /*Cette classe est la gateway pour les tweets.
        La classe est équipée de getters et de setters 
        Elle permet de charger et d'enregistrer un tweet depuis la base de données, et de manipuler les données indépendamment.*/

	private $data;
        private $id;
        private $timestamp;
        private $nomuser;
	private $liked;
	private $likeCount;
        public function loadFromId($id, $bdd) // Charge un tweet par son ID.
        {
        $str = "SELECT twt.id, twt.data, twt.timestamp, name from user, (SELECT * FROM tweet WHERE ( id = :id)) as twt WHERE twt.iduser = user.id;";
        $query = $bdd->get()->prepare($str);
        $query->execute([":id" => $id]);
        $tab = $query->fetch();
        $this->data=  $tab["data"];
        $this->timestamp = $tab["timestamp"];
        $this->id = $tab["id"];
        $this->nomuser = $tab["admin"];
        }
	public function save($bdd) // Enregistre le tweet en base de donnée.
	{
	$str = "SELECT id from user WHERE name = :name;";
	$query = $bdd->get()->prepare($str);
	$query->execute([":name" => $this->nomUser]);
	$iduser = $query->fetch()["id"];
	$str = "INSERT INTO tweet (data, iduser, timestamp) VALUES (:data, :iduser, :timestamp);";
        $query = $bdd->get()->prepare($str);
        $query->execute([":data" => $this->data, ":iduser" => $iduser, ":timestamp" => $this->timestamp]);
	}
	public function __construct ($data, $id, $nomUser, $timestamp, $liked, $likeCount)
        {
        $this->data = $data;
        $this->id = $id;
        $this->nomUser = $nomUser;
        $this->timestamp = $timestamp;
	$this->liked = $liked;
	$this->likeCount = $likeCount;
        }
        public function getData()
        {
        return $this->data;
        }
	public function setData($data)
	{
	$this->data = $data;
	}
        public function getId()
        {
        return $this->id;
        }
	public function setId($id)
	{
	$this->id = $id;
	}
        public function getTimeStamp()
        {
        return $this->timestamp;
        }
	public function setTimeStamp($ts)
	{
	$this->timestamp = $ts;
	}
        public function getUser()
        {
        return $this->nomUser;
        }
	public function setUser($user)
	{
	$this->nomUser = $user;
	}
	public function setLiked($liked)
	{
	$this->liked = $liked;
	}
	public function getLiked()
	{
	return $this->liked;
	}
	public function setLikeCount($likeCount)
        {
        $this->likeCount = $likeCount;
        }
        public function getLikeCount()
        {
        return $this->likeCount;
        }
}

