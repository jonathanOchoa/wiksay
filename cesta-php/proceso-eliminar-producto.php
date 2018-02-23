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
	// aqui llamo al id del usuario que quiere dejar de seguir a la tienda por $_REQUEST
	    $usuario_id_url = $conexion->real_escape_string($_REQUEST['id_user']); //usuario_id que quiere seguir la tienda (OK)
	// en este if compruebo si el id coinciden.
	//   1)si los id coinciden los dejo elimijar el megusta sino los devuelvo al producto
	if($id_usuario['id'] != $usuario_id_url) {header("location: ../cesta.php?error");} else {
		
		//a qui ya conecto con la bd para realizar el proceso
		$conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db

		$producto_id =  $conexion->real_escape_string(utf8_decode($_REQUEST['producto_id'])); //id del producto que se añade a la cesta (OK)
		$usuario_id = 	$conexion->real_escape_string(utf8_decode($_REQUEST['id_user'])); //id del usuario que lo añade a la cesta (OK)
        $cesta_id = 	$conexion->real_escape_string(utf8_decode($_REQUEST['cesta_id'])); //el id de la columna de la cesta del producto (OK)
		
		$query = ("DELETE FROM cesta WHERE producto_id='$producto_id' AND usuario_id='$usuario_id' AND idcesta='$cesta_id'");
		$resultado = $conexion->query($query);// con esto le estamos diciendo que nos almacene los datos

			if ($resultado){
				header ("location: ../cesta.php?bien");
			}else {
				   header ("location: ../cesta.php?mal");
				  }
	}
?>