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

<?php
// compruebo que nadie pone tienda sin escribir un nombre
if ((!isset($_GET['id']) OR empty($_GET['id'])) AND $usuario == ''){
    header("location: index.php");
}else if ((!isset($_GET['id']) OR empty($_GET['id'])) AND $usuario != ''){
    header("location: cliente-producto.php");
}else{}
?>

<?php
// lo que ago aqui es comprobar si el id del producto existe en la BD
// 1) incluyo la coneccion
include("login-php/conexion.bd.php");
$db = new conexion();
// recojo el id del producto por url
$id_producto_url = $_REQUEST['id'];
$sql = $db->query("SELECT id FROM producto WHERE id='$id_producto_url';");
$existe = $db->recorrer($sql); 
if($existe['id'] != $id_producto_url){ header("location: cliente.php");}	 
?>

<?php include('llamadas-bd.php'); // id_user, id_tienda, producto_id ?> 

<?php include('tienda-vendedor-php/mostrar-datos-id.php');?><!--PHP. estas lineas de php es para mostrar los datos-->
	
<!DOCTYPE html>
<html lang="es">
<head>
	<title><?php echo utf8_encode($producto['nombre']);?></title>
	<meta charset="utf-8">
	<meta name="description" content="<?php echo utf8_encode($producto['descripcion']);?>">
	<meta name="keywords" content="Wiksay, tiendas, ropa, comunicación, red social, comprar, productos"/>
	<meta name="viewport" content="width=device-width"> <!--Esto es para que el responsive se adacte a los dispositivos moviles-->
	<link rel="shortcut icon" href="imagenes/wiksay.ico" type="image/x-icon">
	<meta name="robots" content="noodp">
	<link rel="stylesheet" href="css/estilos-producto.css">
	<link rel="stylesheet" href="css/estilos-superior.css">
	<link rel="stylesheet" href="fonts/style.css">
	<link rel="stylesheet" href="font-awesome-4.4.0/css/font-awesome.min.css"/>
	
	<meta name="robots" content="noodp">
	
	<meta property="og:locale" content="es_ES">
	<meta property="og:type" content="website" /> 
	<meta property="og:title" content="<?php echo utf8_encode($producto['nombre']);?>" /> 
	<meta property="og:url" content="http://www.wiksay.com/producto.php?id=<?php echo $producto['id'];?>" /> 
	<meta property="og:image" content="data:image/jpg;base64, <?php echo base64_encode($producto['imagen']); ?>" />
    <meta property="og:descripcion" content="<?php echo utf8_encode($producto['descripcion']);?>" />
	<meta property="og:site_name" content="Wiksay" />
	<meta property="og:price:amount" content="<?php echo utf8_encode($producto['precio']);?>" />
	<meta property="og:price:currency" content="EUR" />
	
	<meta name="twitter:card" content="product">
	<meta name="twitter:site" content="Wiksay">
	<meta name="twitter:title" content="<?php echo utf8_encode($producto['nombre']);?>">
	<meta name="twitter:description" content="<?php echo utf8_encode($producto['descripcion']);?>">
	<meta name="twitter:creator" content="autor">
	<meta name="twitter:image" content="data:image/jpg;base64, <?php echo base64_encode($producto['imagen']); ?>">
	<meta name="twitter:data1" content="<?php echo utf8_encode($producto['precio']),' €';?>">
	<meta name="twitter:label1" content="Precio">
	
</head>

<body>
<!-- google analitics-->
<?php include_once("analyticstracking.php") ?>

