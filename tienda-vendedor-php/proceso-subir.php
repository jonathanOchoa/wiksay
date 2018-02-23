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
	$query = ("SELECT T.* FROM tienda T, usuario U WHERE T.usuario_id = U.id AND U.apodo='$usuario';");
	$resultado = $conexion->query($query);
	$id_tienda = $resultado->fetch_assoc();	
	// aqui llamo al ide mandado por url
    $id_tienda_url = $conexion->real_escape_string($_REQUEST['id']);
	/* en este if compruebo si los dos id coinciden.
	   1)si coinciden lo dejo realizar el proceso de subida
	   2)si no coincioden lo mando directamente a la tienda */
	if($id_tienda['id'] != $id_tienda_url) {header("location: ../tienda-vendedor.php?proceso=malsubido");} else {
	  
	    //a qui ya conecto con la bd para realizar el proceso
		$conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
			
		$id = $conexion->real_escape_string($_REQUEST['id']);
		// aqui guardo el array en una variable para luego validar si la primera posicion esta vacia o no
		$colores_validar = $_POST['color'];
		$talla_validar = $_POST['talla'];
		$cantidad_validar = $_POST['cantidad'];

		//if (!empty($colores[0])){echo'si';}else{echo'no';}
		// isset: verificamos si se envio el formulario de registro ,empty: es para comprobar si hay datos vacios o no, is_muneric: para ver si la variable es numerica o no
		if ( isset($_FILES['imagen']['tmp_name']) AND isset($_POST['nombre']) AND isset($_POST['precio']) AND isset($_POST['categoria_p_id']) AND isset($_POST['descripcion'])){ 
		 if ( !empty($_FILES['imagen']['tmp_name']) AND !empty($_POST['nombre']) AND !empty($_POST['precio']) AND !empty($_POST['categoria_p_id']) AND !empty($_POST['descripcion']) AND !empty($colores_validar[0]) AND !empty($talla_validar[0]) AND !empty($cantidad_validar[0])){ 
		 
			$imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name'])); //obligatorio
			if (isset($_FILES['imagen2']['tmp_name'])) {$imagen2 = addslashes(file_get_contents($_FILES['imagen2']['tmp_name'])); }else{$imagen2 = "";}
			if (isset($_FILES['imagen3']['tmp_name'])) {$imagen3 = addslashes(file_get_contents($_FILES['imagen3']['tmp_name'])); }else{$imagen3 = "";}
			$nombre = 			$conexion->real_escape_string(utf8_decode($_POST['nombre'])); //obligatorio
			$precio = 			$conexion->real_escape_string($_POST['precio']); //obligatorio
			if (isset($_POST['costes_envio'])) {$costes_envio = $conexion->real_escape_string(utf8_decode($_POST['costes_envio']));}else{$costes_envio = "";}
			if (isset($_POST['duracion_envio'])) {$duracion_envio = $conexion->real_escape_string(utf8_decode($_POST['duracion_envio']));}else{$duracion_envio = "";}
			if (isset($_POST['devolucion'])) {$devolucion = $conexion->real_escape_string(utf8_decode($_POST['devolucion']));}else{$devolucion = "";}
			if (isset($_POST['url'])) {$url = $conexion->real_escape_string(utf8_decode($_POST['url']));}else{$url = "";}
			$categoria_p_id = 	$conexion->real_escape_string(utf8_decode($_POST['categoria_p_id'])); //obligatorio
			$descripcion = 		$conexion->real_escape_string(utf8_decode($_POST['descripcion'])); //obligatorio
			$fecha_actual = date('Y-m-d H:i:s');
	        
                $query1 = ("INSERT INTO producto (imagen, imagen2, imagen3, nombre, precio, costes_envio, duracion_envio, devolucion, url, descripcion, fecha_alta, tienda_id, categoria_p_id)
						    VALUE('$imagen','$imagen2','$imagen3','$nombre','$precio','$costes_envio','$duracion_envio','$devolucion','$url','$descripcion','$fecha_actual','$id','$categoria_p_id')");
						
                        $resultado = $conexion->query($query1);// con esto le estamos diciendo que nos almacene los datos
						if ($resultado){
						        // UNA VEZ CREADO EL PRODUCTO LLAMO EL ID DE ESE PRODUCTO
								$query66 = ("SELECT id FROM producto WHERE nombre='$nombre' AND precio='$precio' AND costes_envio='$costes_envio' AND duracion_envio='$duracion_envio' AND devolucion='$devolucion' AND url='$url' AND categoria_p_id='$categoria_p_id' AND descripcion='$descripcion';"); 
								$resultado = $conexion->query($query66);
								$id_de_producto = $resultado->fetch_assoc();
								$id_producto = $id_de_producto['id'];
											
								// INTRODUSCO LOS COLORES, TALLAS Y CANTIDADES EN LA BD DE LA TABLA COLOR realizando el ciclo
								while(list($key,$colores) = each($_POST['color']) AND list($key,$tallas) = each($_POST['talla']) AND list($key,$cantidades) = each($_POST['cantidad'])) {
									if(is_array($_POST['color']) AND is_array($_POST['talla']) AND is_array($_POST['cantidad'])){
										if($colores != ""){
											if($tallas != ""){
												if($cantidades != ""){
																
													$colores1 = utf8_decode($colores);
													$tallas1 = utf8_decode($tallas);
													$cantidades1 = utf8_decode($cantidades);
													$query2 = ("INSERT INTO color (producto_id, nombre_color, nombre_talla, nombre_cantidad) VALUES ('$id_producto','$colores1','$tallas1','$cantidades1')");
													$resultado2 = $conexion->query($query2);// con esto le estamos diciendo que nos almacene los datos
														
													if ($resultado2){
														header ('location: ../tienda-vendedor.php?proceso=subido');
													}else {
														   header ('location: ../subir-producto.php?error al subir el articulo3');
														  }
																	  
												}else { header ('location: ../tienda-vendedor.php?proceso=subido');}			
											}else { header ('location: ../tienda-vendedor.php?proceso=subido');}
										}else { header ('location: ../tienda-vendedor.php?proceso=subido');}
									}else { header ('location: ../subir-producto.php?error al subir el articulo2');}
								}		  
						}else { header ('location: ../subir-producto.php?error al subir el articulo');}
		 }else{header("location: ../subir-producto.php?1");}		
	    }else{header("location: ../subir-producto.php");}	
	}
?>