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
	<link rel="stylesheet" href="/css/estilos-pagina-error.css"/>
	<link rel="stylesheet" href="/css/estilos-superior.css"/>
	<link rel="stylesheet" href="/fonts/style.css"/>
	<link rel="stylesheet" href="/font-awesome-4.4.0/css/font-awesome.min.css"/>
</head>

<body>
<!-- google analitics-->
<?php include_once("analyticstracking.php") ?>

      <div id="gloval">
        <?php include('cabecera/header.php');?> 
		
		<section class="centro">
		
		  <center><h1>Esta página no está disponible</h1></center>
		  <center><h2>Es posible que el enlace que has seguido esté roto o que se haya eliminado la página.</h2></center>
		  
		  <center><img src="imagenes/roto1.png" height="" width="150px"></img></center>
		  
		  
		  
		</section>
      </div>
</body>
</html>