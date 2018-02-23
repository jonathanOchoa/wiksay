<?php
 class generarpassword {
    
	private $cadena;
	private $longitud;
	private $password;
	
	public function __construct() {
	   $this->cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	   $this->password = "";
	}
	
	public function nuevapassword($long) {
	   $lng_cadena = strlen($this->cadena);
	   $this->longitud = $long;
	   
	     for($x=1;$x<=$this->longitud;$x++) {
		    $aleatorio = mt_rand(0,$lng_cadena-1);
			$this->password .= substr($this->cadena,$aleatorio,1);
		 }
		 return $this->password;
	}
 }
 
?>