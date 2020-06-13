<!DOCTYPE html>
<?php
function showAvatar($name)
{                    
    /*Fonction permettant l'affichage correct de l'avatar d'un utilisateur en cherchant sa présence dans le dossier dédié. 
    Si aucune image n'est trouvée, le logo de Pigeon sera affiché à la place.*/   
    $path = "/SNS/SITE/pages/fichiers/" . $name . "/avatar.png";
    $pathProfile="'/profil/" . $name . "/0'";
    if(file_exists($path))
         $path = "'https://pigeon-sns.com/pages/fichiers/" . $name  . "/avatar.png'";
    else
        $path = "'https://pigeon-sns.com/pages/light/apple-touch-icon.png'";
    $pathProfile = "https://pigeon-sns.com/profil/".$name."/0";
    echo "<img src=$path alt='Avatar Utilisateur' class='carreAvatar'></img>";
}
?>
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
            <div class="texte">
                <h2>Paramètres:</h2>
            </div>
            <div class="tweet_block">
                <!--Partie écriture d'un nouveau message-->
                <div class="col-xl-2">
		            <label for="image"><?php showAvatar($params["nickname"]);?></label>
                </div>
              <div class="col-xl-10">
                <div class="tweet_content">
                    <div class="form-login-container">
                        <form action="/account" class="inputLogin" method="post" enctype="multipart/form-data">
			                <input type="file" accept=".png" name="image" id="image" style="width: 0.1px;height: 0.1px;opacity: 0;overflow: hidden;position: absolute;z-index: -1;">
                            <input type="text" id="email" name="email" placeholder="<?=$params['mail']?>" maxlength="150">
                            <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="Mot de passe" maxlength="150">
                            <input type="submit" value="Soumettre">
                        </form>
                    </div>
               </div>
              </div>
            </div>
        </div>    
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://pigeon-sns.com/pages/light/js/script.js"></script>
</body>
</html>
