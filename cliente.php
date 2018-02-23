<?php
//error_reporting(0);
error_reporting(E_ALL);
ini_set('display_errors', true);

session_start();

if(isset($_SESSION["user"])){
     $usuario = utf8_decode($_SESSION['user']);
     $user = $_SESSION['user']; // aqui estoy llamando el apodo del usuario
	 
}else{//si la secion se inicio mal, se destrira y se redirige a la pagina principal
     
	  session_destroy();
	  header("location: index.php?error=acceso");
      }
?>

<?php include('llamadas-bd.php'); // id_user, id_tienda, producto_id ?> 

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
	<link rel="stylesheet" href="css/estilos-cliente.css">
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
		
			
			
			<section class="centro-3">
			<?php 
				// inicio avisos
				if (isset($_REQUEST['proceso'])){
					$proceso = $_REQUEST['proceso'];
					if ($proceso == 'inicio') {  
						echo '<center><div><a href="http://www.wiksay.com/cliente.php"><div class="proceso">Bienvenido a Wiksay.</div></a></div></center>';
					} else if ($proceso == 'nomodificado') { 
						echo '<center><div><a href="http://www.wiksay.com/cliente.php"><div class="proceso1">Lo sentimos. No se ha podido guardar los cambios.<span> X</span></div></a></div></center>';
					} else {}; 
				}else{};
				// final aviso
			?>		
						<?php // todo esto es para mostrar el id del usuario
						$conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
						$user = $_SESSION['user'];
						$usuario = utf8_decode($_SESSION['user']);
						$query = ("SELECT P.*, S.nombre_tienda, S.nombre_usuario, S.usuario_id FROM producto P, seguimiento S, tienda T WHERE P.tienda_id=T.id AND T.id=S.tienda_id AND S.nombre_usuario='$usuario' ORDER BY fecha_alta DESC ;");
						$resultado = $conexion->query($query);
						while($datos_megusta = $resultado->fetch_assoc()){  
						$verificar = 1; 
					        
							$conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
							$producto_id = $datos_megusta['id'];
					        $query1 = ("SELECT P.*, T.nombre_tienda, T.id FROM producto P, tienda T WHERE P.id='$producto_id' AND P.tienda_id=T.id;"); 
					        $resultado1 = $conexion->query($query1);
					        $datos_producto = $resultado1->fetch_assoc();
							
					        $conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
							$query123 = ("SELECT U.imagen FROM producto P, tienda T, usuario U WHERE P.id='$producto_id' AND P.tienda_id=T.id AND T.usuario_id=U.id;"); 
					        $resultado1 = $conexion->query($query123);
					        $datos_usuario = $resultado1->fetch_assoc() ?>
							
							<div class="contenido-muro">
							    <div class="informacion1-muro">
									<a href="tienda.php?nombre=<?php echo utf8_encode($datos_producto['nombre_tienda']);?>">
										<div class="imagen-tienda-muro">
											<?php if (!empty($datos_usuario['imagen'])){ ?>
												<figure><img src="data:image/jpg;base64, <?php echo base64_encode($datos_usuario['imagen']); ?>"></figure>
											<?php }else{ ?>
												<figure><img src="imagenes/perfil-cuadrada.png"></img></figure>
											<?php } ?>
										</div>
										
									</a>	
										<div class="informacion2-muro">
										    <a href="tienda.php?nombre=<?php echo utf8_encode($datos_producto['nombre_tienda']);?>">
												<div class="nombre-tienda-muro"><b><?php echo utf8_encode($datos_producto['nombre_tienda']);?></b></div>
											</a>
											<a href="producto.php?id=<?php echo $producto_id;?>">
												<div class="nombre-producto-muro"><?php echo utf8_encode($datos_producto['nombre']);?></div>
										    </a>
										</div>
										<div class="precio-muro"><?php echo utf8_encode($datos_producto['precio']),' €';?></div>
								</div>
							    <article class="imagen-producto-muro"><a href="producto.php?id=<?php echo $datos_megusta['id'];?>"><figure><img src="data:image/jpg;base64, <?php echo base64_encode($datos_producto['imagen']); ?>"></figure></a></article>
							</div>	
						<?php } if (isset ($verificar) AND $verificar == 1){
									// no ago nada
									}else{echo '<br><center><p>Es posible que todavía no aparezcan artículos aquí debido a que no sigues a ninguna tienda o quizás las tiendas que sigues no han subido artículos.</p></center>';} 
							?>
					
			</section>  
		</section>              
     </div>
</body>
</html>