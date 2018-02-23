<?php
//error_reporting(0);
error_reporting(E_ALL);
ini_set('display_errors', true);

session_start();

if(isset($_SESSION["user"])){
  //echo"Bienvenido", $_SESSION["user"];
}else{//si la secion se inicio mal, se destrira y se redirige a la pagina principal
      session_start();
	  session_destroy();
	  header("location: index.php?error=acceso");
      }
	  
    // todo esto es para mostrar el id del usuario
    $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
    $user = $_SESSION['user'];
	$usuario = utf8_decode($_SESSION['user']);
	$query = ("SELECT * FROM usuario WHERE apodo='$usuario';");
	$resultado = $conexion->query($query);
	$id_usuario = $resultado->fetch_assoc();	
	// aqui llamo al id mandado por url
    $id_usuario_url = $conexion->real_escape_string($_REQUEST['id']);
	/* en este if compruebo si los dos id coinciden.
	   1)si coinciden lo dejo realizar el proceso de subida
	   2)si no coincioden lo mando directamente a la tienda */
	if($id_usuario['id'] != $id_usuario_url) {header("location: ../tienda-vendedor.php?proceso=nomodificado");} else {
	  
	    //a qui ya conecto con la bd para realizar el proceso
        $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db

		$id = $conexion->real_escape_string($_REQUEST['id']);

		// isset: verificamos si se envio el formulario de registro ,empty: es para comprobar si hay datos vacios o no, is_muneric: para ver si la variable es numerica o no		
		if (isset($_POST['categoria_t_id'])){ 
			if (!empty($_POST['categoria_t_id'])){ 
				if ((is_numeric($_POST['telefono1_empresa']) OR empty($_POST['telefono1_empresa']))){

					if (isset($_POST['pais_empresa'])){$pais_empresa = $conexion->real_escape_string(utf8_decode($_POST['pais_empresa']));}else{$pais_empresa = "";}
					if (isset($_POST['provincia_empresa'])){$provincia_empresa = $conexion->real_escape_string(utf8_decode($_POST['provincia_empresa']));}else{$provincia_empresa = "";}
					if (isset($_POST['poblacion_empresa'])){$poblacion_empresa = $conexion->real_escape_string(utf8_decode($_POST['poblacion_empresa']));}else{$poblacion_empresa = "";}
					if (isset($_POST['direccion_empresa'])){$direccion_empresa = $conexion->real_escape_string(utf8_decode($_POST['direccion_empresa']));}else{$direccion_empresa = "";}
					if (isset($_POST['telefono1_empresa'])){$telefono1_empresa = $conexion->real_escape_string($_POST['telefono1_empresa']);}else{$telefono1_empresa = "";}

					$query1 = ("UPDATE empresa SET pais_empresa='$pais_empresa', provincia_empresa='$provincia_empresa', poblacion_empresa='$poblacion_empresa', 
								direccion_empresa='$direccion_empresa', telefono1_empresa='$telefono1_empresa' 
								WHERE usuario_id='$id'");
					$empresa_editado = $conexion->query($query1);
					
					if($empresa_editado){ // la informacion de empresa esta editada, ahora edito la de usuario			
								
						$query2 = ("UPDATE usuario SET pais='$pais_empresa', provincia='$provincia_empresa', poblacion='$poblacion_empresa', direccion='$direccion_empresa',
									telefono='$telefono1_empresa' WHERE id='$id'");
						$usuario_editado = $conexion->query($query2);
						
						if($usuario_editado){ // la informacion de usuario esta editada, ahora edito la de tienda
						
							$categoria_t_id = $conexion->real_escape_string(utf8_decode($_POST['categoria_t_id'])); //obligatorio
							$query3 = ("UPDATE tienda SET categoria_t_id='$categoria_t_id' WHERE usuario_id='$id'");
							$tienda_editado = $conexion->query($query3);
						
							if($tienda_editado){ // la informacion de tienda esta editada, ahora edito la de social_media
							
								if (isset($_POST['facebook'])){ $facebook =   $conexion->real_escape_string(utf8_decode($_POST['facebook'])); }else{$facebook = "";}
								if (isset($_POST['whatsapp'])){ $whatsapp =   $conexion->real_escape_string(utf8_decode($_POST['whatsapp'])); }else{$whatsapp = "";}
								if (isset($_POST['instagram'])){ $instagram =  $conexion->real_escape_string(utf8_decode($_POST['instagram'])); }else{$instagram = "";}
								if (isset($_POST['twitter'])){ $twitter =    $conexion->real_escape_string(utf8_decode($_POST['twitter'])); }else{$twitter = "";}
								if (isset($_POST['youtube'])){ $youtube =    $conexion->real_escape_string(utf8_decode($_POST['youtube'])); }else{$youtube = "";}
								if (isset($_POST['googleplus'])){ $googleplus = $conexion->real_escape_string(utf8_decode($_POST['googleplus'])); }else{$googleplus = "";}
								if (isset($_POST['pinterest'])){ $pinterest =  $conexion->real_escape_string(utf8_decode($_POST['pinterest'])); }else{$pinterest = "";}
								if (isset($_POST['linkedin'])){ $linkedin =   $conexion->real_escape_string(utf8_decode($_POST['linkedin'])); }else{$linkedin = "";}
								if (isset($_POST['mapa'])){ $mapa =       $conexion->real_escape_string(utf8_decode($_POST['mapa'])); }else{$mapa = "";}

								// estas lineas son para saber si el usuario tiene un social_media creado o no

								$query6 =("SELECT id FROM empresa WHERE usuario_id='$id';"); // aqui estoy llamando al id de empresa
								$resultado = $conexion->query($query6);
								$empresaid = $resultado->fetch_assoc();
								$empresa_id = $empresaid['id']; // con estas lineas estoy llamando al id empresa para poderlo insertar en $query3 de INSER INTO. si no, no podria crear la tabla social.


								$query7 =("SELECT empresa_id FROM social_media WHERE empresa_id='$empresa_id';");  //si el (empresa_id de social_media) es = al (id del empresa) significa que tiene social_media. si no es = significa que no tiene social_media
								$resultado = $conexion->query($query7);
								$existe = $resultado->fetch_assoc();
									if ( $existe['empresa_id'] == $empresa_id){
										$query4 = ("UPDATE social_media SET facebook='$facebook', whatsapp='$whatsapp', instagram='$instagram', twitter='$twitter', youtube='$youtube', pinterest='$pinterest', googleplus='$googleplus', linkedin='$linkedin', mapa='$mapa' WHERE empresa_usuario_id='$id'");
														  
									} else if ( $existe['empresa_id'] != $empresa_id){
									$query4 = ("INSERT INTO social_media (facebook, whatsapp, instagram, twitter, youtube, googleplus, pinterest, linkedin, mapa, empresa_id, empresa_usuario_id) VALUE ('$facebook', '$whatsapp', '$instagram', '$twitter', '$youtube', '$googleplus', '$pinterest', '$linkedin', '$mapa', '$empresa_id', '$id')");
									}

								$social_media_editado = $conexion->query($query4);
						
							    if($social_media_editado){ // la informacion de tienda esta editada, ahora edito la de social_media
										header ("location: ../configuracion-tienda.php?id=".$id."&proceso=info");
								}else {
									  header("location: ../configuracion-tienda.php?id=".$id."&1");
								      }
							}else {
								  header("location: ../configuracion-tienda.php?id=".$id."&2");
								  }	
						}else {
							  header("location: ../configuracion-tienda.php?id=".$id."&3");
							  }									
					}else {
						   header("location: ../configuracion-tienda.php?id=".$id."&4");
						  }	
				}else{
				      header("location: ../configuracion-tienda.php?id=".$id."&5");
					  }	
			}else{
				  header("location: ../configuracion-tienda.php?id=".$id."&6");
				 }			
	    }else{
			  header("location: ../configuracion-tienda.php?id=".$id."&7");
			  }	
	}
?>