<?php
  require_once("./model/Login.php");
  class LoginController{
      private static $instance;

      public static function getInstance() {

        if (!isset(self::$instance)) {
          self::$instance = new self();
        }

        return self::$instance;
      }
      
      //obtengo los datos del form y luego chequeo del lado interno, se consulta si esta, se crea la session, se envia a sus tareas.
      function consultar(){
        if(isset($_POST['user']) || isset($_POST['password'])){
            if( $_POST['user']!='' && $_POST['password']!=''){
              $us= $_POST['user'];
              $con= $_POST['password'];
              if(isset($us) && isset($con)){
                    if(trim($us)!="" && trim($con)!=""){
                      //La función strip_tags () quita una cadena de etiquetas HTML, XML y PHP.
                      $us= strip_tags($_POST['user']);
                      $con= strip_tags($_POST['password']);
                          if(trim($us)!="" && trim($con)!=""){
                            $consulta = verificarLogin($us,$con); 
                              if($consulta>0){
                                $_SESSION['idusu']=$consulta['idusuario'];
                                $_SESSION['username']=$us;
                                $_SESSION['nombre']=$consulta['nombre'];
                                $_SESSION['rol']=$consulta['rol'];
                                TareaController::Tareas();
                                unset($_POST['user']);
                                unset($_POST['password']);
                                unset($us);
                                unset($con);
                               }else{
                                $error="Wrong username and / or password";
                                $template=load();
                                $template ->display('home.twig',array('alerta'=>$error));  
                              }
                          }else{
                            $error = "Corrupt data was sent";
                            $template = load();
                            $template -> display('home.twig',array('alerta' => $error));
                          }     
                    }else{
                      $error = "Enter your username or password";
                      $template = load();
                      $template -> display('home.twig',array('alerta' => $error));
                    }
              
              }else{
                $error = "No session started";
                $template = load();
                $template -> display('home.twig',array('error' => $error));
              }

            }else{
                $error = "Enter your username or password";
                $template = load();
                $template -> display('home.twig',array('error' => $error));
            }
        }else{
          if(isset($_SESSION['idusu'])){
            TareaController::Tareas();
          }else{
            $error="Access denied";
            $template=load();
            $template ->display('home.twig',array('error'=>$error));
          }
          
        }
        
      }
 
      function desconectar(){
        if(isset($_SESSION['idusu'])){
            $_SESSION = array ();
            session_destroy ();
            $template = load();
            $template -> display('home.twig');
        }else{
            $error="Access denied";
            $template=load();
            $template ->display('home.twig',array('error'=>$error));
        }
            
      }
      public function home(){
        $template = load();
        $template -> display('home.twig');
      }

  }
?>