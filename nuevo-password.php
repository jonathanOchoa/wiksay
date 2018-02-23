<?php
//error_reporting(0);
error_reporting(E_ALL);
ini_set('display_errors', true);

include("login-php/conexion.bd.php");
$db = new conexion();

$modo = isset($_GET["modo"]) ? $_GET["modo"] : "default";

switch($modo){
  case "claveperdida":
         if (isset($_POST["email"])){
         
		    if(!empty($_POST["email"])){
			
			   include("login-php/acceso.php");
			   $recuperar = new acceso($_POST["user"],$_POST["email"],$_POST["pass"]);
			   $recuperar->claveperdida();
			} else {
			        header("location: nuevo-password.php?modo=claveperdida&error=campo_vacio");
			       }
			}else if (isset($_GET["error"]) and $_GET["error"] == "campo_vacio"){
		     $error= "ERROR: Debes rellenar el campo de Email";//es un mensaje de aviso para la clave perdida	
			}else if (isset($_GET["error"]) and $_GET["error"] == "email_inexistente"){
		     $error= "ERROR: El email que has ingresado no existe";//es un mensaje de aviso para la clave perdida
		    }if(isset($_GET["succes"]) and $_GET["succes"] == "ok") {
	             $succes= "Perfecto, le acabamos de enviar una nueva contraseña";//comentario que puedo cambiar
	   }
  break;  
  default:
  // como los errores los genero todos en cas: claveperdida; no hace falta que deje ninguno aqui.
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
	<link rel="shortcut icon" href="imagenes/wiksay.ico" type="image/x-icon">
	<meta name="robots" content="noodp">
	<link rel="stylesheet" href="css/estilos-nuevo-password.css">
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
			     <?php if(isset($_GET["succes"])){ echo '<div class="succes">',$succes,'</div>';}?><!---- (php)  para que los errores se muestren en pantalla ---->
                 <form action="nuevo-password.php?modo=claveperdida" method="POST">
				 <center><font size="5%">Recuperar contraseña</font ></center>
					<table>
						<tr>
							<td><input class="nombre-email" type="email" size="38%" placeholder="Correo electronico" name="email" autocomplete="off"></td>
							<input type="hidden" name="user" value="nada">
							<input type="hidden" name="pass" value="nada">
						</tr>
						<tr>
							<td><center><input class="entrar" type="submit" value="Recuperar contraseña"></center></td>
						</tr>
					</table>
				</form>
				
				
			</center>
		   </div>
		
		   <div class="fondo">
		   <center>
		        <ul>
			     <li class="queeswiksay"><b><a href="inicio-informacion.php"><b>¿Qué es Wiksay?</b></a></li>
			     <li><a href="inicio-informacion.php"><b>Condiciones legales</b></a></li>
			     <li><a href="inicio-informacionhp.php"><b>Privacidad</b></a></li>
			     <li><a href="inicio-informacion.php"><b>Cookies</b></a></li>
			</ul>
		   </center>
		   </div>
		
		</footer>   
      </div>
</body>
</html>