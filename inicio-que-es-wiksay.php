<?php
//error_reporting(0);
error_reporting(E_ALL);
ini_set('display_errors', true);
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
	<link rel="stylesheet" href="css/estilos-inicio-informacion.css">
</head>

<body>
<!-- google analitics-->
<?php include_once("analyticstracking.php") ?>

    <div id="gloval">
        <header class="superior">
		  <nav>
		    <center>
				<ul>
					<li class="menu1"><a href="inicio.php"><b>Wiksay</b></a></li>
				</ul> 
			</center>
          </nav>		  
        </header>
		
		<section class="centro-3">
			      <p><a href="inicio-que-es-wiksay.php"><b>¿Que es Wiksay?</b></a></p>
                  <p><a href="inicio-condiciones-legales.php"><b>Condiciones legales</b></a></p>
                  <p><a href="inicio-politica-privacidad.php"><b>Politica de privacidad</b></a></p>
                  <p><a href="inicio-politica-cookies.php"><b>Politica de cookies</b></a></p>
		</section>
		
      </div>
</body>
</html>