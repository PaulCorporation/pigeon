<!DOCTYPE html>
<?php
function pagination($total, $current)
{
    /*Fonction permettant l'affichage correct de la pagination en bas de page.
    La pagination est faite pour que la première et la dernière page soient toujours affichées,
    les deux pages entourant la page courante seront également systématiquement affichées.*/
    echo "<h3 class='message_attention'>";
    if($current > 2)
        echo "<a style='color:black;' href=https://pigeon-sns.com/members/0>0</a>," . "...";
    for( $it = 0; $it < $total; $it++)
    {
                if($current - $it < 2 AND $current - $it > -2)
                {
                    echo "<a style='color:black;' href=https://pigeon-sns.com/members/$it>$it</a>,";
                }
    }
    if($current < $total -3)
        {
            $lastPage = $total-1;
            echo "..." . "<a style='color:black;' href=https://pigeon-sns.com/members/$lastPage>$lastPage</a>";
        }
    echo "</h3>";
}
function showAvatar($name)
{			$path = "/SNS/SITE/pages/fichiers/" . $name . "/avatar.png";
                         $pathProfile="'/profil/" . $name . "/0'";
                         if(file_exists($path))
                         $path = "'https://pigeon-sns.com/pages/fichiers/" . $name  . "/avatar.png'";
                         else
                         $path = "'https://pigeon-sns.com/pages/light/apple-touch-icon.png'";
			$pathProfile = "https://pigeon-sns.com/profil/".$name."/0";
			echo "<a href=$pathProfile ><img src=$path alt='Avatar Utilisateur' class='carreAvatar'></img></a>";
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
           <h2>Liste membres:</h2>
		  <?php 
          foreach($params["users"] as $usr):
          $name = $usr["name"];
          ?>
            </div>
            <div class="tweet_block">
                <!--Partie écriture d'un nouveau message-->
                <div class="col-xl-2">
			        <?php showAvatar($name);?>
        	    </div>
              <div class="col-xl-10">
                <div class="tweet_content">
                    <div class="form-login-container">
                        <h2><?php echo "<a href='https://pigeon-sns.com/profil/$name/0'><h3>$name</h3></a>";?></h2>
                    </div>
                    <div class="tweet_relationships_">
			        <form action="/profil/<?=$name?>/0" method="post">
				        <button type='submit' style='border:none; background-color: rgba(0, 0, 0, 0);' name='follow' value=<?=$params['name']?>><img src='https://pigeon-sns.com/pages/light/images/subscribe.png' alt='Retweet' style="width:150px; height:100px;"></button>
			        </form>
                    </div>
               </div>
           </div>
		  <?php endforeach;?>
        </div>
		<?php		 pagination(intval($params["count"]), intval($params["page"]));?>
        </div>    
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://pigeon-sns.com/pages/light/js/script.js"></script>
</body>
</html>
