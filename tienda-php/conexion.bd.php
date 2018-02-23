<?php
class conexion extends mysqli{

  public function __construct() {
    parent::__construct("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
    $this->query("SET NAMES 'utf8';");// esto sirve para evitar los caracteres extraños cuando estemos mandando y recibiendo datos. CONSULTAR MEJOR
    $this->connect_errno ? die("error con la conexion") : $x = "Conectado";
    //echo $x;
	unset($x);
  }
 
  public function recorrer($y){
     return mysqli_fetch_array($y);
  }
  public function rows($y) {
     return mysqli_num_rows($y);
  }
}
 

?>