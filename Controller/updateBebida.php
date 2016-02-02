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
    
    // Buscamos en la base de datos y guardamos el objeto que queremos modificar
    $bebida = Bebida::getBebidaById($_POST["updateId"]);
    
    // Setter para modificar todos los atributos del objeto
    $bebida->setter($_POST["updateNombre"], $_POST["updatePrecio"], $_POST["updateCantidad"], $fecha);
    
    // Recogemos la respuesta de la BD
    $resultado = $bebida->update();
    
    if ($resultado == false) {
        header("Location: bebida.php?error=1");
    } else {
        header("Location: bebida.php?success=1");
    }
    
} else {
    
    header("Location: bebida.php?error=1");
    
}