<?php
class TareaController{
	private static $instance;

	public static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	function accessDeniedHome(){
		$error="Access denied";
	    $template=load();
	    $template ->display('home.twig',array('error'=>$error));
	}
	function AltaTarea(){

		if(isset($_POST['titulo']) || isset($_POST['fechaInicio']) || isset($_POST['Descripcion'])){
			if(trim($_POST['titulo'])!="" && trim($_POST['fechaInicio'])!="" && trim($_POST['Descripcion'])!=""){
				$usuario=$_SESSION['idusu'];
                modelTarea::insertarTarea($usuario,$_POST['titulo'],$_POST['fechaInicio'],$_POST['Descripcion']);
                $mensaje="The task was added successfully";
				self::TareasMensaje($mensaje);
				unset($_POST['titulo']);
                unset($_POST['fechaInicio']);
                unset($_POST['Descripcion']);
                
			}else{
				$mensaje="Sorry, there is one or more data on this page that are missing";
				self::TareasMensaje($mensaje);
				unset($_POST['titulo']);
                unset($_POST['fechaInicio']);
                unset($_POST['Descripcion']);
			}

		}else{
			if(isset($_SESSION['idusu'])){
				$mensaje="Access denied";
				self::TareasMensaje($mensaje);
			}else{
				self::accessDeniedHome();
			}
	           
		}
		

	}

	function Tareas(){
		if(isset($_SESSION['idusu']) || isset($_SESSION['username'])){
			$idusuario=$_SESSION['idusu'];
			$username=$_SESSION['username'];
			$dato=modelTarea::listarTareas($idusuario);
			/* dato para saber si estan los datos para modificar o no */
			$varM=0;
			$numero = $dato->rowCount();
			if($numero != 0){
				if($_SESSION['rol']==0){
		            $template = load();
		            $template -> display('tareas.twig',array('dato' => $dato,'user' =>$username, 'varM' => $varM));

	          	}
			}else{
				$vacio="You have no tasks to perform";
				$template=load();
				$template -> display('tareas.twig', array('user'=>$username, 'varM' => $varM, 'vacio' => $vacio));
			}
		}else{
			self::accessDeniedHome();
		}
	}

	function TareasMensaje($mensaje){
		if(isset($_SESSION['idusu']) || isset($_SESSION['username'])){
			$idusuario=$_SESSION['idusu'];
			$username=$_SESSION['username'];
			$dato=modelTarea::listarTareas($idusuario);
			/* dato para saber si estan los datos para modificar o no */
			$varM=0;
			$numero = $dato->rowCount();
			if($numero != 0){
				if($_SESSION['rol']==0){
			        $template = load();
	           		$template -> display('tareas.twig',array('dato' => $dato,'mensaje'=> $mensaje,'user' =>$username, 'varM' => $varM));
		          	}
				}else{
					$vacio="You have no tasks to perform";
					$template=load();
					$template -> display('tareas.twig', array('user'=>$username,'mensaje'=> $mensaje, 'varM' => $varM, 'vacio' => $vacio));
				}			
		}else{
			self::accessDeniedHome();
		}

	}


	function datosModificar(){
		if(isset($_POST['datosMod']) ){
			$idTarea=$_POST['datosMod'];
			$idusuario=$_SESSION['idusu'];
			$datosUnaTarea = modelTarea::unaTarea($idusuario,$idTarea);
			$dato=modelTarea::listarTareas($idusuario);
			$username=$_SESSION['username'];
			$template = load();
			/* dato para saber si estan los datos para modificar o no */
			$varM=1;
	        $template -> display('tareas.twig',array('dato' => $dato,'user' =>$username, 'datosModTarea' => $datosUnaTarea, 'varM' => $varM));
	     	unset($_POST['datosMod']);
		}else{
			if(isset($_SESSION['idusu'])){
				$mensaje="Access denied";
				self::TareasMensaje($mensaje);
			}else{
				self::accessDeniedHome();
			}
		}

	}

	function actualizaRealizado(){
		if(isset($_POST["tituloM"]) && isset($_POST["Descripcion"])){
			if(trim($_POST["tituloM"])!="" && trim($_POST["Descripcion"])!=""){	
				if(isset($_POST["realizada"])){
					$marca=1;
				}else{
					$marca=0;
				}
				if($_POST["fechaInicio"]!=""){
					modelTarea::actualizarUnaTareaF($_POST["idModTarea"],$_POST["tituloM"],$_POST["Descripcion"], $_POST["fechaInicio"],$marca );
					$mensaje="The task was successfully updated";
					self::TareasMensaje($mensaje);

				}else{
					modelTarea::actualizarUnaTareaSF($_POST["idModTarea"],$_POST["tituloM"],$_POST["Descripcion"],$marca );
					$mensaje="The task was successfully updated";
					self::TareasMensaje($mensaje);

				}
				unset($_POST["tituloM"]);
				unset($_POST["Descripcion"]);
				unset($_POST["fechaInicio"]);
				unset($_POST["fechaMuestra"]);
				unset($_POST["realizada"]);
			}else{
				$mensaje="Sorry, there is one or more data on this page that are missing";
				self::TareasMensaje($mensaje);
				unset($_POST["tituloM"]);
				unset($_POST["Descripcion"]);
				unset($_POST["fechaInicio"]);
				unset($_POST["fechaMuestra"]);
				unset($_POST["realizada"]);	
			}
		}else{
			if(isset($_SESSION['idusu'])){
				$mensaje="Access denied";
				self::TareasMensaje($mensaje);
			}else{
				self::accessDeniedHome();
			}
		}
		
	}

	function eliminarTarea(){
		if (isset($_POST["Eliminar"])){
			modelTarea::eliminarTarea($_POST["Eliminar"],1);
			$mensaje="The task was successfully eliminated";
			self::TareasMensaje($mensaje);			
			unset($_POST["Eliminar"]);
		}else{
			if(isset($_SESSION['idusu'])){
				$mensaje="Access denied";
				self::TareasMensaje($mensaje);
			}else{
				self::accessDeniedHome();
			}
		}
		
	}

}

?>