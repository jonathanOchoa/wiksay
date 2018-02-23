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
	/* compruebo: 1)si el id usuario no es igual al id_url lo redirijo a la pagina cliente.php
	              2)si el id usuario es igual al id_url lo dejo entrar */
	$id_url = $_REQUEST['id'];
	if($id_user['id'] != $id_url) { header("location: cliente.php");}
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
	<link rel="stylesheet" href="css/estilos-configuracion-usuario.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script><!--este es para que funcione la imagen predeterminada-->
	<script type="text/javascript" src="js/preload-imagen.js"></script><!--este es para que funcione la imagen predeterminada-->
	
</head>

<body>
      <div id="gloval">
	    <?php include('usuario-php/mostrar-datos-user.php');?><!--PHP. estas lineas de php es para mostrar los datos-->
        <?php include('cabecera/header.php');?> 
		
		<section class="centro">
		<!-- inicio php configuracion usuario-->
		
				
				 <center><div class="configuracion"><p>Configuración usuario</p></div></center>
				 <center>
				 <form class="formulario-imagen" action="usuario-php/proceso-modificar-imagen-usuario.php?id=<?php echo $informacion['id'];?>" method="POST" enctype="multipart/form-data"> 	
					    <div class="imagen">
						    <!--puse la img primero porque se me colocaba fuera del div el input y lo coloque con css-->
						    <img id="output" class="imagen" src="usuario-php/imagenes-usuario/<?php echo $informacion['imagen1']; ?>">
						    <input accept="image/*" onchange="loadFile(event)" class="imagen-imagen" type="file" name="imagen" REQUIRED/>
							
					    </div>
						<div class="nota"><p>*Las imágenes no pueden superar los 2000px de largo y 2000px de alto.</p></div> 
						<div class="nota"><p>*Recomendamos una imágen con relación 2 de largo x 1 de alto.</p></div>
			            <div class="guardar-imagen"><input type="submit" value="Modificar imagen"></div>
			    </form>
				
				 <form class="formulario" action="usuario-php/proceso-modificar-informacion-usuario.php?id=<?php echo $informacion['id'];?>" method="POST" enctype="multipart/form-data">
					<table class="tabla-configuracion">
						<tr>
							<td class="pregunta">Nombre usuario:</td>
							<td class="respuesta"><?php echo utf8_encode($informacion['apodo']); ?> <font color="#9197a3">(No se puede modificar)</font></td>
						</tr>
						<tr>
							<td class="pregunta">Email:</td>
							<td class="respuesta"><?php echo utf8_encode($informacion['email']); ?> <font color="#9197a3">(No se puede modificar)</font></td>
					    </tr>
						<tr>
							<td class="pregunta">Apellidos:</td>
							<td class="respuesta"><input type="text"  size="38%" placeholder="Apellidos" value="<?php echo utf8_encode($informacion['apellidos']); ?>" name="apellidos" autocomplete="off" ></td>
					    </tr>
						<tr>
							<td class="pregunta">Número teléfono:</td>
							<td class="respuesta"><input type="number"  size="38%" placeholder="Número contacto" value="<?php echo utf8_encode($informacion['telefono']); ?>" name="telefono" autocomplete="off" ></td>
					    </tr>
						<tr>
							<td class="pregunta">País:</td>
							<td class="respuesta"><input type="text"  size="38%" placeholder="País" value="<?php echo utf8_encode($informacion['pais']); ?>" name="pais" autocomplete="off" ></td>
					    </tr>
						<tr>
							<td class="pregunta">Provincia:</td>
							<td class="respuesta"><input type="text"  size="38%" placeholder="Provincia" value="<?php echo utf8_encode($informacion['provincia']); ?>" name="provincia" autocomplete="off" ></td>
					    </tr>
						<tr>
							<td class="pregunta">Población:</td>
							<td class="respuesta"><input type="text"  size="38%" placeholder="Población" value="<?php echo utf8_encode($informacion['poblacion']); ?>" name="poblacion" autocomplete="off" ></td>
					    </tr>
						<tr>
							<td class="pregunta">Dirección:</td>
							<td class="respuesta"><input type="text"  size="38%" placeholder="Nombre de la calle" value="<?php echo utf8_encode($informacion['direccion']); ?>" name="direccion" autocomplete="off" ></td>
					    </tr>
						<tr>
						    <td class="pregunta">Facebook:</td>
							<td class="respuesta"><input type="url"  size="38%" placeholder="Pega la URL de tu página de facebook" value="<?php echo utf8_encode($social['facebook']); ?>" name="facebook" autocomplete="off" ></td>
					    </tr>
						<tr>
						    <td class="pregunta">Instagram:</td>
							<td class="respuesta"><input type="url"  size="38%" placeholder="Pega la URL de tu página de instagram" value="<?php echo utf8_encode($social['instagram']); ?>" name="instagram" autocomplete="off" ></td>
					    </tr>
						<tr>
						    <td class="pregunta">Twitter:</td>
							<td class="respuesta"><input type="url"  size="38%" placeholder="Pega la URL de tu página de twitter" value="<?php echo utf8_encode($social['twitter']); ?>" name="twitter" autocomplete="off" ></td>
					    </tr>
						<tr>
						    <td class="pregunta">Google plus:</td>
							<td class="respuesta"><input type="url"  size="38%" placeholder="Pega la URL de tu página de google plus" value="<?php echo utf8_encode($social['google_plus']); ?>" name="google_plus" autocomplete="off" ></td>
					    </tr>
						<tr>
						    <td class="pregunta">Pinterest:</td>
							<td class="respuesta"><input type="url"  size="38%" placeholder="Pega la URL de tu página de pinterest" value="<?php echo utf8_encode($social['pinterest']); ?>" name="pinterest" autocomplete="off" ></td>
					    </tr>
						<tr>
						    <td class="pregunta">Linkedin:</td>
							<td class="respuesta"><input type="url"  size="38%" placeholder="Pega la URL de tu página de linkedin" value="<?php echo utf8_encode($social['linkedin']); ?>" name="linkedin" autocomplete="off" ></td>
					    </tr>
						<tr>
						    <td class="pregunta"></td>
						    <td class="guardar-informacion"><input type="submit" value="Modificar información"></td>
						</tr>
					</table>
			    </form>
				<!-- final php configuracion usuario-->	
			    <!-- inicio php configuracion contraseña-->		
				<form action="usuario-php/cambiar_password.php?id=<?php echo $informacion['id'];?>" method="POST">
					<table  class="tabla-cambiar-contraseña">
					    <tr>
						    <td class="pregunta">Contraseña actual</td>
							<td class="respuesta"><input type="password"  size="38%" placeholder="Tu contraseña actual" name="contraseña"  autocomplete="off" REQUIRED></td>
					    </tr>
						<tr>
						    <td class="pregunta">Nueva contraseña:</td>
							<td class="respuesta"><input type="password"  size="38%" placeholder="Nueva contraseña" name="repetir_contraseña"  autocomplete="off" REQUIRED></td>
					    </tr>
						<tr>
						    <td class="pregunta">Repetir contraseña:</td>
							<td class="respuesta"><input type="password"  size="38%" placeholder="Repetir nueva contraseña" name="nueva_contraseña"  autocomplete="off" REQUIRED></td>
					    </tr>
						<tr>
						    <td class="pregunta"></td>
							<td class="guardar-informacion"><input type="submit" value="Modificar contraseña"></td>
					    </tr>
					</table>
			    </form>
				</center>
		        <!-- final php configuracion contraseña-->		
		</section>
     </div>
