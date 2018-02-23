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
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"> <!--Esto es para que el responsive se adacte a los dispositivos moviles-->
	<link rel="shortcut icon" href="imagenes/wiksay.ico" type="image/x-icon">
	<link rel="stylesheet" href="css/estilos-buscar-producto-tienda.css">
</head>

<body>
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
		     <center>
		      <div class="centro-2-1">
                <ul class="tabs-nav">
                  <center><a href="index.php"><li>#PRODUCTOS</li></a></center>
                  <center><a href="buscar-tienda.php"><li>#TIENDAS</li></a></center>
                </ul>
		      </div>
			 </center>
			 
		      <div class="contenido">
			   <center>
				<!-- inicio aqui se mostraran todos los productos-->
		         <center>
					<form class="buscador-sinfiltros" action="buscar-tienda.php" method="POST">
						<label class="buscador"></label><input type="text" name="buscar_tienda" placeholder="Busca tu tienda favorita..." id="buscar_tienda" />
						<input class="buscar" type="submit" value="BUSCAR" />
					</form>
				 </center>   


              
   
<?php
include ('cliente-php/conexion.bd.php');

if (isset($_POST['buscar_tienda'])){ // miramos si existe la variable
   $db = new conexion(); // conexion a la base de datos
   $filtro = $db->real_escape_string($_POST['buscar_tienda']); 
   $sql = $db->query("SELECT DISTINCT C.*, T.*, U.imagen FROM categoria_ti C, tienda T, usuario U, producto P WHERE C.id = T.categoria_t_id AND T.apodo_tienda=U.apodo AND U.id=T.usuario_id AND T.nombre_tienda LIKE '%$filtro%' AND T.id=P.tienda_id ORDER BY RAND();"); //seleccionamos en la base de datos las tiendas

   if($db->rows($sql) > 0){ // miramos si hay tiendas llamados igual que lo que incertamos en el buscador
         while ($tienda = $db->recorrer($sql)){ // recorremos todos las tiendas y ensellamos las que se llaman igual o parecido a lo que busque
         $verificar= 1;?> 
		        <article class="article-tienda">
					<figure>
						<a href="tienda.php?nombre=<?php echo utf8_encode($tienda['nombre_tienda']);?>" title="">
							<?php if (!empty($tienda['imagen'])){ ?>
								<img src="data:image/jpg;base64, <?php echo base64_encode($tienda['imagen']); ?>"  alt="<?php echo utf8_encode($tienda['nombre_tienda']); ?>">
							<?php }else{ ?>
								<img src="imagenes/perfil-cuadrada.png" alt="<?php echo utf8_encode($tienda['nombre_tienda']) ?>">
							<?php } ?>
						</a>
					</figure>
					<div class="inferior-centro-2">
					   <center><p class="nombre-tienda"><?php echo utf8_encode($tienda['nombre_tienda']); ?></p></center>
					   <center><p class="categoria"><?php echo utf8_encode($tienda['nombre_categoria_ti']); ?></p></center>
					</div>
                </article>
	     <?php }
   }else{
         echo 'No se han encontrado resultados';
         }  
}else{ //esto  es para que me muestro todas las tiendas al inicio, es decir, cuando aun no he buscado nada
            $conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
			$query = ("SELECT DISTINCT C.*, T.*, U.imagen FROM categoria_ti C, tienda T, usuario U, producto P WHERE C.id = T.categoria_t_id AND T.apodo_tienda=U.apodo AND U.id=T.usuario_id AND T.id=P.tienda_id ORDER BY RAND();");
			$resultado = $conexion->query($query);
			while($tienda = $resultado->fetch_assoc()){ 
                        $verificar= 1;?>
				<article class="article-tienda">
					<figure>
						<a href="tienda.php?nombre=<?php echo utf8_encode($tienda['nombre_tienda']);?>" title="">
							<?php if (!empty($tienda['imagen'])){ ?>
								<img src="data:image/jpg;base64, <?php echo base64_encode($tienda['imagen']); ?>"  alt="<?php echo utf8_encode($tienda['nombre_tienda']); ?>">
							<?php }else{ ?>
								<img src="imagenes/perfil-cuadrada.png" alt="<?php echo utf8_encode($tienda['nombre_tienda']);?>">
							<?php } ?>
						</a>
					</figure>
					<div class="inferior-centro-2">
						  <center><p class="nombre-tienda"><?php echo utf8_encode($tienda['nombre_tienda']); ?></p></center>
						  <center><p class="categoria"><?php echo utf8_encode($tienda['nombre_categoria_ti']); ?></p></center>
					</div>
                </article>				  
	  <?php }
	 
	 }if (isset ($verificar) AND $verificar == 1){
				// no ago nada
				}else{echo '<br><center><p>En estos momentos no tenemos ninguna tienda disponible en nuestra plataforma.</p></center>';} ?>
		 
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