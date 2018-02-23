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
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
	<meta name="viewport" content="width=device-width"> <!--Esto es para que el responsive se adacte a los dispositivos moviles-->
	<link rel="shortcut icon" href="imagenes/wiksay.ico" type="image/x-icon">
	<meta mane="robots" content="noodp">
	<link rel="stylesheet" href="css/estilos-mapa.css">
	<link rel="stylesheet" href="css/estilos-superior.css">
	<link rel="stylesheet" href="fonts/style.css">
	<link rel="stylesheet" href="font-awesome-4.4.0/css/font-awesome.min.css"/>
	
	<script src="http://maps.googleapis.com/maps/api/js? key=YOUR_KEY "></script>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?client=gme-yourclientid&sensor=true_or_false"></script>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script>
    var map;function initialize() 
	  {
	   var mapOptions ={zoom: 8,center: new google.maps.LatLng(51.508742,-0.120850)}; 
	   map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);
      }
    google.maps.event.addDomListener(window, 'load', initialize);
    </script>
	
</head>

<body>
<!-- google analitics-->
<?php include_once("analyticstracking.php") ?>

      <div id="gloval">
	    <?php include('usuario-php/mostrar-datos-user.php');?><!--PHP. estas lineas de php es para mostrar los datos-->
        <?php include('cabecera/header.php');?>
		
		<div id="map-canvas"></div>
		
     </div>
</body>
</html>