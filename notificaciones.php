<?php
//error_reporting(0);
error_reporting(E_ALL);
ini_set('display_errors', true);

session_start();

if(isset($_SESSION["user"])){
     $usuario = utf8_decode($_SESSION['user']);
     $user = $_SESSION['user']; // aqui estoy llamando el apodo del usuario
}else{//si la secion se inicio mal, se destrira y se redirige a la pagina principal
      $usuario = '';
      $user = ''; // aqui estoy llamando el apodo del usuario
      }	  	  
?>

<?php include('llamadas-bd.php'); // id_user, id_tienda, producto_id ?> 

<?php 
	// compruebo que esta definida, que no esta vacia, y que es 1
	if (isset($_REQUEST['estado']) AND !empty($_REQUEST['estado'])){
		if ($_REQUEST['estado'] == 1){
		
		    $usuario_id = $id_user['id'];
			$usuario_apodo = $id_user['apodo'];
			$tienda_id = $id_tienda['id'];
			$estado = $_REQUEST['estado'];
		
			$conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
			$query1 = ("UPDATE notificacion SET  estado='$estado' WHERE tienda_id='$tienda_id' AND tipo!='3 nuevoArticulo';"); // nombre_tienda lo llame en la parte de arriba
			$resultado1 = $conexion->query($query1);// con esto le estamos diciendo que nos almacene los datos
			
		}else{header("location: cliente.php");}
	}else{header("location: cliente.php");}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Wiksay</title>
	<meta charset="utf-8">
	<meta name="description" content="Crea una cuenta en Wiksay. Conecta con tiendas y diseñadores. Comparte, comenta, dale like y encuentra cualquier articulo. Envía mensajes y...">
	<meta name="keywords" content="Wiksay, tiendas, ropa, comunicación, red social, comprar, productos"/>
	<meta name="viewport" content="width=device-width"> <!--Esto es para que el responsive se adacte a los dispositivos moviles-->
	<link rel="shortcut icon" href="imagenes/wiksay.ico" type="image/x-icon">
	<meta mane="robots" content="noodp">
	<link rel="stylesheet" href="css/estilos-notificaciones.css">
	<link rel="stylesheet" href="css/estilos-superior.css">
	<link rel="stylesheet" href="css/estilos-controles.css">
	<link rel="stylesheet" href="fonts/style.css">
	<link rel="stylesheet" href="font-awesome-4.4.0/css/font-awesome.min.css"/>
	
</head>

<body>
<!-- google analitics-->
<?php include_once("analyticstracking.php") ?>

    <div id="gloval">
	    <?php include('usuario-php/mostrar-datos-user.php');?><!--PHP. estas lineas de php es para mostrar los datos-->
        <?php include('cabecera/header.php');?>

	<section class="centro">
	    
		<?php include('cabecera/controles.php');?>
		   
		<section class="centro-2">
		    <section class="centro-2-1">
			    <nav>
				    <ul>
				       <center><li class="centro-2-1-1"><p>NOTIFICACIONES</p></li></center>
				    </ul>
				</nav>
			</section>
			  
			<?php 
			$conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
			$query = ("SELECT * FROM notificacion WHERE tienda_id='$tienda_id' AND tipo!='3 nuevoArticulo' ORDER BY id DESC;"); // nombre_tienda lo llame en la parte de arriba
			$resultado = $conexion->query($query);
			while($notificaciones = $resultado->fetch_assoc()){ 	
				
				$conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
				$nombre_usuario_notificacion = $notificaciones['nombre_usuario'];
				$query123 = ("SELECT imagen FROM usuario WHERE apodo='$nombre_usuario_notificacion';"); 
				$resultado1 = $conexion->query($query123);
				$datos_usuario = $resultado1->fetch_assoc(); ?>
				<section class="notificaciones1">
			        <div class="notificaciones-imagen">
					     <article class="notificaciones-imagen-forma">
					        <?php if (!empty($datos_usuario['imagen'])){ ?>
					            <figure><img src="data:image/jpg;base64, <?php echo base64_encode($datos_usuario['imagen']); ?>"></figure>
					        <?php }else{ ?>
					            <figure><img src="imagenes/perfil-cuadrada.png"></figure>
					        <?php } ?>
					    </article>
					</div>
					<div class="contenido-notificaciones">
						<?php
							if ( $notificaciones['tipo'] == '1 seguidores'){
								echo '<p><b>',utf8_encode($notificaciones['nombre_usuario']),'</b> ha empezado a seguirte.</p>';
							}else if( $notificaciones['tipo'] == '2 megusta'){
								echo '<p>A <b>',utf8_encode($notificaciones['nombre_usuario']),'</b> Le gusta tu artículo <a href="producto.php?id=',utf8_encode($notificaciones['producto_id']),'"><b>',utf8_encode($notificaciones['nombre_producto']),'.</b></a></p>';
						    }else if( $notificaciones['tipo'] == '4 comentario'){
								echo '<p><b>',utf8_encode($notificaciones['nombre_usuario']),'</b> ha comentado en <a href="producto.php?id=',utf8_encode($notificaciones['producto_id']),'"><b>',utf8_encode($notificaciones['nombre_producto']),'.</b></a></p>';
							}
						?>
				    </div>
				</section>
			<?php } ?>
			<?php /*
			$conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
			$query = ("SELECT N.*, T.imagen_tienda FROM notificacion N, Tienda T, seguimiento S, usuario U WHERE N.tipo='3 nuevoArticulo' AND N.tienda_id=T.id AND T.id!='$tienda_id' AND T.id=S.tienda_id AND S.usuario_id=U.id AND U.apodo='$usuario' ORDER BY id DESC;"); // nombre_tienda lo llame en la parte de arriba
			$resultado = $conexion->query($query);
			while($notificaciones2 = $resultado->fetch_assoc()){ ?>
				<section class="notificaciones1">
			        <div class="notificaciones-imagen">
					     <article class="notificaciones-imagen-forma">
					        <?php if (!empty($notificaciones2['imagen_tienda'])){ ?>
					            <figure><img src="data:image/jpg;base64, <?php echo base64_encode($notificaciones2['imagen_tienda']); ?>"></figure>
					        <?php }else{ ?>
					            <figure><img src="imagenes/perfil-cuadrada.png"></figure>
					        <?php } ?>
					    </article>
					</div>
					<div class="contenido-notificaciones">
						<?php
							if ( $notificaciones2['tipo'] == '3 nuevoArticulo'){
								echo '<p><a href="tienda.php?nombre=',$notificaciones2['nombre_tienda'],'"><b>',$notificaciones2['nombre_tienda'],'</b></a> ha subido un artículo nuevo: <a href="producto.php?id=',$notificaciones2['producto_id'],'"><b>',$notificaciones2['nombre_producto'],'.</b></a></p>';
							} else{}
						?>
				    </div>
				</section>
			<?php } */ 
			?>
			     
		</section>
		   
		</section>
	 </section>
    </div>
</body>
</html>