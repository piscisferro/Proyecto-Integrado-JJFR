<?php
// Importamos las clases de Bebida, Bebida y Autoloader de Twig
require_once '../Model/Bebida.php';
require_once 'Twig/lib/Twig/Autoloader.php';

// Inicializamos Twig
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem(__DIR__.'/../View');
$twig = new Twig_Environment($loader); 

if (isset($_POST["deleteSubmit"])) {
    
    // Buscamos en la base de datos y guardamos el objeto que queremos borrar
    $bebida = Bebida::getBebidaById($_POST["deleteId"]);
    
    // Mandamos borrar el objeto de la base de datos y recogemos la respuesta de la BD
    $resultado = $bebida->delete();
    
    if ($resultado == false) {
        header("Location: bebida.php?error=1");
    } else {
        header("Location: bebida.php?success=1");
    }
    
} else {
    
    header("Location: bebida.php?error=1");
    
}