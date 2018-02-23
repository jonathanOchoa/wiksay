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
	<link rel="stylesheet" href="css/estilos-me-siguen.css">
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
				       <center><li class="centro-2-1-1"><p>SEGUIDORES</p></li></center>
				    </ul>
				 </nav>
			  </section>
			  
				    <?php
					   $conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
					   $nombre_tienda = $id_tienda['nombre_tienda']; // el nombre de tienda lo llame en la parte de arriba
					   $query = ("SELECT S.*, U.imagen FROM seguimiento S, usuario U WHERE S.nombre_tienda='$nombre_tienda' AND S.usuario_id=U.id;");
					   $resultado = $conexion->query($query);
					   while($datos_seguimiento = $resultado->fetch_assoc()){ 
					   $verificar = 1; ?>
					   <section class="centro-2-2">
					        <div class="centro-2-2-0">
					           <article class="imagen-portada">
									<?php if (!empty($datos_seguimiento['imagen'])){ ?>
										<figure><img src="data:image/jpg;base64, <?php echo base64_encode($datos_seguimiento['imagen']); ?>"></figure>
									<?php }else{ ?>
										<figure><img src="imagenes/perfil-cuadrada.png"></figure>
									<?php } ?>
					           </article>
					        </div>
							<div class="centro-2-2-1">
								<div class="centro-2-2-1-1"><font color="black"><b><?php echo utf8_encode($datos_seguimiento['nombre_usuario']);?></b></font></div>  
								<?php if (utf8_encode($datos_seguimiento['nombre_tienda_usuario']) != NULL) { ?>							 
								<div class="centro-2-2-1-2"><a href="tienda.php?nombre=<?php echo utf8_encode($datos_seguimiento['nombre_tienda_usuario']);?>"><button><b>Ir a su tienda</b></button><a></div> 
								<?php }else{ ?>
								<div class="centro-2-2-1-2"><a><button><b>No tiene tienda</b></button><a></div>
								<?php } ?>
							</div>
			           </section>
					<?php }   
					  
			           if (isset ($verificar) AND $verificar == 1){
				       // no ago nada
				       }else{echo '<br><center><p>Date a conocer para que tus fans empiecen a seguirte.</p>
								   </center>';}
					?>	  
				 
		   </section>
		</section>
     </div>
</body>
</html>