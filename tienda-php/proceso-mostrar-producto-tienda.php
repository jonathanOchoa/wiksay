<?php
if (isset($_REQUEST['id']) AND !empty($_REQUEST['id'])){ // miramos si existe la variable que define una categoria
        $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
		$num = 0; // esto es para que se valla sumando 1 numero en el id de article. asi cada articulo tiene un id diferente.
	    $categoria_id = $_REQUEST['id'];// este es el id de categoria_pr
		$tienda_id = $_REQUEST['tienda_id']; //este es el id de la tienda
		
		if (isset($_REQUEST['colores']) AND !empty($_REQUEST['colores'])){
			$colores = $conexion->real_escape_string($_REQUEST['colores']);
			$colores1 = "AND C.nombre_color='".$colores."'";
	   }else{ $colores1 = "";}
	   
	   if (isset($_REQUEST['tallas']) AND !empty($_REQUEST['tallas'])){
			$tallas = $conexion->real_escape_string($_REQUEST['tallas']);
			$tallas1 = "AND C.nombre_talla='".$tallas."'"; 
	   }else{ $tallas1 = "";}
	   
		$query1 = ("SELECT DISTINCT P.* FROM producto P, color C WHERE P.tienda_id='$tienda_id' AND P.categoria_p_id='$categoria_id' AND P.id=C.producto_id $colores1 $tallas1;");
		$resultado1 = $conexion->query($query1);
        while ($producto = $resultado1->fetch_assoc()){ // recorremos todos los productos y ensellamos los que se llaman igual o parecido a lo que busque ?> 
			<article class="article" id="<?php echo $num++;?>">
                <figure><a href="producto.php?id=<?php echo $producto['id'];?>" title=""><img src="data:image/jpg;base64, <?php echo base64_encode($producto['imagen']); ?>" alt="<?php echo $producto['nombre']; ?>"></a></figure>
                <div class="inferior-centro-1">
                    <center><p class="nombre-producto"><b><?php echo utf8_encode($producto['nombre']); ?></b></p></center>
                    <center><p class="precio"><?php echo utf8_encode($producto['precio']),' €'; ?></p></center>
				</div>
            </article>				  
<?php   }
	
}else{ //esto  es para que me muestro todos los productos al inicio, es decir, cuando aun no he buscado nada
        $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
		$num = 0; // esto es para que se valla sumando 1 numero en el id de article. asi cada articulo tiene un id diferente.
		$nombre_tienda = utf8_decode($_REQUEST['nombre']);// este nombre lo estamos sacando de la url
		$query = ("SELECT P.* FROM producto P, tienda T WHERE P.tienda_id=T.id AND T.nombre_tienda='$nombre_tienda';"); // llamo desde la tabla producto un dato de la tabla empresa
		$resultado = $conexion->query($query);
		while($producto = $resultado->fetch_assoc()){ ?>
			<article class="article" id="<?php echo $num++;?>">
				<figure><a href="producto.php?id=<?php echo $producto['id'];?>" ><img src="data:image/jpg;base64, <?php echo base64_encode($producto['imagen']); ?>"></a></figure>
				<div class="inferior-centro-1">
					<center><p class="nombre-producto"><b><?php echo utf8_encode($producto['nombre']); ?></b></p></center>
					<center><p class="precio"><?php echo utf8_encode($producto['precio']),' €'; ?></p></center>
				</div>
			</article>				  
<?php   } 
	}
?>