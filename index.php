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
	<link rel="alternate" hreflang="es" href="http://www.wiksay.com" />
	<meta name="description" content="Crea una cuenta en Wiksay. Conecta con tiendas y diseñadores. Comparte, comenta, dale like y encuentra cualquier articulo. Envía mensajes y...">
	<meta name="keywords" content="Wiksay, tiendas, ropa, comunicación, red social, comprar, productos"/>
	<meta name="viewport" content="width=device-width"> <!--Esto es para que el responsive se adacte a los dispositivos moviles-->
	<link rel="shortcut icon" href="imagenes/wiksay.ico" type="image/x-icon">
	<meta name="robots" content="noodp">
	<link rel="stylesheet" href="css/estilos-buscar-producto-tienda.css">
</head>

<body>
<!-- google analitics-->
<?php include_once("analyticstracking.php") ?>

      <div id="gloval">
        <header class="superior">
		      <div class="registrarse">
			     <ul>
					<li class="menu1"><a href="index.php"><b>Wiksay</b></a></li>
					<li class="menu2" title="Iniciar Sesión"><a href="inicio.php">Iniciar Sesión</a></li>
			  	    <li class="menu4">|</li>
			   	    <li class="menu5" title="Registrarme"><a href="inicio.php">Registrarme</a></li>
				 </ul>
			   </div>			  
        </header>
		<footer>
		   
		    <section class="centro-2">
		    <?php 
				// inicio avisos
				if (isset($_REQUEST['proceso'])){
					$proceso = $_REQUEST['proceso'];
					if ($proceso == 'cuenta_eliminada') {  
						echo '<center><div><a href="http://www.wiksay.com/"><div class="proceso"><b>Cuenta eliminada.</b><br> Esperamos volver a verte en nuestra comunidad.</div></a></div></center>';
					} else {}; 
				}else{};
				// final aviso
			?>    
				<div class="centro-2-1">
					<ul class="tabs-nav">
						<center><a href="index.php"><li># PRODUCTOS</li></a></center>
						<center><a href="buscar-tienda.php"><li># TIENDAS</li></a></center>
					</ul>
				</div>
				
		        <div class="contenido">
					<center>
					<!-- inicio aqui se mostraran todos los productos-->
					<center> 
					
					<?php
					if (isset($_REQUEST['categoria_id']) AND !empty($_REQUEST['categoria_id'])) {$sinfiltros_categoria = 'categoria_id='.$_REQUEST['categoria_id'];}else{$sinfiltros_categoria="";}
					if (isset($_REQUEST['color']) AND !empty($_REQUEST['color'])) {$sinfiltros_talla = 'color='.$_REQUEST['color'];}else{$sinfiltros_talla="";}
					if (isset($_REQUEST['talla']) AND !empty($_REQUEST['talla'])) {$sinfiltros_color = 'talla='.$_REQUEST['talla'];}else{$sinfiltros_color="";}
					if (isset($_REQUEST['provincia']) AND !empty($_REQUEST['provincia'])) {$sinfiltros_provincia = 'provincia='.$_REQUEST['provincia'];}else{$sinfiltros_provincia="";}	
					?>
					    
						<form class="buscador-sinfiltros" action="index.php?<?php echo $sinfiltros_talla?>"  method="GET">
							<label class="buscador"></label><input type="text" placeholder="Busca tu propio estilo..." name="buscar" id="buscar"/>
							<input class="buscar" type="submit" value="BUSCAR"/>
						</form>
					</center>   
					
					<?php // INICIO AQUI COMIENZA LA BUSQUEDA POR FILTROS ?> 
							   
					<div class="formulario">
						<div class="filtros-busqueda">      
						<center>
							<!--Inicio: aqui muestro las categorias de los productos que hay en la tienda-->
										
							<div class="categoria">CATEGORIAS<span class="icon-arrow-down6"></span>
								<ul  class="sub-categoria">
									<?php 
									$conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
									if (isset($_REQUEST['buscar']) AND !empty($_REQUEST['buscar'])) {$buscar_encategoria = 'buscar='.$_REQUEST['buscar'].'&';}else{$buscar_encategoria="";}
									if (isset($_REQUEST['color']) AND !empty($_REQUEST['color'])) {$color_encategoria = 'color='.$_REQUEST['color'].'&';}else{$color_encategoria="";}
									if (isset($_REQUEST['talla']) AND !empty($_REQUEST['talla'])) {$talla_encategoria = 'talla='.$_REQUEST['talla'].'&';}else{$talla_encategoria="";}
									if (isset($_REQUEST['provincia']) AND !empty($_REQUEST['provincia'])) {$provincia_encategoria = 'provincia='.$_REQUEST['provincia'].'&';}else{$provincia_encategoria="";}
									
									$niña_decode = utf8_decode('Niña');
									$niño_decode = utf8_decode('Niño');
									$query_mujer = ("SELECT DISTINCT C.* FROM categoria_pr C, producto P WHERE P.categoria_p_id=C.id AND (genero='Mujer' OR genero='Hombre' OR genero='Unisex' OR genero='$niña_decode' OR genero='$niño_decode' OR genero='Bebe' OR genero='Premama');");
									$resultado = $conexion->query($query_mujer);
									while($categoria = $resultado->fetch_assoc()){ ?> 
										<li class="sub-categoria-listado">
											<a href="index.php?<?php echo $buscar_encategoria?>categoria_id=<?php echo utf8_encode($categoria['id']).'&';?><?php echo $color_encategoria?><?php echo $talla_encategoria?><?php echo $provincia_encategoria?>"><?php echo utf8_encode($categoria['genero']),' ',utf8_encode($categoria['nombre_categoria']),' ',utf8_encode($categoria['zapatos']),' ',utf8_encode($categoria['accesorios']),' ',utf8_encode($categoria['ropa_interior']);?></a>
										</li>
									<?php } ?>
								</ul>
							</div>

							<div class="separador"></div>
										
									  <!--INICIO COLORES-->
							<div class="colores">COLORES<span class="icon-arrow-down6"></span>
								<ul  class="sub-colores">
									<?php 
									$conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
									if (isset($_REQUEST['buscar']) AND !empty($_REQUEST['buscar'])) {$buscar_color = 'buscar='.$_REQUEST['buscar'].'&';}else{$buscar_color="";}
									if (isset($_REQUEST['categoria_id']) AND !empty($_REQUEST['categoria_id'])) {$categoria_color = 'categoria_id='.$_REQUEST['categoria_id'].'&';}else{$categoria_color="";}
									if (isset($_REQUEST['talla']) AND !empty($_REQUEST['talla'])) {$talla_color = 'talla='.$_REQUEST['talla'].'&';}else{$talla_color="";}
									if (isset($_REQUEST['provincia']) AND !empty($_REQUEST['provincia'])) {$provincia_color = 'provincia='.$_REQUEST['provincia'].'&';}else{$provincia_color="";}
									$query77 = ("SELECT DISTINCT nombre_color FROM color ");  // el $id ya esta llamado en el submenu de mujer 
									$resultado77 = $conexion->query($query77);
									while($colores = $resultado77->fetch_assoc()){ ?>
										<li class="sub-colores-listado">
											<a href="index.php?<?php echo $buscar_color?><?php echo $categoria_color?>color=<?php echo $colores['nombre_color'].'&';?><?php echo $talla_color?><?php echo $provincia_color?>"><div class="colores-sinseleccionada"><div class="<?php echo $colores['nombre_color']; ?>" title="<?php echo $colores['nombre_color']; ?>"></div></div></a>
										</li>
									<?php } ?>
								</ul>
							</div>
									  <!--FINAL COLORES-->
									  <!--INICIO TALLAS-->
							<div class="tallas">TALLAS<span class="icon-arrow-down6"></span>
								<ul class="sub-tallas">
									<?php 
									$conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
									if (isset($_REQUEST['buscar']) AND !empty($_REQUEST['buscar'])) {$buscar_talla = 'buscar='.$_REQUEST['buscar'].'&';}else{$buscar_talla="";}
									if (isset($_REQUEST['categoria_id']) AND !empty($_REQUEST['categoria_id'])) {$categoria_talla = 'categoria_id='.$_REQUEST['categoria_id'].'&';}else{$categoria_talla="";}
									if (isset($_REQUEST['color']) AND !empty($_REQUEST['color'])) {$color_talla = 'color='.$_REQUEST['color'].'&';}else{$color_talla="";}
									if (isset($_REQUEST['provincia']) AND !empty($_REQUEST['provincia'])) {$provincia_talla = 'provincia='.$_REQUEST['provincia'].'&';}else{$provincia_talla="";}
									$query81 = ("SELECT DISTINCT nombre_talla FROM color");  // el $id ya esta llamado en el submenu de mujer 
									$resultado81 = $conexion->query($query81);
									while($tallas = $resultado81->fetch_assoc()){ ?>
										<li class="sub-tallas-listado">
											<a href="index.php?<?php echo $buscar_talla?><?php echo $categoria_talla?><?php echo $color_talla?>talla=<?php echo utf8_encode($tallas['nombre_talla']).'&';?><?php echo $provincia_talla?>"><div class="tallas-sinseleccionada"><?php echo utf8_encode($tallas['nombre_talla']); ?></div></a>
										</li>
									<?php } ?> 
								</ul>
							</div>
							<?php /* ?>
							<div class="lugar">POVINCIA<span class="icon-arrow-down6"></span>
								<ul class="sub-lugar">
									<?php 
									$conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
									if (isset($_REQUEST['buscar']) AND !empty($_REQUEST['buscar'])) {$buscar_provincia = 'buscar='.$_REQUEST['buscar'].'&';}else{$buscar_provincia="";}
									if (isset($_REQUEST['categoria_id']) AND !empty($_REQUEST['categoria_id'])) {$categoria_provincia = 'categoria_id='.$_REQUEST['categoria_id'].'&';}else{$categoria_provincia="";}
									if (isset($_REQUEST['talla']) AND !empty($_REQUEST['talla'])) {$talla_provincia = 'talla='.$_REQUEST['talla'].'&';}else{$talla_provincia="";}
									if (isset($_REQUEST['color']) AND !empty($_REQUEST['color'])) {$color_provincia = 'color='.$_REQUEST['color'].'&';}else{$color_provincia="";}
									$query82 = ("SELECT DISTINCT provincia_empresa FROM empresa");  // el $id ya esta llamado en el submenu de mujer 
									$resultado81 = $conexion->query($query82);
									while($lugar = $resultado81->fetch_assoc()){ ?>
										<li class="sub-lugar-listado">
											<a href="index.php?<?php echo $buscar_provincia?><?php echo $categoria_provincia?><?php echo $talla_provincia?><?php echo $color_provincia?>provincia=<?php echo utf8_encode($lugar['provincia_empresa']).'&';?>"><div class="lugar-sinseleccionada"><?php echo utf8_encode($lugar['provincia_empresa']); ?></div></a>
										</li>
									<?php } ?> 
								</ul>
							</div>
							<?php */ ?>
									  <!--FINAL TALLAS-->		  
							</center>
							<div class="historial">
							<?php
							if (isset($_REQUEST['buscar']) AND !empty($_REQUEST['buscar'])) {$resultado_buscar = 'buscar='.$_REQUEST['buscar'].'&';}else{$resultado_buscar="";}
							if (isset($_REQUEST['categoria_id']) AND !empty($_REQUEST['categoria_id'])) {$resultado_categoria = 'categoria_id='.$_REQUEST['categoria_id'].'&';}else{$resultado_categoria="";}
							if (isset($_REQUEST['color']) AND !empty($_REQUEST['color'])) {$resultado_talla = 'color='.$_REQUEST['color'].'&';}else{$resultado_talla="";}
							if (isset($_REQUEST['talla']) AND !empty($_REQUEST['talla'])) {$resultado_color = 'talla='.$_REQUEST['talla'].'&';}else{$resultado_color="";}
							if (isset($_REQUEST['provincia']) AND !empty($_REQUEST['provincia'])) {$resultado_provincia = 'provincia='.$_REQUEST['provincia'].'&';}else{$resultado_provincia="";}
							
							if (isset($_REQUEST['categoria_id']) AND !empty($_REQUEST['categoria_id'])) {
								$categoria_seleccionada =$_REQUEST['categoria_id'];
								$conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
								$query11 = ("SELECT DISTINCT * FROM categoria_pr WHERE id='$categoria_seleccionada' AND (genero='Mujer' OR genero='Hombre' OR genero='Unisex' OR genero='$niña_decode' OR genero='$niño_decode' OR genero='Bebe' OR genero='Premama');");
								$resultado = $conexion->query($query11);
								$categoria_nombre = $resultado->fetch_assoc();
								echo $categoria_p = '<p> Categoria: '.$categoria_nombre['genero'].' '.$categoria_nombre['nombre_categoria'].' '.$categoria_nombre['zapatos'].' '.$categoria_nombre['accesorios'].' '.$categoria_nombre['ropa_interior'].''?> <a href="index.php?<?php echo $resultado_buscar.''.$resultado_talla.''.$resultado_color.''.$resultado_provincia ?>"><font color="red"> X </font></a></p> <?php ;
							}else{$categoria_p="";}
									
							if (isset($_REQUEST['color']) AND !empty($_REQUEST['color'])) { echo $color_p ='<p> Color: '.$_REQUEST['color'].''?><a href="index.php?<?php echo $resultado_buscar.''.$resultado_categoria.''.$resultado_color.''.$resultado_provincia ?>"><font color="red"> X </font></a></p> <?php }else{$color_p="";}	
							if (isset($_REQUEST['talla']) AND !empty($_REQUEST['talla'])) {echo $talla_p ='<p> Talla: '.$_REQUEST['talla'].''?><a href="index.php?<?php echo $resultado_buscar.''.$resultado_categoria.''.$resultado_talla.''.$resultado_provincia ?>"><font color="red"> X </font></a></p><?php }else{$talla_p="";}
							if (isset($_REQUEST['provincia']) AND !empty($_REQUEST['provincia'])) {echo $provincia_p ='<p> Provincia: '.$_REQUEST['provincia'].''?><a href="index.php?<?php echo $resultado_buscar.''.$resultado_categoria.''.$resultado_talla.''.$resultado_color ?>"><font color="red"> X </font></a></p><?php }else{$provincia_p="";}
							?>
							</div>
						</div>	
					</div>
					
						<?php
						if ((isset($_REQUEST['buscar']) AND !empty($_REQUEST['buscar'])) OR (isset($_REQUEST['categoria_id']) AND !empty($_REQUEST['categoria_id'])) OR (isset($_REQUEST['color']) AND !empty($_REQUEST['color'])) OR
						(isset($_REQUEST['talla']) AND !empty($_REQUEST['talla'])) OR (isset($_REQUEST['provincia']) AND !empty($_REQUEST['provincia']))){
							include ('cliente-php/conexion.bd.php');
							 $db = new conexion(); // conexion a la base de datos
							 
							if (isset($_REQUEST['buscar']) AND !empty($_REQUEST['buscar'])) {$filtro_buscar = "AND P.nombre LIKE '%".$_REQUEST['buscar']."%'";}else{$filtro_buscar="";}
							if (isset($_REQUEST['categoria_id']) AND !empty($_REQUEST['categoria_id'])) {$filtro_categoria = "AND P.categoria_p_id='".$db->real_escape_string(utf8_decode($_REQUEST['categoria_id']))."'";}else{$filtro_categoria="";}
							if (isset($_REQUEST['color']) AND !empty($_REQUEST['color'])) {$filtro_color = "AND P.id=C.producto_id AND C.nombre_color='".$db->real_escape_string(utf8_decode($_REQUEST['color']))."'";}else{$filtro_color="";}
							if (isset($_REQUEST['talla']) AND !empty($_REQUEST['talla'])) {$filtro_talla = "AND P.id=C.producto_id AND C.nombre_talla='".$db->real_escape_string(utf8_decode($_REQUEST['talla']))."'";}else{$filtro_talla="";}
							// me falta este: if (isset($_REQUEST['provincia']) AND !empty($_REQUEST['provincia'])) {$filtro_provincia = "AND E.provincia_empresa='".$db->real_escape_string(utf8_decode($_REQUEST['provincia']))."'";}else{$filtro_provincia="";} 
							   
								$conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
								$buscar_producto = ("SELECT DISTINCT P.*, T.nombre_tienda FROM producto P, tienda T, color C WHERE P.id!='' $filtro_categoria $filtro_color $filtro_talla $filtro_buscar AND P.tienda_id=T.id  ORDER BY RAND() LIMIT 500;"); //seleccionamos en la base de datos los productos
								$resultado = $conexion->query($buscar_producto);
								while($producto = $resultado->fetch_assoc()){ // recorremos todos los productos y ensellamos los que se llaman igual o parecido a lo que busque
								$verificar= 1; ?> 
									<article class="article-producto">
									<figure><a href="producto.php?id=<?php echo $producto['id'];?>" title=""><img src="data:image/jpg;base64, <?php echo base64_encode($producto['imagen']); ?>" alt="<?php echo $producto['nombre']; ?>"></a></figure>
										<div class="inferior-centro-1">
											<center><p class="nombre-tiendas"><?php echo $producto['nombre_tienda']; ?></p></center>
											<center><p class="nombre-producto"><?php echo $producto['nombre']; ?></p></center>
											<center><p class="precio"><?php echo $producto['precio'],' €'; ?></p></center>
										</div>
									</article>
								<?php 
								} 
								if (isset ($verificar) AND $verificar == 1){
									// no ago nada
								}else{echo '<br><center><p>No se han encontrado artículos con esas características.</p></center>';}								
						}else{ //esto  es para que me muestro todos los productos al inicio, es decir, cuando aun no he buscado nada
								$conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
								$query = ("SELECT P.*, T.nombre_tienda FROM producto P, tienda T WHERE P.tienda_id=T.id ORDER BY RAND() LIMIT 500;");
								$resultado = $conexion->query($query);
								while($producto = $resultado->fetch_assoc()){ ?>
									<article class="article-producto">
										<figure><a href="producto.php?id=<?php echo utf8_encode($producto['id']);?>" title=""><img src="data:image/jpg;base64, <?php echo base64_encode($producto['imagen']); ?>" alt="<?php echo $producto['nombre']; ?>"></a></figure>
										<div class="inferior-centro-1">
											<center><p class="nombre-tiendas"><?php echo utf8_encode($producto['nombre_tienda']); ?></p></center>
											<center><p class="nombre-producto"><?php echo utf8_encode($producto['nombre']); ?></p></center>
											<center><p class="precio"><?php echo $producto['precio'],' €'; ?></p></center>
										</div>
									</article>
											 <?php } $resultado->close(); $conexion->close();	 
						} ?>			 
										<!-- final aqui se mostraran todos los productos-->	
					</center>
	            </div>
		    </section>
		
		   <div class="fondo">
		   <center>
		      <ul>
			     <li class="queeswiksay"><b><a href="inicio-que-es-wiksay.php"><b>¿Qué es Wiksay?</b></a></li>
				 <li><a href="inicio-condiciones-legales.php"><b>Condiciones legales</b></a></li>
				 <li><a href="inicio-politica-privacidad.php"><b>Privacidad</b></a></li>
				 <li><a href="inicio-politica-cookies.php"><b>Cookies</b></a></li>
			  </ul>
			</center>
		   </div>
		
		</footer>   
      </div>
</body>
</html>