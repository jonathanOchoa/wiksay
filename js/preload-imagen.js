// Cada uno de estos parrafos sirve para mostrar tres imagenes. las estoy utilizando en subir produco y modificar producto.
       var loadFile = function(event) {
       var output = document.getElementById('output');
       output.src = URL.createObjectURL(event.target.files[0]);
		comprobarImagen(output.src,output);
       };
	   
	function comprobarImagen(imgSrc,idImg) {
    var newImg = new Image();

    newImg.onload = function() {
      var height = newImg.height;
      var width = newImg.width;
	  if(width>9000 || height>9000){
	      swal({   title: "Oops...La imagen es demasiado grande", timer: 2000, showConfirmButton: false });
		  var output = document.getElementById('output');
          output.src ='';
		  setTimeout ("document.location=document.location", 2000);
	  }
    }
    newImg.src = imgSrc; // solo va a funcionar cuando la págna esté cargada
}
// fin de la primera funcion	   
	   var loadFile2 = function(event) {
       var output2 = document.getElementById('output2');
       output2.src = URL.createObjectURL(event.target.files[0]);
	   comprobarImagen2(output2.src,output);
       };
	   
	function comprobarImagen2(imgSrc,idImg) {
    var newImg = new Image();

    newImg.onload = function() {
      var height = newImg.height;
      var width = newImg.width;
	  if(width>9000 || height>9000){
		  swal({   title: "Oops...La imagen es demasiado grande", timer: 2000, showConfirmButton: false });
		  var output2 = document.getElementById('output2');
		  output2.src ='';
	      setTimeout ("document.location=document.location", 2000);
	  }
    }

    newImg.src = imgSrc; // solo va a funcionar cuando la págna esté cargada
}
// fin de la segunda funcion
	   
	   var loadFile3 = function(event) {
       var output3 = document.getElementById('output3');
       output3.src = URL.createObjectURL(event.target.files[0]);
	   comprobarImagen3(output3.src,output);
       };

	function comprobarImagen3(imgSrc,idImg) {
    var newImg = new Image();

    newImg.onload = function() {
      var height = newImg.height;
      var width = newImg.width;
	  if(width>9000 || height>9000){
		  swal({   title: "Oops...La imagen es demasiado grande", timer: 2000, showConfirmButton: false });
		  var output3 = document.getElementById('output3');
          output3.src ='';
		  setTimeout ("document.location=document.location", 2000);
	  }
    }

    newImg.src = imgSrc; // solo va a funcionar cuando la págna esté cargada
}
// fin de la tercera funcion