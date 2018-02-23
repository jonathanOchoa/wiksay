<?php 
             $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
		     $id = $_REQUEST['id'];
			 $query = ("SELECT * FROM usuario WHERE id='$id';");
		     $resultado = $conexion->query($query);
			 $informacion = $resultado->fetch_assoc()
?>

<?php 
             $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
             $id = $_REQUEST['id'];
	         $query = ("SELECT * FROM networking WHERE usuario_id='$id';"); 
	         $resultado = $conexion->query($query);
	         $social = $resultado->fetch_assoc()
?>