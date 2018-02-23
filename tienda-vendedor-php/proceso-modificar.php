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
	  
	/* aqui hago dos comprovaciones.
	   1) con el apodo del usuario busco el ide de la tienda que es ($id_tienda['id'])
	   2) con el id del producto mandado por url ($id_producto_url = $_REQUEST['id'];) busco el campo tienda_id al que pertenece.
	   3) los comparo para ver si son iguales o no
	*/
    // todo esto es para mostrar el id del usuario
    $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
    $usuario = utf8_decode($_SESSION['user']);
	$query = ("SELECT T.* FROM tienda T, usuario U WHERE T.usuario_id = U.id AND U.apodo='$usuario';");
	$resultado = $conexion->query($query);
	$id_tienda = $resultado->fetch_assoc();	

    // todo esto es para mostrar el id del usuario
    $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
    $id_producto_url = $conexion->real_escape_string($_REQUEST['id']);
	$query23 = ("SELECT * FROM producto WHERE id='$id_producto_url';");
	$resultado23 = $conexion->query($query23);
	$id_comprobar_producto = $resultado23->fetch_assoc();	
	/* combruebo: 1)si el id del usuario no es igual al id del usuario de la tienda lo redirijo a la pagina tienda-vendedor.php
	              2)si el id del usuario es igual al id del usuario de la tienda lo dejo entrar*/
	if($id_comprobar_producto['tienda_id'] != $id_tienda['id']) {header("location: ../tienda-vendedor.php?proceso=nomodificado");} else {
	  
	    //a qui ya conecto con la bd para realizar el proceso
		$conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
 
		$id = 				$conexion->real_escape_string($_REQUEST['id']);
        // aqui guardo el array en una variable para luego validar si la primera posicion esta vacia o no
		$colores_validar = $_POST['color'];
		$talla_validar = $_POST['talla'];
		$cantidad_validar = $_POST['cantidad'];
		
		// isset: verificamos si se envio el formulario de registro ,empty: es para comprobar si hay datos vacios o no, is_muneric: para ver si la variable es numerica o no		
		if (isset($_POST['nombre']) AND isset($_POST['precio']) AND isset($_POST['categoria_p_id']) AND isset($_POST['descripcion']) AND isset($_POST['color']) AND isset($_POST['talla']) AND isset($_POST['cantidad'])){
		 if (!empty($_POST['nombre']) AND !empty($_POST['precio']) AND !empty($_POST['categoria_p_id']) AND !empty($_POST['descripcion']) AND !empty($_POST['color']) AND !empty($_POST['talla']) AND !empty($_POST['cantidad']) AND !empty($colores_validar[0]) AND !empty($talla_validar[0]) AND !empty($cantidad_validar[0])){ 
		 
			$nombre = 			$conexion->real_escape_string(utf8_decode($_POST['nombre']));//obligatorio
			$precio = 			$conexion->real_escape_string(utf8_decode($_POST['precio']));//obligatorio
			if (isset($_POST['costes_envio'])) {$costes_envio = $conexion->real_escape_string(utf8_decode($_POST['costes_envio']));}else{$costes_envio = "";}
			if (isset($_POST['duracion_envio'])) {$duracion_envio = $conexion->real_escape_string(utf8_decode($_POST['duracion_envio']));}else{$duracion_envio = "";}
			if (isset($_POST['devolucion'])) {$devolucion = $conexion->real_escape_string(utf8_decode($_POST['devolucion']));}else{$devolucion = "";}
			if (isset($_POST['url'])) {$url = $conexion->real_escape_string(utf8_decode($_POST['url']));}else{$url = "";}
			if (isset($_POST['cantidad'])) {$cantidad = $conexion->real_escape_string(utf8_decode($_POST['cantidad']));}else{$cantidad = "";}
			$categoria_p_id = 	$conexion->real_escape_string(utf8_decode($_POST['categoria_p_id']));//obligatorio
			$descripcion = 		$conexion->real_escape_string(utf8_decode($_POST['descripcion']));//obligatorio
			$fecha_modificado = date('Y-m-d H:i:s');

				$query1 = ("UPDATE producto SET nombre='$nombre', precio='$precio', costes_envio='$costes_envio', duracion_envio='$duracion_envio', 
							devolucion='$devolucion', url='$url', cantidad='$cantidad', categoria_p_id='$categoria_p_id', descripcion='$descripcion', 
							fecha_modificado='$fecha_modificado' WHERE id='$id';");
				$query2 = ("DELETE FROM color WHERE producto_id='$id';");
                            $resultado1 = $conexion->query($query1);// con esto le estamos diciendo que nos almacene los datos
							$resultado2 = $conexion->query($query2);// con esto le estamos diciendo que nos almacene los datos
							
                                    if ($resultado1 AND $resultado2){
										    // UNA VEZ CREADO EL PRODUCTO LLAMO EL ID DE ESE PRODUCTO
											$query66 = ("SELECT id FROM producto WHERE id='$id';"); 
											$resultado66 = $conexion->query($query66);
											$id_de_producto = $resultado66->fetch_assoc();
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
																$resultado3 = $conexion->query($query2);// con esto le estamos diciendo que nos almacene los datos
														
																if ($resultado3){
																	header ('location: ../listar-productos-modificar.php?id='.$id.'&proceso=info');
																}else {
																	  header ('location: ../listar-productos-modificar.php?id='.$id.'&error');
																	  }
																	  
															}else { header ('location: ../listar-productos-modificar.php?id='.$id.'&proceso=info');}			
														}else { header ('location: ../listar-productos-modificar.php?id='.$id.'&proceso=info');}
													}else { header ('location: ../listar-productos-modificar.php?id='.$id.'&proceso=info');}
												}else { header ('location: ../listar-productos-modificar.php?id='.$id.'&proceso=info');}
											}	  
									}else {
										   header ('location: ../listar-productos-modificar.php?id='.$id.'&error');
										  }						  
		 }else{header("location: ../listar-productos-modificar.php?id=".$id." hay campos vacios");}			
	    }else{header("location: ../listar-productos-modificar.php?id=".$id." hay campos vacios");}	
	}										  
?>

