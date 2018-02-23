
    <center> 
	 <form class="buscador-sinfiltros" action="cliente-producto.php"  method="GET">
	   <label class="buscador"></label><input type="text" name="buscar" id="buscar"/>
       <input class="buscar" type="submit" value="Buscar"/>
     </form>
	</center>
   
<?php

include ('conexion.bd.php');

if (isset($_GET['buscar'])){ // miramos si existe la variable
   $db = new conexion(); // conexion a la base de datos
   $filtro = $db->real_escape_string(utf8_decode($_GET['buscar']));
   $sql = $db->query("SELECT * FROM producto WHERE nombre LIKE '%$filtro%';"); //seleccionamos en la base de datos los productos

   if($db->rows($sql) > 0){ // miramos si hay productos llamados igual que lo que incertamos en el buscador
   
// INICIO AQUI COMIENZA LA BUSQUEDA POR FILTROS ?> 
   
    <form action="cliente-producto.php?buscar=<?php echo $_GET['buscar'];?>"  method="POST">
        <div class="filtros-busqueda">      
		<center>
			<!--Inicio: aqui muestro las categorias de los productos que hay en la tienda-->
			
		    <div class="categorias">
		        <select class="categorias" name="categorias">
				<!--Esta funcion es para saber si esta definino el name (categorias).-->
				<?php if (isset($_POST['categorias'])) { 
				       $conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
				       $id_categorias_post = $_POST['categorias'];
					   $query34 = ("SELECT * FROM categoria_pr WHERE id='$id_categorias_post'");
					   $resultado34 = $conexion->query($query34);
				       $nombre_seleccioado = $resultado34->fetch_assoc() ?> 
				       <option value="<?php echo $id_categorias_post; ?>">
					   <?php if ($nombre_seleccioado['genero'] == '') { 
                            echo 'Mostrar todas';
					   } else { ?>
							<?php echo utf8_encode($nombre_seleccioado['genero']),' ',utf8_encode($nombre_seleccioado['nombre_categoria']),' ',utf8_encode($nombre_seleccioado['zapatos']),' ',utf8_encode($nombre_seleccioado['accesorios']),' ',utf8_encode($nombre_seleccioado['ropa_interior']);?>
					   <?php } ?>
					   </option> 
				<?php }else{ ?> <option value="">Mostrar todas</option> <?php } ?>
					<?php 
					$conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
					$niña_decode = utf8_decode('Niña');
					$niño_decode = utf8_decode('Niño');
					$query_mujer = ("SELECT DISTINCT C.* FROM categoria_pr C, producto P WHERE P.categoria_p_id=C.id AND (genero='Mujer' OR genero='Hombre' OR genero='Unisex' OR genero='$niña_decode' OR genero='$niño_decode' OR genero='Bebe' OR genero='Premama');");
					$resultado = $conexion->query($query_mujer);
				    while($mujer = $resultado->fetch_assoc()){ ?> 
						<option value="<?php echo $mujer['id']; ?>"><?php echo utf8_encode($mujer['genero']),' ',utf8_encode($mujer['nombre_categoria']),' ',utf8_encode($mujer['zapatos']),' ',utf8_encode($mujer['accesorios']),' ',utf8_encode($mujer['ropa_interior']);?></option>
                    <?php } ?>						
                </select>
		    </div>
			
			<div class="separador"></div>
			
								  <!--INICIO COLORES-->
			<div class="colores">COLORES<span class="icon-arrow-down6"></span>
			    <ul  class="sub-colores">
				    <li class="sub-colores-listado">
						<?php 
							$conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
							$query77 = ("SELECT DISTINCT nombre_color FROM color ");  // el $id ya esta llamado en el submenu de mujer 
							$resultado77 = $conexion->query($query77);
							while($colores = $resultado77->fetch_assoc()){ ?>
								    <a href="cliente-producto.php?buscar=<?php echo $_REQUEST['buscar'];?>&color=<?php echo $colores['nombre_color'];?>"><div class="colores-sinseleccionada"><div class="<?php echo $colores['nombre_color']; ?>" title="<?php echo $colores['nombre_color']; ?>"></div></div></a>
							<?php } ?>
			        </li>
			    </ul>
			</div>
	                              <!--FINAL COLORES-->
								  <!--INICIO TALLAS-->
			<div class="tallas">TALLAS<span class="icon-arrow-down6"></span>
			    <ul class="sub-tallas">
					<li>
						    <?php 
							if (isset($_REQUEST['color']) AND !empty($_REQUEST['color'])){
								$conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
								$color_url = "nombre_color="."'".$_REQUEST['color']."'";									
								$query81 = ("SELECT DISTINCT nombre_talla FROM color WHERE $color_url");  // el $id ya esta llamado en el submenu de mujer 
								$resultado81 = $conexion->query($query81);
								while($tallas = $resultado81->fetch_assoc()){ ?>
									<a href="cliente-producto.php?buscar=<?php echo $_REQUEST['buscar'];?>&color=<?php echo $color_url;?>&talla=<?php echo $tallas['nombre_talla'];?>"><div class="tallas-sinseleccionada"><?php echo $tallas['nombre_talla']; ?></div></a>
								<?php } 
							}else{ echo 'selecciona primero un color';}	?> 
					</li>
			    </ul>
			</div>
	    				          <!--FINAL TALLAS-->
		</center>
	    </div>	
    </form>
	
       <?php
       if (isset($_REQUEST['buscar'])){$busqueda = utf8_decode($_REQUEST['buscar']); }else{ $busqueda = "";}
	   if (isset($_POST['categorias']) AND $_POST['categorias'] != ''){$categoria = $_POST['categorias']; $categorias = "P.categoria_p_id='$categoria'";}else{ $categorias = "P.categoria_p_id!=''";}
	   
	   if (isset($_POST['Negro'])){$Negro = "O.nombre_color='Negro' OR"; }else{ $Negro = "";}
       if (isset($_POST['Blanco'])){$Blanco = "O.nombre_color='Blanco' OR"; }else{ $Blanco = "";}
       if (isset($_POST['Gris'])){$Gris = "O.nombre_color='Gris' OR"; }else{ $Gris = "";}
       if (isset($_POST['Marron'])){$Marron = "O.nombre_color='Marron' OR"; }else{ $Marron = "";}
       if (isset($_POST['Beige'])){$Beige = "O.nombre_color='Beige' OR"; }else{ $Beige = "";}
       if (isset($_POST['Rojo'])){$Rojo = "O.nombre_color='Rojo' OR"; }else{ $Rojo = "";}
       if (isset($_POST['Rosa'])){$Rosa = "O.nombre_color='Rosa' OR"; }else{ $Rosa = "";}
       if (isset($_POST['Naranja'])){$Naranja = "O.nombre_color='Naranja' OR"; }else{ $Naranja = "";}
       if (isset($_POST['Amarillo'])){$Amarillo = "O.nombre_color='Amarillo' OR"; }else{ $Amarillo = "";}
       if (isset($_POST['Verde'])){$Verde = "O.nombre_color='Verde' OR"; }else{ $Verde = "";}
       if (isset($_POST['Azul'])){$Azul = "O.nombre_color='Azul' OR"; }else{ $Azul = "";}
       if (isset($_POST['Morado'])){$Morado = "O.nombre_color='Morado' OR"; }else{ $Morado = "";}
       if (isset($_POST['Oro'])){$Oro = "O.nombre_color='Oro' OR "; }else{ $Oro = "";}
       if (isset($_POST['Plata'])){$Plata = "O.nombre_color='Plata' OR"; }else{ $Plata = "";}
       if (isset($_POST['Claro'])){$Claro = "O.nombre_color='Claro' OR"; }else{ $Claro = "";}
       if (isset($_POST['Multiples'])){$Multiples = "O.nombre_color='Multiples' OR"; }else{ $Multiples = "";}
	   
	   if (isset($_POST['veintidos'])){$veintidos = "O.nombre_talla='22' OR"; }else{ $veintidos = "";}
       if (isset($_POST['veintitres'])){$veintitres = "O.nombre_talla='23' OR"; }else{ $veintitres = "";}
       if (isset($_POST['veinticuatro'])){$veinticuatro = "O.nombre_talla='24' OR"; }else{ $veinticuatro = "";}
       if (isset($_POST['veinticinco'])){$veinticinco = "O.nombre_talla='25' OR"; }else{ $veinticinco = "";} 
       if (isset($_POST['veintiseis'])){$veintiseis = "O.nombre_talla='26' OR"; }else{ $veintiseis = "";}
       if (isset($_POST['veintisiete'])){$veintisiete = "O.nombre_talla='27' OR"; }else{ $veintisiete = "";}
       if (isset($_POST['veintiocho'])){$veintiocho = "O.nombre_talla='28' OR"; }else{ $veintiocho = "";}
       if (isset($_POST['veintinueve'])){$veintinueve = "O.nombre_talla='29' OR"; }else{ $veintinueve = "";}
       if (isset($_POST['treinta'])){$treinta = "O.nombre_talla='30' OR"; }else{ $treinta = "";}
       if (isset($_POST['treintayuno'])){$treintayuno = "O.nombre_talla='31' OR"; }else{ $treintayuno = "";}
       if (isset($_POST['treintaydos'])){$treintaydos = "O.nombre_talla='32' OR"; }else{ $treintaydos = "";}
       if (isset($_POST['treintaytres'])){$treintaytres = "O.nombre_talla='33' OR"; }else{ $treintaytres = "";}
       if (isset($_POST['treintaycuatro'])){$treintaycuatro = "O.nombre_talla='34' OR"; }else{ $treintaycuatro = "";}
       if (isset($_POST['treintaycinco'])){$treintaycinco = "O.nombre_talla='35' OR"; }else{ $treintaycinco = "";}
       if (isset($_POST['treintayseis'])){$treintayseis = "O.nombre_talla='37' OR"; }else{ $treintayseis = "";}
       if (isset($_POST['treintaysiete'])){$treintaysiete = "O.nombre_talla='37' OR"; }else{ $treintaysiete = "";}
       if (isset($_POST['treintayocho'])){$treintayocho = "O.nombre_talla='38' OR"; }else{ $treintayocho = "";}
       if (isset($_POST['treintaynueve'])){$treintaynueve = "O.nombre_talla='39' OR"; }else{ $treintaynueve = "";}
       if (isset($_POST['cuarenta'])){$cuarenta = "O.nombre_talla='40' OR"; }else{ $cuarenta = "";}
       if (isset($_POST['cuarentayuno'])){$cuarentayuno = "O.nombre_talla='41' OR"; }else{ $cuarentayuno = "";}
       if (isset($_POST['cuarentaydos'])){$cuarentaydos = "O.nombre_talla='42' OR"; }else{ $cuarentaydos = "";}
       if (isset($_POST['cuarentaytres'])){$cuarentaytres = "O.nombre_talla='43' OR"; }else{ $cuarentaytres = "";}
       if (isset($_POST['cuarentaycuatro'])){$cuarentaycuatro = "O.nombre_talla='44' OR"; }else{ $cuarentaycuatro = "";}
       if (isset($_POST['cuarentaycinco'])){$cuarentaycinco = "O.nombre_talla='45' OR"; }else{ $cuarentaycinco = "";}
       if (isset($_POST['cuarentayseis'])){$cuarentayseis = "O.nombre_talla='46' OR"; }else{ $cuarentayseis = "";}
       if (isset($_POST['cuarentaysiete'])){$cuarentaysiete = "O.nombre_talla='47' OR"; }else{ $cuarentaysiete = "";}
       if (isset($_POST['cuarentayocho'])){$cuarentayocho = "O.nombre_talla='48' OR"; }else{ $cuarentayocho = "";}
       if (isset($_POST['cuarentaynueve'])){$cuarentaynueve = "O.nombre_talla='49' OR"; }else{ $cuarentaynueve = "";}
       if (isset($_POST['cincuenta'])){$cincuenta = "O.nombre_talla='50' OR"; }else{ $cincuenta = "";}
	   
	   if (isset($_POST['XXS'])){$XXS = "O.nombre_talla='XXS' OR"; }else{ $XXS = "";}
       if (isset($_POST['XS'])){$XS = "O.nombre_talla='XS' OR"; }else{ $XS = "";}
       if (isset($_POST['S'])){$S = "O.nombre_talla='S' OR"; }else{ $S = "";}
       if (isset($_POST['M'])){$M = "O.nombre_talla='M' OR"; }else{ $M = "";}
       if (isset($_POST['L'])){$L = "O.nombre_talla='L' OR"; }else{ $L = "";}
       if (isset($_POST['XL'])){$XL = "O.nombre_talla='XL' OR"; }else{ $XL = "";}
       if (isset($_POST['XXL'])){$XXL = "O.nombre_talla='XXL' OR"; }else{ $XXL = "";}
       if (isset($_POST['XXXL'])){$XXXL = "O.nombre_talla='XXXL' OR"; }else{ $XXXL = "";}

       if (isset($_POST['meses0a1'])){$meses0a1 = "O.nombre_talla='Meses 0 a 1 (50) cm' OR"; }else{ $meses0a1 = "";}
       if (isset($_POST['meses1a2'])){$meses1a2 = "O.nombre_talla='Meses 1 a 2 (56) cm' OR"; }else{ $meses1a2 = "";}
       if (isset($_POST['meses2a4'])){$meses2a4 = "O.nombre_talla='Meses 2 a 4 (62) cm' OR"; }else{ $meses2a4 = "";}
       if (isset($_POST['meses4a6'])){$meses4a6 = "O.nombre_talla='Meses 4 a 6 (68) cm' OR"; }else{ $meses4a6 = "";}
       if (isset($_POST['meses6a9'])){$meses6a9 = "O.nombre_talla='Meses 6 a 9 (74) cm' OR"; }else{ $meses6a9 = "";}
       if (isset($_POST['meses9a12'])){$meses9a12 = "O.nombre_talla='Meses 9 a 12 (80) cm' OR"; }else{ $meses9a12 = "";}
       if (isset($_POST['meses12a18'])){$meses12a18 = "O.nombre_talla='Meses 12 a 18 (86) cm' OR"; }else{ $meses12a18 = "";}
       if (isset($_POST['meses18a24'])){$meses18a24 = "O.nombre_talla='Meses 18 a 24 (92) cm' OR"; }else{ $meses18a24 = "";}
       if (isset($_POST['$anos2a3'])){$anos2a3 = "O.nombre_talla='Años 2 a 3 (98) cm' OR"; }else{ $anos2a3 = "";}
       if (isset($_POST['$anos3a4'])){$anos3a4 = "O.nombre_talla='Años 3 a 4 (104) cm' OR"; }else{ $anos3a4 = "";}
       if (isset($_POST['$anos4a5'])){$anos4a5 = "O.nombre_talla='Años 4 a 5 (110) cm' OR"; }else{ $anos4a5 = "";}
       if (isset($_POST['$anos5a6'])){$anos5a6 = "O.nombre_talla='Años 5 a 6 (116) cm' OR"; }else{ $anos5a6 = "";}
       if (isset($_POST['$anos6a7'])){$anos6a7 = "O.nombre_talla='Años 6 a 7 (122) cm' OR"; }else{ $anos6a7 = "";}
       if (isset($_POST['$anos7a8'])){$anos7a8 = "O.nombre_talla='Años 7 a 8 (128) cm' OR"; }else{ $anos7a8 = "";}
       if (isset($_POST['$anos8a9'])){$anos8a9 = "O.nombre_talla='Años 8 a 9 (134) cm' OR"; }else{ $anos8a9 = "";}
       if (isset($_POST['$anos9a10'])){$anos9a10 = "O.nombre_talla='Años 9 a 10 (140) cm' OR"; }else{ $anos9a10 = "";}
       if (isset($_POST['$anos10a11'])){$anos10a11 = "O.nombre_talla='Años 10 a 11 (146) cm' OR"; }else{ $anos10a11 = "";}
       if (isset($_POST['$anos11a12'])){$anos11a12 = "O.nombre_talla='Años 11 a 12 (152) cm' OR"; }else{ $anos11a12 = "";}
       if (isset($_POST['$anos12a13'])){$anos12a13 = "O.nombre_talla='Años 12 a 13 (158) cm' OR"; }else{ $anos12a13 = "";}
       if (isset($_POST['$anos13a14'])){$anos13a14 = "O.nombre_talla='Años 13 a 14 (164) cm' OR"; }else{ $anos13a14 = "";}
       if (isset($_POST['$anosmas14'])){$anosmas14 = "O.nombre_talla='Años 14+ (170) cm' OR"; }else{ $anosmas14 = "";}

       if (isset($_POST['setentaA'])){$setentaA = "O.nombre_talla='70A' OR"; }else{ $setentaA = "";}
       if (isset($_POST['setentaB'])){$setentaB = "O.nombre_talla='70B' OR"; }else{ $setentaB = "";}
       if (isset($_POST['setentaC'])){$setentaC = "O.nombre_talla='70C' OR"; }else{ $setentaC = "";}
       if (isset($_POST['setentaD'])){$setentaD = "O.nombre_talla='70D' OR"; }else{ $setentaD = "";} 
       if (isset($_POST['setentaE'])){$setentaE = "O.nombre_talla='70E' OR"; }else{ $setentaE = "";}
       if (isset($_POST['setentaycincoA'])){$setentaycincoA = "O.nombre_talla='75A' OR"; }else{ $setentaycincoA = "";}
       if (isset($_POST['setentaycincoB'])){$setentaycincoB = "O.nombre_talla='75B' OR"; }else{ $setentaycincoB = "";}
       if (isset($_POST['setentaycincoC'])){$setentaycincoC = "O.nombre_talla='75C' OR"; }else{ $setentaycincoC = "";}
       if (isset($_POST['setentaycincoD'])){$setentaycincoD = "O.nombre_talla='75D' OR"; }else{ $setentaycincoD = "";}
       if (isset($_POST['setentaycincoE'])){$setentaycincoE = "O.nombre_talla='75E' OR"; }else{ $setentaycincoE = "";}
       if (isset($_POST['ochentaA'])){$ochentaA = "O.nombre_talla='80A' OR"; }else{ $ochentaA = "";}
       if (isset($_POST['ochentaB'])){$ochentaB = "O.nombre_talla='80B' OR"; }else{ $ochentaB = "";}
       if (isset($_POST['ochentaC'])){$ochentaC = "O.nombre_talla='80C' OR"; }else{ $ochentaC = "";}
       if (isset($_POST['ochentaD'])){$ochentaD = "O.nombre_talla='80D' OR"; }else{ $ochentaD = "";} 
       if (isset($_POST['ochentaE'])){$ochentaE = "O.nombre_talla='80E' OR"; }else{ $ochentaE = "";}
       if (isset($_POST['ochentaycincoA'])){$ochentaycincoA = "O.nombre_talla='85A' OR"; }else{ $ochentaycincoA = "";}
       if (isset($_POST['ochentaycincoB'])){$ochentaycincoB = "O.nombre_talla='85B' OR"; }else{ $ochentaycincoB = "";}
       if (isset($_POST['ochentaycincoC'])){$ochentaycincoC = "O.nombre_talla='85C' OR"; }else{ $ochentaycincoC = "";}
       if (isset($_POST['ochentaycincoD'])){$ochentaycincoD = "O.nombre_talla='85D' OR"; }else{ $ochentaycincoD = "";}
       if (isset($_POST['ochentaycincoE'])){$ochentaycincoE = "O.nombre_talla='85E' OR"; }else{ $ochentaycincoE = "";}
       if (isset($_POST['noventaA'])){$noventaA = "O.nombre_talla='90A' OR"; }else{ $noventaA = "";}
       if (isset($_POST['noventaB'])){$noventaB = "O.nombre_talla='90B' OR"; }else{ $noventaB = "";}
       if (isset($_POST['noventaC'])){$noventaC = "O.nombre_talla='90C' OR"; }else{ $noventaC = "";}
       if (isset($_POST['noventaD'])){$noventaD = "O.nombre_talla='90D' OR"; }else{ $noventaD = "";} 
       if (isset($_POST['noventaE'])){$noventaE = "O.nombre_talla='90E' OR"; }else{ $noventaE = "";}
       if (isset($_POST['noventaycincoA'])){$noventaycincoA = "O.nombre_talla='95A' OR"; }else{ $noventaycincoA = "";}
       if (isset($_POST['noventaycincoB'])){$noventaycincoB = "O.nombre_talla='95B' OR"; }else{ $noventaycincoB = "";}
       if (isset($_POST['noventaycincoC'])){$noventaycincoC = "O.nombre_talla='95C' OR"; }else{ $noventaycincoC = "";}
       if (isset($_POST['noventaycincoD'])){$noventaycincoD = "O.nombre_talla='95D' OR"; }else{ $noventaycincoD = "";}
       if (isset($_POST['noventaycincoE'])){$noventaycincoE = "O.nombre_talla='95E' OR"; }else{ $noventaycincoE = "";}
       if (isset($_POST['cienA'])){$cienA = "O.nombre_talla='100A' OR"; }else{ $cienA = "";}
       if (isset($_POST['cienB'])){$cienB = "O.nombre_talla='100B' OR"; }else{ $cienB = "";}
       if (isset($_POST['cienC'])){$cienC = "O.nombre_talla='100C' OR"; }else{ $cienC = "";}
       if (isset($_POST['cienD'])){$cienD = "O.nombre_talla='100D' OR"; }else{ $cienD = "";} 
       if (isset($_POST['cienE'])){$cienE = "O.nombre_talla='100E' OR"; }else{ $cienE = "";}
       if (isset($_POST['cientocincoA'])){$cientocincoA = "O.nombre_talla='105A' OR"; }else{ $cientocincoA = "";}
       if (isset($_POST['cientocincoB'])){$cientocincoB = "O.nombre_talla='105B' OR"; }else{ $cientocincoB = "";}
       if (isset($_POST['cientocincoC'])){$cientocincoC = "O.nombre_talla='105C' OR"; }else{ $cientocincoC = "";}
       if (isset($_POST['cientocincoD'])){$cientocincoD = "O.nombre_talla='105D' OR"; }else{ $cientocincoD = "";}
       if (isset($_POST['cientocincoE'])){$cientocincoE = "O.nombre_talla='105E' OR"; }else{ $cientocincoE = "";}
       if (isset($_POST['cientodiezA'])){$cientodiezA = "O.nombre_talla='110A' OR"; }else{ $cientodiezA = "";}
       if (isset($_POST['cientodiezB'])){$cientodiezB = "O.nombre_talla='110B' OR"; }else{ $cientodiezB = "";}
       if (isset($_POST['cientodiezC'])){$cientodiezC = "O.nombre_talla='110C' OR"; }else{ $cientodiezC = "";}
       if (isset($_POST['cientodiezD'])){$cientodiezD = "O.nombre_talla='110D' OR"; }else{ $cientodiezD = "";}
       if (isset($_POST['cientodiezE'])){$cientodiezE = "O.nombre_talla='110E' OR"; }else{ $cientodiezE = "";}
       if (isset($_POST['cientoquinceA'])){$cientoquinceA = "O.nombre_talla='115A' OR"; }else{ $cientoquinceA = "";}
       if (isset($_POST['cientoquinceB'])){$cientoquinceB = "O.nombre_talla='115B' OR"; }else{ $cientoquinceB = "";}
       if (isset($_POST['cientoquinceC'])){$cientoquinceC = "O.nombre_talla='115C' OR"; }else{ $cientoquinceC = "";}
       if (isset($_POST['cientoquinceD'])){$cientoquinceD = "O.nombre_talla='115D' OR"; }else{ $cientoquinceD = "";}
       if (isset($_POST['cientoquinceE'])){$cientoquinceE = "O.nombre_talla='115E' OR"; }else{ $cientoquinceE = "";}
	   // colores y tallas
	   // este if es para saber si hay algun filtro seleccionado, (Explico el proceso abajo)
          if ($Negro == "" AND $Blanco == "" AND $Gris == "" AND $Marron == "" AND $Beige == "" AND $Rojo == "" AND $Rosa == "" AND $Naranja == "" AND $Amarillo == ""
		  AND $Verde == "" AND $Azul == "" AND $Morado == "" AND $Oro == "" AND $Plata == "" AND $Claro == "" AND $Multiples == "") {
	          //si todos los filtros estan vacios, muestro el id!='' para que pueda bscar por el nombre de los producto
			  $idtienda_nada = "P.tienda_id!=''";
		     } else {
			         //si hay algun filtro que contenga algo, muestro el id='' para que busque los filtros de todos los productos llamado por el nombre.
					 // esto lo ago para poder poner un (and) antes denombre LIKE... porque si no lo pongo no me muestra las busquedas bien.
					 $idtienda_nada = "P.tienda_id=''";
			        }
		  if ( $veintidos == "" AND $veintitres == "" AND $veinticuatro == "" AND $veinticinco == "" AND $veintiseis == "" AND $veintisiete == "" AND $veintiocho == "" AND $veintinueve == "" AND $treintayuno == "" AND 
			  $treintaydos == "" AND $treintaytres == "" AND $treintaycuatro == "" AND$treintaycinco == "" AND $treintayseis == "" AND $treintaysiete == "" AND $treintayocho == "" AND $treintaynueve == "" AND $cuarenta == "" AND 
			  $cuarentayuno == "" AND $cuarentaydos == "" AND $cuarentaytres == "" AND $cuarentaycuatro == "" AND $cuarentaycinco == "" AND $cuarentayseis == "" AND $cuarentaysiete == "" AND $cuarentayocho == "" AND 
			  $cuarentaynueve == "" AND $cincuenta == "" AND 
			  $XXS == "" AND $XS == "" AND $S == "" AND $M == "" AND $L == "" AND $XL == "" AND $XXL == "" AND $XXXL == "" AND 
		      $meses0a1 == "" AND $meses1a2 == "" AND $meses2a4 == "" AND $meses4a6 == "" AND $meses6a9 == "" AND $meses9a12 == "" AND $meses12a18 == "" AND $meses18a24 == "" AND $anos2a3 == "" AND $anos3a4 == "" AND 
			  $anos4a5 == "" AND $anos5a6 == "" AND $anos6a7 == "" AND $anos7a8 == "" AND $anos8a9 == "" AND $anos9a10 == "" AND $anos10a11 == "" AND $anos11a12 == "" AND $anos12a13 == "" AND $anos13a14 == "" AND 
			  $anosmas14 == "" AND $setentaA == "" AND $setentaB == "" AND $setentaC == "" AND $setentaD == "" AND $setentaE == "" AND 
			  $setentaycincoA == "" AND $setentaycincoB == "" AND $setentaycincoC == "" AND $setentaycincoD == "" AND $setentaycincoE == "" AND $ochentaA == "" AND $ochentaB == "" AND $ochentaC == "" AND $ochentaD == "" AND
			  $ochentaE == "" AND $ochentaycincoA == "" AND $ochentaycincoB == "" AND $ochentaycincoC == "" AND $ochentaycincoD == "" AND $ochentaycincoE == "" AND $noventaA == "" AND $noventaB == "" AND 
			  $noventaC == "" AND $noventaD == "" AND $noventaE == "" AND $noventaycincoA == "" AND $noventaycincoB == "" AND $noventaycincoC == "" AND $noventaycincoD == "" AND $noventaycincoE == "" AND 
			  $cienA == "" AND $cienB == "" AND $cienC == "" AND $cienD == "" AND $cienE == "" AND $cientocincoA == "" AND $cientocincoB == "" AND $cientocincoC == "" AND $cientocincoD == "" AND 
			  $cientocincoE == "" AND $cientodiezA == "" AND $cientodiezB == "" AND $cientodiezC == "" AND $cientodiezD == "" AND $cientodiezE == "" AND $cientoquinceA == "" AND $cientoquinceB == "" AND 
			  $cientoquinceC == "" AND $cientoquinceD == "" AND $cientoquinceE == "") {	
              //si todos los filtros estan vacios, muestro el id!='' para que pueda bscar por el nombre de los producto
			  $id_nada = "P.id!=''";
		     } else {
			         //si hay algun filtro que contenga algo, muestro el id='' para que busque los filtros de todos los productos llamado por el nombre.
					 // esto lo ago para poder poner un (and) antes denombre LIKE... porque si no lo pongo no me muestra las busquedas bien.
			         $id_nada = "P.id=''";
			        }			  
					
	   $sql = $db->query("SELECT DISTINCT P.*, D.nombre_tienda FROM producto P, tienda D, color O WHERE( $Negro $Blanco $Gris $Marron $Beige $Rojo $Rosa $Naranja $Amarillo $Verde $Azul $Morado $Oro $Plata $Claro $Multiples $idtienda_nada)
	                     AND
                         ($veintidos $veintitres $veinticuatro $veinticinco $veintiseis $veintisiete $veintiocho $veintinueve $treinta $treintayuno $treintaydos $treintaytres
						 $treintaycuatro $treintaycinco $treintayseis $treintaysiete $treintayocho $treintaynueve $cuarenta $cuarentayuno $cuarentaydos $cuarentaytres 
						 $cuarentaycuatro $cuarentaycinco $cuarentayseis $cuarentaysiete $cuarentayocho $cuarentaynueve $cincuenta $XXS $XS $S $M $L $XL $XXL $XXXL $meses0a1 
						 $meses1a2 $meses2a4 $meses4a6 $meses6a9 $meses9a12 $meses12a18 $meses18a24 $anos2a3 $anos3a4 $anos4a5 $anos5a6 $anos6a7 $anos7a8 $anos8a9 $anos9a10 
						 $anos10a11 $anos11a12 $anos12a13 $anos13a14 $anosmas14 $setentaA $setentaB $setentaC $setentaD $setentaE $setentaycincoA $setentaycincoB $setentaycincoC 
						 $setentaycincoD $setentaycincoE $ochentaA $ochentaB $ochentaC $ochentaD $ochentaE $ochentaycincoA $ochentaycincoB $ochentaycincoC $ochentaycincoD 
						 $ochentaycincoE $noventaA $noventaB $noventaC $noventaD $noventaE $noventaycincoA $noventaycincoB $noventaycincoC $noventaycincoD $noventaycincoE
						 $cienA $cienB $cienC $cienD $cienE $cientocincoA $cientocincoB $cientocincoC $cientocincoD $cientocincoE $cientodiezA $cientodiezB $cientodiezC 
						 $cientodiezD $cientodiezE $cientoquinceA $cientoquinceB $cientoquinceC $cientoquinceD $cientoquinceE $id_nada) AND $categorias
	                     AND P.id=O.producto_id AND P.tienda_id=D.id AND P.id=T.producto_id AND P.nombre LIKE '%$busqueda%' ORDER BY RAND() LIMIT 500;"); //seleccionamos en la base de datos los productos
						 
       while ($producto = $db->recorrer($sql)){ // recorremos todos los productos y ensellamos los que se llaman igual o parecido a lo que busque?> 
		        <article class="article-producto">
                <figure><a href="producto.php?id=<?php echo utf8_encode($producto['id']);?>" title=""><img src="data:image/jpg;base64, <?php echo base64_encode($producto['imagen']); ?>" alt="<?php echo utf8_encode($producto['nombre']); ?>"></a></figure>
                    <div class="inferior-centro-1">
						<center><p class="nombre-tiendas"><?php echo $producto['nombre_tienda']; ?></p></center>
                        <center><p class="nombre-producto"><?php echo $producto['nombre']; ?></p></center>
                        <center><p class="precio"><?php echo utf8_encode($producto['precio']),' €'; ?></p></center>
                    </div>
                </article>
	<?php }
   }else{
         echo '<br><br>No se han encontrado resultados';
         }  
}else{ //esto  es para que me muestro todos los productos al inicio, es decir, cuando aun no he buscado nada
			$conexion = new mysqli ("localhost", "fhmjch8m_joocca", "78593136ccoj", "fhmjch8m_wiksay"); // conexion a la db
			$query55 = ("SELECT P.*, T.nombre_tienda FROM producto P, tienda T WHERE P.tienda_id=T.id ORDER BY RAND() LIMIT 500;");
			$resultado55 = $conexion->query($query55);
			while($producto = $resultado55->fetch_assoc()){ ?>
				<article class="article-producto">
                    <figure><a href="producto.php?id=<?php echo utf8_encode($producto['id']);?>" title=""><img src="data:image/jpg;base64, <?php echo base64_encode($producto['imagen']); ?>" alt="<?php echo utf8_encode($producto['nombre']); ?>"></a></figure>
                    <div class="inferior-centro-1">
						<center><p class="nombre-tiendas"><?php echo utf8_encode($producto['nombre_tienda']); ?></p></center>
                        <center><p class="nombre-producto"><?php echo utf8_encode($producto['nombre']); ?></p></center>
                        <center><p class="precio"><?php echo utf8_encode($producto['precio']),' €'; ?></p></center>
                    </div>
                </article>
            <?php } 
	 
	 }?>