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
	$query = ("SELECT * FROM usuario WHERE apodo='$usuario'");
	$resultado = $conexion->query($query);
	$id_usuario = $resultado->fetch_assoc();	
	// aqui llamo al id del producto y el id y apodo del usuario mandados por $_POST
	$id_producto_url = $conexion->real_escape_string($_REQUEST['producto_id']);
	$usuario_id_post = $conexion->real_escape_string($_POST['usuario_id']);
    $usuario_emisor_post = $conexion->real_escape_string($_POST['usuario_emisor']);
	// en este if compruebo si el id y el apodo coinciden.
	//   1)si los id coinciden los dejo pasar a la siguiente pregunta sino los devuelvo al producto
	if($id_usuario['id'] != $usuario_id_post) {header("location: ../producto.php?id=".$id_producto_url."");} else {
	    //2)si los apodos coinciden los dejo guardar el comentario, sino los devuelvo al producto
	    if(utf8_encode($id_usuario['apodo']) != $usuario_emisor_post) {header("location: ../producto.php?id=".$id_producto_url."");} else {
			// verificamos si la variable esta definida Y empty es para comprobar si hay datos vacios o no
		    if (isset($_POST['comentario_emisor']) AND !empty($_POST['comentario_emisor'])){ 
				
				//a qui ya conecto con la bd para realizar el proceso
				$conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
			
				$comentario_emisor = $conexion->real_escape_string(utf8_decode($_POST['comentario_emisor'])); // es el comentario que escribe el usuario
				$usuario_id = 		 $conexion->real_escape_string(utf8_decode($_POST['usuario_id'])); // el id del usuario que lo escribe.
				$usuario_emisor = 	 $conexion->real_escape_string(utf8_decode($_POST['usuario_emisor'])); // es el que escribe el mensaje
				$tienda_id = 		 $conexion->real_escape_string(utf8_decode($_REQUEST['tienda_id'])); //este es el ide de la tienda que visitas (OK)
			    $nombre_tienda =  	 $conexion->real_escape_string(utf8_decode($_REQUEST['nombre_tienda'])); //nombre de la tienda (OK)
				$producto_id = 		 $conexion->real_escape_string($_REQUEST['producto_id']);
				$nombre_producto =   $conexion->real_escape_string(utf8_decode($_REQUEST['nombre_producto'])); //nombre del producto (OK)
				$fecha_actual = date('Y-m-d H:i:s');

					$query = ("INSERT INTO comentario (usuario_emisor, comentario_emisor, producto_id, usuario_id, fecha_publicacion) VALUE ('$usuario_emisor','$comentario_emisor','$producto_id','$usuario_id','$fecha_actual')");
					$resultado = $conexion->query($query);// con esto le estamos diciendo que nos almacene los datos

					if ($resultado){
							$conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
							$query = ("SELECT id FROM comentario WHERE usuario_id='$usuario_id' AND producto_id='$producto_id' AND comentario_emisor='$comentario_emisor'");
							$resultado = $conexion->query($query);
							$comentario = $resultado->fetch_assoc();
							$comentario_id = $comentario['id'];
					
							$query2 = ("INSERT INTO notificacion (tienda_id, nombre_tienda, producto_id, nombre_producto, usuario_id, nombre_usuario, comentario_id, estado, tipo, fecha_alta ) VALUE ('$tienda_id', '$nombre_tienda', '$producto_id', '$nombre_producto', '$usuario_id', '$usuario_emisor', '$comentario_id', '0', '4 comentario', '$fecha_actual')");
							$resultado2 = $conexion->query($query2); // con esto le estamos diciendo que nos almacene los datos	
									
									if ($resultado2){
										header ("location: ../producto.php?id=".$producto_id.""); 
									}else {
										   header("location: ../producto.php?id=".$producto_id."");
										  }					
					}else {
						  header("location: ../producto.php?id=".$producto_id."");
						  }
						  
			}else{header("location: ../producto.php?id=".$id_producto_url."");}			  
		}
	}
?>