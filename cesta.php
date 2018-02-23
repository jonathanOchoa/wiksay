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

<?php include('llamadas-bd.php'); // id_user, id_tienda, producto_id ?> 

<?php
// INICIO: conexion a la base de datos
class conexion extends mysqli{

  public function __construct() {
    // direccion, usuario, contraseña, web  
    parent::__construct("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
    $this->query("SET NAMES 'utf8';");// esto sirve para evitar los caracteres extraños cuando estemos mandando y recibiendo datos. CONSULTAR MEJOR
    $this->connect_errno ? die("error con la conexion") : $x = "Conectado";
    //echo $x;
	unset($x);
  }
 
  public function recorrer($y){
     return mysqli_fetch_array($y); 
  }
}
// FINAL: conexion a la base de datos

$modo = isset($_GET["modo"]) ? $_GET["modo"] : "default";

switch($modo){
  case "login":
      if (isset($_POST["login"])){// verificamos si se envio el formulario de iniciar sesion
	     if(!empty($_POST["user"]) and !empty($_POST["pass"])){ // esto es para comprobar si hay datos vacios o no
	            
		    include("cesta-php/acceso.php");
		     $login = new acceso($_POST["user"],$_POST["email"],$_POST["pass"]);
		     $login->login();
		     
	    }else{ 
	          header("location: cesta.php?error=campos_vacios"); // este es el error de campos vacios
		     }
	}else{ 
	    header("location: cesta.php"); // esto es para el que intente entrar a la web comiando la url, el php lo redireccione a la pagina de registro. en wiksay seria index
	     }
  break;
  
  case "registro":
       if (isset($_POST["registro"])){// verificamos si se envio el formulario de registro
	     if(!empty(trim($_POST["user"])) and !empty(trim($_POST["email"])) and !empty(trim($_POST["pass"]))){ // empty es para comprobar si hay datos vacios o no y trim para que no me metan espacios como si fueran caracteres 
	        
			// Eliminar todos los caracteres ilegales de correo electrónico y Validamos e-mail
		      $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
		      if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) { 
					
					include("cesta-php/acceso.php");
					$registro = new acceso($_POST["user"],$_POST["email"], $_POST["pass"]);
					$registro->registro();
			  }else{ header("location: cesta.php?Error=Email no valido"); }
			 
	     }else{ header("location: cesta.php?modo=registro&error=campos_vacios"); } // lo redirijo a la pagina principal porque los datos estan vacios
			  
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
	<link rel="shortcut icon" href="imagenes/wiksay.ico" type="image/x-icon">
	<meta mane="robots" content="noodp">
	<link rel="stylesheet" href="css/estilos-cesta.css">
	<link rel="stylesheet" href="css/estilos-superior.css">
	<link rel="stylesheet" href="fonts/style.css">
	<link rel="stylesheet" href="font-awesome-4.4.0/css/font-awesome.min.css"/> 

</head>

<body>
<!-- google analitics-->
<?php include_once("analyticstracking.php") ?>

    <div id="gloval">
	    <?php include('usuario-php/mostrar-datos-user.php');?><!--PHP. estas lineas de php es para mostrar los datos-->
		
        <?php include('cabecera/header.php');?>
		
	    <!--inicio-->
	<section class="centro">
		<div class="titulo"><center><p>Cesta</p></center></div>	
		 
	    <?php 
		$total_compra =0;
		$total_envio =0;
		$conexion = new mysqli ("localhost", "linkmate", "corridor89", "linkmate_glewi"); // conexion a la db
	    $query = ("SELECT P.imagen, P.id, T.nombre_tienda, C.* FROM  producto P, cesta C, tienda T WHERE T.id=P.tienda_id AND P.id=C.producto_id;"); // nombre_tienda lo llame en la parte de arriba
		$resultado = $conexion->query($query);
		while($producto = $resultado->fetch_assoc()){ 
		    if ($id_user['id'] == $producto['usuario_id']) {
				$verificar = 1; ?>	
			  
				<section class="grupo">
					<div class="izquierda-1">		 
						<div class="imagen"><img class="imagen" src="data:image/jpg;base64, <?php echo base64_encode($producto['imagen']); ?>"></div>
					</div>
					<div  class="izquierda-2"> 
						<ul>
							<li class="nombre-producto"><b></b> <?php echo utf8_encode($producto['producto_nombre']);?></li>
						</ul>
						<ul>
							<li class="pregunta-10"><b>Tienda:</b></li>
							<li class="respuesta-10"><b><?php echo utf8_encode($producto['nombre_tienda']);?></b><a href="tienda.php?nombre=<?php echo utf8_encode($producto['nombre_tienda']);?>">: Ir a su tienda y mirar algo más</a></li>
						</ul>
						<ul>
							<li class="pregunta-10"><b>Precio:</b></li>
							<li class="respuesta-10"><b><?php echo utf8_encode($producto['producto_precio']);?> €</b></li>
							<?php 
							    // AQUI VAMOS SUMANDO CADA UNO DE LOS PRECIOS DE CADA PRODUCTO PARA OBTENER LA SUMA TOTAL DE TODOS
								$numero_unidades = utf8_encode($producto['producto_cantidad']);
								$producto_precio = utf8_encode($producto['producto_precio']);
								$producto_final = $producto_precio * $numero_unidades;
								$total_compra= $total_compra + $producto_final; 
							?>
						</ul>
						<?php if ($producto['producto_costes_envio'] != "" ){ ?>
							<ul>
								<li class="pregunta-10"><b>Costes envío:</b></li>
								<li class="respuesta-10"><?php echo $producto_costes_envio = utf8_encode($producto['producto_costes_envio']);?><b> €</b></li>
								<?php 
							    // AQUI VAMOS SUMANDO CADA UNO DE LOS COSTES DE ENVIO DE CADA PRODUCTO PARA OBTENER LA SUMA TOTAL DE TODOS
								$total_envio= $total_envio + $producto_costes_envio; 
							    ?>
							</ul>
						<?php }else{}; ?>
						<ul>
							<li class="pregunta-10"><b>Colores:</b></li>
							<li class="respuesta-10">
								<?php echo $color = utf8_encode($producto['producto_color']);?>
							</li>
						</ul>
						<ul> 
							<li class="pregunta-10"><b>Tallas:</b> </li>
							<li class="respuesta-10">
								<?php echo $talla = utf8_encode($producto['producto_talla']);?>
							</li> 
						</ul>
						<?php if ($producto['producto_cantidad'] != "" ){ ?>
							<ul>
								<li class="pregunta-10"><b>Cantidad:</b></li>
								<li class="respuesta-10">
									<?php echo $cantidad = utf8_encode($producto['producto_cantidad']),' Unidades.';?>
								</li>
							</ul>
						<?php }else{}; ?>
						<ul>
							<li  class="eliminar"title="Eliminar producto"><a href="cesta-php/proceso-eliminar-producto.php?cesta_id=<?php echo $producto['idcesta'] ?>&producto_id=<?php echo $producto['id'] ?>&id_user=<?php echo $id_user['id'] ?>&nombre_user=<?php echo $id_user['apodo'] ?>">Eliminar</a></li>
						</ul>
					</div>
				</section>
	    <?php 
		    } else{}
		} 
		?>
		<?php
		if (isset ($verificar) AND $verificar == 1){
				// no ago nada
			    }else{echo '<div class="carrito_vacio">
									<div class="ojo"><font size="5px"><span class="fa fa-eye"></span></font></div>
									<div class="vacio"><font size="5px"><b>Carrito vacio</b></font></div>
                            </div>';} 
		?> 

        <section class="grupo-1">
			
			    <div class="titulo-1"><center><b>Total del pedido</b></center></div>
                <div class="comprar">
					<ul class="total-compra-envio">
						<li class="cuenta-izquierda"><b>TOTAL COMPRA</b></li>
						<li class="cuenta-derecha"><b><?php echo $total_compra,' €'; ?></b></li>
					</ul>
				
					<ul class="total-compra-envio">
						<li class="cuenta-izquierda"><b>COSTES DE ENVÍO</b></li>
						<li class="cuenta-derecha"><b><?php echo $total_envio,' €'; ?></b></li>
					</ul>
				
					<ul class="total-pedido">
						<li class="cuenta-izquierda"><b>TOTAL PEDIDO</b></li>
						<li class="cuenta-derecha"><b><?php echo $total_pedido = $total_compra+$total_envio; echo ' €';?></b></li>
					</ul>
				</div>
		</section>
		
		<?php if(!isset($_SESSION["user"])){ ?>
		<section class="grupo-2">
			<div>
			    <div class="titulo-2">
				    <p><b>1. Datos de acceso.</b></p>
				    <p>Inicia Sesion</p>
				</div>
				
					<?php if(isset($_GET["error"])){ echo '<div class="error">',$error,'</div>';}?><!---- (php)  para que los errores se muestren en pantalla ---->
					<form action="cesta.php?modo=login" method="POST">
						<ul>
							<li class="pregunta"><font color="red">*</font>Nombre Usuario</li>
							<li class="respuesta"><input type="text"  size="20%" placeholder="Nombre Usuario" name="user" autocomplete="off" REQUIRED></li>
						</ul>
						<ul>
							<li class="pregunta"><font color="red">*</font>Contraseña</li>
							<li class="respuesta">
								<input type="password"  size="20%" placeholder="Contraseña" name="pass" autocomplete="off" REQUIRED>
							    <input type="hidden" value="1" name="login"/>
							</li>
						</ul>
						<ul>
							<li class="comprar"><input type="submit" value="Iniciar Sesion"></li>
						</ul>
					</form>
					
				<div class="titulo-2">
				    <p>Registrate</p>
				</div>
				
					<?php if(isset($_GET["error"])){ echo '<div class="error">',$error,'</div>';}?><!---- (php)  para que los errores se muestren en pantalla ---->
					<form action="cesta.php?modo=registro" method="POST">
						<ul>
							<li class="pregunta"><font color="red">*</font>Nombre Usuario</li>
							<li class="respuesta"><input type="text"  size="20%" placeholder="Nombre Usuario" name="user" autocomplete="off" REQUIRED></li>
						</ul>
						<ul>
							<li class="pregunta"><font color="red">*</font>Correo Electronico</li>
							<li class="respuesta"><input type="email"  size="20%" placeholder="Correo Electronico" name="email" autocomplete="off" REQUIRED></li>
						</ul>
						<ul>
							<li class="pregunta"><font color="red">*</font>Contraseña</li>
							<li class="respuesta">
								<input type="password"  size="20%" placeholder="Contraseña" name="pass" autocomplete="off" REQUIRED>
								<input type="hidden" value="1" name="registro"/>
							</li>
						</ul>
						<ul>
							<li class="comprar"><input type="submit"  size="20%" value="Registrarme"></li>
						</ul>
					</form>
			</div>
		</section>
		<?php }else{ } ?>
		
		<section class="grupo-3">
			<div>
			    <div class="titulo-3">
				    <p><b>2. Dirección de envío.</b></p>
				    <p>¿Donde quieres que te enviemos este pedido?</p>
				</div>
				
				<ul>
					<li class="pregunta"><font color="red">*</font>Nombre</li>
					<li class="respuesta"><input type="text"  size="30%" placeholder="Nombre" name="nombre" autocomplete="off" REQUIRED></li>
				</ul>
				<ul>
					<li class="pregunta"><font color="red">*</font>Apellidos</li>
					<li class="respuesta"><input type="text"  size="30%" placeholder="Apellidos" name="nombre" autocomplete="off" REQUIRED></li>
				</ul>
				<ul>
					<li class="pregunta"><font color="red">*</font>Localidad</li>
					<li class="respuesta"><input type="text"  size="15%" placeholder="Localidad" name="nombre" autocomplete="off" REQUIRED></li>
				</ul>
				<ul>
					<li class="pregunta"><font color="red">*</font>Código Postal</li>
					<li class="respuesta"><input type="text"  size="15%" placeholder="Código Postal" name="nombre" autocomplete="off" REQUIRED></li>
				</ul>
				<ul>
					<li class="pregunta"><font color="red">*</font>Provincia</li>
					<li class="respuesta"><input type="text"  size="15%" placeholder="Provincia" name="nombre" autocomplete="off" REQUIRED></li>
				</ul>
				<ul>
					<li class="pregunta"><font color="red">*</font>Teléfono</li>
					<li class="respuesta"><input type="text"  size="15%" placeholder="Teléfono" name="nombre" autocomplete="off" REQUIRED></li>
				</ul>
			</div>
		</section>
		
		<section class="grupo-4">
			<div>
			    <div class="titulo-4">
				    <p><b>3. Detalles de pago.</b></p>
				    <p>Completa los datos para realizar tu compra</p>
				</div>
				
				<ul>
					<li class="pregunta"><font color="red">*</font>Nombre del Titular</li>
					<li class="respuesta"><input type="text"  size="30%"  name="nombre" autocomplete="off" REQUIRED></li>
				</ul>
				<ul>
					<li class="pregunta"><font color="red">*</font>Numero de tarjeta</li>
					<li class="respuesta"><input type="text"  size="30%"  name="nombre" autocomplete="off" REQUIRED></li>
				</ul>
				<ul>
					<li class="pregunta"><font color="red">*</font>Fecha de vencimiento</li>
					<li class="respuesta">
						<button type="button">
							<select>
								<option value="1" selected="selected">01</option>
								<option value="2">02</option>
								<option value="3">03</option>
								<option value="4">04</option>
								<option value="5">05</option>
								<option value="6">06</option>
								<option value="7">07</option>
								<option value="8">08</option>
								<option value="9">09</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
							</select>
						</button>
						
						<button type="button">
							<select>
								<option value="2015" selected="selected">2015</option>
								<option value="2016">2016</option>
								<option value="2017">2017</option>
								<option value="2018">2018</option>
								<option value="2019">2019</option>
								<option value="2020">2020</option>
								<option value="2021">2021</option>
								<option value="2022">2022</option>
								<option value="2023">2023</option>
								<option value="2024">2024</option>
								<option value="2025">2025</option>
								<option value="2026">2026</option>
								<option value="2027">2027</option>
								<option value="2028">2028</option>
								<option value="2029">2029</option>
								<option value="2030">2030</option>
								<option value="2031">2031</option>
								<option value="2032">2032</option>
								<option value="2033">2033</option>
								<option value="2034">2034</option>
								<option value="2035">2035</option>
								<option value="2036">2036</option>
								<option value="2037">2037</option>
								<option value="2038">2038</option>
								<option value="2039">2039</option>
								<option value="2040">2040</option>
								<option value="2041">2041</option>
								<option value="2042">2042</option>
								<option value="2043">2043</option>
								<option value="2044">2044</option>
								<option value="2045">2045</option>
							</select>
						</button>
					</li>
				</ul>
				<ul>
					<li class="pregunta"><font color="red">*</font>Código CVV2</li>
					<li class="respuesta"><input type="text"  size="30%"  name="nombre" autocomplete="off" REQUIRED></li>
				</ul>
				<ul>
					<li class="comprar"><input type="submit"  size="30%" value="Comprar"></li>
				</ul>
			</div>
		</section>
		
	</section>
	</div>
		<!--fin-->  
</body>
</html>