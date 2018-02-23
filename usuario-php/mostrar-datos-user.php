<?php 
             $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
		     //$usuario = utf8_decode($_SESSION['user']); como es un include lo estoy llamando en la pagina.php que lo estoy incluyendo
			 $query = ("SELECT * FROM usuario WHERE apodo='$usuario';");
		     $resultado = $conexion->query($query);
			 $informacion = $resultado->fetch_assoc();
?>

<?php 
             $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
                // $usuario = utf8_decode($_SESSION['user']); como es un include lo estoy llamando en la pagina.php que lo estoy incluyendo
			 $id= $informacion['id']; // aqui estoy llamando el id de usuario, lo estraigo directamente del SELECT que tengo justo arriba.
	         $query = ("SELECT N.* FROM networking N, usuario U WHERE U.apodo='$usuario' AND usuario_id='$id';"); 
	         $resultado = $conexion->query($query);
	         $social = $resultado->fetch_assoc();
?>

<?php 
			// esto es para mostrar cuantos productos tengo en mi tienda
			$conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
			$id= $informacion['id']; // aqui estoy llamando el id de usuario, lo estraigo directamente del SELECT que tengo justo arriba.
	        $query2 = ("SELECT id FROM tienda WHERE usuario_id='$id';");
			$resultado2 = $conexion->query($query2);
			$id_tienda_solo = $resultado2->fetch_assoc(); // este $id_tienda_solo solo lo uso en la busqueda sql de abajo

			// esto es para mostrar cuantos productos tengo en mi tienda
			$conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
			$id_usuario_para_buscar_numero_producto = $id_tienda_solo['id']; //este es el id del usuario 
			$query2 = ("SELECT COUNT(*) as id FROM producto WHERE tienda_id='$id_usuario_para_buscar_numero_producto';");
			$resultado2 = $conexion->query($query2);
			$numero_productos_mios = $resultado2->fetch_assoc();
?>