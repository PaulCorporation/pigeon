<?php
namespace DATA\BASE\models;
use DATA\BASE\models\baseinterface;
use DATA\BASE\models\gateway\accountGW;
use \PDO;
class accountFinder implements baseinterface
{
        /*La classe accountFinder est un service gérant tout ce qui est lié de près ou de loin aux comptes d'utilisateurs.
        Elle intègre une référence vers la bdd et l'app, pour avoir accès aux autres services et implémente de nombreuses méthodes. */
	private $bdd;
	private $app;
	public function __construct($app)
	{
                /*récupération de la base de donnée en tant que service*/
	        $this->bdd = $app->getService("DB");
	        $this->app = $app;
        }
        
	public function authentication($email, $password)
        {
                /*La fonction d'authentification vérifie si le compte existe, puis crée une gateway et la charge pour récupérer le hash du mot de passe
                le mot de passe passé en paramètre est à son tour hashé et comparé à celui en base.
                Retourne false en cas d'échec, et le compte en cas de succès.*/
                if($this->mailexist($email))
                {
		        $compte = new accountGW($this->app);
		        $compte->loadFromMail($email, $this->bdd);
		        if(password_verify($password,$compte->getHash()))
		        {
		             return $compte;
		        }
                }
        return false;
        }

	public function exist($name, $mail)
        {
                /*Permet de érifier l'existence d'un compte utilisateur à partir d'une pseudonyme et d'une adresse mail.
                Si un seul des paramètres match, la méthode renvoit true.*/
                $str = "SELECT count(*) FROM user WHERE ( name LIKE :name OR address LIKE :mail)";
                $query = $this->bdd->get()->prepare($str);
                $query->execute([":name" => $name, ":mail" => $mail]);
                if($query->fetch()["count(*)"] == "0")
                                return false;
        return true;
        }

	public function existByName($name)
        {
                /*Même chose, sauf que le seul paramètre est le nom.*/
                $str = "SELECT count(*) FROM user WHERE ( name LIKE :name)";
                $query = $this->bdd->get()->prepare($str);
                $query->execute([":name" => $name]);
                if($query->fetch()["count(*)"] == "0")
                                return false;
        return true;
        }

	public function newPass($mail, $mdp)
	{
		if(filter_var($mail, FILTER_VALIDATE_EMAIL))
		{
				$courriel = "'Votre nouveau mot de passe est : " . $mdp . " vous pouvez le changer à votre prochaine connexion.\n Ceci est un mail automatique, à bientôt sur https://pigeon-sns.com'";
				$command = "sendPigeon " . $courriel . " " . $mail;
                                //shell_exec($command);
				mail($mail, "contact", $courriel);
				
		}
        }
        
	public function register($mail, $name)
        {
                /*Enregistrement d'un nouveau compte utilisateur, création d'un mot de passe aléatoire, et envoit d'un mail informatif
                permettant à l'utilisateur de se connecter.*/
                if(!$this->exist($name, $mail) AND filter_var($mail, FILTER_VALIDATE_EMAIL))
                {	
				$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz'; 
                                $mdp = substr(str_shuffle($permitted_chars), 0, 50);
				$mail = htmlspecialchars($mail); // Evite les failles XSS
				$name = htmlspecialchars($name);
				$name = preg_replace("#[^a-zA-Z0-9]#", "", $name);
				$this->newPass($mail, $mdp); // Envoit le mail informatif
				$mdp = password_hash($mdp, PASSWORD_DEFAULT); // Hash le mot de passe avant son enregistrement.
				$str = "INSERT INTO user (name, address, password, admin) VALUES (:name,:address ,:password  , 0);";
				$query = $this->bdd->get()->prepare($str);
				$query->execute([":address" => $mail, ":name" => $name, ":password" => $mdp]);
				return true;
                }
		return false;
        }

