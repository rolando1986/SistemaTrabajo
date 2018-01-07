<?php
   
   require_once('PDORepository.php');

    function verificarLogin($usuario,$clave){
	   $bd = conexion::conectar();
	   $query = $bd -> prepare ("SELECT * FROM usuario WHERE nomusuario = ? AND clave = ?"); // utilizo prepare para evitar sql inyection
	   $query->execute(array($usuario, $clave));
	   return $query->fetch(); 
    }
?>