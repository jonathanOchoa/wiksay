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
	<link rel="stylesheet" href="css/estilos-siguiendo.css">
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
		      <header class="centro-2-1">
			     <nav>
				    <ul>
				       <center><li class="centro-2-1-1"><p>SIGUIENDO</p></li></center>
					</ul>
				 </nav>
			  </header>
				 <?php $conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
				       $usuario_id = $informacion['id'];
					   $query = ("SELECT S.*, U.imagen, T.id FROM seguimiento S, tienda T, usuario U WHERE S.usuario_id='$usuario_id' AND S.tienda_usuario_id=T.usuario_id AND T.usuario_id=U.id;"); 
					   $resultado = $conexion->query($query);
					   while($datos_seguimiento = $resultado->fetch_assoc()){ 
					   $verificar = 1; ?>
					   <section class="centro-2-2">
					            <div class="centro-2-2-0">
								   <div class="imagen-tienda-muro">
										<article class="imagen-portada">
											<?php if (!empty($datos_seguimiento['imagen'])){ ?>
												<figure><a href="tienda.php?nombre=<?php echo utf8_encode($datos_seguimiento['nombre_tienda']);?>"><img src="data:image/jpg;base64, <?php echo base64_encode($datos_seguimiento['imagen']); ?>"></a></figure>
											<?php }else{ ?>
												<figure><img src="imagenes/perfil-cuadrada.png"></img></figure>
											<?php } ?>
										</article>
									</div>
								</div>
							    <div class="centro-2-2-1">
									<div class="centro-2-2-1-1"><a href="tienda.php?nombre=<?php echo utf8_encode($datos_seguimiento['nombre_tienda']);?>"><font color="black"><b><?php echo utf8_encode($datos_seguimiento['nombre_tienda']);?></b></font></a></div>
									<div class="centro-2-2-1-2">
										<form action="seguimiento-php/proceso-eliminar-seguir.php?nombre_tienda=<?php echo utf8_encode($datos_seguimiento['nombre_tienda']);?>&tienda_id=<?php echo utf8_encode($datos_seguimiento['id']);?>&tienda_usuario_id=<?php echo utf8_encode($datos_seguimiento['tienda_usuario_id']);?>&id_user=<?php echo $informacion['id'];?>" method="POST"> <!--este id_tienda lo llame en la parte superior.-->
												<div><input class="siguiendo" type="submit" value="Dejar de seguir"></div>
										</form>
									</div>          
				                </div>
			           </section>						   
			     <?php }  
					  
			    if (isset ($verificar) AND $verificar == 1){
				// no ago nada
				}else{echo '<br><center><p>¿Todavía no sigues a ninguna tienda?. No esperes mas, Wiksay es más entretenido cuando sigues tiendas.</p></center>';}?>
		   </section>
		</section>
     </div>
</body>
</html>