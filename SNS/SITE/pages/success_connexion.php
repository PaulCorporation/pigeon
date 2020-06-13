<!DOCTYPE html>
<style>
body 
        {
                background-color: blue;



        } 
#form-outer 
        {
                background-color: rgba(250, 250, 250, 0.9);
                margin: 0 auto;
                border-radius: 4px;
                width: 75%;
                padding: 15px;
                padding-top: 10px;
                padding-bottom: 20px;
                display:flex;
                flex-direction:column;
                align-items:center;
        }
</style>
<html>
        <head>
                <meta charset="utf-8" />
                <title>Pigeon - Dashboard</title>
        </head>
        <body>
	<div id="form-outer">
        Vous êtes bien connecté.<br/>
	Votre nom : <?php echo $params["compte"]->getNickname(); ?> <br/>
	Votre mail : <?php echo $params["compte"]->getMail(); ?> <br/>
	<a href="pigeon-sns.com/account">mon compte</a> <br/>
	Tweeter un truc.<br/>
	<form action="/" id="ajout" method="post">
        <textarea name="tweet" rows="5" cols="33" maxlength="140">votre tweet</textarea>
	<br/>
        <input type="submit">
	<br/>
		Vos tweets : 
	<br/>
	<?php foreach($params["tweets"] as $msg): ?>
	nom : <?php echo $msg->getUser(); ?> <br/>
	message : <?php echo $msg->getData(); ?> <br/>
	<?php endforeach; ?>
	</div>
        </body>
</html>
