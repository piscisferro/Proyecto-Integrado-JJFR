<?php
// Importamos las clases de Comida, Bebida y Autoloader de Twig
require_once '../Model/Bebida.php';
require_once 'Twig/lib/Twig/Autoloader.php';

// Inicializamos Twig
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem(__DIR__.'/../View');
$twig = new Twig_Environment($loader);  

// Variable para filtrar los post inicializada vacia
$orden = null;
$dir = null;
$filtro = null;
$valor = null;
$filtro2=null;

// Sei se ha mandado el orden y la direccion
if (isset($_POST["orden"])) {
    $orden = $_POST["orden"];
    $dir = $_POST["dir"];
}


// Si se ha mandado el filtro
if (isset($_POST["filtro"])) {
    // Asignamos el filtro
    $filtro = $_POST["filtro"];
    $valor = $_POST["filtroValor"];
}

// Si se ha mandado el filtro
if (isset($_POST["filtro2"])) {
    // Asignamos el filtro
    $filtro2 = $_POST["filtro2"];
}

// Si nos llega algun mensaje de error lo guardamos en data para pasarlo a la vista
if (isset($_GET["error"])) {
    $data["error"] = 1;
}

// Si nos llega algun mensaje de exito lo guardamos
if (isset($_GET["success"])) {
    $data["success"] = 1;
}

// Si nos llega informacion sobre actualizar
if (isset($_POST["updateSubmit"])) {
    // Guardamos la Id del producto a modificar para mandarla a la vista
    // e imprimir un formulario en su lugar
    $data["updateId"] = $_POST["updateId"];
}


// Guardamos en data la lista de objetos que nos devuelve la base de datos.
$data["bebidas"] = Bebida::getBebidas($orden, $dir, $filtro, $valor, $filtro2);

// Mostramos el listado usando la plantilla twig
echo $twig->render('listadoBebida.html.twig', $data);

  
  