<!-- inicio scrip de alert-->
     <script>
	    <?php 
	    $proceso = $_REQUEST['proceso'];
	    if ($proceso == 'imag') { ?>
	        swal({   title: "Excelente", text: "La imágen se ha guardado", timer: 2000, showConfirmButton: false }); <?php
	    } else {}; ?>
    </script>
     <script>
	    <?php 
	    $proceso = $_REQUEST['proceso'];
	    if ($proceso == 'info') { ?>
	        swal({   title: "Excelente", text: "Los cambios se han guardado", timer: 2000, showConfirmButton: false }); <?php
	    } else {}; ?>
    </script>
	<script>
	    <?php 
	    $proceso = $_REQUEST['proceso'];
	    if ($proceso == 'password') { ?>
	        swal({   title: "Excelente", text: "La contraseña se ha modificado", timer: 2000, showConfirmButton: false }); <?php
	    } else {}; ?>
    </script>
	<script>
	    <?php 
	    $proceso = $_REQUEST['proceso'];
	    if ($proceso == 'malpassword') { ?>
	        swal({   title: "Oops ...", text: "La contraseña no coincide", timer: 2000, showConfirmButton: false }); <?php
	    } else {}; ?>
    </script>
	<script>
	    <?php 
	    $proceso = $_REQUEST['proceso'];
	    if ($proceso == 'diferentespassword') { ?>
	        swal({   title: "Oops ...", text: "Las contraseñas no son iguales", timer: 2000, showConfirmButton: false }); <?php
	    } else {}; ?>
    </script>
<!-- final scrip de alert--> 
</body>
</html>