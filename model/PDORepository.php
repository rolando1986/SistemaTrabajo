<?php

class conexion{
    private $dbu;

    public function conectar(){
        $dbu= new PDO("mysql:dbname=".'sistematarea'.";host=".'localhost','root','');
        return $dbu;
    }
    public function desconectar(){
        $dbu=null;
        return $dbu;
    }
}
?>
