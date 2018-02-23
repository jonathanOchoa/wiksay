<?php 
    $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
	$nombre_tienda = utf8_decode($_REQUEST['nombre']);
	$query = ("SELECT T.*, U.imagen FROM tienda T, usuario U WHERE U.id=T.usuario_id AND T.nombre_tienda='$nombre_tienda';");
	$resultado = $conexion->query($query);
	$informacion = $resultado->fetch_assoc()
?>
<?php 
    // esto es para mostrar cuantos productos tiene en la tienda el usuario que estoy viendo en www.wiksay/tienda?nombre=......
    $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
	$id = $informacion['id'];
	$query2 = ("SELECT COUNT(*) as id FROM producto WHERE tienda_id='$id';");
	$resultado = $conexion->query($query2);
	$numero_productos = $resultado->fetch_assoc()
?>

<?php 
		// busco el ide del usuario de esa tienda para buscar los seguidores y a quienes siguen de esos usuarios
			$conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
			$nombre_tienda = utf8_decode($_REQUEST['nombre']);
			$query = ("SELECT id FROM usuario WHERE apodo='$nombre_tienda';");
			$resultado = $conexion->query($query);
			$informacion_id_usuario = $resultado->fetch_assoc()
?>
<?php 
        // esto es para mostrar cuantos usuarios estoy siguiendo
             $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
			 $id = $informacion_id_usuario['id'];
			 $query2 = ("SELECT COUNT(*) as usuario_id FROM seguimiento WHERE usuario_id='$id';");
		     $resultado = $conexion->query($query2);
			 $siguiendo = $resultado->fetch_assoc()
?>
<?php 
        // esto es para mostrar cuantos usuarios me siguen
             $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
			 $id = $informacion_id_usuario['id'];
			 $query2 = ("SELECT COUNT(*) as tienda_usuario_id FROM seguimiento WHERE tienda_usuario_id='$id';");
		     $resultado = $conexion->query($query2);
			 $me_siguen = $resultado->fetch_assoc()
?>
