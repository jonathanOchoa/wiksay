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
	// aqui llamo al id mandado por url
    $id_usuario_url = $conexion->real_escape_string($_REQUEST['id']);
	/* en este if compruebo si los dos id coinciden.
	   1)si coinciden lo dejo realizar el proceso de subida
	   2)si no coincioden lo mando directamente a la tienda */
	if($id_usuario['id'] != $id_usuario_url) {header("location: ../cliente?proceso=nomodificado");} else {
	  
	    //a qui ya conecto con la bd para realizar el proceso
		$conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db

		$id = $conexion->real_escape_string($_REQUEST['id']);
        
		// isset: verificamos si se envio el formulario de registro ,empty: es para comprobar si hay datos vacios o no, is_muneric: para ver si la variable es numerica o no
		if (is_numeric($_POST['telefono']) OR empty($_POST['telefono'])){
		
			if (isset($_POST['apellidos'])){$apellidos = 	$conexion->real_escape_string(utf8_decode($_POST['apellidos']));}else{$apellidos = "";}
			if (isset($_POST['telefono'])){$telefono = 	$conexion->real_escape_string(utf8_decode($_POST['telefono']));}else{$telefono = "";}
			if (isset($_POST['pais'])){$pais = 		$conexion->real_escape_string(utf8_decode($_POST['pais']));}else{$pais = "";}
			if (isset($_POST['provincia'])){$provincia =	$conexion->real_escape_string(utf8_decode($_POST['provincia']));}else{$provincia = "";}
			if (isset($_POST['poblacion'])){$poblacion = 	$conexion->real_escape_string(utf8_decode($_POST['poblacion']));}else{$poblacion = "";}
			if (isset($_POST['direccion'])){$direccion = 	$conexion->real_escape_string(utf8_decode($_POST['direccion']));}else{$direccion = "";}

			$query1 = ("UPDATE usuario SET apellidos='$apellidos', 
						telefono='$telefono', pais='$pais', provincia='$provincia', poblacion='$poblacion', direccion='$direccion' 
						WHERE id='$id'");
		   
			if (isset($_POST['facebook'])){$facebook = 	$conexion->real_escape_string(utf8_decode($_POST['facebook']));}else{$facebook = "";}
			if (isset($_POST['instagram'])){$instagram = 	$conexion->real_escape_string(utf8_decode($_POST['instagram']));}else{$instagram = "";}
			if (isset($_POST['twitter'])){$twitter = 		$conexion->real_escape_string(utf8_decode($_POST['twitter']));}else{$twitter = "";}
			if (isset($_POST['google_plus'])){$google_plus = 	$conexion->real_escape_string(utf8_decode($_POST['google_plus']));}else{$google_plus = "";}
			if (isset($_POST['pinterest'])){$pinterest = 	$conexion->real_escape_string(utf8_decode($_POST['pinterest']));}else{$pinterest = "";}
			if (isset($_POST['linkedin'])){$linkedin = 	$conexion->real_escape_string(utf8_decode($_POST['linkedin']));}else{$linkedin = "";}


			// estas lineas son para saber si el usuario tiene un networking creado o no, a travez del usuario_id de usuario
			$conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
			$query4 =("SELECT usuario_id FROM networking WHERE usuario_id='$id';"); // si el (usuario_id de la usuario) es = al (id del usuario) significa que tiene networking. si no es = significa que no tiene networking
			$resultado = $conexion->query($query4);
			$existe = $resultado->fetch_assoc();

				if ( $existe['usuario_id'] == $id){
					$query2 = ("UPDATE networking SET facebook='$facebook', instagram='$instagram', twitter='$twitter', pinterest='$pinterest', google_plus='$google_plus', linkedin='$linkedin' WHERE usuario_id='$id'");
									  
				} else if ( $existe['usuario_id'] != $id){
					   							     $query2 = ("INSERT INTO networking (facebook, instagram, twitter, google_plus, pinterest, linkedin, usuario_id) VALUE ('$facebook', '$instagram', '$twitter', '$google_plus', '$pinterest', '$linkedin', '$id')");
														}  
			


				$resultado = $conexion->query($query1);// con esto le estamos diciendo que nos almacene los datos en la tabla usuario
				$resultado = $conexion->query($query2);// con esto le estamos diciendo que nos almacene los datos en la tabla networking

					if ($resultado){
						header ("location: ../configuracion-usuario?id=".$id."&proceso=info");
					}else {
						   header ("location: ../configuracion-usuario?id=".$id."");
						  }
		}else{header ("location: ../configuracion-usuario?id=".$id."&proceso=info");}
	}
?>