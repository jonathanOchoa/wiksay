<?php
error_reporting(0);
//error_reporting(E_ALL);
//ini_set('display_errors', true);

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
	// verifico qu el usuario no tenga ninguna tienda creada, si no no lo dejo entrar 
	if ($id_user['id'] == $id_tienda['usuario_id']) {header("location: cliente.php");}
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
	<link rel="stylesheet" href="css/estilos-superior.css">
	<link rel="stylesheet" href="fonts/style.css">
	<link rel="stylesheet" href="font-awesome-4.4.0/css/font-awesome.min.css"/>
	<link rel="stylesheet" href="css/estilos-crear-tienda.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script><!--este es para que funcione la imagen predeterminada-->
	<script type="text/javascript" src="js/preload-imagen.js"></script> <!--este es el script de imagen previa-->
	
	
</head>

<body>
      <div id="gloval">
	    <?php include('usuario-php/mostrar-datos-user.php');?><!--PHP. estas lineas de php es para mostrar los datos-->
        <?php include('cabecera/header.php');?>
	  
      <section class="centro"> 
                <center><div class="titulo"><p>Crear tienda</p></div></center> 
				<form class="formulario" action="crear-tienda-php/proceso-subir-autonomo.php?id=<?php echo utf8_encode($info['id']);?>&apodo=<?php echo utf8_encode($info['apodo']);?>" method="POST"  enctype="multipart/form-data">
                   
				   <table>
						<div class="div-informacion-numerico"><p>1. AÑADE TU IMÁGEN DE FONDO DE TIENDA</p></div>
					<center> 	
						<div class="imagen-fondo">
							<input accept="image/*" onchange="loadFile(event)" class="imagen-imagen-fondo" type="file" name="imagen_fondo" REQUIRED />
							<img id="output" width="100%"height="100%">
						</div>
						<div class="nota"><p>*Las imágenes no pueden superar los 2000 X 2000 de alto.</p></div>
						<div class="nota"><p>*Recomendamos una imágen con relación 3.3 de largo x 1 de alto.</p></div>
				    </center>
					
						<div class="div-informacion-numerico"><p>2. AÑADE TU IMÁGEN DE PERFIL DE TIENDA.</p></div>
                    <center> 
						<div class="imagen-perfil">
							<input accept="image/*" onchange="loadFile2(event)" class="imagen-imagen-perfil" type="file" name="imagen_perfil" REQUIRED />
							<img id="output2" width="100%"height="100%">
						</div>
						<div class="nota"><p>*Las imágenes no pueden superar los 2000 X 2000 de alto.</p></div>
						<div class="nota"><p>*Recomendamos una imágen cuadrada.</p></div>
					</center> 	
						<div class="div-informacion-numerico"><p>3. RELLENA LOS SIGUIENTES CAMPOS</p></div>
				    
				   <div class="informacion">
						<ul>
						    <li class="pregunta">Nombre de usuario que utiliza:*</li>
							<li class="respuesta"><input type="text"  size="38%" placeholder="Nombre de usuario que utiliza" name="apodo_empresa"  autocomplete="off" REQUIRED></li>
							<!-- el apodo_empresa lo introducimos en la tabla de empresa como apodo_empresa y en la tabla de tienda como apodo_tienda-->
					    </ul>
						<ul> 
						    <li class="pregunta">Tipo:*</li>
							<li class="respuesta">
							   <select name="tipo_empresa" REQUIRED>
							      <option></option>
							      <option value="Autonomo">Autónomo</option>
							      <option value="Particular">Particular</option>
							   </select>
							</li>
						</ul>
						<ul>
						    <li class="pregunta">Nombre que quieres dar a tu tienda:*</li>
							<li class="respuesta"><input type="text"  size="38%" placeholder="Nombre de empresa completo" name="nombre_empresa"  autocomplete="off" REQUIRED></li>
							<!-- el nombre_empresa lo introducimos en la tabla de empresa como nombre_empresa y en la tabla de tienda como nombre_tienda-->
					    </ul>
						<ul>
						    <li class="pregunta">Categoría de la tienda:*</li>
						    <!--inicio: esto es para que me muestre todas las categorias que hay en la base de datos-->
							<li class="respuesta">
							    <select name="categoria_ti_id">
							     <?php $conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
					                   $query = ("SELECT * FROM categoria_ti;"); // nombre_tienda lo llame en la parte de arriba
					                   $resultado = $conexion->query($query);
					                   while($categoria_ti = $resultado->fetch_assoc()){ ?>
							                 <option value="<?php echo utf8_encode($categoria_ti['id']);?>"><?php echo utf8_encode($categoria_ti['nombre_categoria_ti']);?></option>
									   <?php } ?>
							     </select>
							</li>
							<!--final: esto es para que me muestre todas las categorias que hay en la base de datos-->
					    </ul>
						<ul>
						    <li class="pregunta">E-mail de empresa:*</li>
							<li class="respuesta"><input type="email"  size="38%" placeholder="E-mail" name="email_empresa"  autocomplete="off" REQUIRED></li>
					    </ul>
						<ul>
						    <li class="pregunta" title="Facebook"><span class="icon-facebook"></span></li>
							<li class="respuesta"><input type="url"  size="66%" placeholder="Pega la URL de tu página de Facebook" value="" name="facebook" autocomplete="off" ></li>
					    </ul>
						<ul>
						    <li class="pregunta" id="whatsapp" title="Whatsapp"><font size="5px"><span class="fa fa-whatsapp"></span></font></li>
							<li class="respuesta"><input type="text"  size="66%" placeholder="Escribe tu número de Whatsapp" value="" name="whatsapp" autocomplete="off" ></li>
					    </ul>
						<ul>
						    <li class="pregunta" title="Instagram"><span class="icon-instagram"></span></li>
							<li class="respuesta"><input type="url"  size="66%" placeholder="Pega la URL de tu página de Instagram" value="" name="instagram" autocomplete="off" ></li>
					    </ul>
						<ul>
						    <li class="pregunta" title="Twitter"><span class="icon-twitter"></span></li>
							<li class="respuesta"><input type="url"  size="66%" placeholder="Pega la URL de tu página de Twitter" value="" name="twitter" autocomplete="off" ></li>
					    </ul>
						<ul>
						    <li class="pregunta" id="youtube" title="Youtube"><font size="5px"><span class="fa fa-youtube"></span></font></li>
							<li class="respuesta"><input type="url"  size="66%" placeholder="Pega la URL de tu página de Youtube" value="" name="youtube" autocomplete="off" ></li>
					    </ul>
						<ul>
						    <li class="pregunta" title="Google+"><span class="icon-googleplus"></span></li>
							<li class="respuesta"><input type="url"  size="66%" placeholder="Pega la URL de tu página de Google Plus" value="" name="googleplus" autocomplete="off" ></li>
					    </ul>
						<ul>
						    <li class="pregunta" title="Pinterest"><span class="icon-pinterest"></span></li>
							<li class="respuesta"><input type="url"  size="66%" placeholder="Pega la URL de tu página de Pinterest" value="" name="pinterest" autocomplete="off" ></li>
					    </ul>
						<ul>
						    <li class="pregunta" title="Linkedin"><span class="icon-linkedin"></span></li>
							<li class="respuesta"><input type="url"  size="66%" placeholder="Pega la URL de tu página de Linkedin" value="" name="linkedin" autocomplete="off" ></li>
					    </ul>
						<ul>
						    <li class="pregunta" title="Google Maps"><span class="icon-location"></span></li>
							<li class="respuesta"><input type="url"  size="66%" placeholder="Pega la URL de la ubicación de la tienda" value="" name="mapa" autocomplete="off" ></li>
					    </ul>
						<center>
						<ul class="boton-enviar">
						    <li class="respuesta"><div class="guardar"><input type="submit" value="Crear tienda"></div></li>
						</ul>
						</center>
				   </div>
				   </table>
		        </form>
		</section>
     </div>
<!-- inicio scrip de alert-->
     <script>
	    <?php 
	    $proceso = $_REQUEST['proceso'];
	    if ($proceso == 'apodo') { ?>
	        swal({title: "El nombre de usuario que introdujo no coincide con el sullo", timer: 4000, showConfirmButton: false }); <?php
	    } else {}; ?>
    </script>
<!-- final scrip de alert--> 
</body>
</html>