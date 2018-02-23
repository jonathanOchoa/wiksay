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
	  echo $user = $_SESSION['user'];
	  
    // todo esto es para mostrar el id del usuario
    $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
    $user = $_SESSION['user'];
	$query = ("SELECT * FROM usuario WHERE apodo='$user';");
	$resultado = $conexion->query($query);
	$id_usuario = $resultado->fetch_assoc();	
	// aqui llamo al id mandado por url
    $id_usuario_url = $conexion->real_escape_string($_REQUEST['id']);
	/* en este if compruebo si los dos id coinciden.
	   1)si coinciden lo dejo realizar el proceso de subida
	   2)si no coincioden lo mando directamente a la tienda */
	if($id_usuario['id'] != $id_usuario_url) {header("location: ../cliente.php?proceso=nomodificado");} else {
	  
	    //a qui ya conecto con la bd para realizar el proceso
		$conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db

		$id = $conexion->real_escape_string($_REQUEST['id']);
		
		// verificamos si se envio el formulario de registro Y empty es para comprobar si hay datos vacios o no		
		if (isset($_FILES['imagen']['tmp_name']) AND !empty($_FILES['imagen']['tmp_name'])){ 
			
				$imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));

					$query1 = ("UPDATE usuario SET imagen='$imagen' WHERE id='$id'");   
					$resultado = $conexion->query($query1);// con esto le estamos diciendo que nos almacene los datos en la tabla usuario

						if ($resultado){
							header ("location: ../configuracion-tienda.php?id=".$id."&proceso=imag");
						}else {
							   echo 'error';
							  }
							  
		}else{header("location: ../configuracion-tienda.php?id=".$id."");}							
	}
?>