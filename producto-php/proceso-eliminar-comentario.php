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
	$id_producto_url = $conexion->real_escape_string($_REQUEST['producto_id']);
	$usuario_id_url = $conexion->real_escape_string($_REQUEST['usuario_id']);
    $usuario_emisor_url = $conexion->real_escape_string($_REQUEST['usuario_emisor']);
	// en este if compruebo si el id y el apodo coinciden.
	//   1)si los id coinciden los dejo pasar a la siguiente pregunta sino los devuelvo al producto
	if($id_usuario['id'] != $usuario_id_url) {header("location: ../producto.php?id=".$id_producto_url."");} else {
	    //2)si los apodos coinciden los dejo guardar el comentario, sino los devuelvo al producto
	    if(utf8_encode($id_usuario['apodo']) != $usuario_emisor_url) {header("location: ../producto.php?id=".$id_producto_url."");} else {
		
			//a qui ya conecto con la bd para realizar el proceso
			$conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db

			$usuario_emisor = $conexion->real_escape_string(utf8_decode($_REQUEST['usuario_emisor'])); // usuario que escribe el mensaje
			$usuario_id = 	  $conexion->real_escape_string(utf8_decode($_REQUEST['usuario_id'])); // el id del usuario que lo escribe.
			$comentario_id =  $conexion->real_escape_string(utf8_decode($_REQUEST['comentario_id'])); // id del comentario
			$producto_id =    $conexion->real_escape_string(utf8_decode($_REQUEST['producto_id'])); // id del producto
            $tienda_id = 	  $conexion->real_escape_string(utf8_decode($_REQUEST['tienda_id'])); //este es el ide de la tienda que visitas (OK)
			$nombre_tienda =  $conexion->real_escape_string(utf8_decode($_REQUEST['nombre_tienda'])); //nombre de la tienda (OK)
			
			$query = ("DELETE FROM comentario WHERE id='$comentario_id' AND usuario_emisor='$usuario_emisor'"); // eliminame los comentarios de ste producto
			$eliminado = $conexion->query($query);// con esto le estamos diciendo que nos almacene los datos

				if ($eliminado){
				
					$query2 = ("DELETE FROM notificacion WHERE comentario_id='$comentario_id' AND tienda_id='$tienda_id' AND nombre_tienda='$nombre_tienda' AND usuario_id='$usuario_id' AND producto_id='$producto_id' AND tipo='4 comentario'");
					$resultado2 = $conexion->query($query2);// con esto le estamos diciendo que nos almacene los datos

						if ($resultado2){
							header ("location: ../producto.php?id=".$producto_id."&1");
						}else {
							   header ("location: ../producto.php?id=".$producto_id."&2");
							  }
				}else {
					   header ("location: ../producto.php?id=".$producto_id."&3");
					  }
		}
	}
?>