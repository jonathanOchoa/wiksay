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
	// aqui llamo al id del producto y el id y apodo del usuario mandados por $_REQUEST
	    $id_producto_url =      $conexion->real_escape_string($_REQUEST['producto_id']); //este es el id del producto que visitas (OK)
	    $usuario_id_url =          $conexion->real_escape_string($_REQUEST['id_user']); //usuario_id que quiere seguir la tienda (OK)
		$usuario_emisor_url =   $conexion->real_escape_string($_REQUEST['nombre_usuario']); // nombre del usuario que quiere darle a megusa al producto(OK)
	// en este if compruebo si el id y el apodo coinciden.
	//   1)si los id coinciden los dejo pasar a la siguiente pregunta sino los devuelvo al producto
	if($id_usuario['id'] != $usuario_id_url) {header("location: ../likes.php");} else {
	    //2)si los apodos coinciden los dejo guardar el comentario, sino los devuelvo al producto
	    if(utf8_encode($id_usuario['apodo']) != $usuario_emisor_url) {header("location: ../likes.php");} else {
		
			//a qui ya conecto con la bd para realizar el proceso
			$conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
 
			$producto_id =      $conexion->real_escape_string(utf8_decode($_REQUEST['producto_id'])); //este es el id del producto que visitas (OK)
			$nombre_producto =  $conexion->real_escape_string(utf8_decode($_REQUEST['nombre_producto'])); //nombre del producto (OK)
			$id_user =          $conexion->real_escape_string(utf8_decode($_REQUEST['id_user'])); //usuario_id que quiere seguir la tienda (OK)
			$nombre_usuario =   $conexion->real_escape_string(utf8_decode($_REQUEST['nombre_usuario'])); // nombre del usuario que quiere darle a megusa al producto(OK)
			$fecha_actual = date('Y-m-d H:i:s');

			$query1 = ("SELECT producto_id, usuario_id FROM megusta WHERE producto_id='$producto_id' AND usuario_id='$id_user'");
			$resultado = $conexion->query($query1);// con esto le estamos diciendo que nos almacene los datos
			$existe_producto = $resultado->fetch_assoc();

				if ( $existe_producto['producto_id'] == $producto_id AND $existe_producto['usuario_id'] == $id_user){
				// si existe no hagas nada:
					header ("location: ../likes.php");
				}else {
					  // si no existe haz esto:
					  $query = ("INSERT INTO megusta (nombre_producto, producto_id, usuario_id, nombre_usuario, fecha_alta) VALUE ('$nombre_producto', '$producto_id', '$id_user', '$nombre_usuario', '$fecha_actual')");
					  $resultado = $conexion->query($query); // con esto le estamos diciendo que nos almacene los datos
			
							if ($resultado){
									header ("location: ../likes.php");
							}else {
								   header ("location: ../likes.php");
	                              }
				}
        }
    }  




?>