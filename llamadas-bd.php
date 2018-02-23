    <?php
	// REPETIR EN TODOS
	    // 1 CLIENTE, CLIENTE PRODUCTO, CLIENTE TIENDA, CESTA, ELIMINAR CUENTA, ELIMINAR TIENDA, INFORMACION PROBLEMAS, LIKES, SIGUIENDO, MAPA, AYUDA, BUSCAR TIENDA, CONFIGURACION USUARIO  PHP
		// 1 y 2 NOTIFICACIONES, CREAR TIENDA, TIENDA, TIENDA VENDEDOR, CONFIGURACION TIENDA, SUBIR PRODUCTOS, ME SIGUEN, ERROR 500 404 403 401 400 PHP
        // 1 y 3 PRODUCTO, LISTAR PRODUCTOS MODIFICAR PHP
		
		// aqui buscamos el id del usuario
		$conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
		$query = ("SELECT id, apodo FROM usuario WHERE apodo='$usuario';");
		$resultado = $conexion->query($query);
		$id_user = $resultado->fetch_assoc();
		
		// aqui buscamos el id de la tienda
		$conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
		$query = ("SELECT T.id, T.* FROM usuario U, tienda T WHERE T.usuario_id = U.id AND U.apodo='$usuario';");
		$resultado = $conexion->query($query);
		$id_tienda = $resultado->fetch_assoc();
		
		// aqui buscamos el id del producto
		$conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
		if(isset($_REQUEST['id'])){$id_producto_url = $conexion->real_escape_string($_REQUEST['id']);}else{$id_producto_url="";}
		 //aqui estoy llamando el id del producto de la tienda que el usuario visita..........................................................................
		$query = ("SELECT id, tienda_id FROM producto WHERE id='$id_producto_url';");
		$resultado = $conexion->query($query);
		$producto_id = $resultado->fetch_assoc();	
	?>
	
	
	