<?php
// Importamos las clases de Comida, Bebida y Autoloader de Twig
require_once '../Model/Comida.php';
require_once 'Twig/lib/Twig/Autoloader.php';

// Inicializamos Twig
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem(__DIR__.'/../View');
$twig = new Twig_Environment($loader); 


if (isset($_POST["addSubmit"])) {
    
    // Fecha actual con formato
    $fecha = date('d-m-Y');
    
    if (isset($_FILES["addImagen"]["name"]) && $_FILES["addImagen"]["name"]  !== "") {
    
    // Le damos un nombre nuevo a la imagen
    $imgName = "img" . time();
    
    // Explotamos el type de archivo para recoger su extension
    $tipo = explode('image/', $_FILES["addImagen"]["type"]);
    $extension = $tipo[1];

    // Direccion donde la guardaremos
    $imgDir = "../View/images/" . $imgName . "." . $extension;
    
    // Subimos el archivo al server
    move_uploaded_file($_FILES["addImagen"]["tmp_name"], $imgDir);
    
    } else {
        $imgDir = "";
    }
    
	if ($_POST["addPrecio"] === "") {
	
		$precio = 0;
	
	}
	
    // Creamos el objeto que insertaremos
    $comida = new Comida($_POST["addNombre"], $precio = 0, $_POST["addIngredientes"], $imgDir, $fecha);
    
    // Recogemos la respuesta de la BD
    $resultado = $comida->insert();
    
    if ($resultado == false) {
        echo "error";
    } else {
        echo "success";
    }
    
} else {
    
    echo "error";
    
}

