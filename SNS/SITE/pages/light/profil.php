<?php
function pagination($total, $current, $nom)
{
	/*Fonction permettant le bon fonctionnement de la pagination en bas de page.
	La pagination fonctionne de manière à ce que la premièr et la dernière page soient toujours visibles.
	Ensuite, la pagination affiche les pages qui entourent la page courante. */
	echo "<h3 class='message_attention'>";
	if($current > 2)
		echo "<a style='color:black;' href=https://pigeon-sns.com/profil/$nom/0>0</a>," . "...";
	for( $it = 0; $it < $total; $it++)
	{
		if($current - $it < 2 AND $current - $it > -2)
		{
                echo "<a style='color:black;' href=https://pigeon-sns.com/profil/$nom/$it>$it</a>,";
		}
	}
	if($current < $total -3)
	{
		$lastPage = $total-1;
		echo "..." . "<a style='color:black;' href=https://pigeon-sns.com/profil/$nom/$lastPage>$lastPage</a>";
	}
	echo "</h3>";
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="apple-touch-icon" sizes="180x180" href="https://pigeon-sns.com/pages/light/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="https://pigeon-sns.com/pages/light/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://pigeon-sns.com/pages/light/favicon-16x16.png">
    <link rel="manifest" href="https://pigeon-sns.com/pages/light/site.webmanifest">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profil</title>
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://pigeon-sns.com/pages/light/styles/style.css">
</head>
<body>
    <div class="container">
        <div class="main-nav fixed-top">
			<nav class="container navbar navbar-expand-lg navbar-light static-top">
				<div class="container">
					<a class="navbar-brand" href="/">
						<img class="logo" src="https://pigeon-sns.com/pages/light/images/logo.png" alt="Mon logo" href="/">
					</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarResponsive">
						<ul class="navbar-nav ml-auto">
							<li class="nav-item active">
								<a class="nav-link" href="/">ACCUEIL
									<span class="sr-only">(current)</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="/members/0">MEMBRES</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="/account">PARAMETRES</a>
							</li>
							<li class="nav-item">
                                                                <a class="nav-link" href="/timeline/0">TIMELINE</a>
                                                        </li>
						</ul>
					</div>
				</div>
			</nav>
		</div>
        <div class="parentAccueil">
            <div class="col-xl-2">
                <!--Partie Pub 1?-->
            </div>
           <div class="col-xl-10">
            <div class="rectangleText">
               <div class="col-md-10">
                <div class="heading">
                    <!--Partie Pub 2?-->
                </div>
               </div>
            </div>
           </div>
        </div>
        <div class="tweet_container container">
            <div class="parentProfil">
                <div class="col-xl-4">
                    <div class="rectangleProfil">
                        <div>
                            <h4><?=$params["name"]?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="rectangleProfil">

				<?php
        	        $path = "/SNS/SITE/pages/fichiers/" . $params["name"] . "/avatar.png";
	                if(file_exists($path))
               		 {$path = "https://pigeon-sns.com/pages/fichiers/" . $params["name"] . "/avatar.png";
               		 echo "<img src=$path alt='Votre avatar' class='carreAvatarProfil'>";
               		 }
              		  else
               		 echo "<img src='https://pigeon-sns.com/pages/light/apple-touch-icon.png' alt='avatar utilisateur' class='carreAvatarProfil'>";
               		 ?>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="rectangleProfil">
                        <div>
				<form action="/profil/<?=$params['name']?>/<?=$params['page']?>" method="post">
                    			<button type='submit' style='border:none; background-color: rgba(0, 0, 0, 0);' name='follow' value=<?=$params['name']?>><img src='https://pigeon-sns.com/pages/light/images/subscribe.png' alt='Retweet' style="width:150px; height:100px;"></button>
                		</form>
                        </div>
                    </div>
                </div>      
            </div>


	<div class="texte">
                <h2>Derniers Pigeons:</h2>
            </div>
	<?php if($params["FOLLOW"]):?>
                <!--Partie écriture d'un nouveau message-->
		<?php foreach($params["tweets"] as $msg): ?>
		         <?php
						 /*Récupération des données permettant le bon affichage des tweets
						 $msg est une gateway de tweet, il suffit donc d'utiliser ses getters pour extraire les données
						 utiles à son affichage. */
                         $path = "/SNS/SITE/pages/fichiers/" . $msg->getUser() . "/avatar.png";
			 			 $pathProfile="'/profil/" . $msg->getUser() . "/0'";
                         if(file_exists($path))
                         $path = "'https://pigeon-sns.com/pages/fichiers/" . $msg->getUser()  . "/avatar.png'";
                         else
                      	 $path = "'https://pigeon-sns.com/pages/light/apple-touch-icon.png'";
                      	 $pathLikedIcon = "https://pigeon-sns.com/pages/light/images/like2.png";
						 if($msg->getLiked() == "FALSE")
							$pathLikedIcon = "https://pigeon-sns.com/pages/light/images/like.png";
							$pathRetweetIcon = "https://pigeon-sns.com/pages/light/images/retweet.png";
			  ?>
		<div class="tweet_block">
                <!--Partie écriture d'un nouveau message-->
                <div class="col-xl-2">
		<a href=<?= $pathProfile?> ><img src=<?=$path?> alt="Avatar Utilisateur" class="carreAvatar"></img></a>
                </div>
              <div class="col-xl-10">
                <div class="tweet_content">
                    <a style="text-decoration: none;" href=<?=$pathProfile?>><h3 class="pseudoname"><?= $msg->getUser()?></h3></a>
                    <p class="tweet_message"><?= $msg->getData()?></p>
		    		<?php
					$path = "/SNS/SITE/pages/images/" . $msg->getId() . ".png";
		                	if(file_exists($path))
							{	// Affichage d'une image au tweet, si l'image portant l'id du tweet existe.
								$url="https://pigeon-sns.com/pages/images/" . $msg->getId() . ".png";
								echo "<a href=$url><img src=$url style='width:120px; height:80px; border-radius:20px; border-style:solid; border-color:#ffdb38; border-size:5px;'></a>";
							}
		    			?>
						<?=date(DATE_RFC2822, $msg->getTimeStamp());?>
               </div>
               <div class="tweet_relationships">
						<?php if($msg->getUser() != $params["compte"]->getNickname())
                                {
										//Affichage d'une icone 'retweet' si le tweet n'appartient pas à l'utilisateur courant.
                                        $idtweet = $msg->getId();
                                        echo "<form action='/' method='post'><button style='border:none; background-color: rgba(0, 0, 0, 0);' type='submit' name='retweet' value=$idtweet><img src=$pathRetweetIcon alt='Retweet'></button></form>";
                                }
                         ?>
		<form action="/profil/<?=$params['name']?>/<?=$params['page']?>" method="post">
		    <button style='border:none; background-color: rgba(0, 0, 0, 0);' type='submit' name='like' value=<?=$msg->getId()?>><img src=<?=$pathLikedIcon?> alt='Like'></button>
		</form>
		<div><?=$msg->getLikeCount()?> like(s)</div>
               </div>
              </div>
            </div> 
	<?php endforeach; ?>
	<?php pagination(intval($params["pagecount"]), intval($params['page']), $params['name']);?>
        <?php endif;?>
	<?php if(!$params["FOLLOW"]):?>
		<div class="message_attention">
		    <h3>Vous devez être abonné pour visualiser le contenu d'un autre membre!</h3>
		</div>
	<?php endif;?>
	</div>    
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://pigeon-sns.com/pages/light/js/script.js"></script>
</body>
</html>
