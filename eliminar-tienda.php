<?php
error_reporting(0);
//error_reporting(E_ALL);
//ini_set('display_errors', true);

session_start();

if(isset($_SESSION["user"])){
        $user = $_SESSION['user'];
	$usuario = utf8_decode($_SESSION['user']);
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
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"> <!--Esto es para que el responsive se adacte a los dispositivos moviles-->
	<link rel="shortcut icon" href="imagenes/wiksay.ico" type="image/x-icon">
	<link rel="stylesheet" href="css/estilos-eliminar-tienda.css">
	<link rel="stylesheet" href="css/estilos-superior.css">
	<link rel="stylesheet" href="fonts/style.css">
	<link rel="stylesheet" href="font-awesome-4.4.0/css/font-awesome.min.css"/>

</head>

<body>
      <div id="gloval">
	   <?php include('usuario-php/mostrar-datos-user.php');?><!--PHP. estas lineas de php es para mostrar los datos-->
       <?php include('cabecera/header.php');?>
	
	    <section class="centro">
		
		    <section class="centro-2">
		        	<header class="titulo"> 
					<nav>
						<ul>
							<center><p class="centro-2-1">Eliminar tienda</p></center>
						</ul>
					</nav>
				</header>
				<section class="informacion">
					<h1>¿Estas seguro de que deseas eliminar tu tienda?</h1>
				
					<p>Si podemos ayudarte en algo o convencerte para que te quedes con nosotros no dudes en cotificarnoslo para poder ayuderte.</p>
					<p>Te informamos que si eliminas tu tienda, se eliminaran por completo todos los datos que allas guardado, incluyendo imagenes, 
						comentarios y demas.</p>
				
					<div class="formulario">
					  <center>
						<div class="eliminar"><a href="gestionar-cuentas-php/proceso-eliminar-tienda.php?user=<?php echo utf8_encode($id_user['apodo']);?>&id=<?php echo $id_user['id'] ;?>"><input class="input-eliminar" type="submit" value="Eliminar tienda"></a></div>
						<div class="cancelar"><a href="tienda-vendedor.php">Cancelar</a></div>
					  </center>
					</div>
				</section>
		   </section>
		   
		</section>
     </div>
</body>
</html>