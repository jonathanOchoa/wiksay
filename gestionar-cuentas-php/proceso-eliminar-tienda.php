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
	  header("location: index.php?error=acceso");}	  
	  
    // todo esto es para mostrar el id y apodo del usuario
    $conexion = new mysqli ("localhost", "root", "", "wiksay"); // conexion a la db
    $user = $_SESSION['user'];
	$usuario = utf8_decode($_SESSION['user']);
	$query = ("SELECT id, apodo FROM usuario WHERE apodo='$usuario';");
	$resultado = $conexion->query($query);
	$usuario = $resultado->fetch_assoc();	
     
	 $user_url = $conexion->real_escape_string($_REQUEST['user']);
     $user_id_url = $conexion->real_escape_string($_REQUEST['id']);
	/* combruebo: 1)si el apodo del usuario dado por url no es igual al apodo del usuario lo redirijo a la pagina tienda-vendedor.php
	              2)si el apodo del usuario dado por url es igual al apodo del usuario lo dejo entrar*/
	if (utf8_encode($usuario['apodo']) !== $user_url) {header("location: ../cliente.php");} else {
	    // combruebo: 1)si el id del usuario dado por url no es igual al id del usuario lo redirijo a la pagina tienda-vendedor.php, si es igual lo dejo pasar
	    if ($usuario['id'] !== $user_id_url) {header("location: ../cliente.php");} else {
	
			//a qui ya conecto con la bd para realizar el proceso
			$conexion = new mysqli ("localhost", "root", "", "wiksay"); // conexion a la db

			$apodo = $conexion->real_escape_string(utf8_decode($_REQUEST['user']));
			$id = $conexion->real_escape_string(utf8_decode($_REQUEST['id']));

// INICIO: empiezo eliminanto todo lo relacionado con productos, incluyendo los productos.

			// BUSCO EL ID DEL PRODUCTO
			 $conexion = new mysqli ("localhost", "root", "", "wiksay"); // conexion a la db
	         $query = ("SELECT id FROM tienda WHERE usuario_id='$id';");
	         $resultado = $conexion->query($query);
	         $tienda = $resultado->fetch_assoc();
			 $tienda_id = $tienda['id'];
			
			$query = ("DELETE C.* FROM comentario C, producto P WHERE C.producto_id=P.id AND P.tienda_id='$tienda_id'"); // eliminame los (comentarios) de ste producto
			$eliminado_comentario = $conexion->query($query);

			if($eliminado_comentario){ // si los comentarios estan eliminados, ahora eliminame el producto

				$query = ("DELETE M.* FROM megusta M, producto P WHERE M.producto_id=P.id AND P.tienda_id='$tienda_id'"); // eliminame los (me gustas) de ste producto
				$eliminado_megusta = $conexion->query($query);
	
				if($eliminado_megusta){ // si los megustas estan eliminados, ahora eliminame el producto
		
					$query = ("DELETE C.* FROM color C, producto P WHERE C.producto_id=P.id AND P.tienda_id='$tienda_id'"); // eliminame los (me gustas) de ste producto
					$eliminado_colores = $conexion->query($query);
			
					if($eliminado_colores){ // si los megustas estan eliminados, ahora eliminame el producto
		
						$query = ("DELETE FROM producto WHERE tienda_id='$tienda_id'");
						$eliminado_productos = $conexion->query($query);// con esto le estamos diciendo que nos almacene los datos
							
						if ($eliminado_productos){
// FINAL: empiezo eliminanto todo lo relacionado con productos, incluyendo los productos.
// INICIO: ahora elimino las notificaciones de la tienda.

							$query = ("DELETE FROM notificacion WHERE tienda_id='$tienda_id'");
							$eliminado_notificacion = $conexion->query($query);// con esto le estamos diciendo que nos almacene los datos

							if ($eliminado_notificacion){
// FINAL: ahora elimino las notificaciones de la tienda.
// INICIO: ahora elimino los seguidores de la tienda.

								$query = ("DELETE FROM seguimiento WHERE tienda_id='$tienda_id'");
								$eliminado_seguimiento = $conexion->query($query);// con esto le estamos diciendo que nos almacene los datos
								
								if ($eliminado_seguimiento){
// FINAL: ahora elimino los seguidores de la tienda.
// INICIO: ahora elimino los social_media de la tienda.	

									$query = ("DELETE FROM social_media WHERE empresa_usuario_id='$id'");
									$eliminado_social_media = $conexion->query($query);// con esto le estamos diciendo que nos almacene los datos
									
									if ($eliminado_social_media){
// FINAL: ahora elimino los social_media de la tienda.
// INICIO: ahora elimino la tienda del usuario que lo solosita.	

										$query = ("DELETE FROM tienda WHERE usuario_id='$id'");
										$eliminado_tienda = $conexion->query($query);// con esto le estamos diciendo que nos almacene los datos
										
										if ($eliminado_tienda){
// FINAL: ahora elimino la tienda del usuario que lo solosita.	
// INICIO: ahora elimino la empresa del usuario que lo solosita.

											$query = ("DELETE FROM empresa WHERE usuario_id='$id'");
											$eliminado_empresa = $conexion->query($query);// con esto le estamos diciendo que nos almacene los datos
										
											if ($eliminado_empresa){	
												header ('location: ../cliente.php?proceso=tienda_eliminada');
											}else {
											       header("location: ../eliminar-tienda.php"); // empresa
										           }
										}else {
											  header("location: ../eliminar-tienda.php"); // tienda
										      }
									}else {
										   header("location: ../eliminar-tienda.php"); // social media
										  }
								}else {
									   header("location: ../eliminar-tienda.php");  // seguimiento
									  }	
							}else {
								  header("location: ../eliminar-tienda.php"); // notificacion
								  }									
						}else {
							   header("location: ../eliminar-tienda.php"); // productos
							  }				   
					}else{
						 header("location: ../eliminar-tienda.php"); // colores
						 }					   
				}else{
					 header("location: ../eliminar-tienda.php"); // likes
					 }
			}else{
				  header("location: ../eliminar-tienda.php"); // comentarios
				 }	
	    } // este es de la comprobacion del id de usuario
	}// este es de la comprobacion del apodo de usuario
?>