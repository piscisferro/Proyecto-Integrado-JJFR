<?php
// Importamos las clases de Comida, Bebida y Autoloader de Twig
require_once '../Model/Bebida.php';
require_once 'Twig/lib/Twig/Autoloader.php';

// Inicializamos Twig
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem(__DIR__.'/../View');
$twig = new Twig_Environment($loader); 

if (isset($_POST["addSubmit"])) {
    
    // Fecha actual con formato
    $fecha = date('d-m-Y');
    
<<<<<<< HEAD
    // Le damos un nombre nuevo a la imagen
    $imgName = "img" . time();
    
    // Explotamos el type de archivo para recoger su extension
    $tipo = explode('image/', $_FILES["addImagen"]["type"]);
    $extension = $tipo[1];

    // Direccion donde la guardaremos
    $imgDir = "../View/images/" . $imgName . "." . $extension;
    
    // Subimos el archivo al server
    move_uploaded_file($_FILES["addImagen"]["tmp_name"], $imgDir);
    
    // Creamos el objeto que insertaremos
    $bebida = new Bebida($_POST["addNombre"], $_POST["addPrecio"], $_POST["addCantidad"], $imgDir,  $fecha);
=======
    // Creamos el objeto que insertaremos
    $bebida = new Bebida($_POST["addNombre"], $_POST["addPrecio"], $_POST["addCantidad"], $fecha);
>>>>>>> origin/master
    
    // Recogemos la respuesta de la BD
    $resultado = $bebida->insert();
    
<<<<<<< HEAD
    
=======
>>>>>>> origin/master
    if ($resultado == false) {
        header("Location: bebida.php?error=1");
    } else {
        header("Location: bebida.php?success=1");
<<<<<<< HEAD
    } 
=======
    }
>>>>>>> origin/master
    
} else {
    
    header("Location: bebida.php?error=1");
    
}