<?php
//error_reporting(0);
error_reporting(E_ALL);
ini_set('display_errors', true);

session_start();

if(isset($_SESSION["user"])){
        $user = $_SESSION['user'];
	$usuario = utf8_decode($_SESSION['user']);
}else{//si la secion se inicio mal, se destrira y se redirige a la pagina principal
      session_start();
	  session_destroy();
	  header("location: index.php?error=acceso");}	  
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
	<link rel="stylesheet" href="css/estilos-ayuda.css">
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
		        <header class="titulo"> 
					<nav>
						<ul>
							<center><p class="centro-2-1">Ayuda</p></center>
						</ul>
					</nav>
				</header>
				<section class="informacion">
				<?php
					// inicio avisos
					if (isset($_REQUEST['proceso'])){
						$proceso = $_REQUEST['proceso'];
						if ($proceso == 'email_enviado') {  
							echo '<center><div><a href="http://www.wiksay.com/ayuda.php"><div class="proceso">Excelente. El e-mail se a mandado. Le responderemos lo antes posible.<span> X</span></div></a></div></center>';
						} else if ($proceso == 'email_incorrecto') { 
							echo '<center><div><a href="http://www.wiksay.com/ayuda.php"><div class="proceso1">Lo sentimos. El e-mail introducido no es valido.<span> X</span></div></a></div></center>'; 
						} else {}; 
					}else{};
					// final aviso
				?>
				    <form  action="gestionar-cuentas-php/proceso-ayuda-email.php?user=<?php echo utf8_encode($id_user['apodo']);?>&id=<?php echo $id_user['id']; ?>" method="POST">
						<div><p>Escribe tu E-mail*</p></div>
						<div class="respuesta"><input type="email"  size="42%" placeholder="Correo electronico" name="email" autocomplete="off" REQUIRED></div>
					
						<div><p>Cuéntanos  en que podemos ayudarte*</p></div>
						<div class="descripcion"><textarea placeholder="Cuéntanos  cual es tu duda para poder resolvertela" name="informacion" autocomplete="off" REQUIRED></textarea></div>
						<div class="formulario">
						<center>
							<div class="enviar"><input class="input-enviar" type="submit" value="Enviar E-mail"></div>
						</center>
						</div>
					</form>
				</section>
		   </section>
		   
		   <section class="centro-3">
		        <header class="titulo"> 
					<nav>
						<ul>
							<center><p class="centro-3-1">Preguntas frecuentes</p></center>
						</ul>
					</nav>
				</header>
				<section class="informacion">
				    <div><p>Iremos añadiendo las preguntas más frecuentes que nos hagáis para que os sirvan a todos.</p></div>
				</section>
		   </section>
		   
		</section>
     </div>
</body>
</html>