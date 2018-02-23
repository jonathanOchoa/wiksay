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
	  header("location: index.php?error=acceso");
      }
	  $user = $_SESSION['user'];
	  
	/* aqui hago dos comprovaciones.
	   1) con el apodo del usuario busco el ide de la tienda que es ($id_tienda['id'])
	   2) con el id del producto mandado por url ($id_producto_url = $_REQUEST['id'];) busco el campo tienda_id al que pertenece.
	   3) los comparo para ver si son iguales o no
	*/
    // todo esto es para mostrar el id del usuario
    $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
    $usuario = utf8_decode($_SESSION['user']);
	$query = ("SELECT T.* FROM tienda T, usuario U WHERE T.usuario_id = U.id AND U.apodo='$usuario';");
	$resultado = $conexion->query($query);
	$id_tienda = $resultado->fetch_assoc();	

    // todo esto es para mostrar el id del usuario
    $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
    $id_producto_url = $conexion->real_escape_string($_REQUEST['id']);
	$query23 = ("SELECT * FROM producto WHERE id='$id_producto_url';");
	$resultado23 = $conexion->query($query23);
	$id_comprobar_producto = $resultado23->fetch_assoc();	
	/* combruebo: 1)si el id del usuario no es igual al id del usuario de la tienda lo redirijo a la pagina tienda-vendedor.php
	              2)si el id del usuario es igual al id del usuario de la tienda lo dejo entrar*/
	if($id_comprobar_producto['tienda_id'] != $id_tienda['id']) {header("location: ../tienda-vendedor.php?proceso=nomodificado");} else {
		  
	    //a qui ya conecto con la bd para realizar el proceso
		$conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db

		$id = $conexion->real_escape_string($_REQUEST['id']);
        if (isset($_FILES['imagen2']['tmp_name'])) {$imagen2 = addslashes(file_get_contents($_FILES['imagen2']['tmp_name'])); }else{$imagen2 = "";}
			$query = ("UPDATE producto SET imagen2='$imagen2' WHERE id='$id'");

				$resultado = $conexion->query($query);// con esto le estamos diciendo que nos almacene los datos

					if ($resultado){
                            header ("location: ../listar-productos-modificar.php?id=".$id."&proceso=imag");
                    }else {
                          header ("location: ../listar-productos-modificar.php?id=".$id."");
	                      }
	}
?>