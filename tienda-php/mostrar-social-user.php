<?php 
      $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
      $usuario = utf8_decode($_REQUEST['nombre']);
	  $query = ("SELECT S.* FROM social_media S, empresa E WHERE S.empresa_usuario_id=E.usuario_id AND nombre_empresa='$usuario';"); // $user lo llame en la parte de arriba
	  $resultado = $conexion->query($query);
	  $social_tienda = $resultado->fetch_assoc()
?>