<?php
require_once('controller/LoginController.php');
require_once('controller/TareaController.php');
require_once('view/TwigView.php');
require_once('model/PDORepository.php');
require_once('model/tareaModel.php');

session_start();

if(isset($_GET["action"]) && $_GET["action"] == 'login'){
	LoginController::getInstance()->consultar();
}
elseif(isset($_GET["action"]) && $_GET["action"] == 'cerrar'){
	LoginController::getInstance()->desconectar();
}
elseif(isset($_GET["action"]) && $_GET["action"] == 'AltaTarea'){
	TareaController::getInstance()->AltaTarea();
}
elseif(isset($_GET["action"]) && $_GET["action"] == 'datosModificarTarea'){
	TareaController::getInstance()->datosModificar();
}
elseif(isset($_GET["action"]) && $_GET["action"] == 'EliminarTarea'){
	TareaController::getInstance()->eliminarTarea();
}
elseif(isset($_GET["action"]) && $_GET["action"] == 'Home'){
	TareaController::getInstance()->Tareas();
}
elseif(isset($_GET["action"]) && $_GET["action"] == 'ModificarTarea'){
	TareaController::getInstance()->actualizaRealizado();
}else{
	if(isset($_SESSION['idusu'])){
		TareaController::getInstance()->Tareas();
	}else{
		LoginController::getInstance()->home();
	}
	
}
?>
