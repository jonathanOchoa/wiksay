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
	// aqui llamo al id del producto y el id del usuario mandados por $_REQUEST
	    $id_producto_url =      $conexion->real_escape_string($_REQUEST['producto_id']); //este es el id del producto que visitas (OK)
	    $usuario_id_url =          $conexion->real_escape_string($_REQUEST['id_user']); //usuario_id que quiere seguir la tienda (OK)
	// en este if compruebo si el id coinciden.
	//   1)si los id coinciden los dejo elimijar el megusta sino los devuelvo al producto
	if($id_usuario['id'] != $usuario_id_url) {header("location: ../likes.php");} else {
		
		//a qui ya conecto con la bd para realizar el proceso
		$conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
 
		$producto_id =  $conexion->real_escape_string(utf8_decode($_REQUEST['producto_id'])); //id del producto (OK)
		$id_user =      $conexion->real_escape_string(utf8_decode($_REQUEST['id_user'])); //usuario_id que quiere darle a me gusta a ese producto (OK)
		$tienda_id =		$conexion->real_escape_string(utf8_decode($_REQUEST['tienda_id'])); //este es el id de la tienda que lo vende (OK)
		$nombre_tienda =    $conexion->real_escape_string(utf8_decode($_REQUEST['nombre_tienda'])); //este es el nombre de la tienda que lo vende (OK)

		$query = ("DELETE FROM megusta WHERE producto_id='$producto_id' AND usuario_id='$id_user'");
		$resultado = $conexion->query($query);// con esto le estamos diciendo que nos almacene los datos

		if ($resultado){
			header ("location: ../likes.php");
		}else {
			   header ("location: ../likes.php");
			  }
	}
?>