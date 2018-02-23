<?php
//error_reporting(0);
error_reporting(E_ALL);
ini_set('display_errors', true);

session_start();

if(isset($_SESSION["user"])){
     $usuario = utf8_decode($_SESSION['user']);
     $user = $_SESSION['user']; // aqui estoy llamando el apodo del usuario
}else{//si la secion se inicio mal, se destrira y se redirige a la pagina principal
      session_start();
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
	<link rel="stylesheet" href="css/estilos-likes.css">
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
		
		</section>
		<section class="centro-abajo">
		    <section class="centro-2"> 
			     <nav>
				    <ul>
				       <center><p class="centro-2-1">LIKES<span id="corazon" class="icon-heart"></span></p></center>
					</ul>
				 </nav>
			</section>
			<section class="centro-3">
					<nav>
						<?php 
						$conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
						$usuario_id = $informacion['id'];
						$query = ("SELECT * FROM megusta WHERE usuario_id='$usuario_id';"); 
						$resultado = $conexion->query($query);
						while($datos_megusta = $resultado->fetch_assoc()){ 
						$verificar = 1; 
						
							$conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
							$producto_id = $datos_megusta['producto_id'];
					        $query1 = ("SELECT P.*, T.nombre_tienda, T.imagen_tienda, T.id FROM producto P, tienda T WHERE P.id='$producto_id' AND P.tienda_id=T.id;"); 
					        $resultado1 = $conexion->query($query1);
					        $datos_producto = $resultado1->fetch_assoc();
							
							$conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
					        $query123 = ("SELECT U.imagen FROM producto P, tienda T, usuario U WHERE P.id='$producto_id' AND P.tienda_id=T.id AND T.usuario_id=U.id;"); 
					        $resultado1 = $conexion->query($query123);
					        $datos_usuario = $resultado1->fetch_assoc(); ?>
							
							<div class="contenido">
							    <div class="informacion1">
									<a href="tienda.php?nombre=<?php echo $datos_producto['nombre_tienda'];?>">
										<div class="imagen-tienda">
											<?php if (!empty($datos_usuario['imagen'])){ ?>
												<figure><img src="data:image/jpg;base64, <?php echo base64_encode($datos_usuario['imagen']); ?>"></figure>
											<?php }else{ ?>
												<figure><img src="imagenes/perfil-cuadrada.png"></img></figure>
											<?php } ?>
										</div>
									</a>	
										<div class="informacion2">
										    <a href="tienda.php?nombre=<?php echo $datos_producto['nombre_tienda'];?>">
												<div class="nombre-tienda"><b><?php echo utf8_encode($datos_producto['nombre_tienda']);?></b></div>
											</a>
											<a href="producto.php?id=<?php echo $producto_id;?>">
												<div class="nombre-producto"><?php echo utf8_encode($datos_producto['nombre']);?></div>
										    </a>
										</div>
								</div>
							    <article class="imagen-producto"><a href="producto.php?id=<?php echo $datos_megusta['producto_id'];?>"><figure><img src="data:image/jpg;base64, <?php echo base64_encode($datos_producto['imagen']); ?>"></figure></a></article>
							   
							   
							 
							    <?php 
		                        $conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
			                    $query2 = ("SELECT COUNT(*) as producto_id FROM megusta WHERE producto_id='$producto_id';");
		                        $resultado2 = $conexion->query($query2);
			                    $megusta = $resultado2->fetch_assoc() ?>
								<div class="informacion3">
									<div class="informacion4">
										<div class="boton-megusta">
											<!--inicio: estructura de php para el seguimiento de las tiendas-->
											<?php
												$conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
												$producto_idid = $datos_megusta['producto_id'];
												$id_usuario = $datos_megusta['usuario_id']; // este id de usuario la llame del while de arriba
												$query5 = ("SELECT producto_id, usuario_id FROM megusta WHERE producto_id='$producto_id' AND usuario_id='$id_usuario'");
												$resultado5 = $conexion->query($query5);// con esto le estamos diciendo que nos muestre los datos
												$existe = $resultado5->fetch_assoc(); 
											
												if ( $existe['producto_id'] == $producto_idid AND $existe['usuario_id'] == $id_usuario){ 
											?>
												<!-- si ya te guata muestrame esto: -->
												   <form class="centro-centro-1" action="likes-php/proceso-eliminar-megusta.php?producto_id=<?php echo $datos_megusta['producto_id'];?>&id_user=<?php echo $datos_megusta['usuario_id'];?>&nombre_tienda=<?php echo $datos_producto['nombre_tienda'];?>&tienda_id=<?php echo $datos_producto['id'];?>" method="POST"> <!--todo esta llamado del while-->
													  <ul>
														 <li class="megusta-si"><input type="submit" value=""><span class="icon-heart"></span></input></li>
													  </ul>
												   </form>
											<?php }else { ?>
												<!-- si todavia no le has dado a megusta muestra esto: -->
												   <form class="centro-centro-1" action="likes-php/proceso-subir-megusta.php?producto_id=<?php echo $datos_megusta['producto_id'];?>&nombre_producto=<?php echo utf8_encode($datos_megusta['nombre_producto']);?>&id_user=<?php echo $datos_megusta['usuario_id'];?>&nombre_usuario=<?php echo utf8_encode($datos_megusta['nombre_usuario']);?>" method="POST"> <!--todo esta llamado del while-->
													  <ul>
														 <li class="megusta-no"><input type="submit" value=""><span class="icon-heart"></span></input></li>
													  </ul>
												   </form>
											<?php } ?>
											<!--final: estructura de php para el seguimiento de las tiendas-->
										</div>
										<div class="mostrar-numero-megustas">
											<?php 
												if ($megusta['producto_id'] = 0 OR $megusta['producto_id']= 1){
													echo '',$megusta['producto_id'],' Me gusta'; 
												}else{
													echo '',$megusta['producto_id'],' Me gustas'; 
												}
											?>
										</div>
									</div>
									<div class="precio"><?php echo utf8_encode($datos_producto['precio']),' €';?></div>
								</div>
							</div>	
						<?php } if (isset ($verificar) AND $verificar == 1){
								// no ago nada
								}else{echo '<br><center><p>¿Todavía no le has dado LIKE a un articulo? seguro que hay muchos que te gustan.</p></center>';}?>
					</nav>
			</section>
		</section>
     </div>
</body>
</html>