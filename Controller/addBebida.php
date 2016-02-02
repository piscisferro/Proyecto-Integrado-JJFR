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
    
    // Creamos el objeto que insertaremos
    $bebida = new Bebida($_POST["addNombre"], $_POST["addPrecio"], $_POST["addCantidad"], $fecha);
    
    // Recogemos la respuesta de la BD
    $resultado = $bebida->insert();
    
    if ($resultado == false) {
        header("Location: bebida.php?error=1");
    } else {
        header("Location: bebida.php?success=1");
    }
    
} else {
    
    header("Location: bebida.php?error=1");
    
}