<!-- Boton de compartir en facebook-->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.5";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!-- Boton de compartir en facebook-->
<!-- Boton de compartir en twitter-->
     <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<!-- Boton de compartir en twitter-->

      <div id="gloval">
	  <?php include('usuario-php/mostrar-datos-user.php');?><!--PHP. estas lineas de php es para mostrar los datos-->
      <?php include('cabecera/header.php');?>
	  <section class="centro">
		<!---- (php) inicio detalles productos ---->
		    
		    <article class="article">
				<ul class="slider">
				   <li>
				      <input type="radio" id="imagen1" name="sradio" checked>
					  <label for="imagen1"></label>
					  <img src="data:image/jpg;base64, <?php echo base64_encode($producto['imagen']); ?>" alt="">
				   </li>
				   <?php if ($producto['imagen2'] != NULL) { ?>
				   <li>
				      <input type="radio" id="imagen2" name="sradio">
					  <label for="imagen2"></label>
					  <img src="data:image/jpg;base64, <?php echo base64_encode($producto['imagen2']); ?>" alt="">
				   </li>
				   <?php }else{} ?>
				   <?php if ($producto['imagen3'] != NULL) { ?>
				   <li>
				      <input type="radio" id="imagen3" name="sradio">
					  <label for="imagen3"></label>
					  <img src="data:image/jpg;base64, <?php echo base64_encode($producto['imagen3']); ?>" alt="">
				   </li>
				   <?php }else{} ?>
				</ul>
            </article>
			<div class="especificaciones">
			<?php 
			    //avisos
				if (isset($_REQUEST['proceso'])){
					$proceso = $_REQUEST['proceso'];
					if ($proceso == 'registrarse') {  
				?>		
						<center><div><a href="http://www.wiksay.com/producto.php?id=<?php echo $producto['id'];?>"><div class="proceso1">Lo sentimos. Primero debes registrarte o iniciar sesión.<span> X</span></div></a></div></center>
				<?php	
					} else {}; 
				}else{};
			?>
			
			 <!---- (php) inicio detalles productos ---->
			 <?php 
					if (isset($_REQUEST['color'])){$color_url3 = $_REQUEST['color'];}else{ $color_url3 ="";}
					if (isset($_REQUEST['talla'])){$talla_url3 = $_REQUEST['talla'];}else{ $talla_url3 ="";}
				?>
				<form action="producto-php/proceso-agregar-cesta.php?id=<?php echo $producto['id'];?>&producto_color=<?php echo $color_url3;?>&producto_talla=<?php echo $talla_url3;?>&nombre_user=<?php echo $usuario;?>&id_user=<?php echo $id_user['id'];?>" method="POST"> <!--este id_tienda lo llame en la parte superior.-->
					<ul>
						<li class="nombre-producto"><b></b> <?php echo utf8_encode($producto['nombre']);?></li>
					</ul>
					<ul>
						<li class="pregunta-10"><b>Precio:</b></li>
						<li class="respuesta-10-precio"><b><?php echo utf8_encode($producto['precio']);?> €</b></li>
					</ul>
                    <ul>
						<a href="tienda.php?nombre=<?php echo utf8_encode($producto['nombre_tienda']);?>">
							<li class="pregunta-10"><b>Tienda:</b></li>
							<li class="respuesta-10"><b><?php echo utf8_encode($producto['nombre_tienda']);?></b></li>
						</a>
					</ul>
					<?php if ($producto['costes_envio'] != "" ){ ?>
					<ul>
						<li class="pregunta-10"><b>Costes envío:</b></li>
						<li class="respuesta-10"><?php echo utf8_encode($producto['costes_envio']);?><b> €</b></li>
					</ul>
					<?php }else{}; ?>
					<?php if ($producto['duracion_envio'] != "" ){ ?>
					<ul>
						<li class="pregunta-10"><b>Duración envío:</b></li>
						<li class="respuesta-10"><?php echo utf8_encode($producto['duracion_envio']);?><b></b></li>
					</ul>
					<?php }else{}; ?>
					<?php if ($producto['devolucion'] != "" ){ ?>
					<ul>
						<li class="pregunta-10"><b>Devolución:</b></li>
						<li class="respuesta-10"><?php echo utf8_encode($producto['devolucion']);?><b></b></li>
					</ul>
					<?php }else{}; ?>
					<?php if ($producto['cantidad'] != "" ){ ?>
					<ul>
						<li class="pregunta-10"><b>Cantidad:</b></li>
						<li class="respuesta-10"><?php echo utf8_encode($producto['cantidad']),' unidades';?></li>
					</ul>
					
					
					
					
					

					<?php }else{}; ?>
					<ul>
						<li class="pregunta-10"><b>Colores:</b></li>
						<li class="respuesta-10">
							<?php 
							$conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
							if (isset($_REQUEST['talla']) AND !empty($_REQUEST['talla'])) {$talla_color = '&talla='.$_REQUEST['talla'];}else{$talla_color="";}
							$idproducto = $producto['id'];
							$query77 = ("SELECT DISTINCT C.nombre_color FROM color C, producto P WHERE C.producto_id='$idproducto'");  // el $id ya esta llamado en el submenu de mujer 
							$resultado77 = $conexion->query($query77);
							while($colores = $resultado77->fetch_assoc()){ ?>
								    <a href="producto.php?id=<?php echo $_REQUEST['id'];?>&color=<?php echo $colores['nombre_color'];?><?php echo $talla_color; ?>"><div class="colores-sinseleccionada"><div class="<?php echo $colores['nombre_color']; ?>" title="<?php echo $colores['nombre_color']; ?>"></div></div></a>
							<?php } ?>								
						</li>
					</ul>
					<ul> 
						<li class="pregunta-10"><b>Tallas:</b> </li>
						<li class="respuesta-10">
						    <?php if (isset($_REQUEST['color']) AND !empty($_REQUEST['color'])){$color_talla = '&color='.$_REQUEST['color'];}else{ $color_talla =""; }
								$conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db					
								$idproducto = $producto['id'];
								$query81 = ("SELECT DISTINCT C.nombre_talla FROM color C, producto P WHERE C.producto_id='$idproducto'");  // el $id ya esta llamado en el submenu de mujer 
								$resultado81 = $conexion->query($query81);
								while($tallas = $resultado81->fetch_assoc()){ ?>
									<a href="producto.php?id=<?php echo $_REQUEST['id'];?><?php echo $color_talla;?>&talla=<?php echo utf8_encode($tallas['nombre_talla']);?>"><div class="tallas-sinseleccionada"><?php echo utf8_encode($tallas['nombre_talla']); ?></div></a>
									
								<?php }  ?>
						</li>         
					</ul>
					
					
					
					
					<ul>
						<li class="pregunta-10"><b>Cantidad:</b></li>
						<li class="respuesta-10">
							<?php if (isset($_REQUEST['color']) AND !empty($_REQUEST['color']) AND isset($_REQUEST['talla']) AND !empty($_REQUEST['talla'])){
								$conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
								$idproducto = $producto['id'];
								
								if (isset($_REQUEST['color']) AND !empty($_REQUEST['color'])){
								$color_final = $db->real_escape_string(utf8_decode($_REQUEST['color']));
								$color_final1 = "AND C.nombre_color='".$color_final."'";
								}else{ $color_final1 = "";}
						   
								if (isset($_REQUEST['talla']) AND !empty($_REQUEST['talla'])){
								$talla_final = $db->real_escape_string(utf8_decode($_REQUEST['talla']));
								$talla_final1 = "AND C.nombre_talla='".$talla_final."'"; 
								}else{ $talla_final1 = "";}
								
								$query772 = ("SELECT  C.nombre_cantidad FROM color C, producto P WHERE C.producto_id='$idproducto' $color_final1 $talla_final1");  // el $id ya esta llamado en el submenu de mujer 
								$resultado772 = $conexion->query($query772);
								$cantidad = $resultado772->fetch_assoc(); ?>
								  
								<select name="producto_cantidad">
									<?php for ($i = 1; $i <= $cantidad['nombre_cantidad']; $i++) { ?> <option value="<?php echo $i;?>"> <?php echo $i; ?> </option> <?php } ?>
								</select> Unidades.
							<?php }else{ echo 'Selecciona un color y una talla'; } ?>
						</li>
					</ul>
					<ul> 
						<li class="pregunta-10"><b>Categoría:</b></li>
						<li class="respuesta-10"><?php echo utf8_encode($categoria_pr['genero']),' ',utf8_encode($categoria_pr['nombre_categoria']),' ',utf8_encode($categoria_pr['zapatos']),' ',utf8_encode($categoria_pr['accesorios']),' ',utf8_encode($categoria_pr['ropa_interior']);?></li>
					</ul>
					
					<ul>
						<a href="<?php echo utf8_encode($producto['url']);?>"><li class="agregar-cesta"><center>Comprar</center></li></a>
					</ul>
				</form>
				
				<ul>
			        <li class="boton-megusta">
			              <!--inicio: estructura de php para el seguimiento de las tiendas-->
			              <?php 
						  $conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
		         	      $producto_id = $producto['id']; // este id del producto lo llame de la llamada de productos de arriba
				          $id_usuario = $id_user['id']; // este id de usuario lo llame en la parte de arriba
			              $query1 = ("SELECT producto_id, usuario_id FROM megusta WHERE producto_id='$producto_id' AND usuario_id='$id_usuario'");
                          $resultado = $conexion->query($query1);// con esto le estamos diciendo que nos muestre los datos
                          $existe = $resultado->fetch_assoc(); ?>

	                      <?php if ( $existe['producto_id'] == $producto_id AND $existe['usuario_id'] == $id_usuario){ ?>
 	                      <!-- si ya te guata muestrame esto: -->
                             <form class="centro-centro-1" action="tienda-php/proceso-eliminar-megusta.php?producto_id=<?php echo $producto['id'];?>&tienda_id=<?php echo $producto['tienda_id'];?>&nombre_tienda=<?php echo utf8_encode($producto['nombre_tienda']);?>&id_user=<?php echo $id_user['id'];?>" method="POST"> <!--este id_tienda lo llame en la parte superior.-->
                                <ul>
			                       <li class="megusta-si"><input type="submit" value=""><span class="icon-heart"></span></input></li>
		                        </ul>
			                 </form>
	                      <?php }else { ?>
	                      <!-- si todavia no le has dado a megusta muestra esto: -->
                              <form class="centro-centro-1" action="tienda-php/proceso-subir-megusta.php?producto_id=<?php echo $producto['id'];?>&nombre_producto=<?php echo utf8_encode($producto['nombre']);?>&tienda_id=<?php echo $producto['tienda_id'];?>&nombre_tienda=<?php echo utf8_encode($producto['nombre_tienda']);?>&id_user=<?php echo $id_user['id'];?>&nombre_usuario=<?php echo utf8_encode($id_user['apodo']);?>" method="POST"> <!--este id_tienda lo llame en la parte superior.-->
                                 <ul>
			                        <li class="megusta-no"><input type="submit" value=""><span class="icon-heart"></span></input></li>
		                         </ul>
			                  </form>
							  
                         <?php } ?>
			             <!--final: estructura de php para el seguimiento de las tiendas-->
	                </li>
                         <!--inicio: esto es para mostrar cuantos usuarios estan siguiendo la tienda-->
                               <?php 
		                       $conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
			                   $id = $producto['id'];
			                   $query2 = ("SELECT COUNT(*) as producto_id FROM megusta WHERE producto_id='$id';");
		                       $resultado = $conexion->query($query2);
			                   $megusta = $resultado->fetch_assoc() ?>
			        <li class="mostrar-numero-megustas" ><?php echo '(',$megusta['producto_id'],' veces añadido)'; ?></li>
			             <!--final: esto es para mostrar cuantos usuarios estan siguiendo la tienda-->
			    </ul>
				
				<center>
				   
				   <!--Boton compartir en facebook--><div class="fb-share-button" data-href="http://wiksay.com/producto?id= echo $id_producto_url ?>" data-layout="button"></div>
				   <!--Boton compartir en twitter--><a href="https://twitter.com/share" class="twitter-share-button" data-url="https://www.wiksay.com/producto?id= <?php echo $id_producto_url?>" data-dnt="true">Tweet</a>
				   <!--falta Boton compartir en google plus-->
				   <!--falta Boton compartir en whatapp-->
				</center>
				
				<ul class="tabs-nav">  
				  <li class="detalles"><a href="#tab1"><center><b>COMENTARIOS</b></center></a></li>
				  <li class="comentarios"><a href="#tab2"><center><b>DESCRIPCIÓN</b></center></a></li>
				</ul>
						
   				<div id="tab1" class="contenido">
				   <!---- (php) inicio de los comentarios de productos ---->
				  <form action="producto-php/proceso-subir-comentario.php?producto_id=<?php echo $producto['id'];?>&nombre_producto=<?php echo utf8_encode($producto['nombre']);?>&tienda_id=<?php echo $producto['tienda_id'];?>&nombre_tienda=<?php echo utf8_encode($producto['nombre_tienda']);?>" method="POST"> <!--usuario_id lo llame en la parte de arriba-->
				        <div class="escribir-comentario"><textarea cols=70 rows=4 placeholder="Escribe un mensaje..." name="comentario_emisor" REQUIRED></textarea></div>
						<div><input type="hidden" value="<?php echo $user?>" name="usuario_emisor" ></div>
						<div><input type="hidden" value="<?php echo $id_user['id'];?>" name="usuario_id" ></div>
				        <center><div class="enviar-comentario"><input type="submit" value="Publicar"></div></center>
				  </form>
				  
				  <?php $conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
				        $producto_idid = $producto['id']; // $producto_id['id'] esta llamado en la parte de arriba
						$query6 = ("SELECT COUNT(*) as producto_id FROM comentario WHERE producto_id='$producto_idid';"); // nombre_tienda lo llame en la parte de arriba
						$resultado = $conexion->query($query6);
						$numero_comentario = $resultado->fetch_assoc() ?>
						<div class="numero-comentarios"><p><span class="icon-chat"></span> (<?php echo $numero_comentario['producto_id'],' comentarios';?>)</p></div>
				  <hr>
				  <?php $conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
						// $producto_idid = $producto_id['id']; esta llamado en el query de arriba asi que no lo vuelvo a llamar para que no de fallo
						$query = ("SELECT * FROM comentario WHERE producto_id='$producto_idid' ORDER BY comentario.id DESC;"); // nombre_tienda lo llame en la parte de arriba
						$resultado = $conexion->query($query);
						while($comentario = $resultado->fetch_assoc()){ ?>
				     <ul> 
				        <li class="contenido-comentarios"><?php echo '<b>',utf8_encode($comentario['usuario_emisor']), ':</b> ',$comentario['fecha_publicacion'],'<br>',utf8_encode($comentario['comentario_emisor']);?></li>
						<!-- si el usuario es es igual al nombre del comentario, le aparece el boton eliminar. Si no lo es, no le aparece nada-->
						<?php if ($user == $comentario['usuario_emisor'] ){ ?> 
						<li class="eliminar-comentarios"><a href="producto-php/proceso-eliminar-comentario.php?producto_id=<?php echo $comentario['producto_id'];?>&usuario_emisor=<?php echo utf8_encode($comentario['usuario_emisor']);?>&comentario_id=<?php echo $comentario['id'];?>&usuario_id=<?php echo $comentario['usuario_id'];?>&tienda_id=<?php echo $producto['tienda_id'];?>&nombre_tienda=<?php echo utf8_encode($producto['nombre_tienda']);?>"><font color="black"><span class="icon-trash"></span></font></a></li>
			            <?php } else if ($user != utf8_encode($comentario['usuario_emisor'])){}?>
					 </ul>
				  <?php } ?> 
				  <!---- (php) final de los comentarios de productos ---->
			    </div>
				
				<div id="tab2" class="contenido">
				   <li class="contenido-detalles"><?php echo utf8_encode($producto['descripcion']);?></li>
			    </div>
			</div>
		    <!---- (php) final detalles productos ----> 
		  </section>
	 </div>
</body>
</html>