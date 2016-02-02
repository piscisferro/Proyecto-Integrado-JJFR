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
    
    // Buscamos en la base de datos y guardamos el objeto que queremos modificar
    $comida = Comida::getComidaById($_POST["updateId"]);
    
    // Setter para modificar todos los atributos del objeto
    $comida->setter($_POST["updateNombre"], $_POST["updatePrecio"], $_POST["updateIngredientes"], $fecha);
    
    var_dump($comida);
    
    // Recogemos la respuesta de la BD
    $resultado = $comida->update();
    
    if ($resultado == false) {
        header("Location: comida.php?error=1");
    } else {
        header("Location: comida.php?success=1");
    }
    
} else {
    
    header("Location: comida.php?error=1");
    
}