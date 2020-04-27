<?php
class Conexion{
	public static function conectar(){
	$link = new PDO("mysql:host=localhost;dbname=prcentro","root","");
    //$link = new PDO("mysql:dbname=senagal_pcentro;host=localhost","senagal_pcentro","{O{W?bBVt*v?");
	//$link = new PDO("mysql:dbname=cursoscd_cursos;host=localhost","cursoscd_publico","mkK[ndwLI;_Z");	
    return $link;
    }
}

