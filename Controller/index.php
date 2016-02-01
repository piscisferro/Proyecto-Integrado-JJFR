<?php
// Importamos las clases de Comida, Bebida y Autoloader de Twig
require_once '../Model/Bebida.php';
require_once '../Model/Comida.php';
require_once 'Twig/lib/Twig/Autoloader.php';

// Inicializamos Twig
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem(__DIR__.'/../View');
$twig = new Twig_Environment($loader);  

// Variable para filtrar los post inicializada vacia
$orden;
$filtro;
$valor;

// Si se ha mandado el filtro
if (isset($_POST["filtro"])) {
    // Asignamos el filtro
    $filtro = $_POST["filtro"];
    $valor = $_POST["filtroValor"];
}

// Guardamos en data la lista de objetos que nos devuelve la base de datos.
$data["comida"] = Comida::getComida($orden, $filtro, $valor);

$data["bebidas"] = Bebida::getBebidas($orden, $filtro, $valor);

// Mostramos el listado usando la plantilla twig
echo $twig->render('listadoComida.html.twig', $data);

// Mostramos el listado usando la plantilla twig
echo $twig->render('listadoBebida.html.twig', $data);

  
  