        public function mailexist($mail)
        {
                /*Indique par un booléen si un compte au mail $mail existe.*/
                $str = "SELECT count(*) FROM user WHERE ( address like :mail )";
                $query = $this->bdd->get()->prepare($str);
                $query->execute([":mail" => $mail]);
                if($query->fetch()["count(*)"] == "0")
                               return false;

                return true;
        }

	public function getUsers($offset)
	{
                /*Permet de récupérer des utilisateurs, $offset permet de gérer la pagination.*/
	        $str= "SELECT name FROM user ORDER BY name LIMIT 10 OFFSET :offset";
                $query = $this->bdd->get()->prepare($str);
	        $query->bindValue(":offset", (int) $offset*10, PDO::PARAM_INT);
                $query->execute();
	        return $query->fetchAll();
        }
        
	public function getUsersPageCount()
	{
                /*Permet de générer la pagination de la page des utilisateurs. */
	        $str= "SELECT count(*) FROM user";
                $query = $this->bdd->get()->prepare($str);
                $query->execute();
                return (int)((int)$query->fetch()["count(*)"]/10) +1;
        }
        
	public function changeAvatar($name)
	{
                /*Permet de changer l'avatar, 
                Mets à jour le fichier png */
                if($_FILES["image"]["size"] != 0)
                        if($_FILES["image"]["size"] < 2000000 AND $_FILES["image"]["type"] == "image/png")
                        {
                                $path = "/SNS/SITE/pages/fichiers/".$name."/avatar.png";
                                move_uploaded_file ($_FILES["image"]["tmp_name"], $path);
		                echo("<script>alert('Votre avatar a été changé, si vous ne voyez pas le changement, veuillez supprimer le cache de votre navigateur.')</script>");
                        }
        }
        
	public function changeMail($mail)
	{
                /*Permet de changer l'adresse mail d'un compte utilisateur.
                la méthode vérifie que l'adresse n'est pas prise, et que l'adresse mail est valide. */
		if(!$this->mailexist($mail) AND filter_var($mail, FILTER_VALIDATE_EMAIL))
		{
		        $_SESSION["compte"]->setMail($mail);
		        $_SESSION["compte"]->update($this->bdd);
		}
        }
        
	public function changePassword($pass)
	{
                /*La méthode changePassword appelle la méthode update de la gateway aprrès le hash pour mettre à jour les données en base.*/
		$_SESSION["compte"]->setHash(password_hash($pass, PASSWORD_DEFAULT));
		$_SESSION["compte"]->update($this->bdd);

        }
        
	public function isFollowed($nameFollowed, $id)
        {
                /*Renvoit un booléen présisant si la personne $nameFollowed est suivie par $id*/
	        $str="SELECT count(*) FROM follow as f, (SELECT id FROM user WHERE name = :nameFollowed) as u WHERE f.iduser = :id AND idfollowed = u.id;";
                $query = $this->bdd->get()->prepare($str);
                $query->execute([":id" => $id, ":nameFollowed" => $nameFollowed]);
                return ($query->fetch()["count(*)"] != "0");
        }

        public function toggleFollow($nameFollowed, $id)
        {
                /*Permet de toggle un follow,
                Crée une ligne dans la table follow si isFollowed renvoit false et inversement.
                Cela permet d'éviter les abus lors d'envois multiples de formulaires.*/
                if($this->isFollowed($nameFollowed, $id) AND $this->existByName($nameFollowed))
                {
                        $str="DELETE FROM follow  WHERE iduser = :id AND idfollowed IN (SELECT id FROM user where name = :nameFollowed);";
	                $query = $this->bdd->get()->prepare($str);
	                $query->execute([":id" => $id, ":nameFollowed" => $nameFollowed]);
                }
	        else
	        {
	                $str="INSERT INTO follow (iduser, idfollowed) SELECT :id, id FROM user WHERE name = :nameFollowed;";
                        $query = $this->bdd->get()->prepare($str);
                        $query->execute([":id" => $id, ":nameFollowed" => $nameFollowed]);
	        }
	}
}

?>
