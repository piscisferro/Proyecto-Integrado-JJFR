<?php
// Importamos las clases de Comida, Bebida y Autoloader de Twig
require_once '../Model/Bebida.php';
require_once 'Twig/lib/Twig/Autoloader.php';

// Inicializamos Twig
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem(__DIR__.'/../View');
$twig = new Twig_Environment($loader); 

if (isset($_POST["updateBebida"])) {
    
    // Fecha actual con formato
    $fecha = date('d-m-Y');
    
    // Gestionamos la imagen si se ha subido
    if (isset($_FILES["updateImagen"]["name"]) && $_FILES["updateImagen"]["name"] !== "") {
        
        // Borramos la imagen del servidor
        unlink("../View/Images/" . $_POST['defaultImg']);
        
        // Le damos un nombre nuevo a la imagen
        $imgName = "img" . time();

        // Explotamos el type de archivo para recoger su extension
        $tipo = explode('image/', $_FILES["updateImagen"]["type"]);
        $extension = $tipo[1];

        // Direccion donde la guardaremos
        $imgDir = "../View/images/" . $imgName . "." . $extension;

        // Subimos el archivo al server
        move_uploaded_file($_FILES["updateImagen"]["tmp_name"], $imgDir);
        
    } else { // Si no se ha mandado la imagen
        // Mandamos la direccion vacio para evitar que haga cambios en la BD
        $imgDir = "";
    }
	
	if ($_POST["updatePrecio"] === "") {
	
		$precio = 0;
	
	}
	
	if ($_POST["updateCantidad"] === "") {
	
		$cantidad = 0;
	
	}
    
    // Buscamos en la base de datos y guardamos el objeto que queremos modificar
    $bebida = Bebida::getBebidaById($_POST["updateId"]);
    
    // Setter para modificar todos los atributos del objeto
    $bebida->setter($_POST["updateNombre"], $precio, $cantidad, $imgDir, $fecha);
    
    // Recogemos la respuesta de la BD
    $resultado = $bebida->update();
    
    if ($resultado == false) {
        echo "error";
    } else {
        echo "success";
    }
    
} else {
    
    echo "error";
    
}