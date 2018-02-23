
    <center>
	 <form class="buscador-sinfiltros" action="cliente-tienda.php" method="POST">
	   <label class="buscador"></label><input type="text" name="buscar_tienda" placeholder="Busca tu tienda favorita..." id="buscar_tienda" />
       <input class="buscar" type="submit" value="BUSCAR" />
     </form>
	</center> 
   
<?php
include ('conexion.bd.php');

if (isset($_POST['buscar_tienda'])){ // miramos si existe la variable
   $db = new conexion(); // conexion a la base de datos
   $filtro = $db->real_escape_string($_POST['buscar_tienda']);
   $sql = $db->query("SELECT DISTINCT C.*, T.*, U.imagen FROM categoria_ti C, tienda T, usuario U, producto P  WHERE C.id = T.categoria_t_id AND T.apodo_tienda=U.apodo AND U.id=T.usuario_id AND T.nombre_tienda LIKE '%$filtro%' AND T.id=P.tienda_id ORDER BY RAND();"); //seleccionamos en la base de datos las tiendas

   if($db->rows($sql) > 0){ // miramos si hay tiendas llamados igual que lo que incertamos en el buscador
         while ($tienda = $db->recorrer($sql)){ // recorremos todos las tiendas y ensellamos las que se llaman igual o parecido a lo que busque?> 
		        <article class="article-tienda">
					<figure>
						<a href="tienda.php?nombre=<?php echo $tienda['nombre_tienda'];?>" title="">
							<?php if (!empty($tienda['imagen'])){ ?>
								<img src="data:image/jpg;base64, <?php echo base64_encode($tienda['imagen']); ?>"  alt="<?php echo $tienda['nombre_tienda']; ?>">
							<?php }else{ ?>
								<img src="imagenes/perfil-cuadrada.png" alt="<?php echo $tienda['nombre_tienda']; ?>">
							<?php } ?>
						</a>
					</figure>
					<div class="inferior-centro-2">
					   <center><p class="nombre-tienda"><?php echo $tienda['nombre_tienda']; ?></p></center>
					   <center><p class="categoria"><?php echo $tienda['nombre_categoria_ti']; ?></p></center>
					</div>
                </article>
	     <?php }
   }else{
         echo 'No se han encontrado resultados';
         }  
}else{ //esto  es para que me muestro todas las tiendas al inicio, es decir, cuando aun no he buscado nada
            $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
			$query = ("SELECT DISTINCT C.*, T.*, U.imagen FROM categoria_ti C, tienda T, usuario U, producto P WHERE C.id = T.categoria_t_id AND T.apodo_tienda=U.apodo AND U.id=T.usuario_id AND T.id=P.tienda_id ORDER BY RAND();");
			$resultado = $conexion->query($query);
			while($tienda = $resultado->fetch_assoc()){ ?>
				<article class="article-tienda">
					<figure>
						<a href="tienda.php?nombre=<?php echo utf8_encode($tienda['nombre_tienda']);?>" title="">
							<?php if (!empty($tienda['imagen'])){ ?>
								<img src="data:image/jpg;base64, <?php echo base64_encode($tienda['imagen']); ?>"  alt="<?php echo utf8_encode($tienda['nombre_tienda']); ?>">
							<?php }else{ ?>
								<img src="imagenes/perfil-cuadrada.png" alt="<?php echo utf8_encode($tienda['nombre_tienda']) ?>">
							<?php } ?>
						</a>
					</figure>
					<div class="inferior-centro-2">
						  <center><p class="nombre-tienda"><?php echo utf8_encode($tienda['nombre_tienda']); ?></p></center>
						  <center><p class="categoria"><?php echo utf8_encode($tienda['nombre_categoria_ti']); ?></p></center>
					</div>
                </article>				  
	  <?php }
	 
	 }?>