<?php 
             $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
		     $id = $_REQUEST['id'];
			 $query = ("SELECT * FROM tienda WHERE usuario_id='$id';");
		     $resultado = $conexion->query($query);
			 $informacion_tienda = $resultado->fetch_assoc()
?>	
<?php 		 
			 $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
		     $id = $_REQUEST['id'];
			 $query = ("SELECT * FROM empresa WHERE usuario_id='$id';");
		     $resultado = $conexion->query($query);
			 $informacion_empresa = $resultado->fetch_assoc()
?>

<?php 
             $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
             $id = $_REQUEST['id'];
	         $query = ("SELECT * FROM social_media WHERE empresa_usuario_id='$id';"); 
	         $resultado = $conexion->query($query);
	         $social = $resultado->fetch_assoc()
?>
<?php 
             $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
		     $id = $_REQUEST['id'];
			 $query1 = ("SELECT C.* FROM categoria_ti C, tienda T WHERE C.id = T.categoria_t_id AND T.usuario_id='$id';");
		     $resultado = $conexion->query($query1);
			 $categoria_ti = $resultado->fetch_assoc()
?>