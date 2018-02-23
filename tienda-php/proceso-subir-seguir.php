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
	// aqui llamo al id del usuario que quiere dejar de seguir a la tienda y el nombre de dicha tienda por $_REQUEST
	    $nombre_tienda_url =      $conexion->real_escape_string($_REQUEST['nombre_tienda']); //nombre de la tienda (OK)
	    $usuario_id_url = $conexion->real_escape_string($_REQUEST['id_user']); //usuario_id que quiere seguir la tienda (OK)
		$nombre_usuario_url = 		 $conexion->real_escape_string($_REQUEST['nombre_user']); // nombre del usuario que quiere seguir la tienda (OK)
	// en este if compruebo si el id coinciden.
	//   1)si los id coinciden los dejo elimijar el megusta sino los devuelvo al producto
	if($id_usuario['id'] != $usuario_id_url) {header("location: ../tienda.php?nombre=".$nombre_tienda_url."");} else {
	
		if(utf8_encode($id_usuario['apodo']) != $nombre_usuario_url) {header("location: ../tienda.php?nombre=".$nombre_tienda_url."");} else {
			
			//a qui ya conecto con la bd para realizar el proceso
			$conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db

			$tienda_id = 			 $conexion->real_escape_string(utf8_decode($_REQUEST['id_tienda'])); //este es el ide de la tienda que visitas (OK)
			$nombre_tienda =  		 $conexion->real_escape_string(utf8_decode($_REQUEST['nombre_tienda'])); //nombre de la tienda (OK)
			$tienda_usuario_id =  	 $conexion->real_escape_string(utf8_decode($_REQUEST['usuario_id'])); //usuario_id de esa tienda (OK)
			$usuario_id =			 $conexion->real_escape_string(utf8_decode($_REQUEST['id_user'])); //usuario_id que quiere seguir la tienda (OK)
			$nombre_usuario = 		 $conexion->real_escape_string(utf8_decode($_REQUEST['nombre_user'])); // nombre del usuario que quiere seguir la tienda (OK)
			$nombre_tienda_usuario = $conexion->real_escape_string(utf8_decode($_REQUEST['nombre_tienda_usuario'])); // nombre de la tienda del usuario que quiere seguir la tienda (OK)
			$fecha_actual = date('Y-m-d H:i:s');

			$query1 = ("SELECT tienda_usuario_id, usuario_id FROM seguimiento WHERE tienda_usuario_id='$tienda_usuario_id' AND usuario_id='$usuario_id'");
			$resultado = $conexion->query($query1);// con esto le estamos diciendo que nos almacene los datos
			$existe_tienda = $resultado->fetch_assoc();

				if ( $existe_tienda['tienda_usuario_id'] == $tienda_usuario_id AND $existe_tienda['usuario_id'] == $usuario_id){
				// si existe no hagas nada:
					header ("location: ../tienda.php?nombre=".$nombre_tienda."");
				}else {
					  // si no existe haz esto:
					  $query = ("INSERT INTO seguimiento (nombre_tienda, tienda_id, usuario_id, tienda_usuario_id, nombre_usuario, nombre_tienda_usuario, fecha_alta) VALUE ('$nombre_tienda', '$tienda_id', '$usuario_id', '$tienda_usuario_id', '$nombre_usuario', '$nombre_tienda_usuario', '$fecha_actual')");
					  $resultado = $conexion->query($query); // con esto le estamos diciendo que nos almacene los datos
						
						if ($resultado){
								
							$query2 = ("INSERT INTO notificacion (tienda_id, nombre_tienda, producto_id, nombre_producto, usuario_id, nombre_usuario, comentario_id, estado, tipo, fecha_alta ) VALUE ('$tienda_id', '$nombre_tienda', '0', '', '$usuario_id', '$nombre_usuario', '', '0', '1 seguidores', '$fecha_actual')");
							$resultado2 = $conexion->query($query2); // con esto le estamos diciendo que nos almacene los datos	
									
									if ($resultado2){
										header ("location: ../tienda.php?nombre=".$nombre_tienda_url."");
									}else {
										   header ("location: ../tienda.php?nombre=".$nombre_tienda_url."");
										  }
						}else {
							  header ("location: ../tienda.php?nombre=".$nombre_tienda_url."");
	                          }
                }
        }
	}
?>