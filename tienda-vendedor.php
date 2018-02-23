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

<?php
	// compruebo: si el usuario tiene tienda lo dejo entrar, sino tiene lo redirijo a la pagina cliente.php
	if(utf8_encode($id_tienda['apodo_tienda']) != $user) { ?> <script>location.href="cliente.php";</script> <?php ;}
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
	<link rel="stylesheet" href="css/estilos-tienda-vendedor.css">
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
		   <?php include('crear-tienda-php/mostrar-datos-user.php');?><!--PHP. estas lineas de php es para mostrar los datos-->
		   <?php include('cabecera/controles.php');?>
		  <section class="centro-1">
            <div>
				 <div class="categoria">CATEGORIAS:</div>
				 
				<?php 
				$conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
				$id = $informacion_tienda['id'];
				$query_mujer = ("SELECT DISTINCT C.* FROM producto P, categoria_pr C WHERE (C.genero='Unisex' OR C.genero='Mujer') AND C.id=P.categoria_p_id AND P.tienda_id='$id';");
				$resultado = $conexion->query($query_mujer);
				$mujer1 = $resultado->fetch_assoc();
				if (!empty($mujer1['id'])){
				?>
				 <div class="mujer"><center><p><b>MUJER</b></p></center>
				    <ul class="mujer-sub">
					    <!--Inicio: aqui muestro las categorias de los productos que hay en la tienda-->
					    <?php 
						$conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
					    $query_mujer = ("SELECT DISTINCT C.* FROM producto P, categoria_pr C WHERE (C.genero='Unisex' OR C.genero='Mujer') AND C.id=P.categoria_p_id AND P.tienda_id='$id';");
					    $resultado = $conexion->query($query_mujer);
					    while($mujer = $resultado->fetch_assoc()){ ?>
				        <a href="tienda-vendedor.php?tienda_id=<?php echo $informacion_tienda['id']; ?>&id=<?php echo $mujer['id']; ?>"><li class="categorias-mujer"><?php echo utf8_encode($mujer['genero']),' ',utf8_encode($mujer['nombre_categoria']),' ',utf8_encode($mujer['zapatos']),' ',utf8_encode($mujer['accesorios']),' ',utf8_encode($mujer['ropa_interior']);?></li></a>
                        <?php } ?>
					    <a href="tienda-vendedor.php"><li class="categorias-mujer">Todos</li></a> <!--esto lo ago para que se muestren todos los productos-->							
                    </ul>
				 </div>
				<?php }else{} ?>
				 
				<?php 
				$conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
				$query_hombre = ("SELECT DISTINCT C.* FROM producto P, categoria_pr C WHERE (C.genero='Unisex' OR C.genero='Hombre') AND C.id=P.categoria_p_id AND P.tienda_id='$id';"); // el $id ya esta llamado en el submenu de mujer 
				$resultado = $conexion->query($query_hombre);
				$hombre1 = $resultado->fetch_assoc();
				if (!empty($hombre1['id'])){
				?> 
				 <div class="hombre"><center><p><b>HOMBRE</b></p></center>
				    <ul class="hombre-sub">
					    <?php 
						$conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
					    $query_hombre = ("SELECT DISTINCT C.* FROM producto P, categoria_pr C WHERE (C.genero='Unisex' OR C.genero='Hombre') AND C.id=P.categoria_p_id AND P.tienda_id='$id';"); // el $id ya esta llamado en el submenu de mujer 
					    $resultado = $conexion->query($query_hombre);
					    while($hombre = $resultado->fetch_assoc()){ ?>
				        <a href="tienda-vendedor.php?tienda_id=<?php echo $informacion_tienda['id']; ?>&id=<?php echo $hombre['id']; ?>"><li class="categorias-hombre"><?php echo utf8_encode($hombre['genero']),' ',utf8_encode($hombre['nombre_categoria']),' ',utf8_encode($hombre['zapatos']),' ',utf8_encode($hombre['accesorios']),' ',utf8_encode($hombre['ropa_interior']);?></li></a>
                        <?php } ?>
						<a href="tienda-vendedor.php"><li class="categorias-hombre">Todos</li></a> <!--esto lo ago para que se muestren todos los productos-->							
                    </ul>
				 </div>
				<?php }else{} ?>
				 
				<?php 
				$conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
				$niña_decode = utf8_decode('Niña');
				$query_niña = ("SELECT DISTINCT C.* FROM producto P, categoria_pr C WHERE C.genero='$niña_decode' AND C.id=P.categoria_p_id AND P.tienda_id='$id';"); // el $id ya esta llamado en el submenu de mujer 
				$resultado = $conexion->query($query_niña);
				$niña1 = $resultado->fetch_assoc();
				if (!empty($niña1['id'])){
				?> 
				 <div class="niña"><center><p><b>NIÑA</b></p></center>
				    <ul class="niña-sub">
					    <?php 
						$conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
						$query_niña = ("SELECT DISTINCT C.* FROM producto P, categoria_pr C WHERE C.genero='$niña_decode' AND C.id=P.categoria_p_id AND P.tienda_id='$id';"); // el $id ya esta llamado en el submenu de mujer 
					    $resultado = $conexion->query($query_niña);
					    while($niña = $resultado->fetch_assoc()){ ?>
				        <a href="tienda-vendedor.php?tienda_id=<?php echo $informacion_tienda['id']; ?>&id=<?php echo $niña['id']; ?>"><li class="categorias-niña"><?php echo utf8_encode($niña['genero']),' ',utf8_encode($niña['nombre_categoria']),' ',utf8_encode($niña['zapatos']),' ',utf8_encode($niña['accesorios']),' ',utf8_encode($niña['ropa_interior']);?></li></a>
                        <?php } ?>
					    <a href="tienda-vendedor.php"><li class="categorias-niña">Todos</li></a> <!--esto lo ago para que se muestren todos los productos-->							
                    </ul>
				 </div>
				<?php }else{} ?>
				 
				<?php 
				$conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
				$niño_decode = utf8_decode('Niño');
				$query_niño = ("SELECT DISTINCT C.* FROM producto P, categoria_pr C WHERE C.genero='$niño_decode' AND C.id=P.categoria_p_id AND P.tienda_id='$id';"); // el $id ya esta llamado en el submenu de mujer 
				$resultado = $conexion->query($query_niño);
				$niño1 = $resultado->fetch_assoc();
				if (!empty($niño1['id'])){
				?>
				 <div class="niño"><center><p><b>NIÑO</b></p></center>
				    <ul class="niño-sub">
					    <?php 
						$conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
					    $query_niño = ("SELECT DISTINCT C.* FROM producto P, categoria_pr C WHERE C.genero='$niño_decode' AND C.id=P.categoria_p_id AND P.tienda_id='$id';"); // el $id ya esta llamado en el submenu de mujer 
					    $resultado = $conexion->query($query_niño);
					    while($niño = $resultado->fetch_assoc()){ ?>
				        <a href="tienda-vendedor.php?tienda_id=<?php echo $informacion_tienda['id']; ?>&id=<?php echo $niño['id']; ?>"><li class="categorias-niño"><?php echo utf8_encode($niño['genero']),' ',utf8_encode($niño['nombre_categoria']),' ',utf8_encode($niño['zapatos']),' ',utf8_encode($niño['accesorios']),' ',utf8_encode($niño['ropa_interior']);?></li></a>
                        <?php } ?>
					    <a href="tienda-vendedor.php"><li class="categorias-niño">Todos</li></a> <!--esto lo ago para que se muestren todos los productos-->								
                    </ul>
				 </div>
				<?php }else{} ?>
				 
				<?php 
				$conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
				$query_bebe = ("SELECT DISTINCT C.* FROM producto P, categoria_pr C WHERE C.genero='Bebe' AND C.id=P.categoria_p_id AND P.tienda_id='$id';"); // el $id ya esta llamado en el submenu de mujer 
				$resultado = $conexion->query($query_bebe);
				$bebe1 = $resultado->fetch_assoc();
				if (!empty($bebe1['id'])){
				?>
				 <div class="bebe"><center><p><b>BEBE</b></p></center>
				    <ul class="bebe-sub">
					    <?php 
						$conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
					    $query_bebe = ("SELECT DISTINCT C.* FROM producto P, categoria_pr C WHERE C.genero='Bebe' AND C.id=P.categoria_p_id AND P.tienda_id='$id';"); // el $id ya esta llamado en el submenu de mujer 
					    $resultado = $conexion->query($query_bebe);
					    while($bebe = $resultado->fetch_assoc()){ ?>
				        <a href="tienda-vendedor.php?tienda_id=<?php echo $informacion_tienda['id']; ?>&id=<?php echo $bebe['id']; ?>"><li class="categorias-bebe"><?php echo utf8_encode($bebe['genero']),' ',utf8_encode($bebe['nombre_categoria']),' ',utf8_encode($bebe['zapatos']),' ',utf8_encode($bebe['accesorios']),' ',utf8_encode($bebe['ropa_interior']);?></li></a>
                        <?php } ?>
					    <a href="tienda-vendedor.php"><li class="categorias-bebe">Todos</li></a> <!--esto lo ago para que se muestren todos los productos-->								
                    </ul>
				 </div>
				<?php }else{} ?>
				 
				<?php 
				$conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
				$query_premama = ("SELECT DISTINCT C.* FROM producto P, categoria_pr C WHERE C.genero='Premama' AND C.id=P.categoria_p_id AND P.tienda_id='$id';"); // el $id ya esta llamado en el submenu de mujer 
				$resultado = $conexion->query($query_premama);
				$premama1 = $resultado->fetch_assoc();
				if (!empty($premama1['id'])){
				?>
				 <div class="premama"><center><p><b>PREMAMÁ</b></p></center>
				    <ul class="premama-sub">
					    <?php 
						$conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
					    $query_premama = ("SELECT DISTINCT C.* FROM producto P, categoria_pr C WHERE C.genero='Premama' AND C.id=P.categoria_p_id AND P.tienda_id='$id';"); // el $id ya esta llamado en el submenu de mujer 
					    $resultado = $conexion->query($query_premama);
					    while($premama = $resultado->fetch_assoc()){ ?>
				        <a href="tienda-vendedor.php?tienda_id=<?php echo $informacion_tienda['id']; ?>&id=<?php echo $premama['id']; ?>"><li class="categorias-premama"><?php echo utf8_encode($premama['genero']),' ',utf8_encode($premama['nombre_categoria']),' ',utf8_encode($premama['zapatos']),' ',utf8_encode($premama['accesorios']),' ',utf8_encode($premama['ropa_interior']);?></li></a>
                        <?php } ?>
					    <a href="tienda-vendedor.php"><li class="categorias-premama">Todos</li></a> <!--esto lo ago para que se muestren todos los productos-->
                        <!--final: aqui muestro las categorias de los productos que hay en la tienda-->									
                    </ul>
				 </div>
				<?php }else{} ?>
				
				<?php 
				$conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
				$query_hogar = ("SELECT DISTINCT C.* FROM producto P, categoria_pr C WHERE C.genero='Hogar' AND C.id=P.categoria_p_id AND P.tienda_id='$id';"); // el $id ya esta llamado en el submenu de mujer 
				$resultado = $conexion->query($query_hogar);
				$hogar1 = $resultado->fetch_assoc();
				if (!empty($hogar1['id'])){
				?>
				 <div class="premama"><center><p><b>HOGAR</b></p></center>
				    <ul class="premama-sub">
					    <?php 
						$conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
					    $query_hogar = ("SELECT DISTINCT C.* FROM producto P, categoria_pr C WHERE C.genero='Hogar' AND C.id=P.categoria_p_id AND P.tienda_id='$id';"); // el $id ya esta llamado en el submenu de mujer 
					    $resultado = $conexion->query($query_hogar);
					    while($hogar = $resultado->fetch_assoc()){ ?>
				        <a href="tienda-vendedor.php?tienda_id=<?php echo $informacion_tienda['id']; ?>&id=<?php echo $hogar['id']; ?>"><li class="categorias-premama"><?php echo utf8_encode($hogar['genero']),' ',utf8_encode($hogar['nombre_categoria']);?></li></a>
                        <?php } ?>
					    <a href="tienda-vendedor.php"><li class="categorias-premama">Todos</li></a> <!--esto lo ago para que se muestren todos los productos-->
                        <!--final: aqui muestro las categorias de los productos que hay en la tienda-->									
                    </ul>
				 </div>
				 <?php }else{} ?>
            </div>
		  </section>
		</section>
		
		<?php 
		    // inicio avisos
			if (isset($_REQUEST['proceso'])){
				$proceso = $_REQUEST['proceso'];
				if ($proceso == 'subido') {  
					echo '<center><div><a href="http://www.wiksay.com/tienda-vendedor.php"><div class="proceso">Excelente. El artículo se ha incluido en la tienda.<span> X</span></div></a></div></center>';
				} else if ($proceso == 'eliminado') { 
					echo '<center><div><a href="http://www.wiksay.com/tienda-vendedor.php"><div class="proceso">Excelente. El articulo se ha eliminado.<span> X</span></div></a></div></center>';
				} else if ($proceso == 'borrar') { 
					echo '<center><div><a href="http://www.wiksay.com/tienda-vendedor.php"><div class="proceso1">Lo sentimos. No se ha podido borrar el artículo.<span> X</span></div></a></div></center>';
				} else if ($proceso == 'nomodificado') { 
					echo '<center><div><a href="http://www.wiksay.com/tienda-vendedor.php"><div class="proceso1">Lo sentimos. No se ha podido guardar los cambios.<span> X</span></div></a></div></center>';
				} else if ($proceso == 'malsubido') { 
					echo '<center><div><a href="http://www.wiksay.com/tienda-vendedor.php"><div class="proceso1">Lo sentimos. No se ha podido subir el artículo.<span> X</span></div></a></div></center>'; 
				} else {}; 
			}else{};
			// final aviso
		?>
		
		   <section class="social">
		   <?php include('crear-tienda-php/mostrar-datos-user.php');?><!--PHP. estas lineas de php es para mostrar los datos-->
		      <ul>
		         <?php
			     if ($social['facebook'] != NULL ){ ?>
			        <li title="Facebook"><a href="<?php echo $social['facebook'] ?>" target="_blank" class="icon-facebook"></a></li>
			     <?php }else{};
				 if ($social['whatsapp'] != NULL){ ?>
			        <li class="whatsapp" title="Whatsapp<?php echo ' ',$social['whatsapp']; ?>"><font size="5px"><a class="fa fa-whatsapp"></a></font></li>
			     <?php }else{}
			     if ($social['instagram'] != NULL ){ ?>
			        <li title="Instagram"><a href="<?php echo $social['instagram'] ?>" target="_blank" class="icon-instagram"></a></li>
			     <?php }else{}
			     if ($social['twitter'] != NULL ){ ?>
			        <li title="Twitter"><a href="<?php echo $social['twitter'] ?>" target="_blank" class="icon-twitter"></a></li>
			     <?php }else{}
				 if ($social['youtube'] != NULL){ ?>
			        <li class="youtube" title="Youtube"><font size="5px"><a href="<?php echo $social['youtube'] ?>" target="_blank" class="fa fa-youtube"></a></font></li>
			     <?php }else{}
			     if ($social['googleplus'] != NULL){ ?>
			        <li title="Google+"><a href="<?php echo $social['googleplus'] ?>" target="_blank" class="icon-googleplus"></a></li>
			     <?php }else{}
			     if ($social['pinterest'] != NULL){ ?>
			        <li title="Pinterest"><a href="<?php echo $social['pinterest'] ?>" target="_blank" class="icon-pinterest"></a></li>
			     <?php }else{}
			     if ($social['linkedin'] != NULL){ ?>
			        <li title="Linkedin"><a href="<?php echo $social['linkedin'] ?>" target="_blank" class="icon-linkedin"></a></li>
			     <?php }else{}
				 if ($social['mapa'] != NULL){ ?>
			        <li title="Google Maps"><a href="<?php echo $social['mapa'] ?>" target="_blank" class="icon-location"></a></li>
			     <?php }else{}?>						
		      </ul>
		   </section>
		   
		    
		   
		   	  <?php 
	 // recojo los datos pasado por url para introducirlos en el FORM y poder hacer los filtros de la categoria seleccionada
		      if (isset($_REQUEST['tienda_id']) AND !empty($_REQUEST['tienda_id'])) {$tienda_id_url = $_REQUEST['tienda_id']; } else{};
			  if (isset($_REQUEST['id']) AND !empty($_REQUEST['id'])) {$categoria_url = $_REQUEST['id']; } else{};
	// si hay una categoria seleccionada, entonces muestro la busqueda por filtros. si no la hay no muestrero nada
			  if (isset($tienda_id_url) AND isset($categoria_url)) { 
		      ?>
			<section id="centro-3">
			  <form action="">
		                   <!--INICIO COLORES-->
				<div class="colores"><center><p><b>COLORES</b></p></center>
					<center>
						<?php $conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
						if (isset($_REQUEST['tallas']) AND !empty($_REQUEST['tallas'])){$tallas_color='&tallas='.$_REQUEST['tallas'];}else{$tallas_color="";}
						$id_tienda_url = $_REQUEST['tienda_id'];
						$id_categoria_url = $_REQUEST['id'];
						$query = ("SELECT DISTINCT C.nombre_color FROM color C, producto P WHERE C.producto_id=P.id AND P.tienda_id='$id_tienda_url' AND P.categoria_p_id='$id_categoria_url'");  // el $id ya esta llamado en el submenu de mujer 
						$resultado = $conexion->query($query);
						while($colores = $resultado->fetch_assoc()){ ?>
							<a href="tienda-vendedor.php?tienda_id=<?php echo $_REQUEST['tienda_id']; ?>&id=<?php echo $_REQUEST['id'];?>&colores=<?php echo $colores['nombre_color']; ?><?php echo $tallas_color; ?>"><div class="colores-sinseleccionada"><div class="<?php echo $colores['nombre_color']; ?>" title="<?php echo $colores['nombre_color']; ?>"></div></div></a>
						<?php } ?>  
					</center>	
				</div>
				                  <!--FINAL COLORES-->
								  
								  <!--INICIO TALLAS-->
				<div class="tallas"><center><b>TALLAS</b></center></div>
				<div class="todas-tallas">
					<center>
						<?php $conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
						if (isset($_REQUEST['colores']) AND !empty($_REQUEST['colores'])){$colores_talla='&colores='.$_REQUEST['colores'];}else{$colores_talla="";}
						$id_tienda_url = $_REQUEST['tienda_id'];
						$id_categoria_url = $_REQUEST['id'];
						$query = ("SELECT DISTINCT C.nombre_talla FROM color C, producto P WHERE C.producto_id=P.id AND P.tienda_id='$id_tienda_url' AND P.categoria_p_id='$id_categoria_url'");  // el $id ya esta llamado en el submenu de mujer 
						$resultado = $conexion->query($query);
						while($tallas = $resultado->fetch_assoc()){ ?>
							<a href="tienda-vendedor.php?tienda_id=<?php echo $_REQUEST['tienda_id']; ?>&id=<?php echo $_REQUEST['id'];?><?php echo $colores_talla; ?>&tallas=<?php echo utf8_encode($tallas['nombre_talla']); ?>"><div class="tallas-sinseleccionada"><?php echo utf8_encode($tallas['nombre_talla']); ?></div></a>
						<?php }  ?>	
					</center>				
			    </div>
								  <!--FINAL TALLAS-->
			 </form>
		  </section>
            <?php 
			// si no hay ninguna categoria seleccionada no muestro nada.
			} else {}
			?>	
			
		
		   <section id="centro-2">
		    <center>
		           <!-- inicio de los productos de tienda-->
		           <?php include ('tienda-php/proceso-mostrar-producto-tienda-vendedor.php'); ?>    
			       <!-- final de los productos de tienda-->		
		    </center>
		   </section>
        </div>
</body>
</html>