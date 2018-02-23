<?php
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
	if(utf8_encode($id_tienda['apodo_tienda']) != $user) {header("location: cliente.php");}
	/* combruebo: 1)si el id del usuario no es igual al id del usuario de la tienda lo redirijo a la pagina tienda-vendedor.php
	              2)si el id del usuario es igual al id del usuario de la tienda lo dejo entrar*/
	$id_url = $conexion->real_escape_string($_REQUEST['id']);
	if($id_tienda['usuario_id'] != $id_url) { header("location: tienda-vendedor.php");}
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
	<link rel="stylesheet" href="css/estilos-superior.css">
	<link rel="stylesheet" href="css/estilos-controles.css">
	<link rel="stylesheet" href="fonts/style.css">
	<link rel="stylesheet" href="font-awesome-4.4.0/css/font-awesome.min.css"/>
	<link rel="stylesheet" href="css/estilos-configuracion-tienda.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script><!--este es para que funcione la imagen predeterminada-->
	<script type="text/javascript" src="js/preload-imagen.js"></script><!--este es para que funcione la imagen predeterminada-->
</head>

<body>
<!-- google analitics-->
<?php include_once("analyticstracking.php") ?>

      <div id="gloval">
        <?php include('usuario-php/mostrar-datos-user.php');?><!--PHP. estas lineas de php es para mostrar los datos-->
		<?php include('cabecera/header.php');?>
		
		 <section class="centro">
		 
		 <?php include('cabecera/controles.php');?>
		 
		 <!-- inicio php configuracion tienda-->
		<?php include('crear-tienda-php/mostrar-datos-id.php');?><!--PHP. estas lineas de php es para mostrar los datos-->
				
				<center><div class="configuracion"><p>Configuración usuario</p></div></center>
				<center>
				<?php 
					// inicio avisos
					if (isset($_REQUEST['proceso'])){
						$proceso = $_REQUEST['proceso'];
						if ($proceso == 'imag') { 
				?>				
							<center><div><a href="http://www.wiksay.com/configuracion-tienda.php?id=<?php echo $informacion['id'];?>"><div class="proceso">Excelente. La imágen se ha guardado.<span> X</span></div></a></div></center>
				<?php		
						}else if ($proceso == 'info') {  
				?>				
							<center><div><a href="http://www.wiksay.com/configuracion-tienda.php?id=<?php echo $informacion['id'];?>"><div class="proceso">Excelente. Los cambios se han guardado.<span> X</span></div></a></div></center>
				<?php		
						}else if ($proceso == 'password') {  
				?>				
							<center><div><a href="http://www.wiksay.com/configuracion-tienda.php?id=<?php echo $informacion['id'];?>"><div class="proceso">Excelente. La contraseña se ha modificado.<span> X</span></div></a></div></center>
				<?php		
						} else if ($proceso == 'malpassword') { 
				?>				
							<center><div><a href="http://www.wiksay.com/configuracion-tienda.php?id=<?php echo $informacion['id'];?>"><div class="proceso1">Lo sentimos. La contraseña no coincide.<span> X</span></div></a></div></center>
				<?php			
						} else if ($proceso == 'diferentespassword') { 
				?>				
							<center><div><a href="http://www.wiksay.com/configuracion-tienda.php?id=<?php echo $informacion['id'];?>"><div class="proceso1">Lo sentimos. Las contraseñas no son iguales.<span> X</span></div></a></div></center> 
				<?php			
						} else {};  
					}else{};
					// final aviso
				?> 
				<form class="formulario-imagen"  action="usuario-php/proceso-modificar-imagen-usuario.php?id=<?php echo $informacion['id'];?>" method="POST" enctype="multipart/form-data"> 	
						<div class="imagen">
							<input accept="image/*" onchange="loadFile(event)" class="imagen-imagen" type="file" name="imagen" REQUIRED/>
						    <!--puse la img primero porque se me colocaba fuera del div el input y lo coloque con css-->
							<?php if (!empty($informacion['imagen'])){ ?>
								<img id="output" class="imagen" src="data:image/jpg;base64, <?php echo base64_encode($informacion['imagen']); ?>">
							<?php }else{ ?>
								<img id="output" class="imagen" src="imagenes/perfil-cuadrada.png">
							<?php } ?>
					    </div>
						
						<div class="nota"><p>*Las imágenes no pueden superar los 2000px de largo y 2000px de alto.</p></div>
						<div class="nota"><p>*Recomendamos una imágen con relación 2 de largo x 1 de alto.</p></div>
			            <div class="guardar-imagen"><input type="submit" value="Modificar imagen"></div>
						
			    </form>
				</center>
			    <form class="formulario-informacion"  action="crear-tienda-php/proceso-modificar-informacion-tienda.php?id=<?php echo $informacion_tienda['usuario_id'];?>" method="POST">
                        <div class="formulario">
						    <div class="pregunta">Usuario:</div>
							<div class="respuesta"><?php echo utf8_encode($informacion_tienda['apodo_tienda']),'<font color="#8c9ca9">. (No se puede modificar)</font>'; ?></div>
                        </div>
						<div class="formulario">
						    <div class="pregunta">E-mail:</div>
							<div class="respuesta"><?php echo utf8_encode($informacion_empresa['email_empresa']),'<font color="#8c9ca9">. (No se puede modificar)</font>'; ?></div>
                        </div>
						<div class="formulario">
						    <div class="pregunta">Categoría de la tienda:*</div>
							<!--inicio: esto es para que me muestre todas las categorias que hay en la base de datos-->
							<div class="respuesta">
							    <select name="categoria_t_id" REQUIRED>
								             <option value="<?php echo $categoria_ti['id']; ?>"><?php echo $categoria_ti['nombre_categoria_ti']; ?></option>
							     <?php $conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
					                   $query = ("SELECT * FROM categoria_ti;"); // nombre_tienda lo llame en la parte de arriba
					                   $resultado = $conexion->query($query);
					                   while($categoria_ti = $resultado->fetch_assoc()){ ?>
							                 <option value="<?php echo $categoria_ti['id']; ?>"><?php echo utf8_encode($categoria_ti['nombre_categoria_ti']); ?></option>
									   <?php } ?>
							     </select>
							</div>
							<!--final: esto es para que me muestre todas las categorias que hay en la base de datos-->
                        </div>
						<!--inicio: miramos si la tienda es particular o es autonomo, si es autonomo mostramos esto y si es particular no lo mostramos-->
						<?php if ($informacion_empresa['tipo_empresa'] == 'Autonomo'){ ?>
						<?php }else if ($informacion_empresa['tipo_empresa'] == 'Particular'){}; ?>
						<!--final: miramos si la tienda es particular o es autonomo, si es autonomo mostramos esto y si es particular no lo mostramos-->
						<div class="formulario">
						    <div class="pregunta">País:</div>
							<div class="respuesta">
								<select name="pais_empresa" REQUIRED>
									<option value="España">España</option>
								</select>
							</div>	
						</div>
						<div class="formulario">
						    <div class="pregunta">Provincia:</div>
							<div class="respuesta">
								<select name="provincia_empresa" REQUIRED>
								    <option value="<?php echo utf8_encode($informacion_empresa['provincia_empresa']); ?>"><?php echo utf8_encode($informacion_empresa['provincia_empresa']); ?></option>
									<option>-----</option>
									<option value="Álava">Álava</option>
									<option value="Albacete">Albacete</option>
									<option value="Alicante">Alicante</option>
									<option value="Almería">Almería</option>
									<option value="Asturias">Asturias</option>
									<option value="Ávila">Ávila</option>
									<option value="Badajoz">Badajoz</option>
									<option value="Barcelona">Barcelona</option>
									<option value="Burgos">Burgos</option>
									<option value="Cáceres">Cáceres</option>
									<option value="Cádiz">Cádiz</option>
									<option value="Cantabria">Cantabria</option>
									<option value="Castellón">Castellón</option>
									<option value="Ciudad Real">Ciudad Real</option>
									<option value="Córdoba">Córdoba</option>
									<option value="Cuenca">Cuenca</option>
									<option value="Gerona">Gerona</option>
									<option value="Granada">Granada</option>
									<option value="Guadalajara">Guadalajara</option>
									<option value="Guipúzcoa">Guipúzcoa</option>
									<option value="Huelva">Huelva</option>
									<option value="Huesca">Huesca</option>
									<option value="Islas Baleares">Islas Baleares</option>
									<option value="Jaén">Jaén</option>
									<option value="La Coruña">La Coruña</option>
									<option value="La Rioja">La Rioja</option>
									<option value="Las Palmas">Las Palmas</option>
									<option value="León">León</option>
									<option value="Lérida">Lérida</option>
									<option value="Lugo">Lugo</option>
									<option value="Madrid">Madrid</option>
									<option value="Málaga">Málaga</option>
									<option value="Murcia">Murcia</option>
									<option value="Navarra">Navarra</option>
									<option value="Orense">Orense</option>
									<option value="Palencia">Palencia</option>
									<option value="Pontevedra">Pontevedra</option>
									<option value="Salamanca">Salamanca</option>
									<option value="Segovia">Segovia</option>
									<option value="Sevilla">Sevilla</option>
									<option value="Soria">Soria</option>
									<option value="Tarragona">Tarragona</option>
									<option value="Tenerife">Tenerife</option>
									<option value="Teruel">Teruel</option>
									<option value="Toledo">Toledo</option>
									<option value="Valencia">Valencia</option>
									<option value="Valladolid">Valladolid</option>
									<option value="Vizcaya">Vizcaya</option>
									<option value="Zamora">Zamora</option>
									<option value="Zaragoza">Zaragoza</option>
								</select>
							</div>
						</div>
						<div class="formulario">
						    <div class="pregunta">Población:</div>
							<div class="respuesta"><input type="text"  size="66%" placeholder="Población" value="<?php echo utf8_encode($informacion_empresa['poblacion_empresa']); ?>" name="poblacion_empresa" autocomplete="off" ></div>
                        </div>
						<div class="formulario">
						    <div class="pregunta">Dirección:</div>
							<div class="respuesta"><input type="text"  size="66%" placeholder="Dirección" value="<?php echo utf8_encode($informacion_empresa['direccion_empresa']); ?>" name="direccion_empresa" autocomplete="off" ></div>
                        </div>
						<div class="formulario">
						    <div class="pregunta">Teléfono:</div>
							<div class="respuesta"><input type="number"  size="66%" placeholder="Número de teléfono" value="<?php echo utf8_encode($informacion_empresa['telefono1_empresa']); ?>" name="telefono1_empresa" autocomplete="off" ></div>
                        </div>
						<div class="formulario">
						    <div class="pregunta"><li class="social" title="Facebook"><a class="icon-facebook"></a></li></div>
							<div class="respuesta"><input type="url"  size="66%" placeholder="Pega la URL de tu página de Facebook" value="<?php echo utf8_encode($social['facebook']); ?>" name="facebook" autocomplete="off" ></div>
                        </div>
						<div class="formulario">
						    <div class="pregunta"><li class="whatsapp" title="Whatsapp:<?php echo ' ',$social['whatsapp']; ?>"><font size="5px"><a class="fa fa-whatsapp"></a></font></li></div>
							<div class="respuesta"><input type="text"  size="66%" placeholder="Escribe tu número de Whatsapp" value="<?php echo utf8_encode($social['whatsapp']); ?>" name="whatsapp" autocomplete="off" ></div>
                        </div>
						<div class="formulario">
						    <div class="pregunta"><li class="social" title="Instagram"><a class="icon-instagram"></a></li></div>
							<div class="respuesta"><input type="url"  size="66%" placeholder="Pega la URL de tu página de instagram" value="<?php echo utf8_encode($social['instagram']); ?>" name="instagram" autocomplete="off" ></div>
                        </div>
						<div class="formulario">
						    <div class="pregunta"><li class="social" title="Twitter"><a class="icon-twitter"></a></li></div>
							<div class="respuesta"><input type="url"  size="66%" placeholder="Pega la URL de tu página de Twitter" value="<?php echo utf8_encode($social['twitter']); ?>" name="twitter" autocomplete="off" ></div>
                        </div>
						<div class="formulario">
						    <div class="pregunta"><li class="youtube" title="Youtube"><font size="5px"><a class="fa fa-youtube"></a></font></li></div>
							<div class="respuesta"><input type="url"  size="66%" placeholder="Pega la URL de tu página de Youtube" value="<?php echo utf8_encode($social['youtube']); ?>" name="youtube" autocomplete="off" ></div>
                        </div>
						<div class="formulario">
						    <div class="pregunta"><li class="social" title="Google+"><a class="icon-googleplus"></a></li></div>
							<div class="respuesta"><input type="url"  size="66%" placeholder="Pega la URL de tu página de Google Plus" value="<?php echo utf8_encode($social['googleplus']); ?>" name="googleplus" autocomplete="off" ></div>
                        </div>
						<div class="formulario">
						    <div class="pregunta"><li class="social" title="Pinterest"><a class="icon-pinterest"></a></li></div>
							<div class="respuesta"><input type="url"  size="66%" placeholder="Pega la URL de tu página de Pinterest" value="<?php echo utf8_encode($social['pinterest']); ?>" name="pinterest" autocomplete="off" ></div>
                        </div>
						<div class="formulario">
						    <div class="pregunta"><li class="social" title="Linkedin"><a class="icon-linkedin"></a></li></div>
							<div class="respuesta"><input type="url"  size="66%" placeholder="Pega la URL de tu página de Linkedin" value="<?php echo utf8_encode($social['linkedin']); ?>" name="linkedin" autocomplete="off" ></div>
                        </div>
						<div class="formulario">
						    <div class="pregunta"><li class="social" title="Google Maps"><a class="icon-location"></a></li></div>
							<div class="respuesta"><input type="url" size="66%" placeholder="Pega la URL de la ubicación de la tienda" value="<?php echo utf8_encode($social['mapa']); ?>" name="mapa" autocomplete="off" ></div>
                        </div>
						<div class="formulario">
							<div class="pregunta"><input type="hidden"  size="66%" value="<?php echo $informacion_empresa['id']; ?>"></div> 
						    <div class="guardar-informacion"><input type="submit" value="Guardar información"></div>
					    </div>
				</form>
				<form  class="formulario-informacion" action="usuario-php/cambiar_password.php?id=<?php echo $informacion['id'];?>" method="POST">
					    <div class="formulario">
						    <div class="pregunta">Contraseña actual</div>
							<div class="respuesta"><input type="password"  size="38%" placeholder="Tu contraseña actual" name="contraseña"  autocomplete="off" REQUIRED></div>
					    </div>
						<div class="formulario">
						    <div class="pregunta">Nueva contraseña:</div>
							<div class="respuesta"><input type="password"  size="38%" placeholder="Nueva contraseña" name="repetir_contraseña"  autocomplete="off" REQUIRED></div>
					    </div>
						<div class="formulario">
						    <div class="pregunta">Repetir contraseña:</div>
							<div class="respuesta"><input type="password"  size="38%" placeholder="Repetir nueva contraseña" name="nueva_contraseña"  autocomplete="off" REQUIRED></div>
					    </div>
						<div class="formulario">
						    <div class="pregunta"></div>
							<div class="guardar-informacion"><input type="submit" value="Modificar contraseña"></div>
					    </div>
					</table>
			    </form>
				<!-- final php configuracion tienda--> 
		</section>

      </div>
</body>
</html>