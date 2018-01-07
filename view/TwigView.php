<?php


require_once './Twig/Autoloader.php';

function load() {


            Twig_Autoloader::register();
            $loader = new Twig_Loader_Filesystem('./templates');
            $twig = new Twig_Environment($loader);
        
        
        return $twig;
   }
?>
