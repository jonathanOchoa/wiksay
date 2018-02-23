<?php
if (isset($_REQUEST['id']) AND !empty($_REQUEST['id'])){ // miramos si existe la variable
        $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
		$num = 0; // esto es para que se valla sumando 1 numero en el id de article. asi cada articulo tiene un id diferente.
	    $categoria_id = $_REQUEST['id'];// este es el id de categoria_pr
		$tienda_id = $_REQUEST['tienda_id']; //este es el id de la tienda		
					
		if (isset($_REQUEST['colores']) AND !empty($_REQUEST['colores'])){
			$colores4 = $conexion->real_escape_string($_REQUEST['colores']);
			$colores5 = "AND C.nombre_color='".$colores4."'";
	   }else{ $colores5 = "";}
	   
	   if (isset($_REQUEST['tallas']) AND !empty($_REQUEST['tallas'])){
			$tallas4 = $conexion->real_escape_string($_REQUEST['tallas']);
			$tallas5 = "AND C.nombre_talla='".$tallas4."'"; 
	   }else{ $tallas5 = "";}
	   
		$query1 = ("SELECT DISTINCT P.* FROM producto P, color C WHERE P.tienda_id='$tienda_id' AND P.categoria_p_id='$categoria_id' AND P.id=C.producto_id $colores5 $tallas5");
		$resultado1 = $conexion->query($query1);
        while ($producto1 = $resultado1->fetch_assoc()){ // recorremos todos los productos y ensellamos los que se llaman igual o parecido a lo que busque ?>
			<article class="article" id="<?php echo $num++;?>">
                <figure><a href="producto.php?id=<?php echo $producto1['id'];?>" ><img src="data:image/jpg;base64, <?php echo base64_encode($producto1['imagen']); ?>"></a></figure>
                <div class="inferior-centro-1">
                    <center><p class="nombre-producto"><b><?php echo utf8_encode($producto1['nombre']); ?></b></p></center>
                    <center><p class="precio"><?php echo utf8_encode($producto1['precio']),' €'; ?></p></center>
					<div class="modificar-texto"title="Modificar informacion"><a href="listar-productos-modificar.php?id=<?php echo $producto1['id'];?>"><span class="icon-pencil"></span> <span class="icon-text"></a></div>
			        <div class="eliminar"title="Eliminar producto"><a href="tienda-vendedor-php.php/proceso-eliminar?id=<?php echo $producto1['id']?>"><span class="icon-trash"></a></div>
                </div>
            </article>				  
<?php 	} 
 
}else{ //esto  es para que me muestro todos los productos al inicio, es decir, cuando aun no he buscado nada
                      $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
					  $num = 0; // esto es para que se valla sumando 1 numero en el id de article. asi cada articulo tiene un id diferente.
					  $id = $id_tienda['id'];
					  $query = ("SELECT P.* FROM producto P, tienda T WHERE P.tienda_id = T.id AND T.id='$id'"); 
					  $resultado = $conexion->query($query);
					  while($producto = $resultado->fetch_assoc()){ ?>
					      <article class="article" id="<?php echo $num++;?>">
                             <figure><a href="producto.php?id=<?php echo $producto['id'];?>" ><img src="data:image/jpg;base64, <?php echo base64_encode($producto['imagen']); ?>"></a></figure>
                             <div class="inferior-centro-1">
                                <center><p class="nombre-producto"><b><?php echo utf8_encode($producto['nombre']); ?></b></p></center>
                                <center><p class="precio"><?php echo utf8_encode($producto['precio']),' €'; ?></p></center>
		                        <div class="modificar-texto"title="Modificar informacion"><a href="listar-productos-modificar.php?id=<?php echo $producto['id'];?>"><span class="icon-pencil"></span> <span class="icon-text"></a></div>
			                    <div class="eliminar"title="Eliminar producto"><a href="tienda-vendedor-php/proceso-eliminar.php?id=<?php echo $producto['id']?>"><span class="icon-trash"></a></div> 
                          </article>			  
			    <?php } 
	}
?>