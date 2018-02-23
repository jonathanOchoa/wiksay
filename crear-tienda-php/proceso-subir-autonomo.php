<?php
error_reporting(0);
//error_reporting(E_ALL);
//ini_set('display_errors', true);

session_start();

if(isset($_SESSION["user"])){
  //echo"Bienvenido", $_SESSION["user"];
}else{//si la secion se inicio mal, se destrira y se redirige a la pagina principal
      session_start();
	  session_destroy();
	  header("location: index?error=acceso");
      }
	  $user = $_SESSION['user'];
	  
    // todo esto es para mostrar el id del usuario
    $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
    $usuario = utf8_decode($_SESSION['user']);
	$query = ("SELECT * FROM usuario WHERE apodo='$usuario';");
	$resultado = $conexion->query($query);
	$id_usuario = $resultado->fetch_assoc();	
	// aqui llamo al id y el apodo mandado por url
    $id_usuario_url = $conexion->real_escape_string($_REQUEST['id']);
	$apodo_url = $conexion->real_escape_string($_REQUEST['apodo']);
	/* en este if compruebo si los dos id y apodos coinciden.
	   1)si coinciden el id y el id_usuario_url dejo pasar a la siguiente pregunta */
	if($id_usuario['id'] != $id_usuario_url) {header("location: ../cliente?proceso=nocreada");} else {
	    //2)si coinciden el apodo con el apodo_url dejo crear la tienda
	    if(utf8_encode($id_usuario['apodo']) != $apodo_url) {header("location: ../cliente?proceso=nocreada");} else {
		
			//a qui ya conecto con la bd para realizar el proceso
			$conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db 

			$id =   $conexion->real_escape_string($_REQUEST['id']);
			$user = $conexion->real_escape_string(utf8_decode($_REQUEST['apodo']));

			// isset: verificamos si se envio el formulario de registro ,empty: es para comprobar si hay datos vacios o no, is_muneric: para ver si la variable es numerica o no			
		    if (isset($_FILES['imagen_fondo']['tmp_name']) AND isset($_FILES['imagen_perfil']['tmp_name']) AND isset($_POST['apodo_empresa']) AND isset($_POST['tipo_empresa']) AND isset($_POST['categoria_ti_id']) AND isset($_POST['email_empresa'])){ 
		     if ( !empty($_FILES['imagen_fondo']['tmp_name']) AND !empty($_FILES['imagen_perfil']['tmp_name']) AND !empty($_POST['apodo_empresa']) AND !empty($_POST['tipo_empresa']) AND !empty($_POST['categoria_ti_id']) AND !empty($_POST['email_empresa']) ){ 
			 
			  // Eliminar todos los caracteres ilegales de correo electrónico y Validamos e-mail
		      $email = filter_var(utf8_decode($_POST['email_empresa']), FILTER_SANITIZE_EMAIL);
		      if (!filter_var(utf8_decode($_POST['email_empresa']), FILTER_VALIDATE_EMAIL) === false) {
			 
				$imagen_fondo_tienda = addslashes(file_get_contents($_FILES['imagen_fondo']['tmp_name'])); //obligatorio
				$imagen_perfil_tienda = addslashes(file_get_contents($_FILES['imagen_perfil']['tmp_name'])); //obligatorio
				$apodo_empresa = 	 $conexion->real_escape_string(utf8_decode($_POST['apodo_empresa'])); //obligatorio
				$tipo_empresa = 	 $conexion->real_escape_string(utf8_decode($_POST['tipo_empresa'])); //obligatorio
				$categoria_ti_id = 	 $conexion->real_escape_string(utf8_decode($_POST['categoria_ti_id'])); //obligatorio
				if (isset($_POST['nombre_comercial'])){$nombre_comercial =  $conexion->real_escape_string(utf8_decode($_POST['nombre_comercial']));}else{$nombre_comercial = "";}
				if (isset($_POST['cif_empresa'])){$cif_empresa =       $conexion->real_escape_string(utf8_decode($_POST['cif_empresa']));}else{$cif_empresa = "";}
				if (isset($_POST['nombre_empresa'])){$nombre_empresa =    $conexion->real_escape_string(utf8_decode($_POST['nombre_empresa'])); }else{$nombre_empresa = "";}
				$email_empresa = 	 $conexion->real_escape_string(utf8_decode($_POST['email_empresa'])); //obligatorio
				if (isset($_POST['pais_empresa'])){$pais_empresa = $conexion->real_escape_string(utf8_decode($_POST['pais_empresa']));}else{$pais_empresa = "";}
				if (isset($_POST['provincia_empresa'])){$provincia_empresa = $conexion->real_escape_string(utf8_decode($_POST['provincia_empresa']));}else{$provincia_empresa = "";}
				if (isset($_POST['poblacion_empresa'])){$poblacion_empresa = $conexion->real_escape_string(utf8_decode($_POST['poblacion_empresa']));}else{$poblacion_empresa = "";}
				if (isset($_POST['direccion_empresa'])){$direccion_empresa = $conexion->real_escape_string(utf8_decode($_POST['direccion_empresa']));}else{$direccion_empresa = "";}
				if (isset($_POST['telefono1_empresa'])){$telefono1_empresa = $conexion->real_escape_string($_POST['telefono1_empresa']);}else{$telefono1_empresa = "";}
				if (isset($_POST['telefono2_empresa'])){$telefono2_empresa = $conexion->real_escape_string($_POST['telefono2_empresa']);}else{$telefono2_empresa = "";}
				if (isset($_POST['fax_empresa'])){$fax_empresa = $_POST['fax_empresa'];}else{$fax_empresa = "";}
				$fecha_actual = date('Y-m-d H:i:s');

				if ($user == $apodo_empresa){

					$query = ("INSERT INTO empresa (apodo_empresa, nombre_empresa, nombre_comercial, cif_empresa, 
								email_empresa, pais_empresa, provincia_empresa, poblacion_empresa, direccion_empresa, telefono1_empresa, 
								telefono2_empresa, fax_empresa, tipo_empresa, usuario_id, fecha_alta) VALUE ('$apodo_empresa',
								'$nombre_empresa','$nombre_comercial','$cif_empresa','$email_empresa','$pais_empresa','$provincia_empresa',
								'$poblacion_empresa','$direccion_empresa','$telefono1_empresa','$telefono2_empresa','$fax_empresa','$tipo_empresa','$id','$fecha_actual')");
		  
					// pongo esta segunda insercion para que aparesca el nombre que el usuario quiere darle a la tienda en la tabla tienda tmbn			  
					$query2 = ("INSERT INTO tienda (imagen_tienda, imagen_fondo_tienda, nombre_tienda, apodo_tienda, usuario_id, categoria_t_id, fecha_alta) VALUE ('$imagen_perfil_tienda','$imagen_fondo_tienda','$nombre_empresa','$apodo_empresa','$id','$categoria_ti_id','$fecha_actual')");

					$resultado1 = $conexion->query($query);// con esto le estamos diciendo que nos almacene los datos
					$resultado2 = $conexion->query($query2);// con esto le estamos diciendo que nos almacene los datos
	
						if ($resultado1 AND $resultado2) {
							if (isset($_POST['facebook'])){ $facebook =   $conexion->real_escape_string(utf8_decode($_POST['facebook'])); }else{$facebook = "";}
							if (isset($_POST['whatsapp'])){ $whatsapp =   $conexion->real_escape_string(utf8_decode($_POST['whatsapp'])); }else{$whatsapp = "";}
							if (isset($_POST['instagram'])){ $instagram =  $conexion->real_escape_string(utf8_decode($_POST['instagram'])); }else{$instagram = "";}
							if (isset($_POST['twitter'])){ $twitter =    $conexion->real_escape_string(utf8_decode($_POST['twitter'])); }else{$twitter = "";}
							if (isset($_POST['youtube'])){ $youtube =    $conexion->real_escape_string(utf8_decode($_POST['youtube'])); }else{$youtube = "";}
							if (isset($_POST['googleplus'])){ $googleplus = $conexion->real_escape_string(utf8_decode($_POST['googleplus'])); }else{$googleplus = "";}
							if (isset($_POST['pinterest'])){ $pinterest =  $conexion->real_escape_string(utf8_decode($_POST['pinterest'])); }else{$pinterest = "";}
							if (isset($_POST['linkedin'])){ $linkedin =   $conexion->real_escape_string(utf8_decode($_POST['linkedin'])); }else{$linkedin = "";}
							if (isset($_POST['mapa'])){ $mapa =       $conexion->real_escape_string(utf8_decode($_POST['mapa'])); }else{$mapa = "";}
    
							// UNA VEZ CREADA LA TIENDA LLAMO EL ID DE LA TABLA EMPRESA.
							$query66 = ("SELECT id FROM empresa WHERE usuario_id='$id';"); 
							$resultado = $conexion->query($query66);
							$id_de_empresa = $resultado->fetch_assoc();
							$empresa_id = $id_de_empresa['id'];
		
							$query3 = ("INSERT INTO social_media (facebook, whatsapp, instagram, twitter, youtube, googleplus, pinterest, linkedin, mapa, empresa_id, empresa_usuario_id) VALUE ('$facebook', '$whatsapp', '$instagram', '$twitter', '$youtube', '$googleplus', '$pinterest', '$linkedin', '$mapa', '$empresa_id', '$id')");
	
							$resultado3 = $conexion->query($query3);// con esto le estamos diciendo que nos almacene los datos

								if ($resultado3){
									header ('location: ../tienda-vendedor?proceso=creada');
									}else {
										  header ('location: ../crear-tienda?proceso=error');
										  }
						}else{
					         header ('location: ../crear-tienda?proceso=apodo');
							 }				  
				}else{
			         header ('location: ../crear-tienda?proceso=apodo');
			         }
					 
			 }else{header("location: ../crear-tienda");}		 
			 }else{header("location: ../crear-tienda");}			
	        }else{header("location: ../crear-tienda");}			 
		}
	}
?>