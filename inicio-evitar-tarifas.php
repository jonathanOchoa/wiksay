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
		<h1>Evitar tarifa</h1>
		
		<p>Evitar aranceles, lo cual está prohibido por Wiksay, incluye cualquier acción destinada a evitar el pago de una cuota de inscripción o cuota de transacción .</p>

		<h4>Ejemplos de evitación cuota</h4>

			<p class="puntos">•	La publicación de un aviso de la tienda que anima a los compradores a comprar los mismos elementos que se enumeran en Wiksay desde otro lugar de venta en línea. </p>
			<p class="puntos">•	El uso de una tienda o un perfil vacío para dirigir a los compradores a otro lugar de venta en línea. </p>
			<p class="puntos">•	Modificación de la información de un listado para cambiarlo a un elemento completamente diferente. </p>
			<p class="puntos">•	Ponerse en contacto con otro miembro a través de conversaciones y dirigirlos para comprar o vender un artículo que aparece en wiksay fuera del mercado de wiksay. </p>
			<p class="puntos">•	Completar una transacción fuera de wiksay una vez que se ha iniciado en el sitio.</p>


		</section>
		
      </div>
</body>
</html>