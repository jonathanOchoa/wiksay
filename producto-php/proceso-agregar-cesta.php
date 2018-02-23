<?php
//error_reporting(0);
error_reporting(E_ALL);
ini_set('display_errors', true);

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
	
    // VERIFICO QUE SE A SELECCIONADO UN COLOR, UNA TALLA Y UNA CANTIDAD
	$verificar_producto_cantidad = $conexion->real_escape_string(utf8_decode($_POST['producto_cantidad'])); //cantidad de productos (OK)
	$verificar_producto_talla =    $conexion->real_escape_string(utf8_decode($_REQUEST['producto_talla'])); //talla del producto (OK)
	$verificar_producto_color =    $conexion->real_escape_string(utf8_decode($_REQUEST['producto_color'])); //color del producto (OK)
	
	if (isset($verificar_producto_cantidad) AND isset($verificar_producto_talla) AND isset($verificar_producto_color)){
		if (!empty($verificar_producto_cantidad) AND !empty($verificar_producto_talla) AND !empty($verificar_producto_color)){
		
            // aqui llamo el nombre usuario, id del usuario e id del producto seleccionado.
		    $nombre_usuario_url = $conexion->real_escape_string($_REQUEST['nombre_user']); // nombre del usuario que agrega el producto en la cesta (OK)
		    $id_usuario_url = 		  $conexion->real_escape_string(utf8_decode($_REQUEST['id_user'])); // id del usuario que agrega el producto en la cesta (OK)
		    $id_producto_url =    $conexion->real_escape_string($_REQUEST['id']); // id del producto (OK)
			
			// en este if compruebo si el nombre usuario coinciden.
			//   1)si los nombre usuario coinciden agrego el producto al carrito
			if(utf8_encode($id_usuario['id']) != $id_usuario_url) {header("location: ../producto.php?id=".$id_producto_url."&id mal");} else {
				if(utf8_encode($id_usuario['apodo']) != $nombre_usuario_url) {header("location: ../producto.php?id=".$id_producto_url."&usuario mal");} else {
			
					//a qui ya conecto con la bd para realizar el proceso
					$producto_id = 		 $conexion->real_escape_string(utf8_decode($_REQUEST['id'])); //id del producto (OK)
					$producto_cantidad = $conexion->real_escape_string(utf8_decode($_POST['producto_cantidad'])); //cantidad de productos (OK)
					$producto_talla =  	 $conexion->real_escape_string(utf8_decode($_REQUEST['producto_talla'])); //talla del producto (OK)
					$producto_color =  	 $conexion->real_escape_string(utf8_decode($_REQUEST['producto_color'])); //color del producto (OK)
					$nombre_usuario = 	 $conexion->real_escape_string(utf8_decode($_REQUEST['nombre_user'])); // nombre del usuario que agrega el producto en la cesta (OK)
					$usuario_id = 		 $conexion->real_escape_string(utf8_decode($_REQUEST['id_user'])); // id del usuario que agrega el producto en la cesta (OK)
					$fecha_actual =      date('Y-m-d H:i:s');

				 
					// sacamos la informacion de la tabla producto
					$conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
					$query = ("SELECT * FROM producto WHERE id='$producto_id';");
					$resultado = $conexion->query($query);
					$info_producto = $resultado->fetch_assoc();
				
						// codifico la informacion para que aparezca bien
						$producto_nombre1 = 	 	 utf8_encode($info_producto['nombre']);
						$producto_precio1 =   		 utf8_encode($info_producto['precio']);
						$producto_costes_envio1 =    utf8_encode($info_producto['costes_envio']);
						$producto_duracion_envio1 =  utf8_encode($info_producto['duracion_envio']);
						$producto_devolucion1 =      utf8_encode($info_producto['devolucion']);
						$producto_descripcion1 =     utf8_encode($info_producto['descripcion']);
					
						// vuelvo a codificar la informacion para introducirla en la bd
						$producto_nombre = 	 	    $conexion->real_escape_string(utf8_decode($producto_nombre1));
						$producto_precio =   		$conexion->real_escape_string(utf8_decode($producto_precio1));
						$producto_costes_envio =    $conexion->real_escape_string(utf8_decode($producto_costes_envio1));
						$producto_duracion_envio =  $conexion->real_escape_string(utf8_decode($producto_duracion_envio1));
						$producto_devolucion =      $conexion->real_escape_string(utf8_decode($producto_devolucion1));
						$producto_descripcion =     $conexion->real_escape_string(utf8_decode($producto_descripcion1));
				
							// insertamos la informacion en la tabla
							$conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
							$query = ("INSERT INTO cesta (usuario_id, producto_id, producto_nombre, producto_talla, producto_color, producto_cantidad, producto_precio,
										producto_costes_envio, producto_duracion_envio, producto_devolucion, producto_descripcion, fecha_actual) 
										VALUE ('$usuario_id', '$producto_id', '$producto_nombre', '$producto_talla', '$producto_color', '$producto_cantidad', '$producto_precio', 
										'$producto_costes_envio', '$producto_duracion_envio', '$producto_devolucion', '$producto_descripcion', '$fecha_actual')");
							$resultado = $conexion->query($query); // con esto le estamos diciendo que nos almacene los datos
			
							if ($resultado){
								header ("location: ../producto.php?id=".$id_producto_url."&bien");
							}else {
								header ("location: ../producto.php?id=".$id_producto_url."&proceso=registrarse");
							}   
				}
			}
		}else{header ("location: ../producto.php?id=".$_REQUEST['id']."&error1");}
	}else{header ("location: ../producto.php?id=".$_REQUEST['id']."&error2");}
?>