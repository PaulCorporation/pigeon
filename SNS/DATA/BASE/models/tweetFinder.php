<?php
namespace DATA\BASE\models;
use DATA\BASE\models\baseinterface;
use DATA\BASE\models\gateway\tweetGW;
use \PDO;
class tweetFinder implements baseinterface
{
        private $bdd;
        public function __construct($app)
        {
        $this->bdd = $app->getService("DB");
        }

/*	public function findAll()
        {
        $str = "SELECT * FROM tweet WHERE 1";
        $query = $this->bdd->get()->prepare($str);
        $query->execute();
        $tab = $query>fetchAll();
        if(count($tab) == 0)
                                return null;
        else return $tab;
        }
        public function findOneById($id)
        {
        $str = "SELECT * FROM tweet WHERE ( id = :id)";
        $query = $this->bdd->get()->prepare($str);
        $query->execute([":id" => $id]);
        $tab = $query>fetch();
        return $tab;
        }*/
	public function premiersTweetsParNom($nombre, $name, $user)
        {
	$str = "SELECT d.data, d.id, d.timestamp, u.name, IF((SELECT count(*) FROM liked WHERE iduser = :user AND idtweet = d.id)>0,'TRUE','FALSE'), (SELECT count(*) FROM liked WHERE idtweet = d.id) from (SELECT id, data, iduser, timestamp from (SELECT id, data, iduser, timestamp from tweet WHERE id IN (SELECT idtweet FROM retweet WHERE iduser IN (SELECT id FROM user WHERE (name = :name))) OR id IN (SELECT id FROM tweet WHERE iduser IN (SELECT id from user where (name = :name)))) as t ORDER BY timestamp DESC LIMIT 10 OFFSET :nombre ) as d, (SELECT name, id from user) as u  WHERE d.iduser = u.id ORDER BY d.timestamp DESC;";
        $query = $this->bdd->get()->prepare($str);
        $query->bindValue(":nombre", (int) $nombre, PDO::PARAM_INT);
        $query->bindValue(":name", $name); 
	$query->bindValue(":user", $user);
        $query->execute();
        $datas = $query->fetchAll();
        $tweets = array();
        foreach($datas as $data)
        {
        array_push($tweets, new tweetGW($data["data"],$data["id"] ,$data["name"] ,$data["timestamp"], $data["IF((SELECT count(*) FROM liked WHERE iduser = '$user' AND idtweet = d.id)>0,'TRUE','FALSE')"], $data["(SELECT count(*) FROM liked WHERE idtweet = d.id)"]));
        }
        return $tweets;
        }
	public function pageCount($name)
	{
	$str = "SELECT count(*) FROM tweet WHERE iduser IN (SELECT id FROM user WHERE name = :name) OR id IN (SELECT idtweet FROM retweet WHERE iduser IN (SELECT id FROM user WHERE name = :name))";
	$query = $this->bdd->get()->prepare($str);
	$query->bindValue(":name", $name);
	$query->execute();
	return ((int)($query->fetch()["count(*)"] / 10)) +1 ;
	}
	public function totalTweets($name)
	{
	$str = "SELECT count(*) FROM tweet WHERE iduser IN (SELECT id FROM user WHERE name = :name);";
        $query = $this->bdd->get()->prepare($str);
        $query->bindValue(":name", $name);
        $query->execute();
        return ((int)($query->fetch()["count(*)"]));
	}

