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
    
    // Creamos el objeto que insertaremos
    $comida = new Comida($_POST["addNombre"], $_POST["addPrecio"], $_POST["addIngredientes"], $fecha);
    
    // Recogemos la respuesta de la BD
    $resultado = $comida->insert();
    
    if ($resultado == false) {
        header("Location: comida.php?error=1");
    } else {
        header("Location: comida.php?success=1");
    }
    
} else {
    
    header("Location: comida.php?error=1");
    
}