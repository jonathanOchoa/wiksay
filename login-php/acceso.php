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
		   header("location: cliente.php");
		   }else{ header("location: inicio.php?session vacia"); }
	   }else{
	         header("location: inicio.php?error=datos_incorrectos"); // al no introducir los datos de usuario bien lo redirigimos a la pagina principal
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
			
			$sql = $db->query("SELECT id FROM usuario WHERE apodo='$user';");
			$id_usuario = $db->recorrer($sql);
			$mostrar_id_usuario = $id_usuario['id'];
			
			$db->query("INSERT INTO empresa (apodo_empresa, nombre_empresa, nombre_comercial, cif_empresa, email_empresa, pais_empresa, provincia_empresa,
						poblacion_empresa, direccion_empresa, telefono1_empresa, telefono2_empresa, fax_empresa, tipo_empresa, url_empresa, usuario_id, fecha_alta)
						VALUE ('$user','$user','','','$email','','','','','','','','','','$mostrar_id_usuario','$fecha_actual')");
			
			$db->query("INSERT INTO tienda (imagen_tienda, imagen_fondo_tienda, nombre_tienda, apodo_tienda, usuario_id, descripcion_tienda, categoria_t_id, fecha_alta)
			VALUE ('','','$user','$user','$mostrar_id_usuario','','5','$fecha_actual')");
			
			$sql = $db->query("SELECT id FROM empresa WHERE apodo_empresa='$user';");
			$id_empresa = $db->recorrer($sql);
			$mostrar_id_empresa = $id_empresa['id'];
			
			$db->query("INSERT INTO social_media (facebook, whatsapp, instagram, twitter, youtube, googleplus, pinterest, linkedin, mapa, empresa_id, empresa_usuario_id)
			VALUE ('', '', '', '', '', '', '', '', '', '$mostrar_id_empresa', '$mostrar_id_usuario')");
				
		    session_start();
		    $_SESSION["user"] = htmlspecialchars($user);
		    header("location: cliente.php?proceso=inicio"); // una vez registrado lo redirigimos a dentro de la web
	       
		   }else if ($apodo_db  === $user and $email_db  !== $email){
	         header("location: inicio.php?modo=registro&error=usuario_usado"); // si ya existe el usuario lo redirigimos a la pagina principal
	       }else if ($email_db  === $email and $apodo_db  !== $user){
			 header("location: inicio.php?modo=registro&error=email_usado"); // si ya existe el email lo redirigimos a la pagina principal
           }else if ($email_db  === $email and $apodo_db  === $user){
			 header("location: inicio.php?modo=registro&error=email_usuario_usado"); // si ya existe el email lo redirigimos a la pagina principal
           }
	}
     // hay algo que falla enla linea 61, mira el minuto 43 de este video https://www.youtube.com/watch?v=mOrn77JTWcE&list=PLDQZoQpLCoUC202PnlREWNtC-6mNTwdbh&index=24
    public function claveperdida(){
      $db = new conexion();
	  $email = $db->real_escape_string($this->email); //esto es para la seguridad
	  $sql = $db->query("SELECT email FROM usuario WHERE email='$email';");
	  $existe = $db->recorrer($sql);
	  
	  if ($existe["email"] == $email){
	      include("generar.pass.php");//generamos la contraseña y la enviamos al correo electronico
	      $nueva = new generarpassword();
              $password = $nueva->nuevapassword(12);
              // ahora encricto la contraseña para meterla en la base de datos
              $salt = '$b7g2j6r$/'; // esto es una cadena para que se mezcle con la contraseña
	      $pass = $pass_original = sha1(md5($salt . $db->real_escape_string($password))); //esto es para la seguridad
	      
		  $db->query("UPDATE usuario SET pass='$pass' WHERE email='$email';");
		  mail($email, "Cambio de contraseña", "Estimado usuario hemos realizado el cambio de su contraseña a: $password");
		  
		  header("location: nuevo-password.php?modo=claveperdida&succes=ok");
		  
	  } else {
	        header("location: nuevo-password.php?modo=claveperdida&error=email_inexistente");
			}
			
    }

}
?>