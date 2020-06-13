<?php
namespace DATA\routing\control;
abstract class controller 
{
    /*Page de base des controlleurs.
    Chaque page doit avoir une donnée membre app, et pouvoir appeler la méthode render, pour afficher la page correspondante.
     */
    protected $app;
    public function __construct($app) { 
        $this->app = $app;
    }

    protected function render($template, $params = []) { 
        /*Affiche la page correspondante, ou une page 404, la méthode prend un tableau matérialisant les paramètres.*/
        if($template === '404') {
            header("HTTP/1.0 404 Not Found"); 
        }

        ob_start(); 
        include '/SNS/SITE/pages/'. $template . '.php'; 
        ob_end_flush(); 
        die;
    }
}
?>
