			<section class="centro-1-controles">
			    <div class="icono-camara" title="Subir Articulo">
					<ul>
						<li><a href="subir-producto.php"><span class="fa fa-camera"></span></a></li>
					</ul>
				</div>
				<div class="imagen-controles">
                    <?php if (!empty($informacion['imagen'])){ ?>
						<figure><img src="data:image/jpg;base64, <?php echo base64_encode($informacion['imagen']); ?>" ></img></figure>
					<?php }else{ ?>
						<figure><img src="imagenes/perfil-cuadrada.png"></img></figure>
					<?php } ?>
					
				</div>
				 
				<div class="centro-1-1-controles">
				    <div class="centro-1-1-aling1">
					<h2><?php echo $informacion['apodo']?></h2>
					</div>
					<div class="centro-1-1-aling2">
						<?php include('cliente-php/mostrar-numero-seguimiendo-me-siguen.php');?><!--PHP. estas lineas de php es para mostrar los seguimientos-->
						<div class="list1">
							<center>
								<div class="centro-1-1-1-controles" title="<?php echo $siguiendo['usuario_id'];?> Siguiendo"><a href="siguiendo.php">Siguiendo</a></div>
								<div class="centro-1-1-4-controles"><a href="siguiendo.php"><b><?php echo $siguiendo['usuario_id'];?></b></a></div>
							</center>
						</div>
						<div class="list2">
							<center>
								<div class="centro-1-1-2-controles" title="<?php echo $me_siguen['tienda_usuario_id'];?> Seguidores"><a href="me-siguen.php">Seguidores</a></div>
								<div class="centro-1-1-5-controles"><a href="me-siguen.php"><b><?php echo $me_siguen['tienda_usuario_id'];?></b></a></div>
							</center>
						</div>
						<div class="list3">
							<center>
								<div class="centro-1-1-3-controles" title="<?php echo $me_gusta['usuario_id'];?> Likes"><a href="likes.php">Likes</a></div>
								<div class="centro-1-1-6-controles"><a href="likes.php"><b><?php echo $me_gusta['usuario_id'];?></b></a></div>
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
