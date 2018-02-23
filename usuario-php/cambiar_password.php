<?php
error_reporting(0);
//error_reporting(E_ALL);
//ini_set('display_errors', true);

session_start();

if(isset($_SESSION["user"])){
  //echo"Bienvenido", $_SESSION["user"];
}else{//si la secion se inicio mal, se destrira y se redirige a la pagina principal
      session_start();
	  session_destroy();
	  header("location: index.php?error=acceso");
      }
	  $user = $_SESSION['user'];
	  
    // todo esto es para mostrar el id del usuario
    $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
    $usuario = utf8_decode($_SESSION['user']);
	$query = ("SELECT * FROM usuario WHERE apodo='$usuario';");
	$resultado = $conexion->query($query);
	$id_usuario = $resultado->fetch_assoc();	
	// aqui llamo al id mandado por url
    $id_usuario_url = $conexion->real_escape_string($_REQUEST['id']);
	/* en este if compruebo si los dos id coinciden.
	   1)si coinciden lo dejo realizar el proceso de subida
	   2)si no coincioden lo mando directamente a la tienda */
	   	$id_usuario['id'];
	   	$id_usuario_url;
	if($id_usuario['id'] != $id_usuario_url) {header("location: ../cliente.php?proceso=nomodificado");} else {
	  
	    //a qui ya conecto con la bd para realizar el proceso
		$conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
		$id = $conexion->real_escape_string($_REQUEST['id']);
		$query = ("SELECT pass FROM usuario WHERE id='$id';");
		$resultado = $conexion->query($query);
		$password = $resultado->fetch_assoc();	
	
		$salt = '$b7g2j6r$/'; // esto es una cadena para que se mezcle con la contraseña
	        $contraseña = sha1(md5($salt . $conexion->real_escape_string($_POST['contraseña']))); //esto es para la seguridad
	        
	        $repetir_contraseña = sha1(md5($salt . $conexion->real_escape_string($_POST['repetir_contraseña']))); //esto es para la seguridad
	        
	        $nueva_contraseña = sha1(md5($salt . $conexion->real_escape_string($_POST['nueva_contraseña']))); //esto es para la seguridad
	        
		if ($password['pass'] == $contraseña){
		
		    if ($nueva_contraseña == $repetir_contraseña) {
	
					$query2 = ("UPDATE usuario SET pass='$nueva_contraseña' WHERE id='$id'");
					$resultado2 = $conexion->query($query2);// con esto le estamos diciendo que nos almacene los datos en la tabla usuario
					if ($resultado2){
									header ("location: ../configuracion-tienda.php?id=".$id."&proceso=password");
					}else {
                           header ("location: ../configuracion-tienda.php?id=".$id."&");
	                       }
			}else{
			      header ("location: ../configuracion-tienda.php?id=".$id."&proceso=diferentespassword");
	             } 
            
		}else{
			  header ("location: ../configuracion-tienda.php?id=".$id."&proceso=malpassword");
	         }
	}			
?>