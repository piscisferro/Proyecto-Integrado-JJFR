<?php
// Importamos las clases de Comida, Comida y Autoloader de Twig
require_once '../Model/Comida.php';
require_once 'Twig/lib/Twig/Autoloader.php';

// Inicializamos Twig
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem(__DIR__.'/../View');
$twig = new Twig_Environment($loader); 

if (isset($_POST["deleteSubmit"])) {
    
    // Buscamos en la base de datos y guardamos el objeto que queremos borrar
    $comida = Comida::getComidaById($_POST["deleteId"]);
    
    // Mandamos borrar el objeto de la base de datos y recogemos la respuesta de la BD
    $resultado = $comida->delete();
    
    if ($resultado == false) {
        echo "error";
    } else {
        echo "success";
    }
    
} else {
    
    echo "success";
    
}

