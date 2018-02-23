<?php 
             $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
		     $id = $_REQUEST['id'];
			 $query = ("SELECT P.*, T.nombre_tienda FROM producto P, tienda T WHERE P.id='$id' AND P.tienda_id=T.id;");
		     $resultado = $conexion->query($query);
			 $producto = $resultado->fetch_assoc()
?>
<?php 
             $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
		     $id = $_REQUEST['id'];
			 $query1 = ("SELECT C.* FROM categoria_pr C, producto P WHERE C.id = P.categoria_p_id AND P.id='$id';");
		     $resultado = $conexion->query($query1);
			 $categoria_pr = $resultado->fetch_assoc()
?>