	public function tweetExist($id)
	{
	$str = "SELECT count(*) FROM tweet WHERE id = :id;";
        $query = $this->bdd->get()->prepare($str);
        $query->bindValue(":id", $id);
        $query->execute();
        return ((int)($query->fetch()["count(*)"])) > 0;
	}
        public function sendTweet($twt)
        {
	$twt->save($this->bdd);
	if($_FILES["image"]["size"] != 0)
         if($_FILES["image"]["size"] < 2000000 AND $_FILES["image"]["type"] == "image/png")
		{
		$str = "SELECT t.id FROM (SELECT id, timestamp FROM tweet WHERE iduser IN (SELECT id FROM user WHERE name = :name)) as t ORDER BY t.timestamp DESC LIMIT 1;";
        	$query = $this->bdd->get()->prepare($str);
       		 $query->bindValue(":name", $twt->getUser());
       		 $query->execute();
		$path = "/SNS/SITE/pages/images/".$query->fetch()["id"].".png";
		move_uploaded_file ($_FILES["image"]["tmp_name"], $path);

		}
        }
	public function isLiked($idtweet, $iduser)
	{
	$str = "SELECT count(*) FROM liked WHERE idtweet = :idtweet AND iduser = :iduser;";
        $query = $this->bdd->get()->prepare($str);
        $query->bindValue(":idtweet", $idtweet);
	$query->bindValue(":iduser", $iduser);
        $query->execute();
	return ($query->fetch()["count(*)"] != "0");
	}
	public function toggleLike($idTweet, $iduser)
	{
	if($this->isLiked($idTweet, $iduser) AND $this->tweetExist($idTweet))
	{
	$str="DELETE FROM liked WHERE idtweet = :idtweet AND iduser = :iduser;";
	}
	else
	{
	$str="INSERT INTO liked (idtweet, iduser) VALUES (:idtweet, :iduser);";
	}
        $query = $this->bdd->get()->prepare($str);
        $query->bindValue(":idtweet", $idTweet);
        $query->bindValue(":iduser", $iduser);
        $query->execute();
	}
	public function isRetweeted($idtweet, $iduser)
        {
        $str = "SELECT count(*) FROM retweet WHERE idtweet = :idtweet AND iduser = :iduser;";
        $query = $this->bdd->get()->prepare($str);
        $query->bindValue(":idtweet", $idtweet);
        $query->bindValue(":iduser", $iduser);
        $query->execute();
        return ($query->fetch()["count(*)"] != "0");
        }
	public function toggleRetweet($idTweet, $iduser)
        {
	if($this->isRetweeted($idTweet, $iduser) AND $this->tweetExist($idTweet))
        {
        $str="DELETE FROM retweet WHERE idtweet = :idtweet AND iduser = :iduser;";
        }
        else
        {
        $str="INSERT INTO retweet (idtweet, iduser) VALUES (:idtweet, :iduser);";
        }
        $query = $this->bdd->get()->prepare($str);
        $query->bindValue(":idtweet", $idTweet);
        $query->bindValue(":iduser", $iduser);
        $query->execute();
 	}
	public function likeCount($idTweet)
	{
	 $str = "SELECT count(*) FROM like WHERE idtweet = :idtweet;";
        $query = $this->bdd->get()->prepare($str);
	$query->bindValue(":idtweet", $idTweet);
	$query->execute();
	return ($query->fetch()["count(*)"]);
	}
	public function getTimeline($offset, $id)
	{
	$str = "SELECT t.data, t.id, t.timestamp, (SELECT name FROM user WHERE id = u.idfollowed), IF((SELECT count(*) FROM liked WHERE iduser = :user AND idtweet = t.id)>0,'TRUE','FALSE'), (SELECT count(*) FROM liked WHERE idtweet = t.id)  FROM tweet as t, (SELECT idfollowed FROM follow WHERE iduser = :user) as u WHERE t.iduser = u.idfollowed ORDER BY t.timestamp DESC LIMIT 10 OFFSET :offset;";
        $query = $this->bdd->get()->prepare($str);
        $query->bindValue(":user", $id); // iduser
	$query->bindValue(":offset", (int) $offset, PDO::PARAM_INT);
        $query->execute();
        $datas = $query->fetchAll();
        $tweets = array();
        foreach($datas as $data)
        {
	array_push($tweets, new tweetGW($data["data"],$data["id"] ,$data["(SELECT name FROM user WHERE id = u.idfollowed)"] ,$data["timestamp"],$data["IF((SELECT count(*) FROM liked WHERE iduser = '$id' AND idtweet = t.id)>0,'TRUE','FALSE')"], $data["(SELECT count(*) FROM liked WHERE idtweet = t.id)"]));
        }
        return $tweets;
	}
	public function getTimeLineCount($id)
        {
        $str = "SELECT count(t.id) FROM tweet as t, (SELECT idfollowed FROM follow WHERE iduser = :user) as u WHERE t.iduser = u.idfollowed";
	$query = $this->bdd->get()->prepare($str);
        $query->bindValue(":user", $id); // iduser
	$query->execute();
        return $query->fetch()["count(t.id)"]/10;
        }
}

?>
