<?php 
        // esto es para mostrar cuantos usuarios estoy siguiendo
             $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
			 $id = $informacion['id'];
			 $query2 = ("SELECT COUNT(*) as usuario_id FROM seguimiento WHERE usuario_id='$id';");
		     $resultado = $conexion->query($query2);
			 $siguiendo = $resultado->fetch_assoc()
?>
<?php 
        // esto es para mostrar cuantos usuarios estoy siguiendo
             $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
			 $id = $informacion['id'];
			 $query2 = ("SELECT COUNT(*) as tienda_usuario_id FROM seguimiento WHERE tienda_usuario_id='$id';");
		     $resultado = $conexion->query($query2);
			 $me_siguen = $resultado->fetch_assoc()
?>
<?php 
        // esto es para mostrar cuantos usuarios estoy siguiendo
             $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
			 $id = $informacion['id'];
			 $query2 = ("SELECT COUNT(*) as usuario_id FROM megusta WHERE usuario_id='$id';");
		     $resultado = $conexion->query($query2);
			 $me_gusta = $resultado->fetch_assoc()
?>