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
	  header("location: index.php?error=acceso");}	  
	  
    // todo esto es para mostrar el id y apodo del usuario
    $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
    $user = $_SESSION['user'];
	$usuario = utf8_decode($_SESSION['user']);
	$query = ("SELECT id, apodo FROM usuario WHERE apodo='$usuario';");
	$resultado = $conexion->query($query);
	$usuario = $resultado->fetch_assoc();	
     
	 $user_url = $conexion->real_escape_string($_REQUEST['user']);
     $user_id_url = $conexion->real_escape_string($_REQUEST['id']);
	/* combruebo: 1)si el apodo del usuario dado por url no es igual al apodo del usuario lo redirijo a la pagina tienda-vendedor.php
	              2)si el apodo del usuario dado por url es igual al apodo del usuario lo dejo entrar*/
	if (utf8_encode($usuario['apodo']) !== $user_url) {header("location: ../cliente.php");} else {
	    // combruebo: 1)si el id del usuario dado por url no es igual al id del usuario lo redirijo a la pagina tienda-vendedor.php, si es igual lo dejo pasar
	    if ($usuario['id'] !== $user_id_url) {header("location: ../cliente.php");} else {
		    
			// Eliminar todos los caracteres ilegales de correo electrónico y Validamos e-mail
			$email = filter_var(utf8_decode($_POST['email']), FILTER_SANITIZE_EMAIL);
			if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
			
				//a qui ya conecto con la bd para realizar el proceso
				$email = $conexion->real_escape_string(utf8_decode($_POST['email']));
				$informacion = $conexion->real_escape_string(utf8_decode($_POST['informacion']));
			
				mail("wiksaycomunicacion@hotmail.com", "Problema", "Enviado por $email .Contenido: $informacion");
			
				header ('location: ../informacion-problemas.php?proceso=email_enviado');

			}else{header("location: ../informacion-problemas.php?proceso=email_incorrectop");}
	    } // este es de la comprobacion del id de usuario
	}// este es de la comprobacion del apodo de usuario
?>