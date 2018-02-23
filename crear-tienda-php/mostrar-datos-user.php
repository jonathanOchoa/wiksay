<?php 
             $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
		     // $usuario = utf8_decode($_SESSION['user']); como es un include lo estoy llamando en la pagina.php que lo estoy incluyendo
			 $query = ("SELECT * FROM tienda WHERE apodo_tienda='$usuario';");
		     $resultado = $conexion->query($query);
			 $informacion_tienda = $resultado->fetch_assoc();
?>
<?php 			 
			 $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
		     // $usuario = utf8_decode($_SESSION['user']); como es un include lo estoy llamando en la pagina.php que lo estoy incluyendo
			 $query = ("SELECT * FROM empresa WHERE apodo_empresa='$usuario';");
		     $resultado = $conexion->query($query);
			 $informacion_empresa = $resultado->fetch_assoc()
?>

<?php 
             $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
			 $id = $informacion_empresa['id']; // aqui estoy sacando el id de empresa. lo estraigo directamente del segundo selec que tengo en esta pagina
	         $query = ("SELECT * FROM social_media WHERE empresa_id='$id';"); 
	         $resultado = $conexion->query($query);
	         $social = $resultado->fetch_assoc()
?>
<?php 
             $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
		    // $usuario = utf8_decode($_SESSION['user']); como es un include lo estoy llamando en la pagina.php que lo estoy incluyendo
			 $query1 = ("SELECT C.* FROM categoria_ti C, tienda T WHERE C.id = T.categoria_t_id AND apodo_tienda='$usuario';");
		     $resultado = $conexion->query($query1);
			 $categoria_ti = $resultado->fetch_assoc()
?>