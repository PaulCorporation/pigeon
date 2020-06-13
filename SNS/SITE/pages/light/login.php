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
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://pigeon-sns.com/pages/light/styles/style.css">
<script type="text/javascript" src="//go.ezoic.net/ezoic/ezoic.js"></script> 
</head>
<body>
    <div class="container">
        <div class="center">
            <div class="parent row">
                <div class="LeftRectangleLogin col-md-5">
                    <h1>BONJOUR,</h1>
                    <br>
                    <h3>Connectez-vous<br>s'il vous plaît</h3>
                    <br>
                    <div class="lien">
                        <a href="/signup">
                            <h4>Pas encore inscrit?</h4>
                        </a>
                        <a href="/recovery" class="lien">
                            <h4>Oublié ton mot de passe?</h4>
                        </a>
                    </div>
                </div>
                <div class="RightRectangleLogin col-md-5">
                    <h2>LOGIN</h2>
                    <div class="form-login-container">
                    <form action="/" id="dashboard" method="post" class="inputLogin">
    
                        <input type="text" id="email" name="Adresse_connexion" placeholder="Adresse E-mail" maxlength="150">
    
                        <input type="password" id="mot_de_passe" name="Password_connexion" placeholder="Mot de passe" maxlength="150">
    
                        <input type="submit" value="Soumettre">
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
