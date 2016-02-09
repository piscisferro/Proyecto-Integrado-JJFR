<?php
session_start();

// Si es la primera vez que entramos
if (!isset($_SESSION['pagina'])) {
    // Ponemos pagina en sesion a 0
    $_SESSION['pagina'] = 0;
}

if (!isset($_SESSION['filasVisualizadas'])) {
    // Ponemos pagina en sesion a 10
    $_SESSION['filasVisualizadas'] = 10;
}


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

// Si se ha mandado la pagina
if (isset($_POST["pagina"])) {
    $_SESSION["pagina"] = $_POST["pagina"];
}


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
    $data["filtroValor"] = $_POST["filtroValor"];
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
$data["bebidas"] = Bebida::getBebidas($_SESSION["pagina"], $_SESSION["filasVisualizadas"],$orden, $dir, $filtro, $valor, $filtro2);
$data["origin"] = "Bebida";

/////   Manejo de Paginas   /////
// Recogemos el numero de filas
$numeroFilas = (int) Bebida::getNumRows();
// Pagina maxima
$paginasMaximas = (ceil($numeroFilas/$_SESSION["filasVisualizadas"]) - 1);

// Guardamos la pagina actual
$data["paginaActual"] = $_SESSION["pagina"];

// Si sucede el extraño caso (que puede ocurrir) de que la pagina actual sea mayor
// que la pagina maxima, ponemos la pagina actual como maxima
if ($_SESSION["pagina"] > $paginasMaximas){
    $data["paginaActual"] = $paginasMaximas;
}

// Si la pagina actual es mayor a 0 significa que tenemos una pagina anterior y tambien 
// que hay una primera (aunque a veces sean la misma)
if ($_SESSION["pagina"] > 0) {
    $data["paginaAnterior"] = $_SESSION["pagina"] - 1;
    $data["paginaPrimera"] = 0;
}

// Si la pagina actual es menor a las paginas maximas significa que tenemos una pagina 
// siguiente y tambien que hay una ultima (aunque a veces sean la misma)
if ($_SESSION["pagina"] < $paginasMaximas) {
    $data["paginaSiguiente"] = $_SESSION["pagina"] + 1;
    $data["paginaUltima"] = $paginasMaximas;
}


if (!isset($_POST["ajaxRe"])) {
    
    echo $twig->render('base.html.twig', $data);
    
} else {
    
    echo $twig->render('listadoBebida.html.twig', $data);
    
}

  
  
