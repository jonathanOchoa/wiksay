<?php
//error_reporting(0);
error_reporting(E_ALL);
ini_set('display_errors', true);

include("login-php/conexion.bd.php");


session_start();

if(isset($_SESSION["user"])){
  header("location: cliente.php");} else{}	  

$db = new conexion();

$modo = isset($_GET["modo"]) ? $_GET["modo"] : "default";

switch($modo){
  case "login":
      if (isset($_POST["login"])){// verificamos si se envio el formulario de iniciar sesion
	     if(!empty($_POST["user"]) and !empty($_POST["pass"])){ // esto es para comprobar si hay datos vacios o no
	            
		    include("login-php/acceso.php");
		     $login = new acceso($_POST["user"],$_POST["email"],$_POST["pass"]);
		     $login->login();
		     
	    }else{ 
	          header("location: inicio.php?error=campos_vacios"); // este es el error de campos vacios
		     }
	}else{ 
	    header("location: inicio.php"); // esto es para el que intente entrar a la web comiando la url, el php lo redireccione a la pagina de registro. en wiksay seria index
	     }
  break;
  
  case "registro":
       if (isset($_POST["registro"])){// verificamos si se envio el formulario de registro
	     if(!empty(trim($_POST["user"])) and !empty(trim($_POST["email"])) and !empty(trim($_POST["pass"]))){ // empty es para comprobar si hay datos vacios o no y trim para que no me metan espacios como si fueran caracteres 
	        
			// Eliminar todos los caracteres ilegales de correo electrónico y Validamos e-mail
		      $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
		      if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) { 
					
					include("login-php/acceso.php");
					$registro = new acceso($_POST["user"],$_POST["email"], $_POST["pass"]);
					$registro->registro();
			  }else{ header("location: inicio.php?Error=Email no valido"); }
			 
	     }else{ header("location: inicio.php?modo=registro&error=campos_vacios"); } // lo redirijo a la pagina principal porque los datos estan vacios
			  
	   }else if (isset($_GET["error"]) and $_GET["error"] == "campos_vacios"){
		     $error = "ERROR: Debes rellenar todos los campos para poder registrarte";//es un mensaje de aviso para el registo
	   }else if (isset($_GET["error"]) and $_GET["error"] == "usuario_usado" and $_GET["error"] !== "email_usado"){
		     $error = "ERROR: El usuario ingresado ya existe";//es un mensaje de aviso para el registo
	   }else if (isset($_GET["error"]) and $_GET["error"] == "email_usado" and $_GET["error"] !== "usuario_usado"){
		     $error = "ERROR: El email ingresado ya existe";//es un mensaje de aviso para el registo
	   }else if (isset($_GET["error"]) and $_GET["error"] == "email_usuario_usado"){
		     $error = "ERROR: El usuario y email ingresado ya existen";//es un mensaje de aviso para el registo
	   }
  break;

  default:
      if(isset($_GET["error"]) and $_GET["error"] == "campos_vacios") {
	         $error = "ERROR: Debes rellenar todos los campos";//comenario que puedo cambiar
	   }else if(isset($_GET["error"]) and $_GET["error"] == "datos_incorrectos"){
	         $error = "ERROR: Los datos son incorresctos";//comentario que puedo cambiar
	   }else if(isset($_GET["error"]) and $_GET["error"] == "acceso"){
	         $error = "ERROR: La sesión a caducado o no has iniciado sesión";//comentario que puedo cambiar
	   }else if(isset($_GET["succes"]) and $_GET["succes"] == "ok"){
	         $error = "ERROR: Perfecto, le acabamos de enviar una nueva contraseña";//comentario que puedo cambiar
	   }
  break;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Wiksay</title>
	<meta charset="utf-8">
	<meta name="description" content="Crea una cuenta en Wiksay. Conecta con tiendas y diseñadores. Comparte, comenta, dale like y encuentra cualquier articulo. Envía mensajes y...">
	<meta name="keywords" content="Wiksay, tiendas, ropa, comunicación, red social, comprar, productos"/>
	<meta name="viewport" content="width=device-width"> <!--Esto es para que el responsive se adacte a los dispositivos moviles-->
	<meta mane="robots" content="noodp">
	<link rel="shortcut icon" href="imagenes/wiksay.ico" type="image/x-icon">
	<link rel="stylesheet" href="css/estilos-inicio.css">
</head>

<body>
<!-- google analitics-->
<?php include_once("analyticstracking.php") ?>

      <div id="gloval">
        <header class="superior">
		  <center>
			   <div class="menu1"><a href="index.php"><b>Wiksay</b></a></div>
          </center>				  
        </header>
		<footer>
		   
		   <div class="login">
		   
		   <center>
			     <?php if(isset($_GET["error"])){ echo '<div class="error">',$error,'</div>';}?><!---- (php)  para que los errores se muestren en pantalla ---->
                 <form action="inicio.php?modo=login" method="POST">
				 <center><font size="5%">Iniciar sesión</font ></center>
					<table>
						<tr>
							<td><input class="nombre-email" type="text"  size="38%" placeholder="Nombre de usuario" name="user" autocomplete="off">			<input type="hidden" name="email" value="nada"></td>
						</tr>
						<tr>
							<td>
								<input class="nombre-email" type="password" size="22%" placeholder="Contraseña" name="pass" autocomplete="off">
							    <input type="hidden" value="1" name="login"/>
							    <input class="entrar" type="submit" value="Entrar">
							</td>
						</tr>
					</table>
				</form>
				
				<?php if(isset($_GET["error"])){ echo '<div class="error">',$error,'</div>';}?><!---- (php)  para que los errores se muestren en pantalla ---->
                <form action="inicio.php?modo=registro" method="POST">
				<center><font size="5%">¿Eres nuevo en Wiksay?</font ></center>
				<center><font size="5%">Regístrate</font ></center>
					<table>
						<tr>
							<td><input class="nombre-email" type="text"  size="38%" placeholder="Nombre de usuario" name="user" autocomplete="off"></td>
					    </tr>
						<tr>
							<td><input class="nombre-email" type="email" size="38%" placeholder="Correo electronico" name="email" autocomplete="off"></td>
						</tr>
						<tr>
						<td><input class="nombre-email" type="password" size="18%" placeholder="Contraseña" name="pass" autocomplete="off"></td>
						</tr>
						<tr>
						<center><td><p class="confirmacion">Al hacer clic en Registrarte, aceptas las <a href="inicio-informacion.php">Condiciones</a> y confirmas que has leído nuestra <a href="inicio-informacion.php">Política de datos</a>, incluido el <a href="inicio-informacion.php">Uso de cookies.</a></p></td></center>
						</tr>
						<tr>
						    <td>
								<input type="hidden" value="1" name="registro"/>
							    <input class="entrar" type="submit" value="Registrarse">
							</td>
						</tr>
					</table>
				</form>	
			    <div>Recordar mis datos - <a href="nuevo-password.php">¿Olvidaste tu contraseña?</a></div>
			</center>
		   </div>
		
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