			<section class="centro-1-controles">
				<div class="icono-camara" title="Subir Articulo">
					<ul>
						<li><a href="subir-producto.php"><span class="fa fa-camera"></span></a></li>
					</ul>
				</div>
				<div class="imagen-controles">
                    <?php if (!empty($informacion['imagen_tienda'])){ ?>
						<figure><img src="data:image/jpg;base64, <?php echo base64_encode($informacion['imagen']); ?>" >
					<?php }else{ ?>
						<figure><img src="imagenes/perfil-cuadrada.png"></figure>
					<?php } ?>
					</img></figure>
				</div>
				 
				<div class="centro-1-1-controles">
				    <div class="centro-1-1-aling1">
					<h2><?php echo utf8_encode($informacion['apodo_tienda'])?></h2>
					</div>
					<div class="centro-1-1-aling2">
						<div class="list1">
							<center>
								<div class="centro-1-1-1-controles" title="<?php echo $siguiendo['usuario_id'];?> Siguiendo"><a href="">Siguiendo</a></div>
								<div class="centro-1-1-4-controles"><a href=""><b><?php echo $siguiendo['usuario_id'];?></b></a></div>
							</center>
						</div>
						<div class="list2">
							<center>
								<div class="centro-1-1-2-controles" title="<?php echo $me_siguen['tienda_usuario_id'];?> Seguidores"><a href="">Seguidores</a></div>
								<div class="centro-1-1-5-controles"><a href=""><b><?php echo $me_siguen['tienda_usuario_id'];?></b></a></div>
							</center>
						</div>
						<div class="list3">
							<center>
								<div class="centro-1-1-3-controles" title=" Likes"><a href="">Publicaciones</a></div>
								<div class="centro-1-1-6-controles"><a href=""><b><?php echo $numero_productos['id'];?></b></a></div>
							</center>
						</div>
					</div>
				</div>
		    </section>
		   
		    <section class="centro-2-muro-controles">
		        <div class="centro-2-1-muro-controles">
					<ul class="tabs-nav-controles">
						<center><a href="tienda-vendedor.php"><li><span class="fa fa-user"></span></li></a></center>
						<center><a href="cliente.php"><li><span class="fa fa-th"></span></li></a></center>
						<center><a href="cliente-producto.php"><li><span class="fa fa-search"></span></li></a></center>
					</ul>
				</div>     
			</section>
