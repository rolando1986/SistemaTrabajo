<?php
   
   require_once('PDORepository.php');
   class modelTarea{
   		public static function insertarTarea($usuario,$titulo,$fecha,$Descripcion){
	   		$bd = conexion::conectar();
			$query = $bd -> prepare("INSERT INTO tarea (titulo, descripcion, fecha,realizada) VALUES (:titulo,:Descripcion, :fecha,'0')");
			$query ->bindParam(':titulo',$titulo);
			$query ->bindParam(':fecha',$fecha);
			$query ->bindParam(':Descripcion',$Descripcion);
			$query->execute();
			
           //obtengo el id de la ultima insercion de la tabla tarea
			$tareaQuery = $bd->prepare("SELECT MAX(idtarea) AS id FROM tarea");
            $tareaQuery->execute();  
            $idArr=$tareaQuery->fetch();
            $idtarea= $idArr['id'];             
			$query1 = $bd -> prepare("INSERT INTO tiene (idusuario, idtarea) VALUES (:usuario,:tarea)");
			$query1 ->bindParam(':usuario',$usuario);
			$query1 ->bindParam(':tarea',$idtarea);
			$query1 ->execute();
			
			
	   		
	    }

	    public static function listarTareas($id){
	    	$bd = conexion::conectar();
			$query = $bd -> prepare("SELECT t.idtarea, t.titulo, t.descripcion, t.fecha, t.realizada FROM tarea t INNER JOIN tiene ti ON t.idtarea=ti.idtarea where ti.idusuario=? and t.habilitada=0 ");
			$query -> execute(array($id));
			return $query;
	    	
	    }
	    public static function unaTarea($id,$tarea){
	    	$bd = conexion::conectar();
			$query = $bd -> prepare("SELECT t.idtarea, t.titulo, t.descripcion, t.fecha, t.realizada FROM tarea t INNER JOIN tiene ti ON t.idtarea=ti.idtarea where ti.idusuario= :id and t.idtarea= :idtarea and t.habilitada=0 ");
			$query -> execute(array(':id' => $id, ':idtarea' => $tarea));
			return $query;
	    }

	    public static function actualizarUnaTareaF($idTarea,$titulo,$descripcion,$fecha,$realizada){
	    	$bd = conexion::conectar();
	    	$query = $bd -> prepare("UPDATE tarea SET titulo=:titulo, descripcion=:descripcion, fecha=:fecha, realizada=:realizada WHERE idtarea = :idtarea");
	    	$query ->execute(array(':titulo'=>$titulo , ':descripcion' => $descripcion , ':fecha' => $fecha , ':realizada' => $realizada , ':idtarea' => $idTarea));

	    }
	    public static function actualizarUnaTareaSF($idTarea,$titulo,$descripcion,$realizada){
	    	$bd = conexion::conectar();
	    	$query = $bd -> prepare("UPDATE tarea SET titulo=:titulo, descripcion=:descripcion, realizada=:realizada WHERE idtarea = :idtarea");
	    	$query ->execute(array(':titulo'=>$titulo , ':descripcion' => $descripcion , ':realizada' => $realizada , ':idtarea' => $idTarea));
	    }

	   	public static function eliminarTarea($idTarea,$habilitada){
	   		$bd = conexion::conectar();
	    	$query = $bd -> prepare("UPDATE tarea SET habilitada=:habilitada WHERE idtarea = :idtarea");
	    	$query ->execute(array(':habilitada'=> $habilitada, ':idtarea' => $idTarea));
	   	}
    }

?>