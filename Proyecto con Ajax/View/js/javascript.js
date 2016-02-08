

// Funcion para crear un delay
var delay = (function(){
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();

$(document).ready(function iniciar() {
     
    // Variables globales
    var id; // id de los registros
    var origen; // Origen de los registros (comida, bebida..)
    var datos; // Variables donde guardaremos datos de formulario
    var form; // Variable con la informacion del formulario (raw)
    
    $("#success").hide();
    $("#error").hide();
    
    //////////////////////////////////////
    /////           Buscador         /////    
    //////////////////////////////////////
    $("#inputBuscador").keyup(function(){	
        
        delay(function() { 
        
            var valor = $("#inputBuscador").val();
            origen = $("#inputBuscador").data('origin');


            if(origen == "Comida") {
                var filtro2 = "ingredientes";
            } else {
                var filtro2 = "";
            }


            origen = origen.toLowerCase();


            $.post("../Controller/" + origen +".php", { filtro: "nombre", filtroValor: valor, filtro2: filtro2, ajaxRe: true}, function(data) {
                //vuelve a pintar el listado
                $("#contenido").html(data);

                // Vuelve a lanzar la funcion iniciar, sino lo hacemos perdemos las funciones de todos los botones
                iniciar();

            });
        }, 200); // Fin funcion delay
    });
    
    
    //////////////////////////////////////
    /////           Dialog          //////
    //////////////////////////////////////
    $("#dialogBorrar").dialog({
		autoOpen: false,
		resizable: false,
		modal: true,
		buttons: {
		//BOTON DE BORRAR
		"Borrar": function() {
			//Ajax con get
			$.post("../Controller/delete" + origen +".php", { deleteId: id, deleteSubmit:true },function(data){				
				$("#" + origen + id).fadeOut(500);
                
                $("#success").hide();
                $("#error").hide();
                
                if(data == "error") {
                    $("#error").slideDown(200);
                    
                } else {
                    $("#success").slideDown(200);
                }
			});
            
			//Cerrar la ventana de dialogo				
			$(this).dialog("close");												
		},
		"Cancelar": function() {
				//Cerrar la ventana de dialogo
				$(this).dialog("close");
		}
		}//buttons
	});
    
    $(".borrar").click(function() {
        origen = $(this).data("origin");
        id = $(this).data("id");
        
        $("#dialogBorrar").dialog("open");
        
    });
    
    
    //////////////////////////////////////
    /////   Formulario Modificar    //////
    //////////////////////////////////////
    
    /////   DIALOG    /////
    $("#dialogUpdate").dialog({
		autoOpen: false,
		resizable: false,
		modal: true,
		buttons: {
		//BOTON DE BORRAR
		"Modificar": function() {
			//Ajax con get
            $.ajax({
                url: "../Controller/update" + origen + ".php",
                data: datos,
                contentType: false,
                processData: false,
                type: 'POST',   
            }).fail(function() {
                
                $("#success").hide();
                $("#error").hide();
                
                $("#error").slideDown(200);
                
            }).done(function (data) {
                
                var resultado = data;
                origen.toLowerCase();
                
                $.post("../Controller/" + origen + ".php", { ajaxRe: true }, function(data) {
                    $("#contenido").html(data);
                    iniciar();
                    
                    $("#success").hide();
                    $("#error").hide();
                    
                    if(resultado == "error") {
                        $("#error").slideDown(200);
                    } else {
                        $("#success").slideDown(200);
                    }
                });
            }); 
            
			//Cerrar la ventana de dialogo				
			$(this).dialog("close");
        },
            "Cancelar": function() {
                //Cerrar la ventana de dialogo
                $(this).dialog("close");
            }
        }//buttons
	});
    
    /////   PRIMER BOTON MODIFICAR  /////
    $(".modificar").click(function(){
        
        id = $(this).data("id");
        
        origen = $(this).data("origin");
        
        origen = origen.toLowerCase();
        
        $.post("../Controller/" + origen + ".php", { updateSubmit: true, updateId: id, ajaxRe: true }, function (data){
           
            $("#contenido").html(data);
            
            iniciar();
            
        });   
    });
    
    /////   CUANDO HACEMOS SUBMIT   /////
    $("#updateForm").validate({
        
        submitHandler: function(form) {
        
            origen = $("#updateForm").data("origin");

            datos = new FormData(form);

            $("#dialogUpdate").dialog("open");
        }
    });
    
    ///// BOTON CANCELAR  /////
    $(".cancelar").click(function() {
        
        origen = $(this).data("origin");
        
        origen = origen.toLowerCase();
        
        $.post("../Controller/" + origen + ".php", { ajaxRe: true }, function (data) {
           
            $("#contenido").html(data);
            
            iniciar();
            
        });
    });
    
    
    //////////////////////////////////////
    /////   Formulario Alta         //////
    //////////////////////////////////////
    $("#addForm").validate({
        
        rules: {
            addNombre: {
                required: true,
                minlength: 2
            }
        },
        
        messages: {
            addNombre: {
                required: "Se requiere este campo",
                minlength: "Minimo de 2 caracteres"
            }
        },
        
        debug: true,
        submitHandler: function(form) {

            console.log("yijjaaaaa");
            
            origen = $("#addForm").data("origin"); 

            datos = new FormData(form);


            $.ajax({
                url: "../Controller/add" + origen + ".php",
                data: datos,
                contentType: false,
                processData: false,
                type: 'POST',   
            }).done(function (data) {

                var resultado = data;

                origen.toLowerCase();

                $.post("../Controller/" + origen + ".php", { ajaxRe: true }, function(data) {
                    $("#contenido").html(data);
                    iniciar();

                    $("#success").hide();
                    $("#error").hide();

                    if(resultado == "error") {
                        $("#error").slideDown(200);
                    } else {
                        $("#success").slideDown(200);
                    }
                });
            });
        }
    });
    
    
    
    
    //////////////////////////////////////
    /////       PAGINACION          //////
    //////////////////////////////////////
    $(".pagina").click(function () {
       
        origen = $(this).data("origin");
        var pagina = $(this).data("pagina");
        
        origen = origen.toLowerCase();
        
        $.post("../Controller/" + origen + ".php", { pagina: pagina, ajaxRe: true }, function (data){
           
            $("#contenido").html(data);
            
            iniciar();
            
        });
        
    });
    
    
    //////////////////////////////////////
    /////       ORDENACION          //////
    //////////////////////////////////////
    $(".orderSelect").change(function(){
        
        origen = $(this).data("origin");
        origen = origen.toLowerCase();
        
        var datos = $(".orderForm").serializeArray();
        datos.push({ name : "ajaxRe", value : "true" });
        
        
        $.post("../Controller/" + origen + ".php", datos ,function (data) {
            $("#contenido").html(data);
            iniciar();
        });
    });
});

