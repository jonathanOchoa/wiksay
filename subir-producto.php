﻿<?php
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
	  header("location: index.php?error=acceso");
      }
?>

<?php include('llamadas-bd.php'); // id_user, id_tienda, producto_id ?> 

<?php
	// compruebo: si el usuario tiene tienda lo dejo entrar, sino tiene lo redirijo a la pagina cliente.php
    if(utf8_encode($id_tienda['apodo_tienda']) != $user) { header("location: cliente.php");}	
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
	<link rel="stylesheet" href="css/estilos-subir-producto.css">
	<link rel="stylesheet" href="css/estilos-superior.css">
	<link rel="stylesheet" href="css/estilos-controles.css">
	<link rel="stylesheet" href="fonts/style.css">
	<link rel="stylesheet" href="font-awesome-4.4.0/css/font-awesome.min.css"/>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script><!--este es para que funcione la imagen predeterminada-->
	<script type="text/javascript" src="js/preload-imagen.js"></script>
	  
</head>

<body>
<!-- google analitics-->
<?php include_once("analyticstracking.php") ?>

      <div id="gloval">
	    <?php include('usuario-php/mostrar-datos-user.php');?><!--PHP. estas lineas de php es para mostrar los datos-->
        <?php include('cabecera/header.php');?>
		
	    <!--inicio-->
		  <section class="centro">
		  <?php include('cabecera/controles.php');?>
				<!--inicio php para incertar fotos-->
			<div class="centro-agrupacion">
				<form action="tienda-vendedor-php/proceso-subir.php?id=<?php echo $id_tienda['id'];?>" method="POST" enctype="multipart/form-data"> <!--id_tienda lo llame en la parte de arriba-->
				<center><div class="titulo"><p>Subir Producto</p></div></center>
				
				<table>
				    <div class="div-informacion-numerico"><p>1. AÑADE UNA O VARIAS IMÁGENES</p></div>
					<center>
					<div class="centro-1">
					           
						       <div class="imagen"> 
							      <input accept="image/*" onchange="loadFile(event)" class="imagen-imagen" type="file" name="imagen" REQUIRED/>
							      <img id="output" width="100%"height="100%"/>
							   </div>	
						       <div class="imagen">
							      <input accept="image/*" onchange="loadFile2(event)" class="imagen-imagen" type="file" name="imagen2"/>
							      <img id="output2" width="100%"height="100%"/>
							   </div>
							   <div class="imagen">
						          <input accept="image/*" onchange="loadFile3(event)" class="imagen-imagen" type="file" name="imagen3"/>
							      <img id="output3" width="100%"height="100%"/>
							   </div>
							   <div class="nota"><p><font color="red">*</font>Las imágenes no pueden superar los 2000px de largo y 2000px de alto.</p></div> 
							   <div class="nota"><p><font color="red">*</font>Recomendamos subir imágenes cuadradas.</p></div>
				    </div>
					</center>
					<div class="div-informacion-numerico"><p>2. DESCRIBE EL ARTÍCULO</p></div>
                    <div class="centro-2">
						<ul>
						    <li class="pregunta"><font color="red">*</font>Nombre</li>
							<li class="respuesta"><input type="text"  size="42%" placeholder="Nombre Producto" name="nombre" autocomplete="off" REQUIRED></li>
					    </ul>
						<ul>
						    <li class="pregunta"><font color="red">*</font>Precio</li>
							<li class="respuesta"><input type="text" size="42%" placeholder="Ejemplo: 5 o 15,88 o 0,47" name="precio" autocomplete="off" REQUIRED></li>
					    </ul>
						<ul>
							<li class="pregunta">Duración envío (opcional) </li>
							<li class="respuesta"><input type="text"  size="42%" placeholder="Duración envío" name="duracion_envio" autocomplete="off" ></li><!--falta-->
					    </ul>
						<ul>
						    <li class="pregunta">Costes envío (opcional)</li>
							<li class="respuesta"><input type="text" size="42%" placeholder="Ejemplo: 2 o 1,32" name="costes_envio" autocomplete="off" ></li>
					    </ul>
						<ul>
							<li class="pregunta">Devolución (opcional) </li>
							<li class="respuesta"><input type="text"  size="42%" placeholder="Devolución" name="devolucion" autocomplete="off" ></li><!--falta-->
					    </ul>
						<ul>
							<li class="pregunta"><font color="red">*</font>URL de su web o red social de contacto</li>
							<li class="respuesta"><input type="url"  size="42%" placeholder="URL de tu web o red social de contacto" name="url" autocomplete="off" REQUIRED></li>
					    </ul>
						<ul>
						    <!--inicio: esto es para que me muestre todas las categorias que hay en la base de datos-->
							<li class="pregunta"><font color="red">*</font>Categoría</li>
							<li class="respuesta">
							    <select name="categoria_p_id">
							     <?php $conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
					                   $query = ("SELECT * FROM categoria_pr;"); 
					                   $resultado = $conexion->query($query);
					                   while($categoria_pr = $resultado->fetch_assoc()){ ?>
							                 <option value="<?php echo $categoria_pr['id'];?>"><?php echo utf8_encode($categoria_pr['genero']),' ',utf8_encode($categoria_pr['nombre_categoria']),' ',utf8_encode($categoria_pr['zapatos']),' ',utf8_encode($categoria_pr['accesorios']),' ',utf8_encode($categoria_pr['ropa_interior']);?></option>
									   <?php } ?>
							     </select>
							</li>
							<!--final: esto es para que me muestre todas las categorias que hay en la base de datos-->
					    </ul>
						
						</br>
						
						<script type="text/javascript"> 
							document.write("<ul>");
							document.write("	<li><font color=\"red\">*</font>Mínimo debes seleccionar 1 de los 10 </li>");
							document.write("</ul>");
							document.write("<BR>");
							
							document.write("<ul>");
							document.write("	<li>1 Selecciona Color, Cantilad y Talla</li>");
							document.write("</ul>");
							document.write("<BR>");
							document.write("<ul>");
							document.write("	<li class=\"respuesta\">");
							document.write("		<select name=\"color[]\" REQUIRED>");
							document.write("			<option value=\"\">Color</option>");
							document.write("			<option value=\"Negro\">Negro</option>");
							document.write("			<option value=\"Blanco\">Blanco</option>");
							document.write("			<option value=\"Gris\">Gris</option>");
							document.write("			<option value=\"Marron\">Marron</option>");	
							document.write("			<option value=\"Beige\">Beige</option>");
							document.write("			<option value=\"Rojo\">Rojo</option>");
							document.write("			<option value=\"Rosa\">Rosa</option>");
							document.write("			<option value=\"Naranja\">Naranja</option>");
							document.write("			<option value=\"Amarillo\">Amarillo</option>");
							document.write("			<option value=\"Verde\">Verde</option>");
							document.write("			<option value=\"Azul\">Azul</option>");
							document.write("			<option value=\"Morado\">Morado</option>");
							document.write("			<option value=\"Oro\">Oro</option>");
							document.write("			<option value=\"Plata\">Plata</option>");
							document.write("			<option value=\"Claro\">Claro</option>");
							document.write("			<option value=\"Multiples\">Multiples</option>");	
							document.write("		</select>");
							document.write("	</li>");
							document.write("</ul>");
							document.write("<ul>");
							document.write("	<li class=\"respuesta\"><input type=\"text\" size=\"5\" placeholder=\"Cantidad\" name=\"cantidad[]\" autocomplete=\"off\" REQUIRED></li>");
							document.write("</ul>");
							document.write("<ul>");
							document.write("	<li class=\"respuesta\">");
							document.write("		<select name=\"talla[]\" REQUIRED>");
							document.write("			<option value=\"\">Talla</option>");
							document.write("			<option value=\"Sin talla\">Sin talla</option>");
							document.write("			<option value=\"XXS\">XXS</option>");
							document.write("			<option value=\"XS\">XS</option>");
							document.write("			<option value=\"S\">S</option>");
							document.write("			<option value=\"M\">M</option>");
							document.write("			<option value=\"L\">L</option>");
							document.write("			<option value=\"XL\">XL</option>");
							document.write("			<option value=\"XXL\">XXL</option>");		
							document.write("			<option value=\"XXXL\">XXXL</option>");
                            document.write("			<option value=\"22\">|22|</option>");
							document.write("			<option value=\"23\">|23|</option>");
							document.write("			<option value=\"24\">|24|</option>");
							document.write("			<option value=\"25\">|25|</option>");
							document.write("			<option value=\"26\">|26|</option>");
							document.write("			<option value=\"27\">|27|</option>");
							document.write("			<option value=\"28\">|28|</option>");
							document.write("			<option value=\"29\">|29|</option>");
							document.write("			<option value=\"30\">|30|</option>");
							document.write("			<option value=\"31\">|31|</option>");
							document.write("			<option value=\"32\">|32|</option>");
							document.write("			<option value=\"33\">|33|</option>");
							document.write("			<option value=\"34\">|34|</option>");
							document.write("			<option value=\"35\">|35|</option>");
							document.write("			<option value=\"36\">|36|</option>");
							document.write("			<option value=\"37\">|37|</option>");
							document.write("			<option value=\"38\">|38|</option>");
							document.write("			<option value=\"39\">|39|</option>");
							document.write("			<option value=\"40\">|40|</option>");
							document.write("			<option value=\"41\">|41|</option>");
							document.write("			<option value=\"42\">|42|</option>");
							document.write("			<option value=\"43\">|43|</option>");
							document.write("			<option value=\"44\">|44|</option>");
							document.write("			<option value=\"45\">|45|</option>");
							document.write("			<option value=\"46\">|46|</option>");
							document.write("			<option value=\"47\">|47|</option>");
							document.write("			<option value=\"48\">|48|</option>");
							document.write("			<option value=\"49\">|49|</option>");
							document.write("			<option value=\"50\">|50|</option>");
							document.write("			<option value=\"Meses 0 a 1 (50) cm\">Meses 0 a 1 (50) cm</option>");
						    document.write("			<option value=\"Meses 1 a 2 (56) cm\">Meses 1 a 2 (56) cm</option>");
							document.write("			<option value=\"Meses 2 a 4 (62) cm\">Meses 2 a 4 (62) cm</option>");
							document.write("			<option value=\"Meses 4 a 6 (68) cm\">Meses 4 a 6 (68) cm</option>");
							document.write("			<option value=\"Meses 6 a 9 (74) cm\">Meses 6 a 9 (74) cm</option>");
							document.write("			<option value=\"Meses 9 a 12 (80) cm\">Meses 9 a 12 (80) cm</option>");
							document.write("			<option value=\"Meses 12 a 18 (86) cm\">Meses 12 a 18 (86) cm</option>");
							document.write("			<option value=\"Meses 18 a 24 (92) cm\">Meses 18 a 24 (92) cm</option>");
							document.write("			<option value=\"Años 2 a 3 (98) cm\">Años 2 a 3 (98) cm</option>");
							document.write("			<option value=\"Años 3 a 4 (104) cm\">Años 3 a 4 (104) cm</option>");
							document.write("			<option value=\"Años 4 a 5 (110) cm\">Años 4 a 5 (110) cm</option>");
							document.write("			<option value=\"Años 5 a 6 (116) cm\">Años 5 a 6 (116) cm</option>");
							document.write("			<option value=\"Años 6 a 7 (122) cm\">Años 6 a 7 (122) cm</option>");
							document.write("			<option value=\"Años 7 a 8 (128) cm\">Años 7 a 8 (128) cm</option>");
							document.write("			<option value=\"Años 8 a 9 (134) cm\">Años 8 a 9 (134) cm</option>");
							document.write("			<option value=\"Años 9 a 10 (140) cm\">Años 9 a 10 (140) cm</option>");
							document.write("			<option value=\"Años 10 a 11 (146) cm\">Años 10 a 11 (146) cm</option>");
							document.write("			<option value=\"Años 11 a 12 (152) cm\">Años 11 a 12 (152) cm</option>");
							document.write("			<option value=\"Años 12 a 13 (158) cm\">Años 12 a 13 (158) cm</option>");
							document.write("			<option value=\"Años 13 a 14 (164) cm\">Años 13 a 14 (164) cm</option>");
							document.write("			<option value=\"Años 14+ (170) cm\">Años 14+ (170) cm</option>");
							document.write("			<option value=\"70A\">70A</option>");
							document.write("			<option value=\"70B\">70B</option>");
							document.write("			<option value=\"70C\">70C</option>");
							document.write("			<option value=\"70D\">70D</option>");
							document.write("			<option value=\"70E\">70E</option>");
							document.write("			<option value=\"75A\">75A</option>");
							document.write("			<option value=\"75B\">75B</option>");
							document.write("			<option value=\"75C\">75C</option>");
							document.write("			<option value=\"75D\">75D</option>");
							document.write("			<option value=\"75E\">75E</option>");
							document.write("			<option value=\"80A\">80A</option>");
							document.write("			<option value=\"80B\">80B</option>");
							document.write("			<option value=\"80C\">80C</option>");
							document.write("			<option value=\"80D\">80D</option>");
							document.write("			<option value=\"80E\">80E</option>");
							document.write("			<option value=\"85A\">85A</option>");
							document.write("			<option value=\"85B\">85B</option>");
							document.write("			<option value=\"85C\">85C</option>");
							document.write("			<option value=\"85D\">85D</option>");
							document.write("			<option value=\"85E\">85E</option>");
							document.write("			<option value=\"90A\">90A</option>");
							document.write("			<option value=\"90B\">90B</option>");
							document.write("			<option value=\"90C\">90C</option>");
							document.write("			<option value=\"90D\">90D</option>");
							document.write("			<option value=\"90E\">90E</option>");
							document.write("			<option value=\"95A\">95A</option>");
							document.write("			<option value=\"95B\">95B</option>");
							document.write("			<option value=\"95C\">95C</option>");
							document.write("			<option value=\"95D\">95D</option>");
							document.write("			<option value=\"95E\">95E</option>");
							document.write("			<option value=\"100A\">100A</option>");
							document.write("			<option value=\"100B\">100B</option>");
							document.write("			<option value=\"100C\">100C</option>");
							document.write("			<option value=\"100D\">100D</option>");
							document.write("			<option value=\"100E\">100E</option>");
							document.write("			<option value=\"105A\">105A</option>");
							document.write("			<option value=\"105B\">105B</option>");
							document.write("			<option value=\"105C\">105C</option>");
							document.write("			<option value=\"105D\">105D</option>");
							document.write("			<option value=\"105E\">105E</option>");
							document.write("			<option value=\"110A\">110A</option>");
							document.write("			<option value=\"110B\">110B</option>");
							document.write("			<option value=\"110C\">110C</option>");
							document.write("			<option value=\"110D\">110D</option>");
							document.write("			<option value=\"110E\">110E</option>");
							document.write("			<option value=\"115A\">115A</option>");
							document.write("			<option value=\"115B\">115B</option>");
							document.write("			<option value=\"115C\">115C</option>");
							document.write("			<option value=\"115D\">115D</option>");
							document.write("			<option value=\"115E\">115E</option>");						
							document.write("		</select>");
							document.write("	</li>");
							document.write("</ul>");
							document.write("<BR>");
							
						for (i=2;i<=10;i++) { 
							document.write("<ul>");
							document.write("	<li>",i," Selecciona Color, Cantilad y Talla</li>");
							document.write("</ul>");
							document.write("<BR>");
							document.write("<ul>");
							document.write("	<li class=\"respuesta\">");
							document.write("		<select name=\"color[]\">");
							document.write("			<option value=\"\">Color</option>");
							document.write("			<option value=\"Negro\">Negro</option>");
							document.write("			<option value=\"Blanco\">Blanco</option>");
							document.write("			<option value=\"Gris\">Gris</option>");
							document.write("			<option value=\"Marron\">Marron</option>");	
							document.write("			<option value=\"Beige\">Beige</option>");
							document.write("			<option value=\"Rojo\">Rojo</option>");
							document.write("			<option value=\"Rosa\">Rosa</option>");
							document.write("			<option value=\"Naranja\">Naranja</option>");
							document.write("			<option value=\"Amarillo\">Amarillo</option>");
							document.write("			<option value=\"Verde\">Verde</option>");
							document.write("			<option value=\"Azul\">Azul</option>");
							document.write("			<option value=\"Morado\">Morado</option>");
							document.write("			<option value=\"Oro\">Oro</option>");
							document.write("			<option value=\"Plata\">Plata</option>");
							document.write("			<option value=\"Claro\">Claro</option>");
							document.write("			<option value=\"Multiples\">Multiples</option>");	
							document.write("		</select>");
							document.write("	</li>");
							document.write("</ul>");
							document.write("<ul>");
							document.write("	<li class=\"respuesta\"><input type=\"text\" size=\"5\" placeholder=\"Cantidad\" name=\"cantidad[]\" autocomplete=\"off\"></li>");
							document.write("</ul>");
							document.write("<ul>");
							document.write("	<li class=\"respuesta\">");
							document.write("		<select name=\"talla[]\">");
							document.write("			<option value=\"\">Talla</option>");
							document.write("			<option value=\"Sin talla\">Sin talla</option>");
							document.write("			<option value=\"XXS\">XXS</option>");
							document.write("			<option value=\"XS\">XS</option>");
							document.write("			<option value=\"S\">S</option>");
							document.write("			<option value=\"M\">M</option>");
							document.write("			<option value=\"L\">L</option>");
							document.write("			<option value=\"XL\">XL</option>");
							document.write("			<option value=\"XXL\">XXL</option>");		
							document.write("			<option value=\"XXXL\">XXXL</option>");
                            document.write("			<option value=\"22\">|22|</option>");
							document.write("			<option value=\"23\">|23|</option>");
							document.write("			<option value=\"24\">|24|</option>");
							document.write("			<option value=\"25\">|25|</option>");
							document.write("			<option value=\"26\">|26|</option>");
							document.write("			<option value=\"27\">|27|</option>");
							document.write("			<option value=\"28\">|28|</option>");
							document.write("			<option value=\"29\">|29|</option>");
							document.write("			<option value=\"30\">|30|</option>");
							document.write("			<option value=\"31\">|31|</option>");
							document.write("			<option value=\"32\">|32|</option>");
							document.write("			<option value=\"33\">|33|</option>");
							document.write("			<option value=\"34\">|34|</option>");
							document.write("			<option value=\"35\">|35|</option>");
							document.write("			<option value=\"36\">|36|</option>");
							document.write("			<option value=\"37\">|37|</option>");
							document.write("			<option value=\"38\">|38|</option>");
							document.write("			<option value=\"39\">|39|</option>");
							document.write("			<option value=\"40\">|40|</option>");
							document.write("			<option value=\"41\">|41|</option>");
							document.write("			<option value=\"42\">|42|</option>");
							document.write("			<option value=\"43\">|43|</option>");
							document.write("			<option value=\"44\">|44|</option>");
							document.write("			<option value=\"45\">|45|</option>");
							document.write("			<option value=\"46\">|46|</option>");
							document.write("			<option value=\"47\">|47|</option>");
							document.write("			<option value=\"48\">|48|</option>");
							document.write("			<option value=\"49\">|49|</option>");
							document.write("			<option value=\"50\">|50|</option>");
							document.write("			<option value=\"Meses 0 a 1 (50) cm\">Meses 0 a 1 (50) cm</option>");
						    document.write("			<option value=\"Meses 1 a 2 (56) cm\">Meses 1 a 2 (56) cm</option>");
							document.write("			<option value=\"Meses 2 a 4 (62) cm\">Meses 2 a 4 (62) cm</option>");
							document.write("			<option value=\"Meses 4 a 6 (68) cm\">Meses 4 a 6 (68) cm</option>");
							document.write("			<option value=\"Meses 6 a 9 (74) cm\">Meses 6 a 9 (74) cm</option>");
							document.write("			<option value=\"Meses 9 a 12 (80) cm\">Meses 9 a 12 (80) cm</option>");
							document.write("			<option value=\"Meses 12 a 18 (86) cm\">Meses 12 a 18 (86) cm</option>");
							document.write("			<option value=\"Meses 18 a 24 (92) cm\">Meses 18 a 24 (92) cm</option>");
							document.write("			<option value=\"Años 2 a 3 (98) cm\">Años 2 a 3 (98) cm</option>");
							document.write("			<option value=\"Años 3 a 4 (104) cm\">Años 3 a 4 (104) cm</option>");
							document.write("			<option value=\"Años 4 a 5 (110) cm\">Años 4 a 5 (110) cm</option>");
							document.write("			<option value=\"Años 5 a 6 (116) cm\">Años 5 a 6 (116) cm</option>");
							document.write("			<option value=\"Años 6 a 7 (122) cm\">Años 6 a 7 (122) cm</option>");
							document.write("			<option value=\"Años 7 a 8 (128) cm\">Años 7 a 8 (128) cm</option>");
							document.write("			<option value=\"Años 8 a 9 (134) cm\">Años 8 a 9 (134) cm</option>");
							document.write("			<option value=\"Años 9 a 10 (140) cm\">Años 9 a 10 (140) cm</option>");
							document.write("			<option value=\"Años 10 a 11 (146) cm\">Años 10 a 11 (146) cm</option>");
							document.write("			<option value=\"Años 11 a 12 (152) cm\">Años 11 a 12 (152) cm</option>");
							document.write("			<option value=\"Años 12 a 13 (158) cm\">Años 12 a 13 (158) cm</option>");
							document.write("			<option value=\"Años 13 a 14 (164) cm\">Años 13 a 14 (164) cm</option>");
							document.write("			<option value=\"Años 14+ (170) cm\">Años 14+ (170) cm</option>");
							document.write("			<option value=\"70A\">70A</option>");
							document.write("			<option value=\"70B\">70B</option>");
							document.write("			<option value=\"70C\">70C</option>");
							document.write("			<option value=\"70D\">70D</option>");
							document.write("			<option value=\"70E\">70E</option>");
							document.write("			<option value=\"75A\">75A</option>");
							document.write("			<option value=\"75B\">75B</option>");
							document.write("			<option value=\"75C\">75C</option>");
							document.write("			<option value=\"75D\">75D</option>");
							document.write("			<option value=\"75E\">75E</option>");
							document.write("			<option value=\"80A\">80A</option>");
							document.write("			<option value=\"80B\">80B</option>");
							document.write("			<option value=\"80C\">80C</option>");
							document.write("			<option value=\"80D\">80D</option>");
							document.write("			<option value=\"80E\">80E</option>");
							document.write("			<option value=\"85A\">85A</option>");
							document.write("			<option value=\"85B\">85B</option>");
							document.write("			<option value=\"85C\">85C</option>");
							document.write("			<option value=\"85D\">85D</option>");
							document.write("			<option value=\"85E\">85E</option>");
							document.write("			<option value=\"90A\">90A</option>");
							document.write("			<option value=\"90B\">90B</option>");
							document.write("			<option value=\"90C\">90C</option>");
							document.write("			<option value=\"90D\">90D</option>");
							document.write("			<option value=\"90E\">90E</option>");
							document.write("			<option value=\"95A\">95A</option>");
							document.write("			<option value=\"95B\">95B</option>");
							document.write("			<option value=\"95C\">95C</option>");
							document.write("			<option value=\"95D\">95D</option>");
							document.write("			<option value=\"95E\">95E</option>");
							document.write("			<option value=\"100A\">100A</option>");
							document.write("			<option value=\"100B\">100B</option>");
							document.write("			<option value=\"100C\">100C</option>");
							document.write("			<option value=\"100D\">100D</option>");
							document.write("			<option value=\"100E\">100E</option>");
							document.write("			<option value=\"105A\">105A</option>");
							document.write("			<option value=\"105B\">105B</option>");
							document.write("			<option value=\"105C\">105C</option>");
							document.write("			<option value=\"105D\">105D</option>");
							document.write("			<option value=\"105E\">105E</option>");
							document.write("			<option value=\"110A\">110A</option>");
							document.write("			<option value=\"110B\">110B</option>");
							document.write("			<option value=\"110C\">110C</option>");
							document.write("			<option value=\"110D\">110D</option>");
							document.write("			<option value=\"110E\">110E</option>");
							document.write("			<option value=\"115A\">115A</option>");
							document.write("			<option value=\"115B\">115B</option>");
							document.write("			<option value=\"115C\">115C</option>");
							document.write("			<option value=\"115D\">115D</option>");
							document.write("			<option value=\"115E\">115E</option>");						
							document.write("		</select>");
							document.write("	</li>");
							document.write("</ul>");
							document.write("<BR>");
						} </script> 
						
						<div class="descripcion">
							<li><font color="red">*</font>Breve descripción</li>
							<li><textarea placeholder="Descripción del producto" name="descripcion" autocomplete="off" REQUIRED></textarea></li>
						</div>
						
						<center>
						<ul>
						<li class="enviar-producto"><input type="submit" value="Subir"/></li>
						</ul>
						</center>
						
					</div>
				</table>
			  </form>
			</div>
		</section>
		<!--fin-->
      </div> 
	   
</body>
</html>