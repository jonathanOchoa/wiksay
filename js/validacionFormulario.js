function validar_colores_y_tallas(){
	var arrayColores = document.getElementsByClassName("checkboxColores");
	var arrayTallas = document.getElementsByClassName("checkboxTallas");
	var boton=document.getElementById("botonEnviar");
	var i=0;
	var j=0;
	var colorAceptado=false;
	var tallaAceptada=false;
	
	for(i=0;i<arrayColores.length;i++){
		if(arrayColores[i].checked){
			colorAceptado=true;
			break;
		}
	}
	
	for(i=0;i<arrayTallas.length;i++){
		if(arrayTallas[i].checked){
			tallaAceptada=true;
			break;
		}
	}
	
	if(colorAceptado==true && tallaAceptada==true){
		boton.disabled=false;
		boton.value="Subir articulo";
	}
	else if (colorAceptado==false && tallaAceptada==true){
		boton.disabled=true;
		boton.value="Selecciona minimo un color";
	}
	else if (colorAceptado==true && tallaAceptada==false){
		boton.disabled=true;
		boton.value="Selecciona minimo una talla";
	}
	else if (colorAceptado==false && tallaAceptada==false){
		boton.disabled=true;
		boton.value="Selecciona minimo un color y una talla";
	}
}