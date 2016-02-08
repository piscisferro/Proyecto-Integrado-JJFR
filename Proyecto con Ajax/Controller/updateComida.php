<?php
// Importamos las clases de Comida, Bebida y Autoloader de Twig
require_once '../Model/Comida.php';
require_once 'Twig/lib/Twig/Autoloader.php';

// Inicializamos Twig
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem(__DIR__.'/../View');
$twig = new Twig_Environment($loader); 

if (isset($_POST["updateComida"])) {
    
    // Fecha actual con formato
    $fecha = date('d-m-Y');
    
    // Gestionamos la imagen si se ha subido
    if ($_FILES["updateImagen"]["name"] !== "") {
        
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
    
    // Buscamos en la base de datos y guardamos el objeto que queremos modificar
    $comida = Comida::getComidaById($_POST["updateId"]);
    
    // Setter para modificar todos los atributos del objeto
    $comida->setter($_POST["updateNombre"], $_POST["updatePrecio"], $_POST["updateIngredientes"], $imgDir, $fecha);
    
    // Recogemos la respuesta de la BD
    $resultado = $comida->update();
    
    if ($resultado == false) {
        echo "error";
    } else {
        echo "success";
    }
    
} else {
    
    echo "error";
    
}