<?php
    // esto es para mostrar el total de productos en el icono del carrito
	$usuario_comprador = $id_user['id']; //este es el id del usuario que compra
    $contador_productos = 0;
	$conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
	$query = ("SELECT COUNT(*) AS usuario_id FROM cesta WHERE usuario_id='$usuario_comprador';"); // nombre_tienda lo llame en la parte de arriba
	$resultado = $conexion->query($query);
	$total_productos = $resultado->fetch_assoc();		
?>
<?php
    $tienda_id = $id_tienda['id'];
	$conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
	$query = ("SELECT COUNT(*) AS tienda_id FROM notificacion WHERE tienda_id='$tienda_id' AND estado='0';"); // nombre_tienda lo llame en la parte de arriba
	$resultado = $conexion->query($query);
	$total_notificaciones1 = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es"> 
	<header class="superior">
		  <nav>
            <ul class="derecha-superior">
			    <li class="menu1">
					<?php if ($user != '' OR $usuario != '' OR ($user != '' AND $usuario != '')){ ?>
						<a href="cliente.php"><b>Wiksay</b></a>
					<?php }else{ ?>
						<a href="index.php"><b>Wiksay</b></a>
					<?php } ?>
				</li>
			   
			    <?php //
				// estas lineas son para saber si el usuario tiene una tienda creada o no, a travez del apodo_empresa de usuario
                                 //$user = $_SESSION["user"]; como es un include lo estoy llamando en la pagina.php que lo estoy incluyendo
				//$usuario = utf8_decode($_SESSION['user']); como es un include lo estoy llamando en la pagina.php que lo estoy incluyendo
		        $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
		        $query =("SELECT apodo_empresa FROM empresa WHERE apodo_empresa='$usuario';"); // si el (apodo_empresa de la empresa) es = al (apodo del usuario) significa que tiene tienda. si no es = significa que no tiene tienda
                $resultado = $conexion->query($query);
	            $existe = $resultado->fetch_assoc(); ?>
	            
		        <?php if ($user != '' OR $usuario != '' OR ($user != '' AND $usuario != '')) { ?>
		        
			  	<li class="menu4" title="Cuenta"><span class="fa fa-navicon"></span> <!---- (php)  para que aparesca el nombre del usuario ---->
					<ul class="sub-menu4">
					    <li class="sub-menu4-sub">
							<a href="tienda-vendedor.php">
								<div class="imagen-cuenta">
									<?php if (!empty($informacion['imagen'])){ ?>
										<figure><img src="data:image/jpg;base64, <?php echo base64_encode($informacion['imagen']); ?>" >
									<?php }else{ ?>
										<figure><img src="imagenes/perfil-cuadrada.png"></figure>
									<?php } ?>
									</img></figure>
								</div>
								<div class="nombre-cuenta">
									<p class="nombre-cuenta-1"><?php echo $informacion['apodo']?></p>
									<p class="nombre-cuenta-2"><?php echo $numero_productos_mios['id'],' Articulos'?></p>
								</div>
							</a>
						</li>
						<!--<li class="sub-menu4-sub" title="Chat"><a><span class="fa fa-commenting"></span> Mensajes</a></li>-->
					    <li class="sub-menu4-sub" title="Notificaciones">
							<a href="notificaciones.php?estado=1"><span class=" icon-bell"></span> Notificaciones
							<?php
								$total_notificaciones4 = $total_notificaciones1['tienda_id'];
									
								if ( $total_notificaciones4 == 0){
									// no muestro nada ya que la cesta esta vacia
								}else{
									if ($total_notificaciones4 <= 9){
									  echo '<div class="notificacion_cantidad"><b>',$total_notificaciones4,'</b></div>'; 
									} else{
										   echo '<div class="notificacion_cantidad"><b>+9</b></div>';
										  }
								}
							?>
							</a>
						</li>
						<li class="sub-menu4-sub"><a href="configuracion-tienda.php?id=<?php echo $informacion['id'];?>"><span class=" fa fa-gear"></span> Configuración del usuario</a></li>
						<li class="sub-menu4-sub"><a href="eliminar-cuenta.php"><span class=" fa fa-times"></span> Eliminar cuenta</a></li>
						<li class="sub-menu4-sub"><a href="ayuda.php"><span class="fa fa-info-circle"></span> Ayuda</a></li>
						<li class="sub-menu4-sub"><a href="informacion-problemas.php"><span class="fa fa-bullhorn"></span> Información de problemas</a></li>
					    <li class="sub-menu4-sub"><a href="login-php/destruir_sesion.php"><span class=" fa fa-reply-all"></span> Cerrar sesión</a></li><!---- (php)   para cerrar sesion ---->
					</ul>
			  	</li>
			   	<?php }else{ ?>
				<li class="menu10" title="Cuenta"><span class="fa fa-navicon"></span> <!---- (php)  para que aparesca el nombre del usuario ---->
					<center>
					    <ul class="sub-menu10">
							<li class="sub-menu10-sub"><a href="inicio.php">Inicia Sesión</a></li>
							<li class="sub-menu10-sub"><a href="inicio.php">O</a></li>
							<li class="sub-menu10-sub"><a href="inicio.php">Registrarse</a></li>
					    </ul>
					</center>
			  	</li>
		        <?php } ?>
		    </ul> 
          </nav>		  
    </header>
</html>