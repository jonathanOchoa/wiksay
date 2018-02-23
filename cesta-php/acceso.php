<?php
class acceso{

protected $user;
protected $pass;
protected $email; 


    public function __construct($usuario, $email, $password){
	   $this->user = htmlspecialchars($usuario);//htmlspecialchars esto es para la seguridad
	   $this->email = htmlspecialchars($email);//htmlspecialchars esto es para la seguridad
	   $this->pass = htmlspecialchars($password);//htmlspecialchars esto es para la seguridad
	}

    public function login(){
	   $db = new conexion();
	   $user =  $db->real_escape_string($this->user);//esto es para la seguridad
	   $email = $db->real_escape_string($this->email);//esto es para la seguridad
	   $salt = '$b7g2j6r$/'; // esto es una cadena para que se mezcle con la contraseña
	   $pass = $pass_original = sha1(md5($salt . $db->real_escape_string($this->pass))); //esto es para la seguridad
	   $sql =   $db->query("SELECT apodo, pass FROM usuario WHERE apodo='$user' AND pass='$pass';");
       $dato =  $db->recorrer($sql);
       
       $apodo_db_login = $dato['apodo'];
       $pass_db_login = $dato['pass'];
    
	   if($apodo_db_login === $user AND $pass_db_login === $pass) {
	       session_start();
                     $_SESSION['user'] = htmlspecialchars($user);
                   if (isset($_SESSION['user']) AND !empty($_SESSION['user'])) {
		   header("location: cesta.php");
		   }else{ header("location: cesta.php?session vacia"); }
	   }else{
	         header("location: cesta.php?error=datos_incorrectos"); // al no introducir los datos de usuario bien lo redirigimos a la pagina principal
	        }
	}
	
  
    public function registro(){
        $db = new conexion();
		$user =  $db->real_escape_string($this->user);//esto es para la seguridad
		$email = $db->real_escape_string($this->email);//esto es para la seguridad
	    $salt = '$b7g2j6r$/'; // esto es una cadena para que se mezcle con la contraseña
	    $pass = $pass_original = sha1(md5($salt . $db->real_escape_string($this->pass))); //esto es para la seguridad
		$fecha_actual = date('Y-m-d H:i:s');
	    $sql = $db->query("SELECT apodo, email FROM usuario WHERE apodo='$user' OR email='$email';");
        $existe = $db->recorrer($sql);
        
        $apodo_db = $existe['apodo'];
        $email_db = $existe['email'];
        
		if($apodo_db !== $user and $email_db !== $email){
	        $db->query("INSERT INTO usuario (apodo, email, pass, fecha_alta, rol_id) VALUE ('$user','$email','$pass','$fecha_actual','1');");
		    session_start();
		    $_SESSION["user"] = htmlspecialchars($user);
		    header("location: cesta.php?proceso=inicio"); // una vez registrado lo redirigimos a dentro de la web
	       
		   }else if ($apodo_db  === $user and $email_db  !== $email){
	         header("location: cesta.php?modo=registro&error=usuario_usado"); // si ya existe el usuario lo redirigimos a la pagina principal
	       }else if ($email_db  === $email and $apodo_db  !== $user){
			 header("location: cesta.php?modo=registro&error=email_usado"); // si ya existe el email lo redirigimos a la pagina principal
           }else if ($email_db  === $email and $apodo_db  === $user){
			 header("location: cesta.php?modo=registro&error=email_usuario_usado"); // si ya existe el email lo redirigimos a la pagina principal
           }
	}
}
?>